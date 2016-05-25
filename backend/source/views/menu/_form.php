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
                <?php echo $form->label($model, Yii::t('menu', 'label.menuName').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'menu_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'menu_name'); ?>
            </div>
            <div class="col-md-2" style="display: none">
                <?php echo $form->label($model, Yii::t('menu', 'label.menuParent'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'parent_id', $menus, array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('menu', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active','0' => 'Inactive'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <?php echo $form->label($model, Yii::t('menu', 'label.menuDes').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
        <?php $this->widget('common.extensions.editMe.widgets.ExtEditMe', array(
            'model' => $model,
            'attribute' => 'menu_description',
            'htmlOptions' => array(
                'rows' => 3,
                'class' => 'form-control',
            ),
        )); ?>
        <?php echo $form->error($model, 'menu_description'); ?>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <label class="control-label"><?php echo Yii::t('menu', 'label.menuImage').'<span style="color: #ff0000"> *</span>'; ?></label>
        <?php if(isset($model->menu_small_thumbnail) && !empty($model->menu_small_thumbnail)){?>
            <br/>
            <img height="120px" src="<?php echo Yii::app()->createUrl('site/image', array('id' => $model->menu_id, 'f'=>$model->menu_small_thumbnail, 't'=>DIRECTORY_MENU)); ?>"/>
            <br/>
        <?php } ?>
        <div class="space"></div>
        <div class="controls">
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?php echo Yii::t('common', 'label.selectFile'); ?></span>
                <?php echo $form->hiddenField($model, 'menu_small_thumbnail'); ?>
                <?php echo $form->fileField($model, 'menuNewThumb'); ?>
            </span>
            <span class="fileinput-label"></span>
        </div>
    </div>
    <div class="col-md-12">
        <?php echo CHtml::button(Yii::t('common', $model->menu_id != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>