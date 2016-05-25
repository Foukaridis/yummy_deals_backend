<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class LoginAction extends CAction
{

    public function run()
    {
        if (isset($_GET['user']) && isset($_GET['pass'])) {
            $user = $_GET['user'];
            $pass = $_GET['pass'];
            /** @var Account $account */

            $account = Account::model()->getAccount($user, sha1($pass));
            if ($account!=null) {
                if($account->status == Constants::ACTIVE_ACCOUNT){
                    $dashboardAction ='';
                    if($account->role == Constants::ROLE_CHEF || $account->role == Constants::ROLE_DELIVERYMAN )
                    {
                        $dashboardAction = Yii::app()->getBaseUrl(true).'/employee/orders?user='.$user.'&pass='.$pass;
                    }

                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::SUCCESS,
                        'data' => array(
                            'id'=>$account->id,
                            'user_name'=>$account->username,
                            'email'=>$account->email,
                            'full_name'=>$account->full_name,
                            'phone'=>$account->phone,
                            'address'=>$account->address,
                            'role'=>$account->role,
                            'redirect'=>$dashboardAction,
                            'type'=> $account->type,
                        ),
                        'message' => '',
                    )));
                }else{
                    if ($account->status == Constants::INACTIVE_ACCOUNT) {
                        ApiController::sendResponse(200, CJSON::encode(array(
                            'status' => Constants::ERROR,
                            'data' => '',
                            'message' => 'Your account has been inactive',
                        )));
                    }
                }
            } else {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'Not found!',
                )));
            }
        } else {
            ApiController::sendResponse(400, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => Yii::t('common', 'msg.badRequest'),
            )));
        }
    }

}