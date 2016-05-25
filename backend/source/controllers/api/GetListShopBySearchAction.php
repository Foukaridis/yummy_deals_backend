<?php

class GetListShopBySearchAction extends CAction
{

    public function run()
    {
        if (isset($_REQUEST['keyword'])
            && isset($_REQUEST['c_id'])
            && isset($_REQUEST['m_id'])
            && isset($_REQUEST['page'])
            && isset($_REQUEST['lat']) //lat
            && isset($_REQUEST['long']) //long
            && isset($_REQUEST['distance']) // km
            && isset($_REQUEST['sort_name']) //rate / name / date
            && isset($_REQUEST['sort_type']) //asc desc
            && isset($_REQUEST['open'])//open:1 all: 0
            && isset($_REQUEST['now'])//Unix time from client
        ) {

            $keyword = $_REQUEST['keyword'];
            $cityId = $_REQUEST['c_id'];
            $menuId = $_REQUEST['m_id'];
            $distance = $_REQUEST['distance'];
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['long'];

            $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $sort_name = $_REQUEST['sort_name'];
            if ($sort_name == 'name') {
                $sortName = 'location_name';
            } elseif ($sort_name == 'date') {
                $sortName = 'location_id';
            } else
                $sortName = 'rate';
            $sort_type = $_REQUEST['sort_type'];

            $orderCondition = $sortName . ' ' . $sort_type;

            $open = $_REQUEST['open'];

            $rows_per_page = 5;
            $start_index = ($page - 1) * $rows_per_page;
            $result = array();


            $criteria = new CDbCriteria;
            if ($cityId != 0) {
                $criteria->compare('location_city', $cityId);
            }
            $criteria->compare('status', 1);
            if ($menuId != 0) {
                $shopId = array();
                $foods = Food::model()->findAll('food_menus =' . $menuId);
                foreach ($foods as $food) {
                    $shopId[] = $food->shop_id;
                }
                if (count($shopId) > 0) {
                    $allId = implode(',', $shopId);
                    $criteria->addCondition(" location_id IN ( $allId ) ");
                }
            }
            if ($keyword != '') {
                $criteria->addCondition("location_name LIKE '%$keyword%'");
            }

            if ($distance != 0) {
                $criteria->addCondition('(((acos(sin((' . $lat . '*pi()/180)) *
                    sin((`location_latitude`*pi()/180))+cos((' . $lat . '*pi()/180)) *
                    cos((`location_latitude`*pi()/180)) * cos(((' . $long . '-
                            `location_longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) <= ' . $distance);
            }
            $orderCondition = "isFeatured desc, ".$orderCondition;
            $criteria->order = $orderCondition;
            $count = Shop::model()->count($criteria);
            $criteria->limit = $rows_per_page;
            $criteria->offset = $start_index;

            $shop = Shop::model()->findAll($criteria);

            $now = $_REQUEST['now']; //timestamp app

            $dateId = date(' N', $now);

            $allpage = ceil($count / $rows_per_page);

            $server_timezone = date_default_timezone_get();

            $sourceTimezone = 'GMT';
            /** @var Shop $item */
            foreach ($shop as $item) {
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


                    $openHour = array(
                        'date_id' => $openTime->dateId,
                        'date_name' => Datetb::model()->findByPk($openTime->dateId)->fullDateName,
                        'open_AM' => $open_AM,
                        'close_AM' => $close_AM,
                        'open_PM' => $open_PM,
                        'close_PM' => $close_PM,
                    );
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
                    'rate' => $item->rate == '' ? '' : $item->rate,
                    'rate_times' => $item->rate_times == '' ? '' : $item->rate_times,
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
                    'count' => $count,
                    'allpage' => $allpage,
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