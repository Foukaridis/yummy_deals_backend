<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetFeedbackAction extends CAction
{

    public function run()
    {
        $account_id = isset($_REQUEST['account_id']) ? $_REQUEST['account_id'] : '';
        $tittle = isset($_REQUEST['tittle']) ? $_REQUEST['tittle'] : '';
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';

        if (isset($_GET['type']) && isset($_GET['account_id']) && isset($_GET['tittle']) && isset($_GET['description']) ) {
            $feedback = new Feedback();
            $feedback->account_id = $account_id;
            $feedback->tittle = $tittle;
            $feedback->description = $description;
            $feedback->created = DateTimeUtils::createInstance()->now();
            $feedback->status = 0;
            $feedback->type = $type;

            if ($feedback->save()) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => '',
                    'message' => '',
                )));
            } else {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'Send Feedback is false, please try again !',
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