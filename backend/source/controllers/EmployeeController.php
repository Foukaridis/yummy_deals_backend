<?php

/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:13 AM
 */
class EmployeeController extends Controller
{

    public $layout = Constants::LAYOUT_EMPLOYEE;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            // perform access control for CRUD operations
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules()
//    {
//        return array(
//            //array('allow',
//            //    'actions' => array('orders', 'orderDetail','changeStatus'),
//            //    'expression' => 'Yii::app()->user->isEmployee()',
//            //),
//            array('allow',
//                'actions' => array('orders', 'orderDetail','changeStatus'),
//                'users' => array('*'),
//            ),
//            array('deny',
//                'users' => array('*'),
//            ),
//        );
//    }


    public function actionOrders($user)
    {
        $account = Account::model()->find('username = "' . $user . '"');

        $shopId = $account->shopId;
        $shop = Shop::model()->findByPk($shopId);
        $orders = array();
        if ($account->role == Constants::ROLE_CHEF)
            $orders = Orders::model()->findAll('shop_id =' . $shopId . ' AND  status=' . Constants::ORDER_NEW . ' OR (status =' . Constants::ORDER_IN_PROCESS . ' AND chef_id =' . $account->id . ')');
        if ($account->role == Constants::ROLE_DELIVERYMAN)
            $orders = Orders::model()->findAll('shop_id =' . $shopId . ' AND  status=' . Constants::ORDER_READY . ' OR (status =' . Constants::ORDER_ON_THE_WAY . ' AND deliveryman_id =' . $account->id . ')');

        $this->render('orders', array('orders' => $orders, 'shop' => $shop, 'account' => $account));
    }

    public function actionOrderDetail($id, $user)
    {
        $account = Account::model()->find('username = "' . $user . '"');
        $shopId = $account->shopId;
        $shop = Shop::model()->findByPk($shopId);
        $order = Orders::model()->findByPk($id);
        $customer = Account::model()->findByPk($order->account_id);
        $foods = OrderFood::model()->findAll('order_id =' . $id);
        $count = 0;
        $items = array();
        foreach ($foods as $food) {
            $food_detail = Food::model()->findByPk($food->food_id);
            $item_total = $food->number * $food->price;
            $items[] = array(
                'item_name' => $food_detail->food_name,
                'item_number' => $food->number,
                'item_price' => $food->price,
                'item_total' => $item_total
            );
            $count += $food->number;
        }

        $tax = CJSON::decode($shop->tax);
        $tax_rate = 0;
        if ($tax['tax_status'] == 1) {
            $tax_rate = $tax[Constants::TAX_NAME];

        }

        $orderTotal = OrderTotal::model()->find('orderId =' . $id);
        $tax_amount = $orderTotal->tax;
        $shipping_amount = $orderTotal->shipping;
        $total = $orderTotal->total;
        $grandTotal = $orderTotal->grandTotal;

        $this->render('order_detail', array('order' => $order,
            'shop' => $shop,
            'account' => $account,
            'customer' => $customer,
            'count' => $count,
            'items' => $items,
            'shipping_amount' => $shipping_amount,
            'tax_amount' => $tax_amount,
            'tax_rate' => $tax_rate,
            'total' => $total,
            'grandTotal' => $grandTotal
        ));

    }

    public function actionChangeStatus($status, $id, $grand_total, $user)
    {
        $account = Account::model()->find('username = "' . $user . '"');
        $order = Orders::model()->findByPk($id);
        if ($order->status != Constants::ORDER_DELIVERED) {
            $shopId = $order->shop_id;
            $shop = Shop::model()->findByPk($shopId);
            $ownerId = $shop->account_id;
            if ($account->role == Constants::ROLE_CHEF)
                $order->chef_id = $account->id;
            if ($account->role == Constants::ROLE_DELIVERYMAN)
                $order->deliveryman_id = $account->id;

            $order->status = $status;
            $order->save();
            if ($status == Constants::ORDER_DELIVERED)
                Orders::model()->calculateFinance($shopId, $ownerId, $grand_total);
        }
        $this->redirect(Yii::app()->createUrl('employee/orders', array('user'=>$user)));
    }

}