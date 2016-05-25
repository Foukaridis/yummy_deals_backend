<?php
/**
 */

class BannerController extends Controller
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
                'actions' => array('index', 'searchByShop', 'create', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        //set param shop :
        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "All Banners";
        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }
        $dataList = null;
        $model = new Banner();
        $model->unsetAttributes();
        $modelSearchForm = new SearchBannerForm();

        if (isset($_POST['SearchBannerForm'])) {
            $modelSearchForm->attributes = $_POST['SearchBannerForm'];
            $model = $modelSearchForm->search();
            $dataList = $model->searchByShop($model->shopId);
        } else {
            $dataList = $model->search();
        }
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shops' => $shops,
        ));
    }

    public function actionSearchByShop($id)
    {
        $model = new Banner();
        $model->unsetAttributes();
        $modelSearchForm = new SearchBannerForm();

        if (isset($_POST['SearchBannerForm'])) {
            $modelSearchForm->attributes = $_POST['SearchBannerForm'];
            $model = $modelSearchForm->search($id);
            $dataList = $model->searchByShopAndStatus($model->shopId,$model->status);
        } else {
            $dataList = Banner::model()->searchByShop($id);
        }

        $shop=Shop::model()->findByPk($id);
        $this->render('index', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shop' => $shop,
        ));
    }

    public function actionCreate($shopId)
    {
        $model = new BannerForm();
        $model->shopId=$shopId;

        if (isset($_POST['BannerForm'])) {
            $model->attributes = $_POST['BannerForm'];
            $newThumb = CUploadedFile::getInstance($model, 'bannerNewThumb');
            if ($model->shopId == 0) {
                Yii::app()->user->setFlash('_error_', Yii::t('banner', 'msg.errorShop'));
            } else if (empty($newThumb) && !is_object($newThumb)) {
                Yii::app()->user->setFlash('_error_', Yii::t('banner', 'msg.errorNoImage'));
            } else {
                $fileName = time() . '.' . $newThumb->extensionName;
                $model->bannerImage = $fileName;
                if ($model->save()) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_BANNER;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);
                    }
                    $this->redirect(Yii::app()->createUrl('banner/searchByShop',array('id'=>$model->shopId)));
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

        $this->render('create', array(
            'model' => $model,
            'shops' => $shops,
        ));

    }

    public function actionUpdate($id)
    {
        $model = new BannerForm();
        $model->loadModel($id);

        if (isset($_POST['BannerForm'])) {
            $model->attributes = $_POST['BannerForm'];
            if ($model->shopId == 0) {
                Yii::app()->user->setFlash('_error_', Yii::t('promotion', 'msg.errorShop'));
            } else {
                $oThumb = $model->bannerImage;
                $newThumb = CUploadedFile::getInstance($model, 'bannerNewThumb');
                if (!empty($newThumb) && is_object($newThumb)) {
                    $fileName = time() . '.' . $newThumb->extensionName;
                    $model->bannerImage = $fileName;
                }
                if ($model->update($id)) {
                    if (!empty($newThumb) && is_object($newThumb)) {
                        $uploadDir = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_BANNER;
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $newThumb->saveAs($uploadDir . DIRECTORY_SEPARATOR . $fileName);

                        $oThumb = $uploadDir . DIRECTORY_SEPARATOR . $oThumb;
                        if (file_exists($oThumb) && is_file($oThumb)) {
                            unlink($oThumb);
                        }
                    }
                    $this->redirect(Yii::app()->createUrl('banner/searchByShop',array('id'=>$model->shopId)));
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
        /** @var Banner $model */
        $model = Banner::model()->findByPk($id);
        if ($model != null) {
            $path = $this->uploadFolder . DIRECTORY_SEPARATOR . DIRECTORY_SHOP . DIRECTORY_SEPARATOR . DIRECTORY_BANNER;
            $image = $model->bannerImage;
            $model->delete();
            if (file_exists($path . DIRECTORY_SEPARATOR . $image) && is_file($path . DIRECTORY_SEPARATOR . $image)) {
                unlink($path . DIRECTORY_SEPARATOR . $image);
            }
        }
        $this->redirect(Yii::app()->createUrl('banner/searchByShop',array('id'=>$model->shopId)));
    }
}