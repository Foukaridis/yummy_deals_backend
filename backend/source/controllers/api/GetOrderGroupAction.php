<?php

/**
 * Created by JetBrains PhpStorm.
 * User: HUY
 * Date: 3/7/14
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */
class GetOrderGroupAction extends CAction
{

    public function run()
    {
        $account = isset($_REQUEST['account']) ? $_REQUEST['account'] : '';
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
        $foods = OrderGroup::model()->findAll("account_id ='" . $account . "'");
        $count=count($foods);
		
        $rows_per_page = 10;
        $allpage=ceil($count/$rows_per_page);
        $start_index= ($page-1)*$rows_per_page;




        $criteria = new CDbCriteria();
        $criteria->condition = "account_id ='" . $account . "'";
        $criteria->limit= $rows_per_page;
        $criteria->offset= $start_index;
        $criteria->order = 'dateCreated DESC';
        $result = OrderGroup::model()->findAll($criteria);

        $data = array();
        if (count($result) != 0) {
            foreach ($result as $item) {
                $order_group_status = '';
                $orders = Orders::model()->findAll("group_code = '". $item->group_code."'");

                $count =  count($orders);

                $n = 0;
                $ip = 0;
                $r = 0;
                $otw = 0;
                $d = 0;
                $c = 0;
                $fd = 0;

                foreach ($orders as $order) {
                    if($order->status == Constants::ORDER_NEW)
                    $n +=1;
                    if($order->status == Constants::ORDER_IN_PROCESS)
                    $ip +=1;
                    if($order->status == Constants::ORDER_READY)
                    $r +=1;
                    if($order->status == Constants::ORDER_ON_THE_WAY)
                    $otw +=1;
                    if($order->status == Constants::ORDER_DELIVERED)
                    $d +=1;
                    if($order->status == Constants::ORDER_CANCEL)
                    $c +=1;
                    if($order->status == Constants::ORDER_FAIL_DELIVERY)
                    $fd +=1;
                }

                if($n == $count)
                {
                    $order_group_status = 'New';
                }
                elseif(($d + $c + $fd) == $count)
                {
                    $order_group_status = 'Done';
                }
                else
                {
                    $order_group_status = 'Processing';
                }


                $data[] = array(
                    'code' => $item->group_code,
                    'total' => $item->total,
                    //'time' => date('Y-m-d H:i:s', explode('-', $item->group_code)[0]),
                    'time' => $item->dateCreated,
                    'status'=>$order_group_status
                );
            }

        }

        if (count($result)) {
            ApiController::sendResponse(200, CJSON::encode(array(
                'status' => Constants::SUCCESS,
                'data' => $data,
                'message' => '',
                'count'=>$count,
                'allpage'=>$allpage,
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