<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-8">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('account', 'title.viewOrder'); ?></a></h4>
            </div>
            <div class="col-xs-4 text-right">
                <a class="btn btn-danger inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('account/updateMyAccount',array('id'=>Yii::app()->user->id)); ?>">
                    <?php echo Yii::t('common', 'btn.back'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'news-grid',
            'dataProvider'=> $dataList,
            'columns'=>array(
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
                                /*array(
                    'header' => Yii::t("order", "label.account"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $account = Account::model()->findByPk($data->account_id);
                        return $account->username;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),*/
                array(
                    'header' => Yii::t("order", "label.shop"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Shop::model()->getName($data->shop_id);
                    },
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
                    'header' => Yii::t("order", "label.total").'($)',
                    'type' => 'raw',
                    'value' => function ($data) {
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
                        'width' => '10%',
                    ),
                ),
				array(
                    'header' => Yii::t('food', 'label.view'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.view').'" href="'.Yii::app()->createUrl('order/view', array('id'=>$data->order_id)).'" class="glyphicon glyphicon-search"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),			
            ),
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>