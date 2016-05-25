<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetListPromotionOfDayAction extends CAction
{

    public function run()
    {
            $promotions =Promotion::model()->findAllPromotionOfDay();
            $count=count($promotions);
            $result = array();
            /** @var Promotion $item */
            foreach ($promotions as $item) {
                if($item->shop->status == Constants::STATUS_ACTIVE ) {

                    $result[] = array(
                        'promotion_id' => $item->promotion_id,
                        'shop_id' => $item->shop_id,
                        'promotion_description' => $item->promotion_desc == null ? '' : $item->promotion_desc,
                        'promotion_thumbnail' => $item->promotion_image == null ? '' : SiteController::actionGetUrlImage(DIRECTORY_PROMOTION, $item->promotion_image, DIRECTORY_SHOP),
                        'promotion_end_date' => $item->end_date,
                        'promotion_end_time' => $item->end_time,
                        'promotion_status' => $item->status,

                    );
                }
            };

            if (count($result)) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => $result,
                    'count'=>$count,
                    'message' => '',
                )));
            } else {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'No data found!',
                )));
            }

    }

}