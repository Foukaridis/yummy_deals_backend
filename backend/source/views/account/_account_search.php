<?php
/* @var $model Account */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#account-grid').yiiGridView('update', {
          data: $('#account-search-form').serialize()
    });
	return false;
});
");
?>
<div class="search-form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'account-search-form',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => 'form',
        ),
    )); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->textField($model, 'id', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'ID',
                )); ?>
                <?php echo $form->error($model, 'id'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->textField($model, 'full_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Input Name',
                )); ?>
                <?php echo $form->error($model, 'full_name'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->textField($model, 'email', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                )); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->dropDownList($model, 'role', $roles, array(
                    'class' => 'form-control',
                    'prompt' => 'Select Role',

                )); ?>
            </div>
            <div class="col-md-2">
                <?php echo CHtml::button(Yii::t('common', 'btn.search'), array(
                    'type' => 'submit',
                    'id' => 'btnSearch',
                    'class' => 'btn btn-sm btn-success',
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
