<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-10">
                <h4 class="title"><?php
                    $shop_gmt = $shop->gmt;
                    echo Yii::t('openHour', 'title.openHour') . ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shopId)) . '">' . $shop->location_name ?></a></h4>
                    <h4><i class="glyphicon glyphicon-time"></i> Shop Timezone: <?php echo $shop_gmt ?></h4>
            </div>
            <div class="col-xs-2 text-right">
                <a class="btn btn-danger inline"
                   href="<?php echo Yii::app()->createUrl('shop/update', array('id' => $shopId)); ?>">
                    <?php echo Yii::t('common', 'Back to ' . $shop->location_name); ?></a>
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
                    'header' => Yii::t("openHour", "label.date"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Datetb::model()->findByPk($data->dateId)->fullDateName;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("openHour", "label.openAM"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->openAM == '' ? '<span style="color:red"> No time' . '</span>' :
                            Constants::convertTime($data->openAM, 'GMT',$data->shop->gmt);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("openHour", "label.closeAM"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->closeAM == '' ? '<span style="color:red"> No time' . '</span>' :
                            Constants::convertTime($data->closeAM, 'GMT',$data->shop->gmt);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("openHour", "label.openPM"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->openPM == '' ? '<span style="color:red"> No time' . '</span>' :
                            Constants::convertTime($data->openPM, 'GMT',$data->shop->gmt);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("openHour", "label.closePM"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->closePM == '' ? '<span style="color:red"> No time' . '</span>' :
                            Constants::convertTime($data->closePM, 'GMT',$data->shop->gmt);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t('food', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('openHour/update', array('id' => $data->id)) . '" class="glyphicon glyphicon-edit"></a>';
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