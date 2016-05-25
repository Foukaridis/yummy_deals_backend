<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class RegisterAction extends CAction
{

    public function run()
    {
        if (isset($_GET['data'])) {

            $data = $_GET['data'];
            $jsonData = json_decode($data, TRUE);

            //Register for Normal User
            if ($jsonData['type'] == Constants::ACCOUNT_NORMAL) {
                $username = $jsonData['user_name'];
                $password = $jsonData['password'];
                $email = $jsonData['email'];
                $fullName = $jsonData['full_name'];
                $phone = $jsonData['phone'];
                $address = $jsonData['address'];

                if (Account::model()->checkExistUserName($username)) {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::ERROR,
                        'data' => '',
                        'message' => 'User name is used. Please, try again !',
                    )));
                }

                if (Account::model()->checkExistEmail($email)) {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::ERROR,
                        'data' => '',
                        'message' => 'This email is used. Please, try again !',
                    )));
                }

                $account = new Account();
                $account->id = DateTimeUtils::createInstance()->nowStr();
                $account->type = Constants::ACCOUNT_NORMAL;
                $account->username = trim($username);
                $account->password = sha1($password);
                $account->email = $email;
                $account->full_name = $fullName;
                $account->phone = $phone;
                $account->address = $address;
                $account->role = 0;
                $account->status = 1;

                if ($account->save()) {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::SUCCESS,
                        'data' => array(
                            'id' => $account->id,
                            'user_name' => $account->username,
                            'email' => $account->email,
                            'full_name' => $account->full_name,
                            'phone' => $account->phone,
                            'address' => $account->address,
                            'role' => $account->role,
                            'redirect' => "",
                            'type'=> $account->type,
                        ),
                        'message' => '',
                    )));
                } else {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::ERROR,
                        'data' => '',
                        'message' => 'Register is false, please try again !',
                    )));
                }
            } else {
                //Register for Facebook User
                if ($jsonData['type'] = Constants::ACCOUNT_FACEBOOK) {
                    $username = $jsonData['email'];
                    $password = Constants::genPassword();
                    $email = $jsonData['email'];
                    $fullName = $jsonData['full_name'];
                    $phone = '';
                    $address = '';

                    //Check if this user already register
                    if (Account::model()->checkExistEmail($email)) {
                        $account = Account::model()->getAccountByEmail($email);
                        if ($account->status == Constants::ACTIVE_ACCOUNT) {
                            $dashboardAction = '';
                            if ($account->role == Constants::ROLE_CHEF || $account->role == Constants::ROLE_DELIVERYMAN) {
                                $dashboardAction = Yii::app()->getBaseUrl(true) . '/employee/orders?user=' . $username . '&pass=' . $password;
                            }
                            ApiController::sendResponse(200, CJSON::encode(array(
                                'status' => Constants::SUCCESS,
                                'data' => array(
                                    'id' => $account->id,
                                    'user_name' => $account->username,
                                    'email' => $account->email,
                                    'full_name' => $account->full_name,
                                    'phone' => $account->phone,
                                    'address' => $account->address,
                                    'role' => $account->role,
                                    'redirect' => $dashboardAction,
                                    'type'=> $account->type,
                                ),
                                'message' => '',
                            )));
                        } else {
                            if ($account->status == Constants::INACTIVE_ACCOUNT) {
                                if ($account->status == Constants::INACTIVE_ACCOUNT) {
                                    ApiController::sendResponse(200, CJSON::encode(array(
                                        'status' => Constants::ERROR,
                                        'data' => '',
                                        'message' => 'Your account has been inactive',
                                    )));
                                }
                            }
                        }

                    } else {
                        $account = new Account();
                        $account->id = DateTimeUtils::createInstance()->nowStr();
                        $account->type = Constants::ACCOUNT_FACEBOOK;
                        $account->username = trim($username);
                        $account->password = sha1($password);
                        $account->email = $email;
                        $account->full_name = $fullName;
                        $account->phone = $phone;
                        $account->address = $address;
                        $account->role = 0;
                        $account->status = 1;

                        if ($account->save()) {
                            $account->password = $password;
                            MailUtils::createInstance()->sendMailToNewUserFacebook($account);
                            ApiController::sendResponse(200, CJSON::encode(array(
                                'status' => Constants::SUCCESS,
                                'data' => array(
                                    'id' => $account->id,
                                    'user_name' => $account->username,
                                    'email' => $account->email,
                                    'full_name' => $account->full_name,
                                    'phone' => $account->phone,
                                    'address' => $account->address,
                                    'role' => $account->role,
                                    'redirect' => "",
                                    'type'=> $account->type,
                                ),
                                'message' => '',
                            )));
                        } else {
                            ApiController::sendResponse(200, CJSON::encode(array(
                                'status' => Constants::ERROR,
                                'data' => '',
                                'message' => 'Register is false, please try again !',
                            )));
                        }
                    }
                }
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