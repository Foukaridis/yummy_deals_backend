<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="title"><?php echo Yii::t('account', 'title.updateMyAccount'); ?></h4>
            </div>
            <div class="col-xs-6 text-right">
                <?php if (Yii::app()->user->isAdmin()) { ?>
                    <a class="btn btn-success inline"
                       href="<?php echo Yii::app()->createUrl('shop/index'); ?>"><?php echo Yii::t('account', 'title.viewShop'); ?></a>
                <?php } else { ?>
                    <a class="btn btn-primary inline" onclick="registerShopOwner(<?php echo Yii::app()->user->id ?>)"
                       style="<?php if (!Yii::app()->user->isCustomer()) echo 'display: none' ?>">
                        <?php echo Yii::t('account', 'title.registerShopOwner'); ?>
                    </a>
                    <a class="btn btn-success inline"
                       style="<?php if (!Yii::app()->user->isCustomer()) echo 'display: none' ?>"
                       href="<?php echo Yii::app()->createUrl('account/viewOrder', array('id' => Yii::app()->user->id)); ?>"><?php echo Yii::t('account', 'title.viewOrder'); ?></a>
                <?php } ?>
                <a class="btn btn-success inline"
                   href="<?php echo Yii::app()->createUrl('account/updateMyPassword', array('id' => Yii::app()->user->id)); ?>"><?php echo Yii::t('common', 'mnu.editPassAccount'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_my_account_form', array('model' => $model)); ?>
    </div>
</div>
<script>
    function registerShopOwner(user_id) {
        var postForm = {
            'user_id': user_id
        };
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->request->baseUrl; ?>/api/requestShopOwner',
            data: postForm,
            success: function (data) {
                var obj = jQuery.parseJSON(JSON.stringify(data));
                alert(obj.message);
            }
        });
    }
</script>