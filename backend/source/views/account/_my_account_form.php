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
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('account', 'label.userName') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'username', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'readonly' => true,
                ));
                ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('account', 'label.email') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'email', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'readonly' => true,
                )); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>

            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('account', 'label.role') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'role', array('0' => 'User', '1' => 'Shop Owner', '2' => 'Admin','3' => 'Chef','4'=>'Delivery Man','5'=>'Moderator'), array(
                    'class' => 'form-control',
                    'disabled'=>'disabled',
                )); ?>
                <?php echo $form->error($model, 'role'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->label($model, Yii::t('account', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status', array('1' => 'Active', '0' => 'Inactive'), array(
                    'class' => 'form-control',
                    'disabled'=>'disabled',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->label($model, Yii::t('account', 'label.fullName'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'fullName', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'fullName'); ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->label($model, Yii::t('account', 'label.phone'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'phone', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->label($model, Yii::t('account', 'label.address'), array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'address', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="space"></div>
    </div>

    <div class="space"></div>
    <div class="col-md-12">
        <?php echo CHtml::button(Yii::t('common','btn.update'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>