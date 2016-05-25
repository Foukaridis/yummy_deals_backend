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
            <div class="col-md-2">
                <?php if (yii::app()->user->role != 0) { ?>
                    <?php echo $form->label($model, Yii::t('feedback', 'label.accountId') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'account_id', array(
                        'type' => 'text',
                        'size' => 40,
                        'class' => 'form-control',
                        'readonly' => 'TRUE'
                    )); ?>
                    <?php echo $form->error($model, 'account_id'); ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('feedback', 'label.tittle') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'tittle', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'tittle'); ?>
            </div>
            <div class="col-md-2">
                <?php if (yii::app()->user->role != 0) { ?>
                    <?php echo $form->label($model, Yii::t('feedback', 'label.status'), array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model, 'status', array('0' => 'New', '1' => 'Processing', '2' => 'Closed'), array(
                        'class' => 'form-control',
                    )); ?>
                    <?php echo $form->error($model, 'status'); ?>
                <?php } ?>
            </div>
            <div class="col-md-2">
                <?php if (yii::app()->user->role != 0) { ?>
                    <?php echo $form->label($model, Yii::t('feedback', 'label.status'), array('class' => 'control-label')); ?>
                    <?php echo $form->dropDownList($model, 'type', array('1' => 'Feedback', '2' => 'Report', '3' => 'Bug'), array(
                        'class' => 'form-control',
                        'disabled' => 'disabled'
                    )); ?>
                    <?php echo $form->error($model, 'type'); ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="space"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-7">
                <?php echo $form->label($model, Yii::t('feedback', 'label.description') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textArea($model, 'description', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'rows' => 5,
                )); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-7">
                <?php echo $form->label($model, Yii::t('feedback', 'label.note'), array('class' => 'control-label')); ?>
                <?php echo $form->textArea($model, 'note', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'rows' => 5,
                )); ?>
                <?php echo $form->error($model, 'note'); ?>
            </div>
        </div>
    </div>
    <div class="space"></div>
    <div class="col-md-2">
        <?php echo CHtml::button(Yii::t('common', $model->id != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
</div>
</div>
<div class="space"></div>
<?php $this->endWidget(); ?>
</div>