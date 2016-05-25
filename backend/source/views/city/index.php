<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title" style="margin-top: 20px"><?php echo Yii::t('city', 'title.city'); ?></h4>
            </div>
            <div class="col-xs-8 text-right">
                <?php $this->renderPartial('_searchform', array('searchModel'=>$searchModel)); ?>
            </div>
            <div class="col-xs-1 text-right">
                <a class="btn btn-primary inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('city/create'); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'city-grid',
            'dataProvider'=> $data->search(),
            'columns'=>array(
                array(
                    'header' => Yii::t("city", "label.cityId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->cityId;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("city", "label.cityPostCode"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->cityPostCode;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t("city", "label.cityName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->cityName;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t('city', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.update').'" href="'.Yii::app()->createUrl('city/update', array('id'=>$data->cityId)).'" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Shop::model()->countShopByCity($data->cityId)>0 ? '<span class="glyphicon glyphicon-exclamation-sign tooltips" style="cursor:pointer;" data-placement="top" data-toggle="tooltip" data-original-title="Can not delete this city !"></span>': '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.delete').'" href="'.Yii::app()->createUrl('city/delete', array('id'=>$data->cityId)).'" onclick="return confirm(\''.Yii::t('city', 'msg.confirmDelete').'\');" class="glyphicon glyphicon-trash"></a>';
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