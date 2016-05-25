<?php

class ErrorController extends Controller
{
    public $layout = Constants::LAYOUT_ERROR;

    public function actionErrorShopOwner()
    {
        $this->render('error', array(
            'code'=>'500',
            'message'=> 'You do not have permission to update this shop'
        ));
    }
	
	public function actionErrorPermission()
    {
        $this->render('error', array(
            'code'=>'500',
            'message'=> 'You do not have permission to enter this page'
        ));
    }

    public function actionErrorPermissionPerform()
    {
        $this->render('error', array(
            'code'=>'500',
            'message'=> 'You do not have permission to perform this action'
        ));
    }

}






