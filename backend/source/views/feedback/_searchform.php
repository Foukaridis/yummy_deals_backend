<?php
//Register ajax script
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#feedback-grid').yiiGridView('update', {
          data: $('#formSearch').serialize()
    });
	return false;
});
");
?>

<div class="row">
    <div class="col-xs-3">
            <?php if ($modelSearchForm->type === 'feedback') { ?>
                <h4 class="title" style="font-size: 16px"><?php echo Yii::t('feedback', 'title.feedback'); ?></h4>
            <?php } elseif ($modelSearchForm->type === 'report') { ?>
                <h4 class="title" style="font-size: 16px"><?php echo Yii::t('feedback', 'title.reports'); ?></h4>
            <?php } else { ?>
                <h4 class="title" style="font-size: 16px"><?php echo Yii::t('feedback', 'title.bug'); ?></h4>
            <?php } ?>
    </div>
    <div class="col-xs-8 text-right">
        <div class="search-form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'formSearch',
                'action'=>Yii::app()->createUrl($this->route),
                'method' => 'get',
                'htmlOptions' => array(
                    'class' => 'form',
                ),
            )); ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $form->textField($modelSearchForm, 'account_id', array(
                            'type' => 'text',
                            'size' => 40,
                            'class' => 'form-control',
                            'placeholder' => 'Input Account ID',
                        )); ?>
                        <?php echo $form->hiddenField($modelSearchForm, 'type'); ?>
                        <?php echo $form->error($modelSearchForm, 'account_id'); ?>
                    </div>
                    <div class="col-md-2">
                        <?php echo CHtml::button(Yii::t('common','btn.search'), array(
                            'type' => 'submit',
                            'class ' => 'btn btn-success',
                        )); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <hr class="line"/>
        <div class="row">
            <div class="col-xs-4 ">
                <a class="btn btn-success"
                   href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => 'feedback')) ?>">Feedback</a>
                <a class="btn btn-success"
                   href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => 'report')) ?>">Report</a>
                <a class="btn btn-success"
                   href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => 'bug')) ?>">Bug</a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>


