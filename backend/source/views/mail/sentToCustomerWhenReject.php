<?php
/**
 * @var Providers $provider
 */
?>
Hi <?php echo $account->full_name; ?>,<br/><br/>


Your Order ID : <?php echo $order->order_id; ?><br/>
Detail of your order : <br/>
<Table style="border: 1px solid #000020; background: #D0E3EF; width: 400px">
    <tr style="background: #0055ff;text-align: center;color: WHITE">
        <th>No</th>
        <th>Code</th>
        <th>Name</th>
        <th>Number</th>
        <th>Price</th>
    </tr>
    <?php
    $n = 0;
    $total = 0;
    foreach ($foodList as $item) {
        $total += ($item['price']*$item['number']);
        $food = Food::model()->findByPk($item['id']); ?>
        <tr style="border: 1px solid #000020;">
            <td><?php echo $n + 1; ?></td>
            <td><?php echo $food->food_code; ?></td>
            <td><?php echo $food->food_name; ?></td>
            <td><?php echo $item['number'] ?></td>
            <td><?php echo $item['price'] ?></td>
        </tr>
    <?php } ?>
</Table>
</br>
<H4>Total :<?php echo $total; ?> </h4>

The menu in your order run out.  We can not serve for you.</br>

<br/><br/>
Cheers <br/>