<?php
/**
 */

class PromotionController extends Controller
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
                'actions' => array(
                    'index',
                    'searchByShop',
                    'create',
                    'update',
                    'delete',
                    'getListFoodByPromotion',
                    'getListFoodByShop',
                    'addToPromotion',
                    'removeFromPromotion',
                ),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($id)
    {
        $shop=Shop::model()->findByPk($id);
        $dataList = null;
        $model = new Promotion();
        $model->unsetAttributes();
        $modelSearchForm = new SearchPromotionForm();

        if (isset($_POST['SearchPromotionForm'])) {
            $modelSearchForm->attributes = $_POST['SearchPromotionForm'];
            $model = $modelSearchForm->search($id);
            $dataList = $model->searchByShop($model->shop_id);

        } else {
            $dataList = $model->search();
        }
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shop' => $shop,
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

        $modelSearchForm = new SearchPromotionForm();
        $model = new Promotion();
        $model->unsetAttributes();

        if (isset($_POST['SearchPromotionForm'])) {
            $modelSearchForm->attributes = $_POST['SearchPromotionForm'];
            $model = $modelSearchForm->search($id);
            $dataList = $model->searchByShopAndStatus($model->shop_id,$model->status);
        } else {
            $dataList = Promotion::model()->searchByShop($id);
        }

        $shop=Shop::model()->findByPk($id);
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shop' => $shop,
        ));
    }

    public function actionGetListFoodByPromotion($shopId, $promotionId)
    {
        $dataList = Food::model()->searchByPromotion($promotionId);

        $this->render('foodIndex', array(
            'dataList' => $dataList,
            'shopId' => $shopId,
            'promotionId' => $promotionId,
            'isFoodPromotion' => true,
        ));
    }

    public function actionGetListFoodByShop($shopId, $promotionId)
    {
        $dataList = Food::model()->searchByShop($shopId);

        $this->render('foodIndex', array(
            'dataList' => $dataList,
            'shopId' => $shopId,
            'promotionId' => $promotionId,
            'isFoodPromotion' => false,
        ));
    }

    public function actionAddToPromotion($promotionId, $foodId, $isFoodPromotion)
    {
        $promotion = Promotion::model()->findByPk($promotionId);
        $foodPromotion = new FoodPromotion();
        $foodPromotion->food_id = $foodId;
        $foodPromotion->promotion_id = $promotionId;

        $foodPromotion->save();
        if (!$isFoodPromotion)
            $this->redirect(Yii::app()->createUrl('promotion/getListFoodByShop', array('shopId' => $promotion->shop_id, 'promotionId' => $promotionId)));
        else
            $this->redirect(Yii::app()->createUrl('promotion/getListFoodByPromotion', array('shopId' => $promotion->shop_id, 'promotionId' => $promotionId)));
    }

    public function actionRemoveFromPromotion($promotionId, $foodId, $isFoodPromotion)
    {
        $promotion = Promotion::model()->findByPk($promotionId);
        $foodPromotion = FoodPromotion::model()->findFoodPromotion($promotionId, $foodId);
        $foodPromotion->delete();
        if (!$isFoodPromotion)
            $this->redirect(Yii::app()->createUrl('promotion/getListFoodByShop', array('shopId' => $promotion->shop_id, 'promotionId' => $promotionId)));
        else
            $this->redirect(Yii::app()->createUrl('promotion/getListFoodByPromotion', array('shopId' => $promotion->shop_id, 'promotionId' => $promotionId)));

    }

    public function actionCreate($shopId)
    {
        $model = new PromotionForm();
        $model->eventShop = $shopId;

        if (isset($_POST['PromotionForm'])) {
            $model->attributes = $_POST['PromotionForm'];
            $newThumb = CUploadedFile::getInstance($model, 'eventNewThumb');

            if ($this->validateForm($model)) {
                if (empty($newThumb) && !is_object($newThumb)) {
                    Yii::app()->user->setFlash('_error_', Yii::t('promotion', 'msg.errorNoImage'));
                } else {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->eventImage = $fileName;
                    if ($model->save()) {
                        if (!empty($newThumb) && is_object($newThumb)) {
                            $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_PROMOTION;
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);
                        }
                        $this->redirect(Yii::app()->createUrl('promotion/searchByShop', array('id' => $shopId)));
                    } else {
                        Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                    }
                }
            }
        }
        //set param shop :
        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "Select Shop";
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }
        $this->render('create', array(
            'model' => $model,
            'shops' => $shops,
        ));

    }

    public function actionUpdate($id)
    {
        $model = new PromotionForm();
        $model->loadModel($id);

        if (isset($_POST['PromotionForm'])) {
            $model->attributes = $_POST['PromotionForm'];
            if ($this->validateForm($model)) {
                $oThumb = $model->eventImage;
                $newThumb = CUploadedFile::getInstance($model, 'eventNewThumb');
                if (!empty($newThumb) && is_object($newThumb)) {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->eventImage = $fileName;
                }
                if ($model->update($id)) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_PROMOTION;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);

                        $oThumb = $uploadDir . DIRECTORY_SEPARATOR . $oThumb;
                        if (file_exists($oThumb) && is_file($oThumb)) {
                            unlink($oThumb);
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('promotion/searchByShop', array('id' => $model->eventShop)));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }
        //set param shop :
        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "Select Shop";
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }


        $this->render('update', array(
            'model' => $model,
            'shops' => $shops,
            'shopId' => $model->eventShop,
        ));
    }

    public function actionDelete($id)
    {
        /** @var Promotion $model */
        $model = Promotion::model()->findByPk($id);
        if ($model != null) {
            //delete food promotion :
            $food_promotions=FoodPromotion::model()->findAllFoodPromotionByPromotion($id);

            foreach($food_promotions as $food)
            {
                $food->delete();
            }
            //delete promotion
            $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_PROMOTION;
            $image = $model->promotion_image;
            $model->delete();
            if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                unlink($path . DIRECTORY_SEPARATOR . $image);
            }
        }
        $this->redirect(Yii::app()->createUrl('promotion/searchByShop', array('id' => $model->shop_id)));
    }

    public function validateForm($model)
    {
        /** @var FoodForm $model */
        //check location
        if (Promotion::model()->checkExistCode($model->eventCode, $model->eventCurrentCode, $model->eventShop)) {
            Yii::app()->user->setFlash('_error_', 'Event Code is existed !');
            return false;
        } else if (strtotime($model->eventStartDate) > strtotime($model->eventEndDate)) {
            Yii::app()->user->setFlash('_error_', 'End date have to after than start date');
            return false;
        } else if ($model->eventShop == 0) {
            Yii::app()->user->setFlash('_error_', Yii::t('promotion', 'msg.errorShop'));
            return false;
        }
        return true;
    }
}