<?php

class RequestShopOwnerAction extends CAction
{
    public function run()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';

        if (strlen($user_id) == 0) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => 'ERROR',
                'data' => '',
                'message' => 'Required fields missing',)));
            Yii::app()->end();
        }
		
		 $user = Account::model()->findByPk($user_id);

        if(!isset($user))
        {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => 'ERROR',
                'data' => '',
                'message' => 'User does not exist',)));
            Yii::app()->end();
        }
        else
        {
            if($user->role != Constants::ROLE_CUSTOMER)
            {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => 'ERROR',
                    'data' => '',
                    'message' => 'You can not perform this action',)));
                Yii::app()->end();
            }
        }
		
        $check = Request::model()->find('user_id ='.$user_id);

        if(!isset($check))
        {
            $comment = new Request();
            $comment->user_id = $user_id;
            $comment->created = DateTimeUtils::createInstance()->now();
            if($comment->save())
            {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => '',
                    'message' => 'Request sent',)));
            }
            else
            {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'Fail to send request',)));
            }
        }
        else
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => 'You have already sent to us the request for registration as shop owner. Please wait for processing!',)));
    }
    
}