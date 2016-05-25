<?php
class GetUserInfoByIdAction extends CAction
{
    public function run()
    {
        if (isset($_GET['id'])) {
            /** @var Menu $item */

            $item = Account::model()->findByPk($_GET['id']);



            if ($item != null) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => array(
                        'id' => $item->id,
                        'username' => $item->username,
                        'email' => $item->email==null?'':$item->email,
                        'full_name' => $item->full_name==null?'':$item->full_name,
                        'phone' => $item->phone==null?'':$item->phone,
                        'address' => $item->address==null?'':$item->address,
                        'status' => $item->status==null?'':$item->status,
                    ),
                    'message' => '',
                )));
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