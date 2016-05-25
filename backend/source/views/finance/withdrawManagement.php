<?php
//Yii::app()->clientScript->registerScript('order_refresh', "
//    var tm = setInterval(function(){
//        $('#news-grid').yiiGridView('update', {});
//    }, 10000);
//");
//?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('finance', 'title.admin.withdraw.management') ?></h4>
            </div>
            <div class="col-xs-8 text-right">
                <?php $this->renderPartial('_withdraw_admin_search_form', array('modelSearchForm' => $modelSearchForm,'owners' => $owners)); ?>
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
                    'header' => Yii::t("finance", "label.ownerId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Account::model()->findByPk($data->ownerId)->username;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("finance", "label.amount"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->amount;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
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
                                $str = '<span style="color:blue"> Pending' . '</span>';
                                break;
                            case 1:
                                $str = '<span style="color:green"> Approved' . '</span>';
                                break;
                            case 2:
                                $str = '<span style="color:red"> Rejected' . '</span>';
                                break;
                        }
                        return $str;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),

                array(
                    'header' => Yii::t("finance", "label.createdTime"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->createdTime;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("finance", "label.approvedTime"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->approvedTime;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t('common', 'label.approve'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        if($data->status ==0)
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.approve') . '" href="' . Yii::app()->createUrl('finance/approveRequest', array('id' => $data->id)) . '" class="glyphicon glyphicon-ok-circle"></a>';
                        else return '';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('common', 'label.reject'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        if($data->status ==0)
                            return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.reject') . '" href="' . Yii::app()->createUrl('finance/rejectRequest', array('id' => $data->id)) . '" class="glyphicon glyphicon-ban-circle"></a>';
                        else return '';

                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),

            ),
            'itemsCssClass' => 'table table-hover',
        )); ?>
    </div>
</div>