<?php


$promotion=Promotion::model()->searchPromotionActiveByFoodAndDate($model->food_id,$date);
$promotion!=null ? $percentDiscount = $promotion->percent_discount : $percentDiscount=0;

$number = isset($number)?$number:1;
$foodPromationR = isset($model->foodPromotionR)?$model->foodPromotionR:'';
if($foodPromationR && is_array($foodPromationR)){
    foreach($foodPromationR as $item){
        if(isset($item->promotionR)){

        }
    }
}
if($price ==0)
{
    $price = $model->food_price * (100 - $percentDiscount)/100;
    $total = $price * $number;
}
else
{
    $price = $model->food_price * (100 - $percentDiscount)/100;
    $total = $price * $number;
}
?>


<tr class="my_food" id="food_<?php echo $model->food_id?>">
    <input type="hidden" name ="OrderForm[foodListId][]" value="<?php echo $model->food_id?>"/>
    <input type="hidden" name ="OrderForm[foodListNumber][]" value="<?php echo $number?>"/>
    <input type="hidden" name ="OrderForm[foodListPrice][]" value="<?php echo $price?>"/>


    <input value="<?php echo $model->food_id?>" type="hidden" name ="OrderForm[foodList][<?php echo $model->food_id?>][id]"/>
    <input type="hidden" name ="OrderForm[foodList][<?php echo $model->food_id?>][promotion]"/>
    <td><?php echo $model->food_name?></td>

    <td><input onblur="changeNumberFood(<?php echo $model->food_id?>)" id="food_number_<?php echo $model->food_id?>" value="<?php echo $number?>" name ="OrderForm[foodList][<?php echo $model->food_id?>][number]"/></td>
    <td><input readonly name="OrderForm[foodList][<?php echo $model->food_id?>][price]" value="<?php echo $model->food_price ?>" id="food_price_<?php echo $model->food_id?>"></td>
    <td><?php echo $percentDiscount?>
    <td><input class="food_item_total" id="food_total_<?php echo $model->food_id?>" readonly="TRUE" value="<?php echo $total?>" name ="OrderForm[foodList][<?php echo $model->food_id?>][total]"/></td>
<!--    <td><input name ="foodList[--><?php //echo $model->food_id?><!--][lastTotal]"/></td>-->
    <td><a onclick="removeFood(<?php echo $model->food_id?>)" href="javascript:;">Delete</a> </td>
</tr>