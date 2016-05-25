<div class="login-panel">

    <div class="title">
        <a href="<?php echo Yii::app()->createUrl('employee/orders',array('user'=>$account->username)); ?>">
            <img src="<?php echo  Yii::app()->baseUrl.'/static/img/ic_action_back.png'?>">
        </a>
        Order #<?php echo $order->order_id ?></div>
    <div class="account"><b>Deliver to: </b></div>
    <div class="account">Address: <?php echo $customer->address ?></div>
    <div class="account">Customer: <?php echo $customer->full_name ?> </div>
    <div class="account">Phone: <a href="#"><?php echo $customer->phone ?></a></div>
</div>

<div class="order-item">
    <div class="order-id"><?php echo $count ?> items</div>
    <div class="order-state"><?php echo Orders::model()->getStatus($order->status) ?></div>
    <div style="clear:both"><br/></div>
    <div class="order-date"><?php echo $order->order_time ?></div>
    <div class="order-price">$<?php echo $grandTotal ?></div>
    <div style="clear:both"></div>
</div>

<div class="order-item">
    <?php
    foreach ($items as $item) { ?>
        <div class="detail-name"><?php echo $item['item_name'] ?></div>
        <div class="detail-price">$<?php echo $item['item_price'] ?> x <?php echo $item['item_number'] ?> =
            $<?php echo $item['item_total'] ?></div>
        <div style="clear:both"></div>
    <?php } ?>
    <hr>
    <div class="detail-name">Total</div>
    <div class="detail-price">$<?php echo $total ?></div>
    <div style="clear:both"></div>

    <div class="detail-name">Ship</div>
    <div class="detail-price">$<?php echo $shipping_amount ?></div>
    <div style="clear:both"></div>

    <div class="detail-name">Tax</div>
    <div class="detail-price">(<?php echo $tax_rate ?>%) $<?php echo $tax_amount ?></div>
    <div style="clear:both"></div>

    <div class="detail-name"><b>Grand Total</b></div>
    <div class="detail-price"><b>$<?php echo $grandTotal ?></b></div>
    <div style="clear:both"></div>

</div>
<?php
    if ($account->role == Constants::ROLE_DELIVERYMAN)
    { ?>

    <div class="state-button delivery">
    <a  href="<?php echo Yii::app()->createUrl("employee/changeStatus",
        array('status' => Constants::ORDER_ON_THE_WAY, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
       title="On the way">ON THE WAY</a>
    </div>
    <div class="state-button new">
    <a  href="<?php echo Yii::app()->createUrl("employee/changeStatus",
        array('status' => Constants::ORDER_DELIVERED, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
       title="Delivered">DELIVERED</a>
    </div>
    <div class="state-button cancel">
    <a href="<?php echo Yii::app()->createUrl("employee/changeStatus",
        array('status' => Constants::ORDER_FAIL_DELIVERY, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
       title="Fail">FAIL DELIVERY</a>
    </div>
<?php }
        elseif ($account->role == Constants::ROLE_CHEF)
    { ?>
    <div class="state-button delivery">
        <a  href="<?php echo Yii::app()->createUrl("employee/changeStatus",
            array('status' => Constants::ORDER_IN_PROCESS, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
           title="In progress">IN PROCESS</a>
    </div>
    <div class="state-button new">
        <a href="<?php echo Yii::app()->createUrl("employee/changeStatus",
            array('status' => Constants::ORDER_READY, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
           title="Ready">READY</a>
    </div>
    <div class="state-button cancel">
        <a  href="<?php echo Yii::app()->createUrl("employee/changeStatus",
            array('status' => Constants::ORDER_CANCEL, 'id' => $order->order_id, 'grand_total' => $total, 'user' => $account->username)) ?>"
           title="Cancel">CANCEL</a>
    </div>

<?php } ?>