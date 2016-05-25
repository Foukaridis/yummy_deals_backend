<?php
/**
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title"><?php echo Yii::t('promotion', 'title.updateEvent'); ?></h4>
            </div>
            <div class="col-xs-9 text-right">
                <a class="btn btn-success inline" href="<?php echo Yii::app()->createUrl('promotion/getListFoodByShop',array('shopId'=>$shopId,'promotionId'=>$model->eventId)); ?>"><?php echo Yii::t('promotion', 'label.addFoodToEvent'); ?></a>
                <a class="btn btn-success inline" href="<?php echo Yii::app()->createUrl('promotion/getListFoodByPromotion',array('shopId'=>$shopId,'promotionId'=>$model->eventId)); ?>"><?php echo Yii::t('promotion', 'label.menus'); ?></a>
                <a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('promotion/searchByShop',array('id'=>$shopId)); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_form', array('model'=>$model,'shops'=>$shops)); ?>
    </div>
</div>