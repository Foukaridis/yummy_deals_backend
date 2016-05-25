<?php
/**
 * Created by Lorge.
 * User: Only Love
 * Date: 12/27/13 - 9:31 AM
 */

class ShopController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete','getUsers','getUserDetail'),
                'expression'=>'Yii::app()->user->isShopOwner() OR Yii::app()->user->isAdmin() OR Yii::app()->user->isModerator()',
				'users' => array('@'),
            ),
            array('allow',
                'actions'=>array('shopEmployee','createEmployee','deleteEmployee', 'shippingAndTax'),
                'expression'=>'Yii::app()->user->isShopOwner()',
				'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $arrCity = City::model()->findAll();
        $cities = array();
        foreach ($arrCity as $item) {
            $cities[$item->cityId] = $item->cityName;
        }


        $shop = new Shop('search');
        $shop->unsetAttributes();

        if (isset($_GET['Shop'])) {
            $shop->attributes = $_GET['Shop'];
        }

        $model = new Shop();

        $this->render('index', array(
            'shop' => $shop,
            'model' => $model,
            'cities' => $cities,
        ));
    }


    public function actionCreate()
    {
        //set param city :
        $arrCity = City::model()->findAll();
        $cities = array();
        $cities[0] = "Select City";
        foreach ($arrCity as $item) {
            $cities[$item->cityId] = $item->cityName;
        }

        //set accounts :
        $arrAccount = Account::model()->getListAccountRoleOwner();
        $accounts = array();
        $accounts[0] = "Select Owner";
        foreach ($arrAccount as $item) {
            $accounts[$item->id] = $item->username;
        }


        $model = new ShopForm();
        if (isset($_POST['ShopForm'])) {
            $model->attributes = $_POST['ShopForm'];
            if ($this->validateForm($model)) {
                $newThumb = CUploadedFile::getInstance($model, 'shopTempImage');
                if (empty($newThumb) && !is_object($newThumb)) {
                    Yii::app()->user->setFlash('_error_', Yii::t('shop', 'msg.errorNoImage'));
                } else {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->location_image = $fileName;
                    if ($model->save()) {
                        if (!empty($newThumb) && is_object($newThumb)) {
                            $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . $model->location_id;
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);
                        }

                        $this->redirect(Yii::app()->createUrl('shop/index'));
                    } else {
                        Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData').':' . $model->location_image);
                    }
                }
            }

        }
        $this->render('create', array(
            'model' => $model,
            'cities' => $cities,
            'accounts' => $accounts,
        ));

    }

    public function actionUpdate($id)
    {

        $userId = Yii::app()->user->id;
        $role = Yii::app()->user->role;
        if($role == 1){
            if(Shop::checkOwnerShop($id, $userId)== false)
                $this->redirect(Yii::app()->createUrl('error/errorShopOwner'));

        }
        //set param city :
        $arrCity = City::model()->findAll();
        $cities = array();
        $cities[0] = "Select City";
        foreach ($arrCity as $item) {
            $cities[$item->cityId] = $item->cityName;
        }

        //set accounts :
        $arrAccount = Account::model()->getListAccountRoleOwner();
        $accounts = array();
        $accounts[0] = "Select Owner";
        foreach ($arrAccount as $item) {
            $accounts[$item->id] = $item->username;
        }


        $model = new ShopForm();
        $model->loadModel($id);
        if (isset($_POST['ShopForm'])) {
            $model->attributes = $_POST['ShopForm'];
            if ($this->validateForm($model)) {
                $oThumb = $model->location_image;
                $newThumb = CUploadedFile::getInstance($model, 'shopTempImage');
                if (!empty($newThumb) && is_object($newThumb)) {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->location_image = $fileName;
                }
                if ($model->update($id)) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . $id;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);

                        $oThumb = $uploadDir . DIRECTORY_SEPARATOR . $oThumb;
                        if (file_exists($oThumb) && is_file($oThumb)) {
                            unlink($oThumb);
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('shop/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'cities' => $cities,
            'accounts' => $accounts,
        ));
    }

    public function actionDelete($id)
    {
        /** @var Shop $model */

        if (Yii::app()->user->role != 2)
        {
            $this->redirect(Yii::app()->createUrl('error/errorPermissionPerform'));
        }

        $model = Shop::model()->findByPk($id);
        if ($model != null) {
            //delete all banner of this shop :
            $banners = Banner::model()->findAllByShop($id);
            $pathBanner = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_BANNER;
            if (count($banners) > 0) {
                foreach ($banners as $banner) {
                    $image = $banner->bannerImage;
                    if ($banner->delete()) {
                        if (file_exists($pathBanner . DIRECTORY_SEPARATOR . $image) && is_file($pathBanner . DIRECTORY_SEPARATOR . $image)) {
                            unlink($pathBanner . DIRECTORY_SEPARATOR . $image);
                        }
                    }
                }
            }
            //delete all promotion of this shop :
            $promotions = Promotion::model()->findAllByShop($id);
            $pathPromotion = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_PROMOTION;
            if (count($promotions) > 0) {
                foreach ($promotions as $promotion) {
                    $image = $promotion->promotion_image;
                    if ($promotion->delete()) {
                        if (file_exists($pathPromotion . DIRECTORY_SEPARATOR . $image) && is_file($pathPromotion . DIRECTORY_SEPARATOR . $image)) {
                            unlink($pathPromotion . DIRECTORY_SEPARATOR . $image);
                        }
                    }
                }
            }
            //delete all food of this shop :
            $foods = Food::model()->findAllByShop($id);
            if (count($foods) > 0) {
                foreach ($foods as $food) {
                    $pathFood = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $food->food_id;
                    $image = $food->food_thumbnail;
                    if ($food->delete()) {
                        if (file_exists($pathFood . DIRECTORY_SEPARATOR . $image) && is_file($pathFood . DIRECTORY_SEPARATOR . $image)) {
                            unlink($pathFood . DIRECTORY_SEPARATOR . $image);
                            rmdir ($pathFood);
                        }
                    }
                }
            }
            //delete open hour
            OpenHourDetail::model()->deleteAll('shopId ='.$id);
            //delete this shop :

            $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . $id;
            $image = $model->location_image;
            $model->delete();
            if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                unlink($path . DIRECTORY_SEPARATOR . $image);
                rmdir ($path);
            }
        }
        $this->redirect(Yii::app()->createUrl('shop/index'));
    }

    public function validateForm($model)
    {
        /** @var ShopForm $model */
        //check location
        if (is_float($model->longitude) || is_numeric($model->longitude)) {
            if ($model->longitude > 180 || $model->longitude < -180) {
                Yii::app()->user->setFlash('_error_', Yii::t('shop', 'msg.errorLongitude'));
                return false;
            }
        } else {
            Yii::app()->user->setFlash('_error_', Yii::t('shop', 'msg.errorLongitude'));
            return false;
        }

        if (is_float($model->latitude) || is_numeric($model->latitude)) {
            if ($model->latitude > 90 || $model->latitude < -90) {
                Yii::app()->user->setFlash('_error_', Yii::t('shop', 'msg.errorLatitude'));
                return false;
            }
        } else {
            Yii::app()->user->setFlash('_error_', Yii::t('shop', 'msg.errorLatitude'));
            return false;
        }
        //check exist name
        if ($model->oldLocationName != null) {
            if (($model->oldLocationName != $model->location_name)) {
                if (Shop::model()->checkExistName($model->location_name)) {
                    Yii::app()->user->setFlash('_error_', 'Shop Name is existed !');



                    return false;
                }
            }
        } else if (Shop::model()->checkExistName($model->location_name)) {
            Yii::app()->user->setFlash('_error_', 'Shop Name is existed !');
            return false;
        } else if ($model->location_city == 0) {
            Yii::app()->user->setFlash('_error_', 'Please, select city !');
            return false;
        }


        return true;
    }
    //shop user :
    public function actionGetUsers($id)
    {
        $model = new UserShop();
        $model->unsetAttributes();
        $dataList = $model->searchByShop($id);

        $shop=Shop::model()->findByPk($id);
        $this->render('users', array(
            'dataList' => $dataList,
            'shop' => $shop,
        ));
    }

    public function actionGetUserDetail($id)
    {
        $model = UserShop::model()->findByPk($id);
        $account=Account::model()->findByPk($model->accountId);
        $shop=Shop::model()->findByPk($model->shopId);
        $dataList = Orders::model()->searchByShopAndUser($model->shopId,$model->accountId);

        $this->render('userShopDetails', array(
            'dataList' => $dataList,
            'shop' => $shop,
            'account'=>$account,
        ));
    }

    public function actionShopEmployee($id)
    {
		//check is owner
        $userId = Yii::app()->user->id;
        $role = Yii::app()->user->role;
        if($role == 1){
            if(Shop::checkOwnerShop($id, $userId)== false)
                $this->redirect(Yii::app()->createUrl('error/errorShopOwner'));

        }

        $shop=Shop::model()->findByPk($id);

        $model = new Account();
        $model->unsetAttributes();
        $shopSearch = new SearchEmployeeForm();
        if (isset($_POST['SearchEmployeeForm'])) {
            $shopSearch->attributes = $_POST['SearchEmployeeForm'];
            $model = $shopSearch->search();
            $dataList = $model->searchByModel();
        } else {
            $dataList = $model->searchEmployee($id);
        }

        $roles = array();
        $roles[Constants::ROLE_CHEF] = 'Chef';
        $roles[Constants::ROLE_DELIVERYMAN] = 'Delivery Man';
        $roles[Constants::ROLE_MODERATOR] = 'Moderator';

        $employee = new Account();

        $this->render('employee', array(
            'dataList' => $dataList,
            'shop'=>$shop,
            'modelSearchForm' => $shopSearch,
            'roles' => $roles,
            'employee'=>$employee
        ));
    }


    public function actionCreateEmployee($id)
    {
        header('Content-type: application/json');

        $model = new Account();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ajax']) AND isset($_POST['Account'])) {
            $model->attributes = $_POST['Account'];
            $model->id =  DateTimeUtils::createInstance()->nowStr();
            if($_POST['Account']['password']!= NULL)
                $model->password =sha1($_POST['Account']['password']);
            if(isset($_POST['Account']['role']))
                $model->role = $_POST['Account']['role'];
            else
                $model->role = null;
            $model->shopId = $id;
            $model->status = 1;

            if (!$model->validate()) {
                echo CJSON::encode(array(
                    'success' => true,
                    'valid' => false,
                    'errors' => CHtml::errorSummary($model),
                ));
                return;
            } else {
                $model->save(false);
                echo CJSON::encode(array(
                    'success' => true,
                    'valid' => true,
                ));
                return;
            }
        }
        echo CJSON::encode(array(
            'success' => false,
            'valid' => false,
            'message' => 'Invalid Request!'
        ));
    }

    public function actionDeleteEmployee($id,$shopId)
    {

        $model = Account::model()->findByPk($id);
        if($model->role !=1 or $model->role!=2 )
        {
            $model->delete();
        }
        $this->redirect(Yii::app()->createUrl('shop/shopEmployee',array('id'=>$shopId)));


    }

    public function actionShippingAndTax($id)
    {
		//check is owner
        $userId = Yii::app()->user->id;
        $role = Yii::app()->user->role;
        if($role == 1){
            if(Shop::checkOwnerShop($id, $userId)== false)
                $this->redirect(Yii::app()->createUrl('error/errorShopOwner'));

        }

        $this->title = Yii::t('shop', 'label.viewTaxShipping');
        $shop=Shop::model()->findByPk($id);

        $model = new TaxShippingForm();
        $data = $model->loadModel($id);

        if (isset($_POST['TaxShippingForm'])) {
            $model->attributes = $_POST['TaxShippingForm'];
            $result = $model->update($id);
            if ($result === SettingForm::ERROR_NONE) {
                $this->redirect(Yii::app()->createUrl('shop/shippingAndTax',array('id'=>$id)));
            } else {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
            }
        }

        $this->render('shipping_tax', array(
            'model' => $data,
            'shop'=>$shop,
        ));
    }

}