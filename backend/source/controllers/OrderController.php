<?php

/**
 */
class OrderController extends Controller
{
    public $layout = Constants::LAYOUT_MAIN;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authentication user to perform 'index', ...
                'actions' => array('index', 'searchByShop', 'create', 'update', 'updateStatus', 'delete', 'selectFoodInto', 'selectCustomerInto'),
                'expression'=>'Yii::app()->user->isShopOwner() OR Yii::app()->user->isAdmin() OR Yii::app()->user->isModerator()',
                'users' => array('@'),
            ),
            array('allow',
                'actions'=>array('view'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionView($id){
        /** @var Orders $model */
        $model = Orders::model()->findByPk($id);

        $this->render('view', array(
            'model' => $model,
            'id'=>$id
        ));
    }
    public function actionSelectCustomerInto()
    {
        $id = $_REQUEST['id'];
        $model = Account::model()->findByPk($id, 'status = :status', array(
            ':status' => 1,
        ));
        $this->renderPartial('ajax/select_into_customer', array(
            'model' => $model,
        ));
    }

    public function actionSelectFoodInto()
    {
        $id = $_REQUEST['id'];
        $number = $_REQUEST['number'];
        $price = $_REQUEST['price'];
        $date = $_REQUEST['date'];
        $model = Food::model()->findByPk($id, 'status = :status', array(
            ':status' => 1,
        ));
        $this->renderPartial('ajax/select_into', array(
            'model' => $model,
            'number' => $number,
            'price' => $price,
            'date' => $date,
        ));
    }

    public function actionIndex()
    {
        $arrShop = array();
        if (Yii::app()->user->role == Constants::ROLE_ADMIN) {
            $arrShop = Shop::model()->findAll();
        }
        elseif(Yii::app()->user->role == Constants::ROLE_SHOP_OWNER)
        {
            $criteria = new CDbCriteria;
            $criteria->compare('account_id', Yii::app()->user->id);
            $arrShop = Shop::model()->findAll($criteria);
        }

        $shops = array();
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }


        $status = array(
            Constants::ORDER_NEW => 'New',
            Constants::ORDER_IN_PROCESS => 'Received',
            Constants::ORDER_CANCEL => 'Cancel',
            Constants::ORDER_READY => 'Ready',
            Constants::ORDER_ON_THE_WAY => 'On the way',
            Constants::ORDER_DELIVERED => 'Delivered',
            Constants::ORDER_FAIL_DELIVERY => 'Fail delivery');

        $order = new Orders('search');
        $order->unsetAttributes();

        if (isset($_GET['Orders'])) {
            $order->attributes = $_GET['Orders'];
        }

        $model = new Orders();


        $this->render('admin', array(
            'model' => $model,
            'order' => $order,
            'shop' => $shops,
            'status'=> $status
        ));
    }

    public function actionSearchByShop($id)
    {

        //check is owner
        $userId = Yii::app()->user->id;
        $role = Yii::app()->user->role;
        if($role == 1){
            if(Shop::checkOwnerShop($id, $userId)== false)
                $this->redirect(Yii::app()->createUrl('error/errorShopOwner'));

        }


        $model = new Orders();
        $model->unsetAttributes();
        $modelSearchForm = new SearchOrderForm();

        if (isset($_POST['SearchOrderForm'])) {
            $modelSearchForm->attributes = $_POST['SearchOrderForm'];
            $model = $modelSearchForm->search($id);
            $dataList = $model->searchByShopAndStatus($model->shop_id, $model->status);
        } else {
            $dataList = $model->searchByShop($id);
        }

        $shop = Shop::model()->findByPk($id);
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shop' => $shop,
        ));
    }

    public function actionCreate($shopId)
    {
        $model = new OrderForm();
        $model->orderShop = $shopId;

        if (isset($_POST['OrderForm'])) {

            $model->attributes = $_POST['OrderForm']; //var_dump($model);die;
            if ($model->orderShop == 0) {
                Yii::app()->user->setFlash('_error_', Yii::t('banner', 'msg.errorShop'));
            } else {
                if ($model->validate()) {

                    $model->orderTime = $model->orderTime . ' ' . $model->order_time;
                    $model->orderId = time();

                    $transaction = FALSE;
                    if (!Yii::app()->db->currentTransaction) {
                        $transaction = Yii::app()->db->beginTransaction();
                    }
                    try {
                        $newModel = new Orders();
                        $newModel->shop_id = $model->orderShop;
                        $newModel->order_id = $model->orderId;
                        $newModel->account_id = $model->orderAccount;
                        $newModel->order_places = $model->orderPlace;
                        $newModel->order_requirement = $model->orderRequirement;
                        $newModel->order_time = $model->orderTime;
                        $newModel->created = DateTimeUtils::createInstance()->now();
                        $newModel->save();

                        /*if(!$newModel->save()){
                            var_dump($newModel->getErrors());die;
                        }*/

                        foreach ($model->foodList as $item) {
                            $foodItem = new OrderFood();
                            $foodItem->order_id = $newModel->order_id;
                            $foodItem->food_id = $item['id'];
                            $foodItem->number = $item['number'];
                            $foodItem->price = round($item['price'], 2);
                            $foodItem->save();
                        }
                        //check users of shop :
                        $userShop = UserShop::model()->searchByAccountId($model->orderShop, $model->orderAccount);
                        if ($userShop == null) {
                            $userShop = new UserShop;
                            $userShop->shopId = $model->orderShop;
                            $userShop->accountId = $model->orderAccount;
                            $userShop->order_count = 1;
                            $userShop->save();
                        } else {
                            $userShop->order_count = $userShop->order_count + 1;
                            $userShop->save();
                        }
                        $transaction AND $transaction->commit();

                        $grand_total = $_POST['OrderForm']['grand_total'];
                        $tax_total = $_POST['OrderForm']['tax'];
                        $shipping_fee = $_POST['OrderForm']['shipping'];
                        $order_grand_total = $_POST['OrderForm']['grandTotal'];

                        if (isset($grand_total)) {
                            $group = new OrderTotal();
                            $group->orderId = $newModel->order_id;
                            $group->total = $grand_total;
                            $group->tax = $tax_total;
                            $group->shipping = $shipping_fee;
                            $group->grandTotal = $order_grand_total ;
                            $group->dateCreated = date('Y-m-d H:i:s', strtotime('Now'));
                            $group->save();
                        }

                        $this->redirect(Yii::app()->createUrl('order/searchByShop', array('id' => $model->orderShop)));


                    } catch (Exception $e) // an exception is raised if a query fails
                    {
                        //var_dump($transaction); die;
                        $transaction AND $transaction->rollback();
                    }


                } else {
                    //var_dump($model);die;
                    //var_dump($model->getErrors());die;
                    Yii::app()->user->setFlash('_error_', $model->getErrors());
                }
            }
        }

        $food = new Food('search');
        $food->unsetAttributes();
        $food->status = 1;
        $food->shop_id = $shopId;
        $food->status_in_day = 1;
        /*
        $customer = new Account('search');
        $customer->unsetAttributes();
        $customer->status = 1;
        $customer->role = 0;
        */
        $customer = Account::model()->searchShopCustomer($shopId);


        $this->render('create', array(
            'model' => $model,
            'food' => $food,
            'customer' => $customer,
            'shopId'=>$shopId
        ));

    }

    public function actionUpdate($id)
    {
        $model = new OrderForm();
        $model->loadModel($id);

        //set data
        $model->orderTime = date('Y-m-d', strtotime($model->orderTime));

        //get order item
        $order = Orders::model()->findByPk($id);
        if (isset($order->orderItemR) && is_array($order->orderItemR)) {
            foreach ($order->orderItemR as $item) {
                $model->foodList[] = array(
                    'id' => $item->food_id,
                    'number' => $item->number,
                    'price' => $item->price,
                );
            }
        }

        if (isset($_POST['OrderForm'])) {
            $model->orderAccount = null;
            $model->attributes = $_POST['OrderForm'];
            if ($model->orderShop == 0) {
                Yii::app()->user->setFlash('_error_', Yii::t('promotion', 'msg.errorShop'));
            } else {
                if ($model->validate()) {

                    $model->orderTime = $model->orderTime . ' ' . $model->order_time;

                    $transaction = FALSE;
                    if (!Yii::app()->db->currentTransaction) {
                        $transaction = Yii::app()->db->beginTransaction();
                    }
                    try {
                        //delete all old data item
                        OrderFood::model()->deleteAll('order_id = :order_id', array(
                            ':order_id' => $model->orderId,
                        ));

                        foreach ($model->foodList as $item) {
                            $foodItem = new OrderFood();
                            $foodItem->order_id = $model->orderId;
                            $foodItem->food_id = $item['id'];
                            $foodItem->number = $item['number'];
                            $foodItem->price = $item['price'];
                            $foodItem->save();
                        }
                        
                        $transaction AND $transaction->commit();
                        try {
                            if ($model->isSendToCustomer == 1) {
                                if ($model->status == Constants::ORDER_NEW) {
                                    MailUtils::createInstance()->sendMailToCustomerWhenReceived($order, $model->foodList);
                                } else if ($model->status == Constants::ORDER_READY) {
                                    MailUtils::createInstance()->sendMailToCustomerWhenReady($order, $model->foodList);
                                } else if ($model->status == Constants::ORDER_CANCEL) {
                                    MailUtils::createInstance()->sendMailToCustomerWhenReject($order, $model->foodList);
                                }
                            }
                        } catch (Exception $e) {
                        }


                        $grand_total = $_POST['OrderForm']['grand_total'];
                        $tax_total = $_POST['OrderForm']['tax'];
                        $shipping_fee = $_POST['OrderForm']['shipping'];
                        $order_grand_total = $_POST['OrderForm']['grandTotal'];


                        if (isset($grand_total)) {
                            $check_total = OrderTotal::model()->find('orderId =' . $id);
                            if (isset ($check_total)) {
                                $check_total->total = $grand_total;
                                $check_total->tax = $tax_total;
                                $check_total->shipping = $shipping_fee;
                                $check_total->grandTotal = $order_grand_total ;
                                $check_total->dateCreated = date('Y-m-d H:i:s', strtotime('Now'));
                                $check_total->save();
                            } else {
                                $group = new OrderTotal();
                                $group->orderId = $id;
                                $group->total = $grand_total;
                                $group->tax = $tax_total;
                                $group->shipping = $shipping_fee;
                                $group->grandTotal = $order_grand_total ;
                                $group->dateCreated = date('Y-m-d H:i:s', strtotime('Now'));
                                $group->save();
                            }
                        }

                        if ($model->status == Constants::ORDER_DELIVERED) {
                            $shopId = $model->orderShop;
                            $ownerId = Shop::model()->findByPk($shopId)->account_id;

                            if (isset($grand_total)) {
                                Orders::model()->calculateFinance($shopId,$ownerId,$grand_total);
                            }

                        }

                        //add budget and grand total for order
                        $model->update($id);


                        $this->redirect(Yii::app()->createUrl('order/searchByShop', array('id' => $model->orderShop)));
                    } catch
                    (Exception $e) // an exception is raised if a query fails
                    {
                        //var_dump($transaction); die;
                        $transaction AND $transaction->rollback();
                    }
                } else {
                    //var_dump($model);die;
                    //var_dump($model->getErrors());die;
                    Yii::app()->user->setFlash('_error_', $model->getErrors());
                }

                /*if ($model->update($id)) {
                    $this->redirect(Yii::app()->createUrl('order/searchByShop', array('id' => $model->shopId)));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }*/

            }

        }

        $food = new Food('search');
        $food->unsetAttributes();
        $food->status = 1;
        $food->shop_id = $order->shop_id;
        $food->status_in_day = 1;

//        $customer = new Account('search');
//        $customer->unsetAttributes();
//        $customer->role = 0;


        $customer = Account::model()->searchShopCustomer($order->shop_id);

        if (isset($_GET['OrderForm'])) {
            $model->foodList = null;
            if (isset($_GET['OrderForm']['foodListId']) && is_array($_GET['OrderForm']['foodListId'])) {
                $foodListId = $_GET['OrderForm']['foodListId'];
                $foodListNumber = $_GET['OrderForm']['foodListNumber'];
                $foodListPrice = $_GET['OrderForm']['foodListPrice'];
                //var_dump($model->foodList);die;
                $i = 0;
                foreach ($foodListId as $item) {
                    $model->foodList[] = array(
                        'id' => $item,
                        'number' => $foodListNumber[$i],
                        'price' => $foodListPrice[$i],
                    );
                    $i++;
                }
            }
            //var_dump($model->foodList);die;
        }

        $this->render('update', array(
            'model' => $model,
            'food' => $food,
            'customer' => $customer,
            'shopId'=>$order->shop_id
        ));
    }

    public function actionUpdateStatus($id, $status)
    {
        /** @var Orders $model */
        $model = Orders::model()->findByPk($id);
        if ($model != null) {
            $model->status = $status;
            $model->update();
        }
        //$this->redirect(Yii::app()->createUrl('order/searchByShop', array('id' => $model->shop_id)));
    }

    public function actionDelete($id)
    {
        /** @var Orders $model */
        $model = Orders::model()->findByPk($id);
        $group_code = $model->group_code;
        if ($model != null) {
            //add more update order group

            //delete order food
            $foods = OrderFood::model()->getOrderFoodByOrder($id);
            if ($foods != null)
                foreach ($foods as $foodOrder) {
                    $foodOrder->delete();
                }
            OrderTotal::model()->deleteAll('orderId ='.$id);
            $model->delete();
            OrderGroup::model()->updateGroup($group_code);

        }
        $this->redirect(Yii::app()->createUrl('order/searchByShop', array('id' => $model->shop_id)));
    }
}