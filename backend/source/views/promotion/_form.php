<div class="space"></div>
<?php
$dateTimePickerScript = <<<SCRIPT
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

            $('.endDate').datepicker({
                format: "yyyy-mm-dd",
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                },
             });

              $('.endTime').timepicker();
SCRIPT;
Yii::app()->getClientScript()->registerScript('dateTimePickerScript', $dateTimePickerScript);
?>
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
        <div class="form-group">
            <div class="alert alert-danger">
                <button data-dismiss="alert" class="close"></button>
                <?php echo Yii::app()->user->getFlash('_error_'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventCode') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'eventCode', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'eventCode'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventName') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'eventName', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'eventName'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventPercent') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'percentDiscount', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'percentDiscount'); ?>
            </div>

        </div>
        <div class="space"></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventShop') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'eventShop', $shops, array(
                    'class' => 'form-control',
                    'disabled'=>'disabled',
                )); ?>
                <?php echo $form->error($model, 'eventShop'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventStartDate') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'eventStartDate', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'endDate form-control',
                    'readOnly' => TRUE,
                )); ?>
                <?php echo $form->error($model, 'eventEndDate'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventEndDate') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'eventEndDate', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'endDate form-control',
                    'readOnly' => TRUE,
                )); ?>
                <?php echo $form->error($model, 'eventEndDate'); ?>
            </div>
            <div class="col-md-2" style="display: none">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventEndTime') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'eventEndTime', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'endTime form-control',
                    'readOnly' => TRUE,
                )); ?>
                <?php echo $form->error($model, 'eventEndTime'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventStatus'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'eventStatus', array('0' => 'Inactive', '1' => 'Active'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'eventStatus'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <?php echo $form->label($model, Yii::t('promotion', 'label.eventDesc') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textArea($model, 'eventDesc', array(
                    'type' => 'text',
                    'size' => 40,
                    'rows' => 5,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'eventDesc'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <label
                    class="control-label"><?php echo Yii::t('promotion', 'label.eventImage') . '<span style="color: #ff0000"> *</span>'; ?></label>
                <?php if (isset($model->eventImage) && !empty($model->eventImage)) { ?>
                    <br/>
                    <img height="150px"
                         src="<?php echo Yii::app()->createUrl('site/image', array('id' => DIRECTORY_PROMOTION, 'f' => $model->eventImage, 't' => DIRECTORY_SHOP)); ?>"/>
                    <br/>
                <?php } ?>
                <div class="space"></div>
                <div class="controls">
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?php echo Yii::t('common', 'label.selectFile'); ?></span>
                <?php echo $form->hiddenField($model, 'eventImage'); ?>
                <?php echo $form->fileField($model, 'eventNewThumb'); ?>
            </span>
                    <span class="fileinput-label"></span>
                </div>
            </div>
        </div>
    </div>


    <div class="space"></div>
    <div class="col-md-12">
        <?php echo CHtml::button(Yii::t('common', $model->eventId != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>