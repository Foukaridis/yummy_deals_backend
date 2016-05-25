<?php
/**
 * Created by Lorge.
 * User: Only Love
 * Date: 12/27/13 - 9:31 AM
 */

class MenuController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        //Create list data
        $data = new Menu('search');
        $data->unsetAttributes();

        if (isset($_GET['Menu'])) {
            $data->attributes = $_GET['Menu'];
        }

        //Create model search
        $searchModel = new Menu();

        //Return data
        $this->render('index', array(
            'data' => $data,
            'searchModel' => $searchModel,
        ));
    }

    public function actionCreate()
    {
        $model = new MenuForm();
        if (isset($_POST['MenuForm'])) {
            $model->attributes = $_POST['MenuForm'];
            if ($this->validateForm($model)) {
                $newThumb = CUploadedFile::getInstance($model, 'menuNewThumb');
                if (empty($newThumb) && !is_object($newThumb)) {
                    Yii::app()->user->setFlash('_error_', Yii::t('menu', 'msg.errorNoImage'));
                } else {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->menu_small_thumbnail = $fileName;
                    if ($model->save()) {
                        if (!empty($newThumb) && is_object($newThumb)) {
                            $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_MENU . DIRECTORY_SEPARATOR . $model->menu_id;
                            if (!file_exists($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);
                        }
                        $this->redirect(Yii::app()->createUrl('menu/index'));
                    } else {
                        Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                    }
                }
            }
        }

        //set param menu:
        $arrMenus = Menu::model()->findAll();
        $menus = array();
        $menus[0] = "Root category";
        foreach ($arrMenus as $item) {
            $menus[$item->menu_id] = $item->menu_name;
        }

        $this->render('create', array(
            'model' => $model,
            'menus' => $menus,
        ));

    }

    public function actionUpdate($id)
    {
        $model = new MenuForm();
        $model->loadModel($id);
        if (isset($_POST['MenuForm'])) {
            $model->attributes = $_POST['MenuForm'];
            if ($this->validateForm($model)) {
                $oThumb = $model->menu_small_thumbnail;
                $newThumb = CUploadedFile::getInstance($model, 'menuNewThumb');
                if (!empty($newThumb) && is_object($newThumb)) {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->menu_small_thumbnail = $fileName;
                }
                if ($model->update($id)) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_MENU . DIRECTORY_SEPARATOR . $id;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);

                        $oThumb = $uploadDir . DIRECTORY_SEPARATOR . $oThumb;
                        if (file_exists($oThumb) && is_file($oThumb)) {
                            unlink($oThumb);
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('menu/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }

        //set param menu:
        $arrMenus = Menu::model()->getListAllCategoryForUpDate($id);
        $menus = array();
        $menus[0] = "Root category";
        foreach ($arrMenus as $item) {
            $menus[$item->menu_id] = $item->menu_name;
        }

        $this->render('update', array(
            'model' => $model,
            'menus' => $menus,
        ));
    }

    public function actionDelete($id)
    {
        $menus=Menu::model()->getChildMenusByParent($id);
        if(count($menus)>0)
        {
            foreach($menus as $menu)
            {
                $this->delete($menu->menu_id);
            }
        }
        $this->delete($id);
        $this->redirect(Yii::app()->createUrl('menu/index'));
    }

    public function delete($id)
    {
        /** @var Menu $model */
        $model = Menu::model()->findByPk($id);
        if ($model != null) {

            //delete all food of this menu :
            $foods = Food::model()->findAllByMenu($id);
            if (count($foods) > 0) {
                foreach ($foods as $food) {
                    $pathFood = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_FOOD . DIRECTORY_SEPARATOR . $food->food_id;
                    $image = $food->food_thumbnail;
                    if ($food->delete()) {
                        if (file_exists($pathFood . DIRECTORY_SEPARATOR . $image) && is_file($pathFood . DIRECTORY_SEPARATOR . $image)) {
                            unlink($pathFood . DIRECTORY_SEPARATOR . $image);
                        }
                    }
                }
            }
            //delete this menu :
            $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_MENU . DIRECTORY_SEPARATOR . $id;
            $image = $model->menu_small_thumbnail;
            $model->delete();
            if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                unlink($path . DIRECTORY_SEPARATOR . $image);
            }
        }
    }

    private function validateForm($model)
    {
        /** @var MenuForm $model */
        if ($model->menuOldName != null && $model->menuOldName == $model->menu_name) {
            return true;
        }
        if (Menu::model()->checkExistName($model->menu_name)) {
            Yii::app()->user->setFlash('_error_', 'Category Name is existed !');
            return false;
        }
        return true;
    }
}