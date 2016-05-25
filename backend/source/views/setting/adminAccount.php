<?php
/**
 * @param SettingController $this
 * @param CActiveForm $form
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
            'id'=>'adminAccount-form',
            'method' => 'POST',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
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
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.adminName'); ?></label>
            <div>
                <?php echo $form->textField($model,'adminName', array('class' => 'form-control')); ?>
                <?php echo $form->error($model,'adminName', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.adminEmail'); ?></label>
            <div>
                <?php echo $form->textField($model,'adminEmail', array('class' => 'form-control')); ?>
                <?php echo $form->error($model,'adminEmail', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.adminOldPass'); ?></label>
            <div>
                <?php echo $form->passwordField($model,'adminOldPass', array('class' => 'form-control')); ?>
                <?php echo $form->error($model,'adminOldPass', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.adminNewPass'); ?></label>
            <div>
                <?php echo $form->passwordField($model,'adminNewPass', array('class' => 'form-control')); ?>
                <?php echo $form->error($model,'adminNewPass', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('setting', 'label.adminConfPass'); ?></label>
            <div>
                <?php echo $form->passwordField($model,'adminConfPass', array('class' => 'form-control')); ?>
                <?php echo $form->error($model,'adminConfPass', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::button(Yii::t('common', 'btn.update'), array('type'=>'submit', 'class'=>'btn btn-primary')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>