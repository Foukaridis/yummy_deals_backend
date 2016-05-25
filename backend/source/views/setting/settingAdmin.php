<div class="row">
    <div class="col-md-12 form-title">
        <div class="row">
            <div class="col-md-6">
                <?php echo $this->title; ?>
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-info" href="<?php echo Yii::app()->createUrl('settings/adminAccount')?>">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <?php echo Yii::t('setting', 'title.adminAccount'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'settings-grid',
        'dataProvider'=>$model->search(),
        'columns'=>array(
            array(
                'header' => Yii::t("setting", "label.settingKey"),
                'name' => 'setting_key',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data->setting_key;
                },
                'headerHtmlOptions' => array(
                    'width' => '20%',
                ),
            ),
            array(
                'header' => Yii::t("setting", "label.settingValue"),
                'name' => 'setting_value',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data->setting_value;
                },
                'headerHtmlOptions' => array(
                    'width' => '20%',
                ),
            ),
            array(
                'header' => Yii::t("setting", "label.settingData"),
                'name' => 'setting_data',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data->setting_data;
                },
                'headerHtmlOptions' => array(
                    'width' => '50%',
                ),
            ),
            array(
                'header' => Yii::t("setting", "label.edit"),
                'type' => 'raw',
                'value' => function ($data) {
                    return '<a href="'.Yii::app()->createUrl('setting/updateSetting', array('id'=>$data->setting_id)).'" class="glyphicon glyphicon-edit"></a>';
                },
                'headerHtmlOptions' => array(
                    'width' => '10%',
                ),
            ),
        ),
        'itemsCssClass' => 'table table-striped table-hover data-table',
    )); ?>
    </div>
</div>