<?php

class OpenHourController extends Controller
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
                'actions' => array('index','update'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($id)
    {

        $model = new OpenHourDetail();
        $model->unsetAttributes();
        $dataList=$model->searchByShop($id);
        $shop = Shop::model()->findByPk($id);

        $this->render('index', array(
            'dataList' => $dataList,
            'shopId'=>$id,
            'shop'=>$shop
        ));
    }

    public function actionUpdate($id)
    {
        $model = new OpenHourDetailForm();
        $model->loadModel($id);

        if (isset($_POST['OpenHourDetailForm'])) {
            $model->attributes = $_POST['OpenHourDetailForm'];
                if ($model->update($id)) {
                    $this->redirect(Yii::app()->createUrl('openHour/index',array('id'=>$model->shopId)));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
        }
        $destinationTimezone = Shop::model()->findByPk($model->shopId)->gmt;
        $sourceTimezone  = 'GMT';

        $new_object = Constants::convertObjectTime($model, $sourceTimezone, $destinationTimezone);

       /* $model['openAM'] = Constants::convertTime($model->openAM, $sourceTimezone,$destinationTimezone);
        $model['closeAM'] = Constants::convertTime($model->closeAM, $sourceTimezone,$destinationTimezone);
        $model['openPM'] = Constants::convertTime($model->openPM, $sourceTimezone,$destinationTimezone);
        $model['closePM'] = Constants::convertTime($model->closePM, $sourceTimezone,$destinationTimezone);*/

        $model['openAM'] = $new_object->openAM;
        $model['closeAM'] = $new_object->closeAM;
        $model['openPM'] = $new_object->openPM;
        $model['closePM'] = $new_object->closePM;


        $this->render('update', array(
            'model' => $model,
            'shopId'=>$model->shopId,
        ));
    }

}