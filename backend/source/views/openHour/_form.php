<div class="space"></div>
<?php
$timePickerScript = <<<SCRIPT

              $('.timer').timepicker();
SCRIPT;
Yii::app()->getClientScript()->registerScript('timePickerScript', $timePickerScript);
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

            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('openHour', 'label.shop').' : <span style="color: #ff0000">'.Shop::model()->findByPk($model->shopId)->location_name.'</span>', array('class' => 'control-label')); ?>
                <?php echo $form->hiddenField($model, 'shopId', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
            </div>

            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('openHour', 'label.date').' : <span style="color: #ff0000">'.Datetb::model()->findByPk($model->dateId)->fullDateName.'</span>', array('class' => 'control-label')); ?>
                <?php echo $form->hiddenField($model, 'dateId', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-3">
                <?php echo $form->label($model, 'Open AM'.'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'openAM', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'timer form-control ',
                    'readOnly'=>true,
                )); ?>
                <?php echo $form->error($model, 'openAM'); ?>
            </div>

            <div class="col-md-3">
                <?php echo $form->label($model, 'Close AM', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'closeAM', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'timer form-control ',
                    'readOnly'=>true,
                )); ?>
                <?php echo $form->error($model, 'closeAM'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-3">
                <?php echo $form->label($model, 'Open PM', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'openPM', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'timer form-control ',
                    'readOnly'=>true,
                )); ?>
                <?php echo $form->error($model, 'openPM'); ?>
            </div>

            <div class="col-md-3">
                <?php echo $form->label($model, 'Close PM'.'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'closePM', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'timer form-control ',
                    'readOnly'=>true,
                )); ?>
                <?php echo $form->error($model, 'closePM'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>


    <div class="space"></div>
    <div class="col-md-12">
        <?php echo CHtml::button(Yii::t('common', $model->id != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>