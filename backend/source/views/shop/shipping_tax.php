<?php
/**
 *
 * @var $this ShopController
 * @var $model TaxShippingForm
 * @var $form CActiveForm
 */
?>

<div class="row">
    <div class="col-xs-12 form-title">
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title">  <?php echo $this->title; ?></h4>
            </div>
            <div class="col-xs-8 text-right">

                <a class="btn btn-danger inline"
                   href="<?php echo Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)); ?>">
                    <?php
                    echo Yii::t('common', 'Back to ' . $shop->location_name); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'update-tax-shipping-form',
        'method' => 'POST',
        //'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'panel-body',
        ),
    ));
    ?>
    <?php if (Yii::app()->user->hasFlash('_error_')): ?>
        <div class="form-group">
            <div class="alert alert-danger">
                <button data-dismiss="alert" class="close"></button>
                <?php echo Yii::app()->user->getFlash('_error_'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="title" style="margin-top: 20px">Tax</h4>
            </div>
            <hr class="line"/>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->labelEx($model, 'tax_status'); ?>
                <?php echo $form->checkBox($model, 'tax_status', array('value' => 1, 'uncheckValue' => 0, 'class' => 'checkbox')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'tax_rate'); ?>
                <?php echo $form->textField($model, 'tax_rate', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Tax Rate (%)',
                )); ?>
                <?php echo $form->error($model, 'tax_rate'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="title" style="margin-top: 20px">Shipping</h4>
            </div>
            <hr class="line"/>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->labelEx($model, 'shipping_status'); ?>
                <?php echo $form->checkBox($model, 'shipping_status', array('value' => 1, 'uncheckValue' => 0, 'class' => 'checkbox')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'shipping_rate'); ?>

                <?php echo $form->textField($model, 'shipping_rate', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Shipping Rate',
                )); ?>
                <?php echo $form->error($model, 'shipping_rate'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'minimum'); ?>
                <?php echo $form->textField($model, 'minimum', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Minimum Order Amount',
                )); ?>
                <?php echo $form->error($model, 'minimum'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
                <?php echo $form->labelEx($model, 'local_pickup'); ?>
                <?php echo $form->checkBox($model, 'local_pickup', array('value' => 1, 'uncheckValue' => 0, 'class' => 'checkbox')); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="col-md-12">
            <div class="row">
                <?php echo CHtml::button(Yii::t('common', 'btn.update'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
            </div>
        </div>

    </div>

    <?php $this->endWidget(); ?>
</div>