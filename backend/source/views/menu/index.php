<?php
/**
 *
 * Date: 12/27/13 - 9:44 AM
 */

?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title" style="margin-top: 20px"><?php echo Yii::t('menu', 'title.menu'); ?></h4>
            </div>
            <div class="col-xs-7">
                <?php $this->renderPartial('_searchform', array('modelSearchForm'=>$searchModel)); ?>
            </div>
            <div class="col-xs-2 text-right">
                <a class="btn btn-primary inline" style="margin-top: 15px"
                   href="<?php echo Yii::app()->createUrl('menu/create'); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'menu-grid',
            'dataProvider' => $data->search(),
            'columns' => array(
                array(
                    'header' => Yii::t("menu", "label.menuImage"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<img height="80px" src="' . Yii::app()->createUrl('site/image', array('id' => $data->menu_id, 'f' => $data->menu_small_thumbnail, 't' => DIRECTORY_MENU)) . '"/>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
                array(
                    'header' => Yii::t("menu", "label.menuName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->menu_name;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("menu", "label.menuDes"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->menu_desc;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '30%',
                    ),

                ),
                array(
                    'header' => Yii::t("menu", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->status==0 ? "Inactive" : '<span style="color:blue"> Active'.'</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),

                array(
                    'header' => Yii::t('menu', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.update') . '" href="' . Yii::app()->createUrl('menu/update', array('id' => $data->menu_id)) . '" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('menu', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('menu/delete', array('id' => $data->menu_id)) . '" onclick="return confirm(\'' . Yii::t('menu', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
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