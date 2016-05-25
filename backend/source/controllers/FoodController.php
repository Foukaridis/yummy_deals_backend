<?php
/**
 */

class FoodController extends Controller
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
                'actions' => array('index', 'searchByShop', 'create', 'update', 'delete','updateDayStatus','checkUsage'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        //set param menu:
        $arrMenus = Menu::model()->findAll();
        $menus = array();
        $menus[0] = "Select Category";
        foreach ($arrMenus as $item) {
            $menus[$item->menu_id] = $item->menu_name;
        }
        //set param shop :
        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "Select Shop";
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }
        $dataList = null;
        $model = new Food();
        $modelSearchForm = new SearchFoodForm();
        $model->unsetAttributes();
        if (isset($_POST['SearchFoodForm'])) {
            /*echo '<pre>';
            var_dump($_POST['SearchFoodForm']);die;*/
            $modelSearchForm->attributes = $_POST['SearchFoodForm'];
            $model = $modelSearchForm->search();
            $dataList = $model->searchByModel();

        } else {
            $dataList = $model->search();
        }
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'menus' => $menus,
            'shops' => $shops,
        ));
    }

    public function actionSearchByShop($id)
    {
        //set param menu:
        $arrMenus = Menu::model()->findAll();
        $menus = array();
        $menus[0] = "Select Category";
        foreach ($arrMenus as $item) {
            $menus[$item->menu_id] = $item->menu_name;
        }
        //set param shop :
        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "Select Shop";
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }

        $modelSearchForm = new SearchFoodForm();
        $modelSearchForm->foodShop = $id;
        $dataList = Food::model()->searchByShop($id);
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'menus' => $menus,
            'shops' => $shops,
        ));
    }

    public function actionCreate($shopId)
    {
        $model = new FoodForm();
        $model->food_shop_id=$shopId;
        if (isset($_POST['FoodForm'])) {
            $model->attributes = $_POST['FoodForm'];
            $newThumb = CUploadedFile::getInstance($model, 'foodNewImage');
            if ($this->validateForm($model)) {
                if (empty($newThumb) && !is_object($newThumb)) {
                    Yii::app()->user->setFlash('_error_', Yii::t('food', 'msg.errorNoImage'));
                } else {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->food_image = $fileName;
                    if ($model->save()) {
                        if (!empty($newThumb) && is_object($newThumb)) {
                            $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $model->food_id;
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);
                        }
                        $this->redirect(Yii::app()->createUrl('food/searchByShop',array('id'=>$model->food_shop_id)));
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
        $model = new FoodForm();
        $model->loadModel($id);

        if (isset($_POST['FoodForm'])) {
            $model->attributes = $_POST['FoodForm'];
            if ($this->validateForm($model)) {
                $oThumb = $model->food_image;
                $newThumb = CUploadedFile::getInstance($model, 'foodNewImage');
                if (!empty($newThumb) && is_object($newThumb)) {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->food_image = $fileName;
                }
                if ($model->update($id)) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $id;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);

                        $oThumb = $uploadDir . DIRECTORY_SEPARATOR . $oThumb;
                        if (file_exists($oThumb) && is_file($oThumb)) {
                            unlink($oThumb);
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('food/searchByShop',array('id'=>$model->food_shop_id)));
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
        ));
    }

    public function actionDelete($id)
    {
        /** @var Food $model */
        $model = Food::model()->findByPk($id);
        if ($model != null) {

            //delete

            $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $id;
            $image = $model->food_thumbnail;
            $model->delete();
            if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                unlink($path . DIRECTORY_SEPARATOR . $image);
            }
        }
        $this->redirect(Yii::app()->createUrl('food/searchByShop',array('id'=>$model->shop_id)));
    }

    public function actionUpdateDayStatus($id)
    {
        /** @var Food $model */
        $model = Food::model()->findByPk($id);
        if ($model != null) {
           if($model->status_in_day==0)
           {
               $model->status_in_day=1;
           }else
           {
               $model->status_in_day=0;
           }

            $model->save();
        }
        $this->redirect(Yii::app()->createUrl('food/searchByShop',array('id'=>$model->shop_id)));
    }

    public function validateForm($model)
    {
        /** @var FoodForm $model */
        //check location
        if (Food::model()->checkExistCode($model->food_code,$model->food_current_code, $model->food_shop_id)) {
            Yii::app()->user->setFlash('_error_', 'Menu Code is existed !');
            return false;
        } else if ($model->food_shop_id == 0) {
            Yii::app()->user->setFlash('_error_', Yii::t('food', 'msg.errorShop'));
            return false;
        }

        return true;
    }
	
	public function actionCheckUsage()
    {
        if (Yii::app()->request->isPostRequest) {
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            header('Content-type: application/json');
            $message = 'Ok';
            $success = true;
            if (isset($_POST['foodId'])) {
                $id = $_POST['foodId'];
                $orders = OrderFood::model()->findAll('food_id ='.$id);

               if(count($orders)!=0)
               {
                   $success = false;
                   $message = 'Food is related to orders, you can not delete it.';
               }
                else
                {
                    $model = Food::model()->findByPk($id);
                    if ($model != null) {
                        $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $id;
                        $image = $model->food_thumbnail;
                        $model->delete();
                        if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                            unlink($path . DIRECTORY_SEPARATOR . $image);
                        }
                    }
                }
            }

            echo CJSON::encode(array(
                'success' => $success,
                'message' => $message
            ));
            return;
        }
    }
}