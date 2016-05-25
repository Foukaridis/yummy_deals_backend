<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'adminSearch-form',
        'action'=>Yii::app()->createUrl('finance/withdrawRequestManagement'),
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
        <div class="col-md-2">
            <?php echo $form->dropDownList($modelSearchForm,'status',  array('5'=>'All Status','0' => 'Pending', '1' => 'Approved', '-1'=>'Rejected'), array(
                'class' => 'form-control',
            )); ?>
        </div>
        <div class="col-md-2">
            <?php echo $form->dropDownList($modelSearchForm,'ownerId',  $owners, array(
                'class' => 'form-control',
            )); ?>
        </div>
        <div class="col-md-2">
            <?php echo CHtml::button(Yii::t('common','btn.search'), array(
                'type' => 'submit',
                'class ' => 'btn btn-success',
            )); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>