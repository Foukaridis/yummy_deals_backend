<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetListBannerByShopAction extends CAction
{

    public function run()
    {
        if (isset($_GET['s_id'])) {

            $shopId=$_GET['s_id'];
            $banner =Banner::model()->getBannersActiveByShop($shopId);
            $count=count($banner);
            $result = array();
            /** @var Banner $item */
            foreach ($banner as $item) {
                $result[] = array(
                    'banner_id' => $item->bannerId,
                    'banner_name' => $item->bannerName,
                    'banner_image' => $item->bannerImage == null ? '' : SiteController::actionGetUrlImage(DIRECTORY_BANNER, $item->bannerImage, DIRECTORY_SHOP),
                    'shop_id'=>$item->shopId,
                    'banner_status'=>$item->status,

                );
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

        } else {
            ApiController::sendResponse(400, CJSON::encode(array(
                'status' => Constants::ERROR,
                'data' => '',
                'message' => Yii::t('common', 'msg.badRequest'),
            )));
        }
    }

}