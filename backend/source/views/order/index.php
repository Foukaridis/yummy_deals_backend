<?php
Yii::app()->clientScript->registerScript('order_refresh', "
    var tm = setInterval(function(){
        $('#news-grid').yiiGridView('update', {});
    }, 10000);
");
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('order', 'title.order') . ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>
            <div class="col-xs-2 text-right">
                <?php $this->renderPartial('_searchform', array('modelSearchForm' => $modelSearchForm, 'shop' => $shop)); ?>
            </div>
            <div class="col-xs-3 text-right">
                <?php if (yii::app()->user->role == 2 ) {?>
                    <a class="btn btn-primary inline" style="margin-top: 15px"
                       href="<?php echo Yii::app()->createUrl('order/create', array('shopId' => $shop->location_id)); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
                <?php } ?>
                <a class="btn btn-danger inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)); ?>">
                    <?php
                    echo Yii::t('common', 'Back to ' . $shop->location_name); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<?php
$array_column = array(
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
        'header' => Yii::t("order", "label.total"),
        'type' => 'raw',
        'value' => function ($data) {
//                        $total = OrderFood::model()->getOrderTotal($data->order_id);
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
        'value' =>'$data->getStatus()',
        'headerHtmlOptions' => array(
            'width' => '10%',
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
    )
);
//if(yii::app()->user->role == 1)
//$array_column = array_slice($array_column, 0 , count($array_column)-2);
?>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'news-grid',
            'dataProvider' => $dataList,
            'columns' => $array_column,
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>