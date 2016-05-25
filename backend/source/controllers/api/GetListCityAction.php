<?php

class GetListCityAction extends CAction {

    public function run()
    {
        $cities=City::model()->findAll();
        $result = array();
        /** @var City $item */
        foreach($cities as $item){
            $result[] = array(
                'city_id' => $item->cityId,
                'city_post_code' => $item->cityPostCode,
                'city_name' => $item->cityName,
            );
        }

        if(count($result)){
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => $result,
                'message' => '',
            )));
        }else{
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => 'Not found!',
            )));
        }
    }

}