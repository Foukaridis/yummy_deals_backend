<?php
/* @var $model Orders */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
          data: $('#orders-search-form').serialize()
    });
	return false;
});
");

?>
<div class="search-form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'orders-search-form',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array(
            'class' => 'form',
        ),
    )); ?>
    <div class="col-md-12">
        <div class="col-md-2">
            <?php echo $form->dropDownList($model, 'status', $status,
                array(
                    'class' => 'form-control',
                    'prompt' => 'Select Status'
                )); ?>
        </div>
        <?php if (Yii::app()->user->role != Constants::ROLE_MODERATOR) { ?>
            <div class="col-md-2">
                <?php echo $form->dropDownList($model, 'shop_id', $shop,
                    array(
                    'class' => 'form-control',
                    'prompt' => 'Select Shop'
                )); ?>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <?php echo CHtml::button(Yii::t('common', 'btn.search'), array(
                'type' => 'submit',
                'class ' => 'btn btn-success',
            )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>