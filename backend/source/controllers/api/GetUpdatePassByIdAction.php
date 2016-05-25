<?php
class GetUpdatePassByIdAction extends CAction
{
    public function run()
    {

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $pass = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : '';
        if (isset($_GET['id'])&& isset($_GET['pass'])) {
            $user= Account::model()->findbyPk($id);
            if(count ($user)>0){
                $user->password = sha1($pass);
                if($user->save())
                {
                    ApiController::sendResponse(400, CJSON::encode(array(
                        'status' => Constants::SUCCESS,
                        'data' => '',
                        'message' => 'Update Success!',
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