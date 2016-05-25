<?php
$link = Yii::app()->createUrl("employee/orderDetail");
Yii::app()->clientScript->registerScript('moveToDate', "
function orderdetail(order_id) {
    window.location= '$link'+'?id='+order_id+'&user='+'$account->username';
    }
", CClientScript::POS_END);
?>
<div class="login-panel">

		<div class="title">My Orders</div>
		<div class="account"><?php echo Account::model()->getRole($account->role)?> <b><?php echo $account->full_name ?></b> <br/> Restaurant <b><?php echo $shop->location_name ?> </b></div>

	</div>
<?php
if(count($orders)!=0)
foreach($orders as $order) { ?>

	<div class="order-item" onclick="orderdetail(<?php echo $order->order_id ?>)">
		<div class="order-id">#<?php echo $order->order_id?></div>
		<div class="order-state"><?php echo Orders::model()->getStatus($order->status)?></div>
		<div style="clear:both"><br/></div>
		<div class="order-date"><?php  echo $order->order_time?></div>
		<div class="order-price">$<?php echo OrderTotal::model()->getOrderTotal($order->order_id)?></div>
		<div style="clear:both"></div>
	</div>
<?php } else { ?>
    <div class="order-item">
        <div class="account">No orders found!</div>
    </div>
<?php } ?>