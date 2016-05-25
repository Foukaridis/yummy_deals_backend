<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class GetOrderGroupDetailAction extends CAction
{

    public function run()
    {
        $group_code = isset($_REQUEST['group_code']) ? $_REQUEST['group_code'] : '';

        $results = Orders::model()->findAll("group_code ='".$group_code."'");
        $count = count($results);
        $data = array();
       foreach($results as $item)
       {
           $total = OrderTotal::model()->find("orderId ='".$item->order_id."'");
           $food = array();
           $order_foods = OrderFood::model()->findAll("order_id ='".$item->order_id."'");
           foreach($order_foods as $order_food)
           {
               $food_detail = Food::model()->findByPk($order_food->food_id);
               $food[]=array(
                   'food_id'=>$order_food->food_id,
                   'number'=>$order_food->number,
                   'price'=>$order_food->price,
                   'food_code' => $food_detail->food_code == '' ? '' : $food_detail->food_code,
                   'food_name' => $food_detail->food_name == '' ? '' : $food_detail->food_name,
                   'food_menu' => $food_detail->food_menus == '' ? '' : $food_detail->food_menus,
                   'food_thumbnail' => $food_detail->food_thumbnail == '' ? '' : SiteController::actionGetUrlImage($food_detail->food_id, $food_detail->food_thumbnail, DIRECTORY_FOOD),
                   'food_description' => $food_detail->food_desc == '' ? '' : $food_detail->food_desc,
                   'status' => $food_detail->status == '' ? '' : $food_detail->status,
               );

           }
            $shopRecord = Shop::model()->findByPk($item->shop_id);

           $data[] = array(
               'order_id' => $item->order_id == '' ? '' : $item->order_id,
               'account_id' => $item->account_id == '' ? '' : $item->account_id,
               'shop_id' => $item->shop_id,
				'shop_name'=> $shopRecord->location_name,
               'shop_thumbnail' => $shopRecord->location_image == null ? '' : SiteController::actionGetUrlImage($item->shop_id, $shopRecord->location_image, DIRECTORY_SHOP),
               'order_places' => $item->order_places == '' ? '' : $item->order_places,
               'total' => $total->total,
			   'tax'=> $total->tax,
               'shipping'=> $total->shipping,
               'grandTotal'=> $total->grandTotal,
               'order_time' => $item->order_time,
               'created' => $item->created == '' ? '' : date('H:i - d F Y',strtotime($item->created)),
               'orderStatus' => $item->status == '' ? '' : $item->status,
               'paymentStatus' => $item->paymentStatus == '' ? '' : $item->paymentStatus,
               'paymentMethod' => $item->paymentMethod == '' ? '' : $item->paymentMethod,
               'foods'=>$food
           );
       }

        if (count($data)>0) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => $data,
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
    }

}