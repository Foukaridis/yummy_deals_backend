<?php
/**
 * Created by Lorge.
 * User: Only Love
 * Date: 12/27/13 - 9:31 AM
 */

class CityController extends Controller
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
        $data = new City('search');
        $data->unsetAttributes();
        if (isset($_GET['City'])) {
            $data->attributes = $_GET['City'];
        }

        //Create model search
        $searchModel = new City();

        //Return data
        $this->render('index', array(
            'data' => $data,
            'searchModel' => $searchModel,
        ));
    }

    public function actionCreate()
    {
        $model = new CityForm();
        if (isset($_POST['CityForm'])) {
            $model->attributes = $_POST['CityForm'];
            if ($this->validateForm($model)) {
                    if ($model->save()) {
                        $this->redirect(Yii::app()->createUrl('city/index'));
                    } else {
                        Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                    }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));

    }

    public function actionUpdate($id)
    {
        $model = new CityForm();
        $model->loadModel($id);
        if (isset($_POST['CityForm'])) {
            $model->attributes = $_POST['CityForm'];
            if ($this->validateForm($model)) {
                if ($model->update($id)) {
                    $this->redirect(Yii::app()->createUrl('city/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        /** @var City $model */
        $model = City::model()->findByPk($id);
        if ($model != null) {
            $model->delete();
        }
        $this->redirect(Yii::app()->createUrl('city/index'));
    }

    public function validateForm($model)
    {
        /** @var CityForm $model */
        //check location
        if (City::model()->checkExistName($model->cityName,$model->cityCurrentName)) {
            Yii::app()->user->setFlash('_error_', 'City name is existed !');
            return false;
        }else if(City::model()->checkExistPostCode($model->cityPostCode,$model->cityCurrentPostCode))
        {
            Yii::app()->user->setFlash('_error_', 'Post code is existed !');
            return false;
        }
        return true;
    }
}