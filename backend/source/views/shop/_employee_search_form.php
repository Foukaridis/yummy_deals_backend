
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'formSearch',
        'action'=>Yii::app()->createUrl('shop/shopEmployee', array('id'=>$shopId)),
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
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->textField($modelSearchForm, 'full_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Input Name',
                )); ?>
                <?php echo $form->error($modelSearchForm, 'full_name'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->dropDownList($modelSearchForm, 'role', $roles, array(
                    'class' => 'form-control',
                    'prompt'=>'Select Role'
                )); ?>
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
