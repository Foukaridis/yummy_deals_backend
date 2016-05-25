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
                    echo Yii::t('finance', 'title.finance') ?></h4>
            </div>
            <div class="col-xs-8 text-right">
                <?php $this->renderPartial('_admin_searchform', array('modelSearchForm' => $modelSearchForm,'shop' => $shop)); ?>
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
                    'header' => Yii::t("finance", "label.shopId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                            return Shop::model()->findByPk($data->shopId)->location_name;
                        },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t("finance", "label.budget"),
                    'type' => 'raw',
                    'value' => function ($data) {
                            return $data->budget;
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
                                    $str = '<span style="color:red"> Inactive' . '</span>';
                                    break;
                                case 1:
                                    $str = '<span style="color:green"> Active' . '</span>';
                                    break;
                            }
                            return $str;
                        },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),

                array(
                    'header' => Yii::t("finance", "label.updateTime"),
                    'type' => 'raw',
                    'value' => function ($data) {
                            return $data->updateTime;
                        },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),

            ),
            'itemsCssClass' => 'table table-hover',
        )); ?>
    </div>
</div>