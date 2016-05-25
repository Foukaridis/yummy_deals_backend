<?php
/**
 *
 * @var $this SettingController
 * @var $model SettingForm
 * @var $form CActiveForm
 */
?>

<div class="row">
    <div class="col-md-12 form-title">
        <div class="row">
            <div class="col-md-6">
                <h4 class="title">  <?php echo $this->title; ?></h4>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<div class="row form">
    <div class="col-md-12">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'updateSetting-form',
            'method' => 'POST',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'class' => 'panel-body',
            ),
        ));
        ?>
        <?php if (Yii::app()->user->hasFlash('_error_')): ?>
            <div class="form-group">
                <div class="alert alert-danger">
                    <button data-dismiss="alert" class="close"></button>
                    <?php echo Yii::app()->user->getFlash('_error_'); ?>
                </div>
            </div>
        <?php endif; ?>
        <!--        <div class="form-group">-->
        <!--            <label class="control-label">-->
        <?php //echo Yii::t('setting', 'label.settingKey'); ?><!--</label>-->
        <!--            <div>-->
        <!--                --><?php //echo $form->textField($model,'settingKey', array('class' => 'form-control', 'disabled' => 'disabled')); ?>
        <!--                --><?php //echo $form->error($model,'settingKey', array('class' => 'text-danger')); ?>
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="form-group">-->
        <!--            <label class="control-label">-->
        <?php //echo Yii::t('setting', 'label.settingValue'); ?><!--</label>-->
        <!--            <div>-->
        <!--                --><?php //echo $form->textField($model,'settingValue', array('class' => 'form-control', 'disabled' => 'disabled')); ?>
        <!--                --><?php //echo $form->error($model,'settingValue', array('class' => 'text-danger')); ?>
        <!--            </div>-->
        <!--        </div>-->
        <?php
        $data = CJSON::decode($model->settingData);
        foreach ($data as $key => $item) {

            ?>
            <div class="form-group">
                <label class="control-label"><?php echo ucfirst($key); ?></label>

                <div>
                    <input type="text" name="SettingForm[settingData][<?php echo $key; ?>]" class="form-control"
                           value="<?php echo $item; ?>"/>
                </div>
            </div>
        <?php
        }
        ?>

        <div class="row">
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('setting', 'label.latitude') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'locationLatitude', array(
                    'type' => 'text',
                    'id' => 'latitude',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'locationLatitude'); ?>
                <div class="space"></div>
            </div>
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('setting', 'label.longitude') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'locationLongitude', array(
                    'type' => 'text',
                    'id' => 'longitude',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'locationLongitude'); ?>
                <div class="space"></div>
            </div>
            <div class="col-md-2">
                <p style="color: red; font-size: 12pt ">
                    <?php
                    $this->widget('common.extensions.coordinatePicker.CoordinatePicker', array(
                        'model' => $model,
                        'latitudeAttribute' => 'locationLatitude',
                        'longitudeAttribute' => 'locationLongitude',
                        'editZoom' => 12,
                        'pickZoom' => 12,
                        'defaultLatitude' => 21.022699204346964,
                        'defaultLongitude' => 105.83696370000007,
                    ));
                    ?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.settingBank'); ?></label>

            <div>
                <?php $this->widget('common.extensions.editMe.widgets.ExtEditMe', array(
                    'model' => $model,
                    'attribute' => 'settingBankinfo',
                    'htmlOptions' => array(
                        'rows' => 3,
                        'class' => 'form-control',
                    ),
                )); ?>
                <?php echo $form->error($model, 'settingBankinfo', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <!--        <div class="form-group">-->
        <!--            <label class="control-label">-->
        <?php //echo Yii::t('setting', 'label.settingCurrency'); ?><!--</label>-->
        <!--            <div>-->
        <!--                --><?php //echo $form->textField($model,'settingCurrency', array('class' => 'form-control')); ?>
        <!--                --><?php //echo $form->error($model,'settingCurrency', array('class' => 'text-danger')); ?>
        <!--            </div>-->
        <!--        </div>-->
        <div class="form-group">
            <?php echo CHtml::button(Yii::t('common', 'btn.update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>