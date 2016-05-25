<?php
/**
 * Created by Lorge 
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:38 AM
 */
?>
<div class="form">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-md-11 col-xs-offset-1">
                <section class="panel">
                    <header class="panel-heading text-center" style="font-weight: bold; font-size: 20px"><?php echo Yii::t('login','label.signin')?></header>
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
                        <label class="control-label"><?php echo Yii::t('login','label.username'); ?></label>
                        <?php echo $form->textField($model,'username', array('type'=>'text', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.username'))); ?>
                        <?php echo $form->error($model,'username'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo Yii::t('login','label.password'); ?></label>
                        <?php echo $form->passwordField($model,'password', array('type'=>'password', 'class'=>'form-control', 'placeholder'=>Yii::t('login','label.password'))); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>
                    <div class="checkbox">
                        <?php echo $form->checkBox($model,'rememberMe'); ?>
                        <?php echo CHtml::label( Yii::t('login','label.keepme'), 'LoginForm_rememberMe'); ?>
                    </div>
                    <a href="<?php echo Yii::app()->createUrl('site/forgot')?>" class="pull-right m-t-xs">
                        <small><?php echo Yii::t('login','label.forgotpass')?></small>
                    </a>
                    <?php echo CHtml::button(Yii::t('common', 'btn.login'), array('type'=>'submit', 'class'=>'btn btn-info')); ?>
                    <a class="btn btn-info inline" href="<?php echo Yii::app()->createUrl('site/register'); ?>"><?php echo Yii::t('common', 'btn.signUp'); ?></a>
                    <?php $this->endWidget(); ?>
                </section>
            </div>
        </div>
    </div>
</div>