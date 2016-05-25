<?php
$shopId = $shop->location_id;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title" style="margin-top: 15px"><?php
                    echo Yii::t('account', 'title.account') . ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>
            <div class="col-xs-6">
                <?php $this->renderPartial('_employee_search_form', array('modelSearchForm' => $modelSearchForm,'roles'=>$roles,'shopId'=> $shopId)); ?>
            </div>
            <div class="col-xs-1 text-right">

                <a class="btn btn-danger inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('shop/update', array('id' => $shopId)); ?>">
                    <?php
                    echo Yii::t('common', 'Back to ' . $shop->location_name); ?></a>
            </div>
        </div>
        <hr class="line"/>
        <div class="space"></div>
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title" style="margin-top: 20px">Create Employee Account</h4>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
        <?php $this->renderPartial('_employee_form', array(
                'model' => $employee,
                'roles'=> $roles,
                'shopId'=>$shopId
            )) ?>
        </div>
        <div class="space"></div>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        <h4 class="title" style="margin-top: 20px">Employee List</h4>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'employee-grid',
            'dataProvider' => $dataList,
            'columns' => array(
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
                            return '<span style="color: red">Deleted</span>';
                        else
                            return '<span style="color: blue">Active</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t('food', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('account/updateEmployee', array('id' => $data->id)).'" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('shop/deleteEmployee', array('id' => $data->id,'shopId'=>$data->shopId)) . '" onclick="return confirm(\'' . Yii::t('account', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
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