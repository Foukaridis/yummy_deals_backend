<?php

class GetListShopByMenuAction extends CAction
{

    public function run()
    {
        if (isset($_GET['m_id'])) {
            $menuId=$_GET['m_id'];
            $shops = Shop::model()->findAllShopActiveByMenu($menuId);
            $count = count($shops);
            $result = array();
            $dateId = getdate()['wday'];
            /** @var Shop $item */
            foreach ($shops as $item) {
                /** @var OpenHourDetail $openTime */
                $openTime = OpenHourDetail::model()->getOpenHourByShopAndDate($item->location_id, $dateId + 1);
                $openHour = null;
                if ($openTime != null) {
                    $openHour = array(
                        'date_id' => $openTime->dateId,
                        'date_name' => Datetb::model()->findByPk($openTime->dateId)->fullDateName,
                        'open_AM' => $openTime->openAM==null?'': date('H:i', strtotime($openTime->openAM)),
                        'close_AM' => $openTime->closeAM==null?'':date('H:i', strtotime($openTime->closeAM)),
                        'open_PM' => $openTime->openPM==null?'':date('H:i', strtotime($openTime->openPM)),
                        'close_PM' => $openTime->closePM==null?'':date('H:i', strtotime($openTime->closePM)),
                    );
                }

                $tax=  CJSON::decode($item->tax);
                $shipping=  CJSON::decode($item->shipping);
                $tax_rate =  $tax['tax_status'] == 1?  $tax[Constants::TAX_NAME]: 0;
                $shipping_rate = array('shipping_fee' => $shipping['shipping_status'] == 1?  $shipping[Constants::FLAT_RATE]: 0,
                    'minimum'=>$shipping['minimum']);
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
                    'rate'=> $item->rate == '' ? '0' : $item->rate,
                    'rate_times' => $item->rate_times == '' ? '0' : $item->rate_times,
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