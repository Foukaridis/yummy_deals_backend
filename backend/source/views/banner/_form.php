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
                <?php echo $form->label($model, Yii::t('banner', 'label.bannerName').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'bannerName', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'bannerName'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('banner', 'label.bannerShop').'<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'shopId', $shops, array(
                    'class' => 'form-control',
                    'disabled'=>'disabled',
                )); ?>
                <?php echo $form->error($model, 'shopId'); ?>
            </div>

            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('banner', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active','0' => 'Inactive'), array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <label class="control-label"><?php echo Yii::t('banner', 'label.bannerImage').'<span style="color: #ff0000"> *</span>'; ?></label>
                <?php if (isset($model->bannerImage) && !empty($model->bannerImage)) { ?>
                    <br/>
                    <img height="120px"
                         src="<?php echo Yii::app()->createUrl('site/image', array('id' => DIRECTORY_BANNER, 'f'=>$model->bannerImage, 't'=>DIRECTORY_SHOP)); ?>"/>
                    <br/>
                <?php } ?>
                <div class="space"></div>
                <div class="controls">
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?php echo Yii::t('common', 'label.selectFile'); ?></span>
                <?php echo $form->hiddenField($model, 'bannerImage'); ?>
                <?php echo $form->fileField($model, 'bannerNewThumb'); ?>
            </span>
                    <span class="fileinput-label"></span>
                </div>
            </div>
            <div class="col-md-1">

            </div>
        </div>
    </div>


    <div class="space"></div>
    <div class="col-md-12">
        <?php echo CHtml::button(Yii::t('common', $model->bannerId != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>