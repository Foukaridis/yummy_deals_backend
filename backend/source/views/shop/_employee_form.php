<?php
$invalidRequestMessage = 'Invalid Request';
$timetrackerScript = <<<SCRIPT
var timetracker_create = function (href) {
    $('#create-timetracker-indicator').show();
    $.ajax({
        url: href,
        type: 'POST',
        data: decodeURIComponent($('#create-timetracker-form').serialize()) + '&ajax=create-timetracker-form'
    }).done(function (data) {
            if (data == 'NOT_LOGGED_IN') {
                window.location.reload();
                return;
            }
            if (data.success) {
                if (data.valid) {
                    $('#create-timetracker-error-summary').hide();
                    $('#create-timetracker-indicator').hide();
                    timetracker_resetForm();
                    $('#employee-grid').yiiGridView('update', {
                        data: $('#formSearch').serialize()
                    });
                } else {
                    $('#create-timetracker-error-summary div').html(data.errors);
                    $('#create-timetracker-error-summary').show();
                    $('#create-timetracker-indicator').hide();
                }
            } else {
                $('#create-timetracker-indicator').hide();
                alert(data.message);
            }
        }).fail(function (jqXHR, textStatus) {
            $('#create-timetracker-indicator').hide();
            alert("$invalidRequestMessage");
        });
        return false;
}
var timetracker_resetForm = function() {
    $('#Account_username').val('');
    $('#Account_role').val('-1');

}
SCRIPT;
Yii::app()->getClientScript()->registerScript('timetrackerScript', $timetrackerScript, CClientScript::POS_END);
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'create-timetracker-form',
    'enableAjaxValidation' => false,
    //'enableClientValidation' => true,
    'htmlOptions' => array('onsubmit' => 'timetracker_create("' . Yii::app()->createUrl('shop/createEmployee', array('id' => $shopId)) . '"); return false;', 'class' => 'no-margin form', 'enctype' => 'multipart/form-data')
)); ?>
    <div class="col-md-12">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->textField($model, 'username', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Username',
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'password', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'email', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                )); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->textField($model, 'full_name', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Full Name',
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'phone', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Phone',
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->textField($model, 'address', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Address',
                )); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->dropDownList($model, 'role', $roles, array(
                    'class' => 'form-control',
                    'prompt'=>'Select Role'
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo CHtml::button(Yii::t('common', 'btn.create'), array(
                    'type' => 'submit',
                    'id' => 'btn-create',
                    'class' => 'btn btn-md btn-success',
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div id="create-timetracker-indicator" class="indicator"
             style="display: none; height: 30px">Creating...
        </div>
        <div id="create-timetracker-error-summary" class="alert alert-error" style="display: none">
<!--            <button data-dismiss="alert" class="close"></button>-->
            <div></div>
        </div>
    </div>
    </div>
<?php $this->endWidget(); ?>