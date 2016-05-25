<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/27/13 - 9:44 AM
 */
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="title">Send Email</h4>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-danger inline"
                   href="<?php echo Yii::app()->createUrl('account/index'); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<div class="row">
    <div class="col-xs-12" style="color: blue;padding-left: 30px;padding-top: 10px">
        <?php echo($model->message) ?>
    </div>
    <div class="col-xs-12">
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
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->textField($model, 'title', array(
                    'type' => 'text',
                    'size' => 40,
                    'class' => 'form-control',
                    'placeholder' => 'Title ',
                )); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-12">

                <?php
                $this->widget('common.extensions.editMe.widgets.ExtEditMe', array(
                    'model' => $model,
                    'attribute' => 'content',
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>

            </div>
        </div>
        <br/>

        <div class="row" style="padding-left: 15px">
            <div lass="col-md-12">
                <?php echo CHtml::button("Send", array(
                    'type' => 'submit',
                    'id' => 'btnSearch',
                    'class' => 'btn btn-success',
                    'onClick' => 'loading()'
                )); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div id="congden"></div>
<script type="text/javascript">
    function loading() {
        try {
            $("#congden").fakeLoader({
                timeToHide:120000,
                bgColor:"#1abc9c",
                spinner:"spinner6"
            });
        } catch (ex) {
            alert(ex);
        }
    }
</script>