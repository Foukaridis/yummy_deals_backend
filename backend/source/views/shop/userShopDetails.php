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
                    echo Yii::t('account', 'title.account') . ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>

            <div class="col-xs-3 text-right">

                <a class="btn btn-danger inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('shop/getUsers', array('id' => $shop->location_id)); ?>">
                    <?php
                    echo Yii::t('common', 'Back'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-9">
                <h4 class="title" style="margin-top: 10px;color:#0055ff">Account informations :</h4>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-3">
                <?php echo '<H4>User Name : ' . $account->username . '</H4>'; ?>
            </div>
            <div class="col-md-3">
                <?php echo '<H4>Full name : ' . $account->full_name . '</H4>'; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php echo '<H4>Email : ' . $account->email . '</H4>'; ?>
            </div>
            <div class="col-md-3">
                <?php echo '<H4>Phone : ' . $account->phone . '</H4>'; ?>
            </div>
            <div class="col-md-3">
                <?php echo '<H4>Address : ' . $account->address . '</H4>'; ?>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-9">
                <h4 class="title" style="margin-top: 20px;color:#0055ff">Order Histories :</h4>
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
            'rowCssClassExpression' => '($data->status==0) ? "background-row-gray" : "background-row-white"',
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
                    'header' => Yii::t("order", "label.total"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $total = OrderFood::model()->getOrderTotal($data->order_id);
                        return $total != null ? $total : '0';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("banner", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $str = "";
                        $status = $data->status;
                        switch ($status) {
                            case 0:
                                $str = '<span style="color:blue"> New' . '</span>';
                                break;
                            case 1:
                                $str = '<span style="color:blue"> Received' . '</span>';
                                break;
                            case 2:
                                $str = '<span style="color:blue"> Ready' . '</span>';
                                break;
                            case 3:
                                $str = '<span style="color:blue"> Paid' . '</span>';
                                break;
                            case 4:
                                $str = '<span style="color:red"> Cancel' . '</span>';
                                break;
                        }
                        return $str;
                    },
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

//                array(
//                    'header' => Yii::t('food', 'label.update'),
//                    'type' => 'raw',
//                    'value' => function ($data) {
//                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('order/update', array('id' => $data->order_id)) . '" class="glyphicon glyphicon-edit"></a>';
//                    },
//                    'headerHtmlOptions' => array(
//                        'width' => '5%',
//                    ),
//                ),
//                array(
//                    'header' => Yii::t('food', 'label.delete'),
//                    'type' => 'raw',
//                    'value' => function ($data) {
//                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('order/delete', array('id' => $data->order_id)) . '" onclick="return confirm(\'' . Yii::t('order', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
//                    },
//                    'headerHtmlOptions' => array(
//                        'width' => '5%',
//                    ),
//                ),
            ),
            'itemsCssClass' => 'table table-hover',
        )); ?>
    </div>
</div>