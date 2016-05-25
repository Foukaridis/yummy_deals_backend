<?php

class FinanceController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','shopOwner','withdraw', 'withdrawHistory'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'withdrawRequestManagement', 'approveRequest', 'rejectRequest'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
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
		$model=new Finance;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Finance']))
		{
			$model->attributes=$_POST['Finance'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Finance']))
		{
			$model->attributes=$_POST['Finance'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Finance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

        $arrShop = Shop::model()->findAll();
        $shops = array();
        $shops[0] = "All Shops";

        foreach ($arrShop as $item) {
            $shops[$item->location_id] = $item->location_name;
        }

        $dataList = null;
        $model = new Finance();
        $model->unsetAttributes();

        $modelSearchForm = new SearchOrderForm();

        if (isset($_POST['SearchOrderForm'])) {
            $modelSearchForm->attributes = $_POST['SearchOrderForm'];
            $shop_id = $modelSearchForm->shop_id;
            $status = $modelSearchForm->status;

            $dataList = $model->searchByShopAndStatus($shop_id, $status);
        } else {
            $dataList = $model->search();
        }
        $this->render('admin', array(
            'dataList' => $dataList,
            'modelSearchForm' => $modelSearchForm,
            'shop' => $shops,
        ));


	}

	public function actionShopOwner()
	{
		$user_id = Yii::app()->user->id;
		$shops = Shop::model()->findAll('account_id ='.$user_id);
		$bill = FinanceOwner::model()->find('ownerId='.$user_id);
		$dataList = null;
		$model = new Finance();
		if (count($shops)!= 0) {
			$shops_id = array();
			foreach ($shops as $shop) {
				$shops_id[] = $shop->location_id;
			}
			$shop_ids = implode(',', $shops_id);
			$dataList = $model->searchByOwner($shop_ids);
		}


		//Calculate acount balance
		$this->render('shopOwner', array(
			'dataList' => $dataList,
			'bill'=>$bill,
		));


	}


	public function actionWithdrawRequestManagement()
	{
		$arrShop = Account::model()->findAll();
		$shops = array();
		$shops[0] = "All owner";

		foreach ($arrShop as $item) {
			$shops[$item->id] = $item->full_name;
		}

		$dataList = null;
		$model = new FinanceHistory();
		$model->unsetAttributes();

		$modelSearchForm = new SearchHistoryForm();

		if (isset($_POST['SearchHistoryForm'])) {
			$modelSearchForm->attributes = $_POST['SearchHistoryForm'];
			$ownerId = $modelSearchForm->ownerId;
			$status = $modelSearchForm->status;

			$dataList = $model->searchByOwnerAndStatus($ownerId, $status);
		} else {
			$dataList = $model->search();
		}
		$this->render('withdrawManagement', array(
			'dataList' => $dataList,
			'modelSearchForm' => $modelSearchForm,
			'owners' => $shops,
		));


	}

	public function actionWithdrawHistory()
	{
		$user_id = Yii::app()->user->id;
		$dataList = null;
		$model = new FinanceHistory();
		$model->unsetAttributes();

		$dataList = $model->searchByOwner($user_id);


		$this->render('withdrawHistory', array(
			'dataList' => $dataList,
		));


	}

	public function actionApproveRequest($id)
	{
		$model = FinanceHistory::model()->findByPk($id);
		$amount = $model->amount;
		$ownerId = $model->ownerId;
		$model -> status = 1;
		$model -> save();

		$financeOwner = FinanceOwner::model()->find('ownerId ='.$ownerId);
		$old = $financeOwner->budget;
		$financeOwner -> budget = $old - $amount;
		$financeOwner->save();

		$this->redirect(Yii::app()->createUrl('finance/withdrawRequestManagement'));
	}

	public function actionRejectRequest($id)
	{
		$model = FinanceHistory::model()->findByPk($id);
		$model -> status = 2;
		$model -> save();
		$this->redirect(Yii::app()->createUrl('finance/withdrawRequestManagement'));

	}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Finance the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Finance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Finance $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='finance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionWithdraw()
	{
		$amount = $_POST['amount'];
		if( is_numeric ($amount) and $amount !=0 )
		{
			$user_id = Yii::app()->user->id;
			$current_amount = FinanceOwner::model()->find('ownerId ='.$user_id)->budget;
			$old_request_amount = FinanceHistory::model()->findAll('ownerId ='.$user_id. ' AND status ='.Constants::FINANCE_STATUS_PENDING);
			if(count($old_request_amount)!=0)
			{
				foreach($old_request_amount as $item)
				{
					$current_amount -=  $item->amount;
				}
			}
			//if (abs(($current_amount-$amount)/$amount) < 0.00001)
			if (round($amount,2) <= round($current_amount,2))
			//This is php general trick to compare 2 float values
			{
				$new_request = new FinanceHistory();
				$new_request->ownerId = $user_id;
				$new_request->amount = $amount;
				$new_request->createdTime = date('Y-m-d H:i:s',strtotime('now'));
				$new_request->status = Constants::FINANCE_STATUS_PENDING;
				$new_request->save();
				echo 1;
			}
			else
				echo 0;
		}
		else
		{
			echo 2;
		}


	}
}
