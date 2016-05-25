<?php
class GetShopByIdAction extends CAction
{

    public function run()
    {
        if (isset($_GET['s_id'])) {
            /** @var Shop $item */
            /** @var OpenHourDetail $openTime */
            $item = Shop::model()->findByPk($_GET['s_id']);
            //get banner
            $arrBanner = array();
            $banners = Banner::model()->getBannersActiveByShop($item->location_id);
            if ($banners != null) {
                /** @var Banner $banner */
                foreach($banners as $banner)
                    $arrBanner[] = array(
                        'banner_id' => $banner->bannerId,
                        'banner_name' => $banner->bannerName,
                        'banner_image' => SiteController::actionGetUrlImage(DIRECTORY_BANNER, $banner->bannerImage, DIRECTORY_SHOP),
                    );
            }
            $tax=  CJSON::decode($item->tax);
            $shipping=  CJSON::decode($item->shipping);
            $tax_rate =  $tax['tax_status'] == 1?  $tax[Constants::TAX_NAME]: 0;
            $shipping_rate = array('shipping_fee' => $shipping['shipping_status'] == 1?  $shipping[Constants::FLAT_RATE]: 0,
                'minimum'=>$shipping['minimum']);
            if ($item != null) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => array(
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
                        'shop_banners'=>$arrBanner,
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

        } else {
            ApiController::sendResponse(400, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => Yii::t('common', 'msg.badRequest'),
            )));
        }
    }

}