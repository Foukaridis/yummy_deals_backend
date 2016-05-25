<?php
//Yii::app()->clientScript->registerScript('order_refresh', "
//    var tm = setInterval(function(){
//        $('#news-grid').yiiGridView('update', {});
//    }, 10000);
//");
//
/* @var $order Orders */
/* @var $model Orders */
?>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('order', 'title.order') ?></h4>
            </div>
            <div class="col-xs-8 text-right">
                <?php $this->renderPartial('_admin_searchform', array('model' => $model, 'shop' => $shop, 'status'=>$status)); ?>

            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<?php

$user_id = Yii::app()->user->id;
$role = Yii::app()->user->role;
$shopId = null;
if($role == Constants::ROLE_MODERATOR)
{
   $shopId =  Account::model()->findByPk($user_id)->shopId;
}

?>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'orders-grid',
            'dataProvider' =>$order->searchCustom($user_id,$role, $shopId),
            'columns' => array(
                array(
                    'header' => Yii::t("order", "label.orderId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->order_id;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    'header' => Yii::t("order", "label.account"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $account = Account::model()->findByPk($data->account_id);
                        return $account->username;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("order", "label.shop"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Shop::model()->getName($data->shop_id);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),
                ),
                array(
                    'header' => Yii::t("order", "label.total"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        //$total = OrderFood::model()->getOrderTotal($data->order_id);
                        $total = OrderTotal::model()->getOrderTotal($data->order_id);

                        return $total != null ? $total : '0';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("banner", "label.status"),
                    'type' => 'raw',
                    'value' => '$data->getStatus()',
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("order", "label.orderTime"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->created;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('order/update', array('id' => $data->order_id)) . '" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('order/delete', array('id' => $data->order_id)) . '" onclick="return confirm(\'' . Yii::t('order', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                    'htmlOptions'=>array(
                    )
                ),
            ),
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>