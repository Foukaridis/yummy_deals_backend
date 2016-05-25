<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class GetListOpenHourByShopAction extends CAction
{

    public function run()
    {
        if (isset($_GET['s_id'])//Unix time from client)
        ) {

            $shopId = $_GET['s_id'];
            $openTime = OpenHourDetail::model()->getByShop($shopId);
            $server_timezone = date_default_timezone_get();
            $sourceTimezone = 'GMT';


            $openHour = array();
            if (isset($openTime)) {

                foreach ($openTime as $openT) {
                    /*$openAM = Constants::convertTime($openT->openAM, $sourceTimezone, $server_timezone);
                    $closeAM = Constants::convertTime($openT->closeAM, $sourceTimezone, $server_timezone);
                    $openPM = Constants::convertTime($openT->openPM, $sourceTimezone, $server_timezone);
                    $closePM = Constants::convertTime($openT->closePM, $sourceTimezone, $server_timezone);*/

                    $new_object = Constants::convertObjectTime($openT, $sourceTimezone, $server_timezone);

                    $openAM = strtotime($new_object->openAM);
                    $closeAM = (strtotime($new_object->closeAM) > $openAM )? strtotime($new_object->closeAM) : strtotime($new_object->closeAM) +86400;
                    $openPM = (strtotime($new_object->openPM) > $openAM )? strtotime($new_object->openPM) : strtotime($new_object->openPM) +86400;
                    $closePM = (strtotime($new_object->closePM) > $openAM )? strtotime($new_object->closePM) : strtotime($new_object->closePM) +86400;

                    $openHour[] = array(
                        'date_id' => $openT->dateId,
                        'date_name' => Datetb::model()->findByPk($openT->dateId)->fullDateName,
                        'open_AM' => $openAM,
                        'close_AM' => $closeAM,
                        'open_PM' => $openPM,
                        'close_PM' => $closePM,
                    );
                }

            }

            if (count($openHour)) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => $openHour,
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