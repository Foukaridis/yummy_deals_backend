<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-9">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('account', 'title.account'). ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>

            <div class="col-xs-3 text-right">

                <a class="btn btn-danger inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('shop/update',array('id'=>$shop->location_id)); ?>">
                    <?php
                    echo Yii::t('common', 'Back to '.$shop->location_name); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'news-grid',
            'dataProvider' => $dataList,
            'columns' => array(
                array(
                    'header' => Yii::t("account", "label.userName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $user=Account::model()->findByPk($data->accountId);
                        return $user->username;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("account", "label.email"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $user=Account::model()->findByPk($data->accountId);
                        return $user->email;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("account", "label.phone"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $user=Account::model()->findByPk($data->accountId);
                        return $user->phone;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),

                array(
                    'header' => "Order Numbers",
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->order_count;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),

                array(
                    'header' => "Status",
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->order_count==1 ? '<span style="color: red">New customer</span>' : 'Regular customer';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),

                array(
                    'header' =>'Order History',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('shop/getUserDetail', array('id' => $data->id)).'" class="glyphicon glyphicon-edit"></a>';
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