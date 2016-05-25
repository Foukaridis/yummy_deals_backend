<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
?>
<div class="space"></div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'createNews-form',
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

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.foodCode') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'food_code', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>

                <?php echo $form->error($model, 'food_code'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.foodName') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'food_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>

                <?php echo $form->error($model, 'food_name'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.foodMenu') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'food_menu', Chtml::listData(Menu::model()->findAll(), 'menu_id', 'menu_name'), array(
                    'class' => 'form-control',
                    'prompt' => 'Select Menu'
                )); ?>
                <?php echo $form->error($model, 'food_menu'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.shop') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'food_shop_id', $shops, array(
                    'class' => 'form-control',
                    'disabled' => 'disabled',
                )); ?>
                <?php echo $form->error($model, 'food_shop_id'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.foodPrice') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'food_price', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>

                <?php echo $form->error($model, 'food_price'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>

        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <?php echo $form->label($model, Yii::t('food', 'label.foodDesc') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
        <?php //$this->widget('common.extensions.editMe.widgets.ExtEditMe', array(
        //            'model' => $model,
        //            'attribute' => 'food_description',
        //            'htmlOptions' => array(
        //                'rows' => 3,
        //                'class' => 'form-control',
        //            ),
        //        )); ?>
        <?php echo $form->textArea($model, 'food_description', array(
            'type' => 'text',
            'size' => 40,
            'class' => 'form-control',
            'rows' => 5,
        )); ?>
        <?php echo $form->error($model, 'food_description'); ?>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('food', 'label.available'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'available', array(Constants::AVAILABLE => 'Available', Constants::OUT_OF_STOCK => 'Out of stock'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'available'); ?>
            </div>
			<?php if ($model->food_id != null) { ?>
                <div class="col-md-2">
                    <?php echo $form->labelEx($model,'rate'); ?>
                    <?php echo $form->textField($model, 'rate', array(
                        'type' => 'text',
                        'size' => 40,
                        'disabled' => 'disabled',
                        'class' => 'form-control',
                    )); ?>
                    <?php echo $form->error($model, 'rate'); ?>
                </div>
                <div class="col-md-2">
                    <?php echo $form->labelEx($model,'rate_times'); ?>
                    <?php echo $form->textField($model, 'rate_times', array(
                        'type' => 'text',
                        'size' => 40,
                        'disabled' => 'disabled',
                        'class' => 'form-control',
                    )); ?>
                    <?php echo $form->error($model, 'rate_times'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="space"></div>
    <div class="col-md-12">
        <label
            class="control-label"><?php echo Yii::t('food', 'label.foodImage') . '<span style="color: #ff0000"> *</span>'; ?></label>
        <?php if (isset($model->food_image) && !empty($model->food_image)) { ?>
            <br/>
            <img height="120px"
                 src="<?php echo Yii::app()->createUrl('site/image', array('id' => $model->food_id, 'f' => $model->food_image, 't' => DIRECTORY_FOOD)); ?>"/>
            <br/>
        <?php } ?>
        <div class="space"></div>
        <div class="controls">
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?php echo Yii::t('common', 'label.selectFile'); ?></span>
                <?php echo $form->hiddenField($model, 'food_image'); ?>
                <?php echo $form->fileField($model, 'foodNewImage'); ?>
            </span>
            <span class="fileinput-label"></span>
        </div>
    </div>

    <div class="space"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <?php echo CHtml::button(Yii::t('common', $model->food_id != null ? 'btn.update' : 'btn.create'), array(
                    'type' => 'submit',
                    'class ' => 'btn btn-success',
                )); ?>
            </div>
            <div class="space"></div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>