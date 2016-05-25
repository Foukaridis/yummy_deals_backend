<?php
/* @var $this AccountController */
/* @var $account Account */
Yii::app()->clientScript->registerScript('ajax_call', "
var ajax_call = function(href) {
        $.ajax({
        url: href,
        success: function(response) {
            $.fn.yiiGridView.update('account-grid');
        }});
        return false;
}
", CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-9">
                <h4 class="title" style="margin-top: 20px"><?php echo Yii::t('account', 'title.account') ?></a></h4>
            </div>
            <div class="col-xs-3 text-right">
                <a class="btn btn-primary inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('account/create'); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
                <a class="btn btn-success inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('account/export'); ?>"><?php echo Yii::t('common', 'btn.export'); ?></a>
                <a class="btn btn-success inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('account/sendEmail'); ?>">Send email</a>
            </div>
        </div>
        <div class="row">
            <?php $this->renderPartial('_account_search', array('model' => $model, 'roles' => $roles)); ?>
        </div>
        <hr class="line"/>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'account-grid',
            'dataProvider' => $account->search($inactiveRole),
            'columns' => array(
                array(
                    'header' => "ID",
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->id;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "label.userName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->username;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "label.fullName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->full_name;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "title.accountType"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        if ($data->type == Constants::ACCOUNT_NORMAL) {
                            return Yii::t("account", "label.normal");
                        } else {
                            return Yii::t("account", "label.facebook");
                        }
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "label.email"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->email;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "label.role"),
                    'type' => 'raw',
                    'value' => '$data->getRole()',
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    'header' => Yii::t("account", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        if ($data->status == 0)
                            return '<span style="color: red">Inactive</span>';
                        else
                            return '<span style="color: blue">Active</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('account', 'label.upgradeOwner'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->request))
                            return
                                '<a onclick=ajax_call("' . Yii::app()->createUrl('account/updateToShopOwner', array('id' => $data->id, 'type' => 'approve')) . '") class="glyphicon glyphicon-ok" style="color:green; cursor:pointer;" ></a>' . ' ' .
                                '<p onclick=ajax_call("' . Yii::app()->createUrl('account/updateToShopOwner', array('id' => $data->id, 'type' => 'reject')) . '") class="glyphicon glyphicon-remove" style="color:red; cursor:pointer;"></p>';
                        else return '';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    'header' => Yii::t('account', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('account/update', array('id' => $data->id)) . '" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('account', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('account/delete', array('id' => $data->id)) . '" onclick="return confirm(\'' . Yii::t('account', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
            ),
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>