<?php

$currentUrl = $this->uniqueId;
$detailCurrentUrl = $this->uniqueId . '/' . $this->action->Id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->renderPartial("/layouts/public/header"); ?>
</head>
<body>
<div id="navigation">
    <nav class="navbar navbar-default no-border-radius" role="navigation">
        <div class="container">
            <div class="row">
                <!-- header -->
                <div id="header" class="col-xs-3">
                    <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                </div>
                <!-- header -->

                <!-- mainmenu -->
                <div class="col-xs-9 collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php if (Yii::app()->user->isShopOwner() OR Yii::app()->user->isAdmin() OR Yii::app()->user->isModerator()) { ?>
                            <li <?php if ($currentUrl === 'shop') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('shop/index'); ?>">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                    <?php echo Yii::t('common', 'mnu.shop'); ?>
                                </a>
                            </li>
                            <li <?php if ($currentUrl === 'order') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('order/index'); ?>">
                                    <i class="glyphicon glyphicon-th-list"></i>
                                    <?php echo Yii::t('common', 'mnu.order'); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (Yii::app()->user->isShopOwner()) { ?>
                            <li class="hide" <?php if ($currentUrl === 'finance') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('finance/shopOwner'); ?>">
                                    <i class="glyphicon glyphicon-usd"></i>
                                    <?php echo Yii::t('common', 'mnu.finance'); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (Yii::app()->user->isAdmin()) { ?>
                            <li <?php if ($currentUrl === 'menu') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('menu/index'); ?>">
                                    <i class="glyphicon glyphicon-globe"></i>
                                    <?php echo Yii::t('common', 'mnu.menus'); ?>
                                </a>
                            </li>
                            <li <?php if ($currentUrl === 'city') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('city/index'); ?>">
                                    <i class="glyphicon glyphicon-cloud"></i>
                                    <?php echo Yii::t('common', 'mnu.city'); ?>
                                </a>
                            </li>
                            <li class="hide" <?php if ($currentUrl === 'finance') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('finance/admin'); ?>">
                                    <i class="glyphicon glyphicon-usd"></i>
                                    <?php echo Yii::t('common', 'mnu.finance'); ?>
                                </a>
                            </li>
                            <li <?php if ($currentUrl === 'feedback') echo "class='active'"; ?>>
                                <a href="<?php if (yii::app()->user->role == 0) {
                                    echo Yii::app()->createUrl('feedback/create');
                                } else {
                                    echo Yii::app()->createUrl('feedback/index?type=report');
                                } ?>">
                                    <i class="glyphicon glyphicon-send"></i>
                                    <?php echo Yii::t('common', 'mnu.feedback'); ?>
                                </a>

                            </li>

                            <!--li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
                                    <i class="glyphicon glyphicon-usd"></i>
                                    <!?php echo Yii::t('common', 'mnu.finance'); ?> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu multi-level">
                                    <li>
                                        <a href="<!?php echo Yii::app()->createUrl('finance/admin', array('rs'=>true)); ?>">
                                            <!?php echo Yii::t('common', 'mnu.finance'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<!?php echo Yii::app()->createUrl('finance/withdrawRequestManagement', array('rs'=>true)); ?>">
                                            <!?php echo Yii::t('finance', 'title.admin.withdraw.management'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li-->


                            <li <?php if ($detailCurrentUrl === 'account/index' || $detailCurrentUrl === 'account/update' || $detailCurrentUrl === 'account/create') echo "class='active'"; ?>>
                                <a href="<?php echo Yii::app()->createUrl('account/index'); ?>">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <?php echo Yii::t('common', 'mnu.account'); ?>
                                </a>
                            </li>

                            <li class="dropdown <?php if ($currentUrl === 'setting') echo "active"; ?>">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                   data-hover="dropdown"
                                   data-delay="0" data-close-others="false">
                                    <i class="glyphicon glyphicon-cog"></i>
                                    <?php echo Yii::t('common', 'mnu.settings'); ?> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">

                                    <li <?php if ($detailCurrentUrl === 'setting/adminAccount') echo "class='active'"; ?>>
                                        <a href="<?php echo Yii::app()->createUrl('setting/adminAccount'); ?>">
                                            <?php echo Yii::t('setting', 'mnu.UpdateAdmin'); ?>
                                        </a>
                                    </li>
                                    <li <?php if ($detailCurrentUrl === 'setting/updateSetting') echo "class='active'"; ?>>
                                        <a href="<?php echo Yii::app()->createUrl('setting/updateSetting'); ?>">
                                            <?php echo Yii::t('setting', 'mnu.UpdateSystem'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } else {  ?>
                        <li class="dropdown <?php if ($detailCurrentUrl === 'account/updateMyAccount' || $detailCurrentUrl === 'account/updatePassword') echo "active"; ?>">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                               data-hover="dropdown"
                               data-delay="0" data-close-others="false">
                                <i class="glyphicon glyphicon-cog"></i>
                                <?php echo Yii::t('common', 'mnu.myAccount'); ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">

                                <li <?php if ($detailCurrentUrl === 'account/updateMyAccount') echo "class='active'"; ?>>
                                    <a href="<?php echo Yii::app()->createUrl('account/updateMyAccount',array('id'=>Yii::app()->user->id)); ?>">
                                        <?php echo Yii::t('common', 'mnu.updateAccount'); ?>
                                    </a>
                                </li>
                                <li <?php if ($detailCurrentUrl === 'account/updateMyPassword') echo "class='active'"; ?>>
                                    <a href="<?php echo Yii::app()->createUrl('account/updateMyPassword',array('id'=>Yii::app()->user->id)); ?>">
                                        <?php echo Yii::t('common', 'mnu.editPassAccount'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">
                                <i class="glyphicon glyphicon-log-out"></i>
                                <?php echo Yii::t('common', 'mnu.logout'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- mainmenu -->
            </div>
        </div>
    </nav>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <?php echo $content; ?>
        </div>
    </div>

    <div id="footer" class="row">
        <div class="col-xs-12">
            <!--            <hr class="line"/>-->
            <!--            &copy; 2014 Connect Phone - All rights reserved<br/>-->
        </div>
    </div>
</div>
<?php $this->renderPartial("/layouts/public/footer"); ?>
</body>
</html>