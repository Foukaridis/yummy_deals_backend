<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'searchFood-form',
        'action'=>Yii::app()->createUrl('food/index'),
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
            <div class="col-md-3">
                <?php echo $form->textField($modelSearchForm, 'foodName', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Menu Name',
                )); ?>
                <?php echo $form->error($modelSearchForm, 'foodName'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->dropDownList($modelSearchForm, 'foodMenu', $menus, array(
                    'class' => 'form-control',
                )); ?>
            </div>

            <!--div class="col-md-2" style="display: none">
                <!--?php echo $form->dropDownList($modelSearchForm, 'foodShop', $shops, array(
                    'class' => 'form-control',
                )); ?>
            </div-->
            <div class="col-md-3">
                <?php echo $form->dropDownList($modelSearchForm, 'dayStatus', array('2'=>'Day Status','0'=>'Inactive','1'=>'Active'), array(
                    'class' => 'form-control',
                )); ?>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::button(Yii::t('common','btn.search'), array(
                    'type' => 'submit',
                    'class ' => 'btn btn-success',
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>