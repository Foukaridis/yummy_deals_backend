<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/27/13 - 9:44 AM
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title"><?php echo Yii::t('shop', 'title.updateShop'); ?></h4>
            </div>
            <div class="col-xs-9 text-right">
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('food/searchByShop', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewMenu'); ?></a>
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('promotion/searchByShop', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewOffer'); ?></a>
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('banner/searchByShop', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewBanner'); ?></a>
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('order/searchByShop', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewOrder'); ?></a>
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('shop/getUsers', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewCustomer');?></a>
                <a  style="<?php if (!Yii::app()->user->isShopOwner()) echo 'display:none'?>" class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('shop/shopEmployee', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewEmployee'); ?></a>
                <a  style="<?php if (!Yii::app()->user->isShopOwner()) echo 'display:none'?>" class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('shop/shippingAndTax', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewTaxShipping'); ?></a>
                <a class="btn inline btn-success" href="<?php echo Yii::app()->createUrl('comment/searchByShop', array('id'=>$model->location_id)); ?>"><?php echo Yii::t('shop', 'label.viewComment'); ?></a>
				<a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('shop/index'); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_form', array('model'=>$model,'cities'=>$cities,'accounts'=>$accounts)); ?>
    </div>
</div>