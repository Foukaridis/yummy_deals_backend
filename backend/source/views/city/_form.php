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
                <?php echo $form->label($model, Yii::t('city', 'label.cityPostCode').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'cityPostCode', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'cityPostCode'); ?>
            </div>

            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('city', 'label.cityName').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'cityName', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'cityName'); ?>
            </div>

            <div class="col-md-2">
                <div class="space"></div>
                <?php echo CHtml::button(Yii::t('common', $model->cityId != null ? 'btn.update' : 'btn.create'), array(
                    'type' => 'submit',
                    'class ' => 'btn btn-success',
                )); ?>
            </div>
        </div>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>