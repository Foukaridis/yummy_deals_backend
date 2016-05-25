<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

class SendOrderAction extends CAction
{

    public function run()
    {
        if (isset($_GET['data']) && isset($_GET['paymentMethod']) ) {

           $data = $_GET['data'];
           $paymentMethod = $_GET['paymentMethod'];
			
//            $data1='{"account_id":"1396947160",
//            "address":"1396947160",
//            "item":[
//            {"shop_id":29,"food_id":58,"number":2,"price":4},
//            {"shop_id":26,"food_id":51,"number":2,"price":4},
//            {"shop_id":26,"food_id":54,"number":3,"price":4}
//            ]}';

/*
        $data = '{"account_id":1414741099,"address":"17 Phung Chi Kien","item":[
            {"shop_id":39,"number":1,"food_id":2,"price":50},
            {"shop_id":38,"food_id":3,"number":2,"price":22},
            {"shop_id":38,"food_id":1,"number":4,"price":99}
        ]}';
*/
        $paymentMethod =1;
        $orderList = array();
        $grand_total =0;

            $isSave = FALSE;
            if (!Yii::app()->db->currentTransaction) {
                $transaction = Yii::app()->db->beginTransaction();
            }
            try {
                $jsonData = json_decode($data, TRUE);
                $account = $jsonData['account_id'];
                $address = $jsonData['address'];
                $ordersData = $jsonData['item'];
                $orderTime = DateTimeUtils::createInstance()->now();
                $orderList = array();
                $order = null;
				//$group_code = time().'-'.$account;
                $group_code = Constants::generateOrderGroupId($account);
				
                $total= array();


                foreach ($ordersData as $item) {
                    $shopId = $item['shop_id'];
                    $shop = Shop::model()->findByPk($shopId);
                    if ($shop != null) {
                        $order = Orders::model()->getExistOrder($account, $shopId, $orderTime);
                        if ($order == null) {
                            $order = new Orders();
                            $order->account_id = $account;
                            $order->shop_id = $shopId;
                            $order->order_places = $address;
                            $order->order_time = $orderTime;
                            $order->created = $orderTime;
                            $order->paymentMethod = $paymentMethod;
                            $order->group_code = $group_code;
                            $order->status = Constants::ORDER_NEW;
                            if($paymentMethod == 0)
                            {
                                $order->paymentStatus = 1;
                            }
                            else
                            {
                                $order->paymentStatus = 0;
                            }
                            $order->save();
                            $orderList[]=$order;

                            $userShop=UserShop::model()->searchByAccountId($shopId,$account);
                            if($userShop==null)
                            {
                                $userShop=new UserShop;
                                $userShop->shopId=$shopId;
                                $userShop->accountId=$account;
                                $userShop->order_count=1;
                                $userShop->save();
                            }else{
                                $userShop->order_count=$userShop->order_count+1;
                                $userShop->save();
                            }
                        }

                        $foodOrder = new OrderFood();
                        $foodOrder->order_id = $order->order_id;
                        $foodOrder->food_id = $item['food_id'];
                        $foodOrder->price = $item['price'];
                        $foodOrder->number = $item['number'];

                        $foodOrder->save();

                        $total[$order->order_id][] = $item['price']*$item['number'];

                    }

                }



                foreach($orderList as $order)
                {
                    $total_by_order = array_sum($total[$order->order_id]);


                    $shop = Shop::model()->findByPk($order->shop_id);
                    $tax=  CJSON::decode($shop->tax);
                    $shipping=  CJSON::decode($shop->shipping);
                    $tax_rate =  $tax['tax_status'] == 1 ?  $tax[Constants::TAX_NAME]: 0;
                    $tax_total = $total_by_order*$tax_rate/100;
                    $total_included_tax = $total_by_order + $tax_total;
                    if($shipping['shipping_status'] == 1)
                    {
                        $minimum =  $shipping['minimum'];
                        if($total_included_tax >= $minimum && $minimum !=0 )
                            $shipping_fee = 0;
                        else
                        {
                            $flat_rate = $shipping[Constants::FLAT_RATE];
                            $shipping_fee = $flat_rate;
                        }
                    }
                    else
                    {
                        $shipping_fee =0;
                    }
                    $shipping_tax = $shipping_fee*$tax_rate/100;
                    $tax_total = $tax_total + $shipping_tax;

                    $order_grand_total= $total_by_order + $tax_total + $shipping_fee;
                    $grand_total += $order_grand_total;
                    $order_total = new OrderTotal();
                    $order_total->orderId = $order->order_id;
                    $order_total->total = $total_by_order;
                    $order_total->tax = $tax_total;
                    $order_total->shipping = $shipping_fee;
                    $order_total->grandTotal = $order_grand_total ;
                    $order_total->dateCreated = $orderTime;
                    $order_total->save();


                }

                $order_group = new OrderGroup();
                $order_group->group_code = $group_code;
                $order_group->total = $grand_total;
                $order_group->dateCreated = $orderTime;
                $order_group->account_id = $account;
                $order_group->save();


                $transaction->commit();
                $isSave = true;

            } catch (Exception $e) // an exception is raised if a query fails
            {
                $transaction->rollback();
            }


            if ($isSave)
            {


                foreach($orderList as $order)
                {
                   MailUtils::createInstance()->sendMailToShopOwner($order);
                }

                if($paymentMethod == 1)
                {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::SUCCESS,
                        'data' => '',
                        'message' => 'OK',

                    )));
                }
                elseif($paymentMethod == 0)
                {
                    ApiController::sendResponse(200, CJSON::encode(array(
                        'status' => Constants::SUCCESS,
                        'data' => '',
                        'message' => 'OK',
                    )));
                }

            }
            else
            {
				
                ApiController::sendResponse(200, CJSON::encode(array(
                    'status' => Constants::ERROR,
                    'data' => '',
                    'message' => 'save false!',
                )));
            }
		}
    }

}