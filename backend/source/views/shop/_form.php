<?php
/* @var $model ShopForm */
/* @var $form CActiveForm */
$timePickerScript = <<<SCRIPT

              $('.endTime').timepicker();
               $('.startTime').timepicker();
               $('.lastOrderTime').timepicker();

SCRIPT;
Yii::app()->getClientScript()->registerScript('timePickerScript', $timePickerScript);
?>

<div class="space"></div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'createNews-form',
        'method' => 'POST',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'panel-body',
            'enctype' => 'multipart/form-data',
            'role' => 'form',
        ),
    )); ?>
    <?php if (Yii::app()->user->hasFlash('_error_')): ?>
        <div class="col-md-12">
            <div class="alert alert-danger">
                <button data-dismiss="alert" class="close"></button>
                <?php echo Yii::app()->user->getFlash('_error_'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('shop', 'label.shopName') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'location_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_name'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('shop', 'label.shopPhone') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'location_tel', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_tel'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.shopCity') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'location_city', $cities, array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_city'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.account') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'account_id', $accounts, array(
                    'class' => 'form-control',
                    'options' => (Yii::app()->user->role == 1) ? array(Yii::app()->user->id => array('selected' => true)) : '',
                    //(yii::app()->user->role == 2) ? '' : 'disabled' => 'disabled'  not post account_id?????????????????
                    'style' => (Yii::app()->user->role == 1) ? 'display: none' : ''
                )); ?>
                <?php if (Yii::app()->user->role == 1): ?>
                    <div class="form-control"><?php echo $accounts[Yii::app()->user->id] ?></div>
                <?php endif ?>
                <?php echo $form->error($model, 'account_id'); ?>
            </div>
            <?php
            $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
            $gmt = array();
            foreach ($timezones as $item) {
                $gmt[$item] = $item;
            }
            ?>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.gmt') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'gmt', $gmt, array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_city'); ?>
            </div>

        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <?php echo $form->label($model, Yii::t('shop', 'label.shopAddress') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'location_address', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_address'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.verified') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'isVerified', array('1' => 'Verified', '0' => 'Not Verified'), array(
                    'class' => 'form-control',
                    'disabled' => Yii::app()->user->role == Constants::ROLE_ADMIN ? '' : 'disabled',
                )); ?>
                <?php echo $form->error($model, 'location_address'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.featured') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'isFeatured', array('1' => 'Featured', '0' => 'Not Featured'), array(
                    'class' => 'form-control',
                    'disabled' => Yii::app()->user->role == Constants::ROLE_ADMIN ? '' : 'disabled',
                )); ?>
                <?php echo $form->error($model, 'location_address'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.latitude') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'latitude', array(
                    'type' => 'text',
                    'id' => 'latitude',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'latitude'); ?>
                <div class="space"></div>
            </div>
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.longitude') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'longitude', array(
                    'type' => 'text',
                    'id' => 'longitude',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'longitude'); ?>
                <div class="space"></div>
            </div>
            <div class="col-md-2">
                <p style="color: red; font-size: 12pt ">
                    <?php
                    $this->widget('common.extensions.coordinatePicker.CoordinatePicker', array(
                        'model' => $model,
                        'latitudeAttribute' => 'location_latitude',
                        'longitudeAttribute' => 'location_longitude',
                        'editZoom' => 12,
                        'pickZoom' => 12,
                        'defaultLatitude' => 21.022699204346964,
                        'defaultLongitude' => 105.83696370000007,
                    ));
                    ?>
                </p>
            </div>
            <?php if ($model->location_id != null) { ?>
                <div class="col-md-2" style="margin-top: 20px">
                    <a class="btn inline btn-success"
                       href="<?php echo Yii::app()->createUrl('openHour/index', array('id' => $model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewOpenHour'); ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->label($model, Yii::t('shop', 'label.shopDesc'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'location_des', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'location_des'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('shop', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
            <?php if ($model->location_id != null) { ?>
                <div class="col-md-2">
                    <?php echo $form->labelEx($model, 'rate'); ?>
                    <?php echo $form->textField($model, 'rate', array(
                        'type' => 'text',
                        'size' => 40,
                        'disabled' => 'disabled',
                        'class' => 'form-control',
                    )); ?>
                    <?php echo $form->error($model, 'rate'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo $form->labelEx($model, 'rate_times'); ?>
                    <?php echo $form->textField($model, 'rate_times', array(
                        'type' => 'text',
                        'size' => 40,
                        'disabled' => 'disabled',
                        'class' => 'form-control',
                    )); ?>
                    <?php echo $form->error($model, 'rate_times'); ?>
                </div>
            <?php } ?>

        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.facebook'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'facebook', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'facebook'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.twitter'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'twitter', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'twitter'); ?>
            </div>
        </div>
    </div>
    <br/>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.email'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'email', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('shop', 'label.liveChat'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'live_chat', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'live_chat'); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <label
        class="control-label"><?php echo Yii::t('shop', 'label.shopImage') . '<span style="color: #ff0000"> *</span>'; ?></label>
    <?php if (isset($model->location_image) && !empty($model->location_image)) { ?>
        <br/>
        <img height="120px"
             src="<?php echo Yii::app()->createUrl('site/image', array('id' => $model->location_id, 'f' => $model->location_image, 't' => DIRECTORY_SHOP)); ?>"/>
        <br/>
    <?php } ?>
    <div class="controls">
        <div class="space"></div>
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?php echo Yii::t('common', 'label.selectFile'); ?></span>
                <?php echo $form->hiddenField($model, 'location_image'); ?>
                <?php echo $form->fileField($model, 'shopTempImage'); ?>
            </span>
        <?php echo $form->error($model, 'shopTempImage'); ?>
        <span class="fileinput-label"></span>
    </div>

</div>
<div class="col-md-12">
    <?php echo CHtml::button(Yii::t('common', $model->location_id != null ? 'btn.update' : 'btn.create'), array(
        'type' => 'submit',
        'class ' => 'btn btn-success',
    )); ?>
</div>
<div class="space"></div>
<?php $this->endWidget(); ?>
</div>

