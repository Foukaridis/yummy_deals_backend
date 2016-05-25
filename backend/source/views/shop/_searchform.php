<?php
/* @var $model Shop */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#shop-grid').yiiGridView('update', {
          data: $('#shop-search-form').serialize()
    });
	return false;
});
");

?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'shop-search-form',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => 'form',
        ),
    )); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->textField($model, 'location_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Shop Name'
                )); ?>
                <?php echo $form->error($model, 'location_name'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->dropDownList($model, 'location_city', $cities, array(
                    'class' => 'form-control',
                    'prompt' => 'Select City'
                )); ?>
                <?php echo $form->error($model, 'location_city'); ?>
            </div>
            <div class="col-md-2">
                <?php echo CHtml::button(Yii::t('common', 'btn.search'), array(
                    'type' => 'submit',
                    'id'=>'btnSearch',
                    'class' => 'btn btn-success',
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
