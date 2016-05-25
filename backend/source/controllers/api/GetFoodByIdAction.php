<?php

class GetFoodByIdAction extends CAction
{

    public function run()
    {
        if (isset($_GET['f_id'])) {
            $foodId = $_GET['f_id'];
            $item = Food::model()->findByPk($foodId);
            /** @var Food $item */
            if ($item != null) {
                $promotion=Promotion::model()->searchPromotionActiveByFoodAndDate($item->food_id,DateTimeUtils::createInstance()->now());
                $result = array(
                    'food_id' => $item->food_id == '' ? '' : $item->food_id,
                    'food_code' => $item->food_code == '' ? '' : $item->food_code,
                    'food_name' => $item->food_name == '' ? '' : $item->food_name,
                    'food_price' => $item->food_price == '' ? '' : $item->food_price,
                    'food_percent_discount'=>$promotion==null? 0 : $promotion->percent_discount,
                    'food_shop' => $item->shop_id == '' ? '' : $item->shop_id,
                    'food_menu' => $item->food_menus == '' ? '' : $item->food_menus,
                    'food_thumbnail' => $item->food_thumbnail == '' ? '' : SiteController::actionGetUrlImage($item->food_id, $item->food_thumbnail, DIRECTORY_FOOD),
                    'food_description' => $item->food_desc == '' ? '' : $item->food_desc,
                    'status' => $item->status == '' ? '' : $item->status,
					'rate'=> $item->rate == '' ? '0' : $item->rate,
                    'rate_times' => $item->rate_times == '' ? '0' : $item->rate_times,
                );


                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => $result,
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