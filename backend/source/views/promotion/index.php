<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-7">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('promotion', 'title.event'). ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>
            <div class="col-xs-2 text-right">
                <?php $this->renderPartial('_searchform', array('modelSearchForm'=>$modelSearchForm,'shop' => $shop)); ?>
            </div>
            <div class="col-xs-3 text-right">
                <a class="btn btn-primary inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('promotion/create',array('shopId'=>$shop->location_id)); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
                <a class="btn btn-danger inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('shop/update',array('id'=>$shop->location_id)); ?>">
                    <?php echo Yii::t('common', 'Back to '.$shop->location_name); ?></a>
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
                    'header' => "Thumbnail",
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<img height="80px" src="'.Yii::app()->createUrl('site/image', array('id' => DIRECTORY_PROMOTION, 'f'=>$data->promotion_image, 't'=>DIRECTORY_SHOP)).'"/>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("promotion", "label.eventCode"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->promotion_code;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),

                array(
                    'header' => Yii::t("promotion", "label.eventStartDate"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->start_date==null ? '<span style="color:red"> No date'.'</span>' : $data->start_date;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),

                array(
                    'header' => Yii::t("promotion", "label.eventEndDate"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->end_date==null ? '<span style="color:red"> No date'.'</span>' : $data->end_date;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("promotion", "label.eventPercent"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->percent_discount.' %';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("promotion", "label.eventDesc"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->promotion_desc;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '25%',
                    ),

                ),
                array(
                    'header' => Yii::t("promotion", "label.eventStatus"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->status==0 ? "Inactive" : '<span style="color:blue"> Active'.'</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t('food', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.update').'" href="'.Yii::app()->createUrl('promotion/update', array('id'=>$data->promotion_id)).'" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.delete').'" href="'.Yii::app()->createUrl('promotion/delete', array('id'=>$data->promotion_id)).'" onclick="return confirm(\''.Yii::t('food', 'msg.confirmDelete').'\');" class="glyphicon glyphicon-trash"></a>';
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