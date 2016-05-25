<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class GetDefaultLocation extends CAction
{

    public function run()
    {
        $setting = Settings::model()->findByPk('1382069043');
        if ($setting != null) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => array(
                    'lat' => $setting->location_latitude,
                    'lon' => $setting->location_longitude
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
    }

}