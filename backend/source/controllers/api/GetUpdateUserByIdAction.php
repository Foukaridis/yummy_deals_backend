<?php
class GetUpdateUserByIdAction extends CAction
{
    public function run()
    {

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
        $full_name = isset($_REQUEST['full_name']) ? $_REQUEST['full_name'] : '';
        $phone  = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
        if (isset($_GET['id'])&& isset($_GET['email']) && isset($_GET['full_name']) && isset($_GET['phone'])&& isset($_GET['address']) ) {
            $user= Account::model()->findbyPk($id);
                if(count($user)>0){
                    $user->email  = $email;
                    $user->full_name = $full_name;
                    $user->phone = $phone;
                    $user->address = $address;
                    if($user->save())
                    {
                        ApiController::sendResponse(400, CJSON::encode(array(
                            'status' => Constants::SUCCESS,
                            'data' => '',
                            'message' => 'Update User Info Success!',
                        )));
                    }
                }

            else{
                ApiController::sendResponse(400, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'Update is false, please try again !',
                )));
            }
        }else{
            ApiController::sendResponse(400, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => Yii::t('common', 'msg.badRequest'),
            )));
        }
    }

}