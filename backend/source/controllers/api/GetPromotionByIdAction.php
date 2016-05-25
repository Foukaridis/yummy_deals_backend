<?php
class GetPromotionByIdAction extends CAction
{

    public function run()
    {
        if (isset($_GET['o_id'])) {
            /** @var Promotion $item */
            $promotionId=$_GET['o_id'];
            $item = Promotion::model()->findByPk($promotionId);
            if ($item != null) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => array(
                        'promotion_id' => $item->promotion_id,
                        'shop_id' => $item->shop_id,
                        'promotion_description' => $item->promotion_desc == null ? '' : $item->promotion_desc,
                        'promotion_thumbnail' => $item->promotion_image == null ? '' : SiteController::actionGetUrlImage(DIRECTORY_PROMOTION, $item->promotion_image, DIRECTORY_SHOP),
                        'promotion_end_date'=>$item->end_date,
                        'promotion_end_time'=>$item->end_time,
                        'promotion_status'=>$item->status,
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