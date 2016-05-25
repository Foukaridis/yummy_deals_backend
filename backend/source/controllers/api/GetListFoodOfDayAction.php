<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class GetListFoodOfDayAction extends CAction
{

    public function run()
    {
        if (isset($_GET['lat']) && isset($_GET['long']) && isset($_GET['now'])) {

            $lat = $_GET['lat'];
            $long = $_GET['long'];
            $now = $_GET['now'];

            $shops = Shop::model()->findAllShopByLatLong($lat, $long);

            $dateId = date(' N', $now);
            $server_timezone = date_default_timezone_get();
            $sourceTimezone = 'GMT';

            $result = array();

            /** @var Food $item */
            if (count($shops) > 0) {
                foreach ($shops as $shop) {
                    if ($shop->status == Constants::STATUS_ACTIVE) {
                        $openTime = OpenHourDetail::model()->getOpenHourByShopAndDate($shop->location_id, $dateId + 1);
                        $openHour = null;
                        if (isset($openTime)) {

                            $new_object = Constants::convertObjectTime($openTime, $sourceTimezone, $server_timezone);

                            $open_AM = strtotime($new_object->openAM);
                            $close_AM = (strtotime($new_object->closeAM) > $open_AM) ? strtotime($new_object->closeAM) : strtotime($new_object->closeAM) + 86400;
                            $open_PM = (strtotime($new_object->openPM) > $open_AM) ? strtotime($new_object->openPM) : strtotime($new_object->openPM) + 86400;
                            $close_PM = (strtotime($new_object->closePM) > $open_AM) ? strtotime($new_object->closePM) : strtotime($new_object->closePM) + 86400;


                            if (!($now < $open_AM
                                OR
                                (($now > $close_AM) AND ($now < $open_PM))
                                OR
                                $now > $close_PM
                            ))
                            {
                                $foods = Food::model()->getFoodsOfDayByShop($shop->location_id);
                                foreach ($foods as $item) {
                                    $promotion = Promotion::model()->searchPromotionActiveByFoodAndDate($item->food_id, DateTimeUtils::createInstance()->now());
                                    $result[] = array(
                                        'food_id' => $item->food_id == '' ? '' : $item->food_id,
                                        'food_code' => $item->food_code == '' ? '' : $item->food_code,
                                        'food_name' => $item->food_name == '' ? '' : $item->food_name,
                                        'food_price' => $item->food_price == '' ? '' : $item->food_price,
                                        'food_percent_discount' => $promotion == null ? 0 : $promotion->percent_discount,
                                        'food_shop' => $item->shop_id == '' ? '' : $item->shop_id,
                                        'food_menu' => $item->food_menus == '' ? '' : $item->food_menus,
                                        'food_thumbnail' => $item->food_thumbnail == '' ? '' : SiteController::actionGetUrlImage($item->food_id, $item->food_thumbnail, DIRECTORY_FOOD),
                                        'food_description' => $item->food_desc == '' ? '' : $item->food_desc,
                                        'status' => $item->status == '' ? '' : $item->status,
                                        'rate' => $item->rate == '' ? '0' : $item->rate,
                                        'rate_times' => $item->rate_times == '' ? '0' : $item->rate_times,
                                    );
                                }
                            }
                        }
                    }
                }
            }
            if (count($result)) {
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