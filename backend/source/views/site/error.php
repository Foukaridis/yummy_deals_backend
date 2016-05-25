<?php
/**
 * Created by Lorge 
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:36 AM
 */
?>

<div class="text-center col-md-12">
    <h1 class="text-white"><?php echo $code; ?></h1>
    <h3><?php echo CHtml::encode($message); ?></h3>
</div>
<?php if (Yii::app()->user->isShopOwner() OR Yii::app()->user->isAdmin() OR Yii::app()->user->isModerator()) {?>
    <div class="list-group col-md-12">
        <a href="<?php echo Yii::app()->createUrl('shop/index'); ?>" class="list-group-item">
            <i class="icon icon-home"></i>
            Back to homepage
        </a>
    </div>
<?php } else
{ ?>
    <a href="<?php echo Yii::app()->createUrl('account/updateMyAccount', array('id'=>Yii::app()->user->id)); ?>" class="list-group-item">
        <i class="icon icon-home"></i>
        Back to homepage
    </a>
<?php } ?>