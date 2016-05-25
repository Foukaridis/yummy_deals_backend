<?php
/**
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="title"><?php echo Yii::t('account', 'title.updateAccount'); ?></h4>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('shop/shopEmployee',array('id'=>$model->shopId)); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_form', array('model'=>$model,'roles'=>$roles)); ?>
    </div>
</div>