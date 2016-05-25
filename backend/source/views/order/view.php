<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/27/13 - 9:44 AM
 *
 * @var Orders $model
 */
$orderTotal = OrderTotal::model()->find('orderId ='.$id);
?>

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <h4 class="title">Order detail  #<?php echo $id?></h4>
                </div>
                <div class="col-xs-6 text-right">
                    <a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('account/viewOrder',array('id'=>Yii::app()->user->id)); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
                </div>
            </div>
            <hr class="line"/>
        </div>
    </div>

<div class="row">
    <div class="col-xs-5">
        <table class="table table-bordered table-striped">
            <tr>
                <th><?php echo Yii::t('order', 'label.orderId');?></th>
                <td><?php echo $model->order_id; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.account');?></th>
                <td><?php
                    $account = Account::model()->findByPk($model->account_id);
                    echo $account->username;
                    ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.shop');?></th>
                <td><?php echo Shop::model()->getName($model->shop_id); ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('banner', 'label.status');?></th>
                <td><?php echo $model->getStatus(); ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.total');?></th>
                <td><?php echo $orderTotal->total; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.tax');?></th>
                <td><?php echo $orderTotal->tax; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.shipping');?></th>
                <td><?php echo $orderTotal->shipping; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.grandTotal');?></th>
                <td><?php echo $orderTotal->grandTotal; ?></td>
            </tr>
            <tr>
                <th><?php echo Yii::t('order', 'label.orderTime');?></th>
                <td><?php echo $model->created; ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-bordered table-striped">
            <tr>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('food', 'label.foodImage'); ?></th>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('food', 'label.foodCode'); ?></th>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('food', 'label.foodName'); ?></th>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('orderItem', 'label.number'); ?></th>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('orderItem', 'label.price'); ?></th>
                <th style="width:10%;border: none;text-align: center"><?php echo Yii::t('orderItem', 'label.total'); ?></th>
            </tr>

            <?php foreach($model->orderItemR as $item){
                $data = Food::model()->findByPk($item->food_id);
                if($data != null){
            ?>
                    <tr>
                        <td style="text-align: center"><?php echo '<img class="image-small-thumb" src="'.Yii::app()->createUrl('site/image', array('id' => $data->food_id, 'f'=>$data->food_thumbnail, 't'=>DIRECTORY_FOOD)).'"/>'; ?></td>
                        <td style="text-align: center"><?php echo $data->food_code; ?></td>
                        <td style="text-align: center"><?php echo $data->food_name; ?></td>
                        <td style="text-align: center"><?php echo $item->number; ?></td>
                        <td style="text-align: center"><?php echo $item->price; ?></td>
                        <td style="text-align: center"><?php echo $item->number * $item->price ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
</div>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>