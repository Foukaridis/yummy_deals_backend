<?php

class FeedbackController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    public function actionIndex($type)
    {
		//Create list data
		$data = new Feedback('search');
		$data->unsetAttributes();

		//Create model search
		$searchModel = new Feedback();


		if (isset($_GET['Feedback'])) {
			$data->attributes = $_GET['Feedback'];
		}else{
			$data->type = $type;
			$searchModel->type = $type;
		}

		//Return data
		$this->render('index', array(
			'data' => $data,
			'searchModel' => $searchModel,
		));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new FeedbackForm();
		if(isset($_POST['FeedbackForm'])){
			$model->attributes=$_POST['FeedbackForm'];
			    if($model->save()){
                    $this->redirect(Yii::app()->createUrl('account/updateMyAccount',array('id'=>Yii::app()->user->id)));
                }else{
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
        $model = new FeedbackForm();
        $model->loadModel($id);

        if (isset($_POST['FeedbackForm'])) {
            $model->attributes=$_POST['FeedbackForm'];
            if ($model->update($id)) {
				if ($model->type == 1) // Feedback
					$this->redirect(array('index', 'type' => 'feedback'));
				else if ($model->type == 2) // Report
					$this->redirect(array('index', 'type' => 'report'));
				else  // GET FEATURED
					$this->redirect(array('index', 'type' => 'bug'));
            } else {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = Feedback::model()->findByPk($id);
        if ($model != null) {
            $model->delete();
        }
        if ($model->type == 1) // Feedback
			$this->redirect(array('index', 'type' => 'feedback'));
		else if ($model->type == 2) // Report
			$this->redirect(array('index', 'type' => 'report'));
		else  // GET FEATURED
			$this->redirect(array('index', 'type' => 'bug'));
	}
	/**
	 * Lists all models.
	 */

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Feedback('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Feedback']))
			$model->attributes=$_GET['Feedback'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Feedback the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Feedback::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Feedback $model the model to be validated
	 */


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
