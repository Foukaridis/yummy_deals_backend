<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetListFoodBySearchAction extends CAction
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
            && isset($_REQUEST['open']) //open:1 all: 0
            && isset($_REQUEST['now'])
        ) {

            $keyword = $_REQUEST['keyword'];
            $cityId = $_REQUEST['c_id'];
            $menuId = $_REQUEST['m_id'];
            $page = $_REQUEST['page'];
            $now = $_REQUEST['now'];

//sort condition
            $sort_name = $_REQUEST['sort_name'];
            if($sort_name == 'name')
            {
                $sortName = 'food_name';
            }
            elseif($sort_name == 'date')
            {
                $sortName = 'food_id';
            }
            else
                $sortName = 'rate';
            $sort_type = $_REQUEST['sort_type'];

            $orderCondition = $sortName. ' ' .$sort_type;

            $distance = $_REQUEST['distance'];
            $lat = $_REQUEST['lat'];
            $long = $_REQUEST['long'];
            $open = $_REQUEST['open'];

            //shop query
            $shopCriteria = new CDbCriteria();
            if($cityId != 0){
                $shopCriteria->compare('location_city', $cityId);
            }
            $shopCriteria->compare('status', 1);
            if($distance!=0)
            {
                $shopCriteria->addCondition('(((acos(sin(('.$lat.'*pi()/180)) *
                    sin((`location_latitude`*pi()/180))+cos(('.$lat.'*pi()/180)) *
                    cos((`location_latitude`*pi()/180)) * cos((('.$long.'-
                            `location_longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) <= '.$distance);
            }

            $shops= Shop::model()->findAll($shopCriteria);
            $shopIds =array();

            foreach($shops as $shop)
            {
                $shopIds[]= $shop->location_id;
            }

            if($open == 1)
            {
                $shopIds =  Constants::getOpenShop($shopIds,$now);
            }

//food query
            //remove this
            //$foods = Food::model()->getFoodsBySearch($keyword, $cityId, $menuId);
            //$count=count($foods);
            $rows_per_page = 5;
            $start_index= ($page-1)*$rows_per_page;
            $result = array();

            $criteria = new CDbCriteria;
            //remove this
            /*
            if($cityId != 0){
                $criteria->addCondition('shop_id IN (SELECT location_id FROM location WHERE location_city='.$cityId.')');
            }*/

            $criteria->addInCondition('shop_id', $shopIds);

            if($menuId != 0){
                $criteria->compare('food_menus', $menuId);
            }
            $criteria->compare('status_in_day', 1);
            $criteria->compare('status', 1);
            if($keyword != ''){
                $criteria->addCondition("food_name LIKE '%".$keyword."%'");
            }
            $criteria->order = $orderCondition;

            $count = Food::model()->count($criteria);


            $criteria->limit= $rows_per_page;
            $criteria->offset= $start_index;
            $food= Food::model()->findAll($criteria);


            $allpage=ceil($count/$rows_per_page);


            /** @var Food $item */
            $promotion=null;
            foreach ($food as $item) {

                if($item->shop->status == Constants::STATUS_ACTIVE ) {
                    $promotion = Promotion::model()->searchPromotionActiveByFoodAndDate($item->food_id, DateTimeUtils::createInstance()->now());
                    $shop = Shop::model()->findByPk($item->shop_id);
                    $menu = Menu::model()->findByPk($item->food_menus);
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
                        'rate' => $item->rate == '' ? '' : $item->rate,
                        'rate_times' => $item->rate_times == '' ? '' : $item->rate_times,
                        'category' => $menu->menu_name == '' ? '' : $menu->menu_name,
                        'shop_address' => $shop->location_address == '' ? '' : $shop->location_address,
                        'shop_phone' => $shop->location_tel == '' ? '' : $shop->location_tel,
                        'shop_lat' => $shop->location_latitude == '' ? '' : $shop->location_latitude,
                        'shop_long' => $shop->location_longitude == '' ? '' : $shop->location_longitude,
                        'shop_name' => $shop->location_name == '' ? '' : $shop->location_name,
                        'shop_image_url' => $shop->location_image == '' ? '' : SiteController::actionGetUrlImage($shop->location_id, $shop->location_image, DIRECTORY_SHOP),
                    );
                }
            }

            if (count($result)) {
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::SUCCESS,
                    'data' => $result,
                    'count'=>$count,
                    'allpage'=>$allpage,
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