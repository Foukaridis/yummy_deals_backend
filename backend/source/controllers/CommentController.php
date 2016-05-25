<?php

class CommentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = Constants::LAYOUT_MAIN;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions' => array('delete', 'view', 'searchByShop'),
				'expression'=>'Yii::app()->user->isShopOwner() OR Yii::app()->user->isAdmin() OR Yii::app()->user->isModerator()',
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Comment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comment']))
		{
			$model->attributes=$_POST['Comment'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$shopId = $model->location_id;
		$food_id = $model->food_id;
		$model->delete();
		Comment::model()->updateCommentCount($shopId, $food_id);
		$this->redirect(Yii::app()->createUrl('comment/searchByShop',array('id'=>$shopId)));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
		//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */


	public function actionSearchByShop($id)
	{
		//check is owner
		$userId = Yii::app()->user->id;
		$role = Yii::app()->user->role;
		if($role == 1){
			if(Shop::checkOwnerShop($id, $userId)== false)
				$this->redirect(Yii::app()->createUrl('error/errorShopOwner'));

		}

		$comment= new Comment('search');
		$comment->unsetAttributes();  // clear any default values
		$comment->location_id = $id;
		if(isset($_POST['Comment']))
		{
			$comment->attributes= $_POST['Comment'];
		}

		$shop = Shop::model()->findByPk($id);

		$model = new Comment();

		$this->render('index',array(
			'model'=>$model,
			'comment'=>$comment,
			'shop'=>$shop,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
