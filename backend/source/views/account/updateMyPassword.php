<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="title"><?php echo Yii::t('account', 'title.updateMyAccount'); ?></h4>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('account/updateMyAccount',array('id'=>Yii::app()->user->id)); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_my_password_form', array('model'=>$model)); ?>
    </div>
</div>