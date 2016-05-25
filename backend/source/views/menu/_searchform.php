<?php
//Register ajax script
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#menu-grid').yiiGridView('update', {
          data: $('#formSearch').serialize()
    });
	return false;
});
");
?>
<div class="search-form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'formSearch',
        'action'=>Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => 'form',
        ),
    )); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <?php echo $form->textField($modelSearchForm, 'menu_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Input Category Name',
                )); ?>
                <?php echo $form->error($modelSearchForm, 'menuName'); ?>
            </div>
            <div class="col-md-4">
                <?php echo CHtml::button(Yii::t('common','btn.search'), array(
                    'type' => 'submit',
                    'class ' => 'btn btn-success',
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>