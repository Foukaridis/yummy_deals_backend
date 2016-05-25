<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetListMenuByShopAction extends CAction
{

    public function run()
    {
        if (isset($_GET['s_id'])) {
            /**
             * @var Menu $menu
             * @var Food $food
             * */
            $shopId=$_GET['s_id'];
            $menus =Menu::model()->getListMenuByShop($shopId);
            $result = array();
            /** @var Menu $item */
            foreach ($menus as $item) {

                $countFood=Food::model()->countFoodByShopAndMenu($shopId,$item->menu_id);

                $result[] = array(
                    'menu_id' => $item->menu_id,
                    'menu_name' => $item->menu_name,
                    'menu_description' => $item->menu_id == null ? '' : $item->menu_desc,
                    'menu_thumbnail' => $item->menu_small_thumbnail == null ? '' : SiteController::actionGetUrlImage($item->menu_id, $item->menu_small_thumbnail, DIRECTORY_MENU),
                    'shop_id' => $shopId,
                    'food_count'=>$countFood,
                );
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