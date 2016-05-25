<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'createSearch-form',
        'action'=>Yii::app()->createUrl('banner/index'),
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
            <div class="col-md-12">
                <?php echo $form->dropDownList($modelSearchForm, 'shop', $shops, array(
                    'class' => 'form-control',
                    'onchange'=>"$('#createSearch-form').submit();",
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>