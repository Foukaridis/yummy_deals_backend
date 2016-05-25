<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class GetListShopAction extends CAction
{

    public function run()
    {
        if (isset($_GET['lat']) && isset($_GET['long']) && isset($_GET['now'])) {

            $lat = $_GET['lat'];
            $long = $_GET['long'];
            $now = $_GET['now'];
            $open = isset($_GET['open']) ? $_GET['open'] : '1';// Default is open shops

            $shops = Shop::model()->findAllShopByLatLong($lat, $long);

            $dateId = date(' N', $now);


            $server_timezone = date_default_timezone_get();
            $sourceTimezone = 'GMT';

            $result = array();

            /** @var Shop $item */
            foreach ($shops as $item) {

                $isOpen = 1;

                /** @var OpenHourDetail $openTime */
                $openTime = OpenHourDetail::model()->getOpenHourByShopAndDate($item->location_id, $dateId + 1);
                $openHour = array();
                if (isset($openTime)) {

                    $new_object = Constants::convertObjectTime($openTime, $sourceTimezone, $server_timezone);

                    $open_AM = strtotime($new_object->openAM);
                    $close_AM = (strtotime($new_object->closeAM) > $open_AM) ? strtotime($new_object->closeAM) : strtotime($new_object->closeAM) + 86400;
                    $open_PM = (strtotime($new_object->openPM) > $open_AM) ? strtotime($new_object->openPM) : strtotime($new_object->openPM) + 86400;
                    $close_PM = (strtotime($new_object->closePM) > $open_AM) ? strtotime($new_object->closePM) : strtotime($new_object->closePM) + 86400;

                    $openHour = array(
                        'date_id' => $openTime->dateId,
                        'date_name' => Datetb::model()->findByPk($openTime->dateId)->fullDateName,
                        'open_AM' => $open_AM,
                        'close_AM' => $close_AM,
                        'open_PM' => $open_PM,
                        'close_PM' => $close_PM,
                    );

                    if ($open == 1) {
                        if ($now < $open_AM
                            OR
                            (($now > $close_AM) AND ($now < $open_PM))
                            OR
                            $now > $close_PM
                        )
                            continue;
                    } else {

                        if ($now < $open_AM
                            OR
                            (($now > $close_AM) AND ($now < $open_PM))
                            OR
                            $now > $close_PM
                        )
                            $isOpen = 0;
                    }
                }
                $tax = CJSON::decode($item->tax);
                $shipping = CJSON::decode($item->shipping);
                $tax_rate = $tax['tax_status'] == 1 ? $tax[Constants::TAX_NAME] : 0;
                $shipping_rate = array('shipping_fee' => $shipping['shipping_status'] == 1 ? $shipping[Constants::FLAT_RATE] : 0,
                    'minimum' => $shipping['minimum']);
                $result[] = array(
                    'shop_id' => $item->location_id,
                    'shop_name' => $item->location_name,
                    'shop_address' => $item->location_address == null ? '' : $item->location_address,
                    'shop_city' => $item->location_city == null ? '' : $item->location_city,
                    'shop_tel' => $item->location_tel == null ? '' : $item->location_tel,
                    'shop_description' => $item->location_des == null ? '' : $item->location_des,
                    'shop_thumbnail' => $item->location_image == null ? '' : SiteController::actionGetUrlImage($item->location_id, $item->location_image, DIRECTORY_SHOP),
                    'shop_latitude' => $item->location_latitude == null ? '' : $item->location_latitude,
                    'shop_longitude' => $item->location_longitude == null ? '' : $item->location_longitude,
                    'shop_openHour' => $item->location_open_hour == null ? '' : $item->location_open_hour,
                    'shop_openHourInDay' => $openHour,
                    'shop_lastOrder' => $item->location_last_order_hour == null ? '' : $item->location_last_order_hour,
                    'status' => $item->status == null ? '' : $item->status,
                    'shop_vat' => $tax_rate,
                    'shop_transport_fee' => $shipping_rate,
                    'rate' => $item->rate == '' ? '0' : $item->rate,
                    'rate_times' => $item->rate_times == '' ? '0' : $item->rate_times,
                    'is_open' => $isOpen,
                    'isVerified' => $item->isVerified,
                    'isFeatured' => $item->isFeatured,
                    'facebook' => $item->facebook,
                    'twitter' => $item->twitter,
                    'email' => $item->email,
                    'live_chat' => $item->live_chat,
                );
            }
            if (count($result)) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => $result,
                    'count' => count($result),
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