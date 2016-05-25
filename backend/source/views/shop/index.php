<?php

/* @var $shop Shop */
/* @var $model Shop */
?>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-2">
                <h4 class="title" style="margin-top: 20px"><?php echo Yii::t('shop', 'title.shop'); ?></h4>
            </div>
            <div
                class="col-xs-8" <?php if (Yii::app()->user->role != 1 AND Yii::app()->user->role != 2) echo 'style="display: none"'; ?>>
                <?php $this->renderPartial('_searchform', array('model' => $model, 'cities' => $cities,)); ?>
            </div>
            <div
                class="col-xs-2 text-right" <?php if (Yii::app()->user->role != 1 AND Yii::app()->user->role != 2) echo 'style="display: none"'; ?>>
                <a class="btn btn-primary inline " style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('shop/create'); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>
<?php

$user_id = Yii::app()->user->id;
$role = Yii::app()->user->role;
?>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'shop-grid',
            'dataProvider' => $shop->searchCustom($user_id, $role),
            'columns' => array(
                array(
                    'header' => Yii::t("shop", "label.shopImage"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<img height="80px" src="' . Yii::app()->createUrl('site/image', array('id' => $data->location_id, 'f' => $data->location_image, 't' => DIRECTORY_SHOP)) . '"/>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("shop", "label.shopName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::encode($data->location_name);

                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("shop", "label.shopAddress"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::encode($data->location_address);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("shop", "label.shopCity"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $city = City::model()->findByPk($data->location_city);
                        return $city == null ? '' : CHtml::encode($city->cityName);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("shop", "label.shopPhone"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::encode($data->location_tel);
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("shop", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->status == 0 ? "Inactive" : '<span style="color:blue"> Active' . '</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    //'htmlOptions' => Yii::app()->user->role == Constants::ROLE_ADMIN ? array() : array('style' => 'display:none'),
                    'header' => Yii::t("shop", "label.verified"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->isVerified == 0 ? "Not Verified" : '<span style="color:blue">  Verified' . '</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                        //'style' => Yii::app()->user->role == Constants::ROLE_ADMIN ? '' : 'display:none',
                    ),
                ),
                array(
                    //'htmlOptions' => Yii::app()->user->role == Constants::ROLE_ADMIN ? array() : array('style' => 'display:none'),
                    'header' => Yii::t("shop", "label.featured"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->isFeatured == 0 ? "Not Featured" : '<span style="color:blue"> Featured' . '</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                        //'style' => Yii::app()->user->role == Constants::ROLE_ADMIN ? '' : 'display:none',
                    ),
                ),
                array(
                    'header' => Yii::t('common', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('shop/update', array('id' => $data->location_id)) . '" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('common', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('shop/delete', array('id' => $data->location_id)) . '" onclick="return confirm(\'' . Yii::t('shop', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                        'style' => 'display: none'
                    ),
                    'htmlOptions' => array(
                        'style' => 'display: none'
                    )
                ),
            ),
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>