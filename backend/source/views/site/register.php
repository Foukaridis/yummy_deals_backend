<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:38 AM
 */
?>
<style type="text/css">
    .login-wrapper {
        margin-top: 50px;
    }
</style>
<div class="form">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-md-11 col-xs-offset-1">
                <section class="panel">
                    <header class="panel-heading text-center" style="font-weight: bold; font-size: 20px"><?php echo Yii::t('login','label.signUp')?></header>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions' => array(
                            'class' => 'panel-body',
                        ),
                    )); ?>
                    <div class="form-group">
                        <?php echo $form->error($model,'message'); ?>
                        <label class="control-label"><?php echo Yii::t('login','label.full_name'); ?></label>
                        <?php echo $form->textField($model,'full_name', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.full_name'))); ?>
                        <?php echo $form->error($model,'full_name'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.address'); ?></label>
                        <?php echo $form->textField($model,'address', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.address'))); ?>
                        <?php echo $form->error($model,'address'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.phone'); ?></label>
                        <?php echo $form->textField($model,'phone', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.phone'))); ?>
                        <?php echo $form->error($model,'phone'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.email'); ?></label>
                        <?php echo $form->textField($model,'email', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>"test@example.com")); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.username'); ?></label>
                        <?php echo $form->textField($model,'username', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.username'))); ?>
                        <?php echo $form->error($model,'username'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.password'); ?></label>
                        <?php echo $form->passwordField($model,'newPass', array('type'=>'password', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.password'))); ?>
                        <?php echo $form->error($model,'newPass'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.confirmPassWord'); ?></label>
                        <?php echo $form->passwordField($model,'confPass', array('type'=>'password', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.password'))); ?>
                        <?php echo $form->error($model,'confPass'); ?>
                    </div>
                    <a href="<?php echo Yii::app()->createUrl('site/login'); ?>" class="btn btn-info"><?php echo Yii::t('common','btn.back'); ?></a>
                    <?php echo CHtml::button(Yii::t('common', 'btn.create'), array('type'=>'submit', 'class'=>'btn btn-info')); ?>
                    <?php $this->endWidget(); ?>
                </section>
            </div>
        </div>
    </div>
</div>