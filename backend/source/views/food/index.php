<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
$chechkUrl = Yii::app()->createUrl('food/checkUsage');
$deleteUrl = Yii::app()->createUrl('food/delete');
Yii::app()->clientScript->registerScript('beforeDelete', "
var checkFoodUsage = function(foodId) {
confirm(\"" . Yii::t('food', 'msg.confirmDelete') . "\");
            $('#loading').show();
            $.ajax({
                url: \"$chechkUrl\",
                dataType: 'json',
                type: 'POST',
                 data: { foodId : foodId },
            }).done(function (data) {
                if (data == 'NOT_LOGGED_IN') {
                    window.location.reload();
                    return;
                }
                if (!data.success) {
                    $('#loading').hide();
                    alert(data.message);
                } else {
                   $('#loading').hide();
                }
            }).fail(function (jqXHR, textStatus) {
                $('#loading').hide();
                alert('Invalid Request!');
            });
        return false;
}
", CClientScript::POS_BEGIN);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title" style="margin-top: 20px"><?php
                    $shop=Shop::model()->findByPk($modelSearchForm->foodShop);
                    echo Yii::t('food', 'title.food'). ' >> <a href="' . Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)) . '">' . $shop->location_name ?></a></h4>
            </div>
			<div class="col-xs-6">
			</div>
            <div class="col-xs-3 text-right">
                <a class="btn btn-primary inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('food/create',array('shopId'=>$modelSearchForm->foodShop)); ?>"><?php echo Yii::t('common', 'btn.create'); ?></a>
                <a class="btn btn-danger inline" style="margin-top: 15px" href="<?php echo Yii::app()->createUrl('shop/update',array('id'=>$modelSearchForm->foodShop)); ?>">
                    <?php
                    echo Yii::t('common', 'Back to '.$shop->location_name); ?></a>
            </div>
        </div>
		<div class="row">        
            <div class="col-xs-12">
                <?php $this->renderPartial('_searchform', array('modelSearchForm'=>$modelSearchForm,'menus' => $menus,
                    'shops' => $shops,)); ?>
            </div>         
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'news-grid',
            'dataProvider'=> $dataList,
            'columns'=>array(
                array(
                    'header' => Yii::t("food", "label.foodImage"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<img height="80px" src="'.Yii::app()->createUrl('site/image', array('id' => $data->food_id, 'f'=>$data->food_thumbnail, 't'=>DIRECTORY_FOOD)).'"/>';
                    },

                ),
                array(
                    'header' => Yii::t("food", "label.foodCode"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_code;
                    },
                ),
                array(
                    'header' => Yii::t("food", "label.foodName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_name;
                    },
                ),
                array(
                    'header' => Yii::t("food", "label.foodMenu"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $menu = Menu::model()->findByPk($data->food_menus);
                        if($menu != null){
                            return $menu->menu_name;
                        }else{
                            return "No menu";
                        }
                    },
                ),
                array(
                    'header' => Yii::t("food", "label.shop"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $shop=Shop::model()->findByPk($data->shop_id);
                        return $shop==null?'':$shop->location_name;
                    },
                ),
                array(
                    'header' => Yii::t("food", "label.foodPrice"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_price;
                    },
                ),

                array(
                    'header' => Yii::t("menu", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {

                        if($data->status==0)
                        {
                            return "Inactive";
                        }else if($data->status==1)
                        {
                            return '<span style="color:blue"> Active'.'</span>';
                        }
                        else
                            return '';

                    },
                ),

                array(
                    'header' => Yii::t("food", "label.available"),
                    'type' => 'raw',
                    'value' => '$data->getAvailable();'
                ),

                array(
                    'header' => Yii::t('food', 'label.dayStatus'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return ($data->status_in_day==0) ? '<a class="btn btn-danger inline" href="'.Yii::app()->createUrl('food/updateDayStatus',array('id'=>$data->food_id)).'">Inactive</a>':'<a class="btn btn-primary inline" href="'.Yii::app()->createUrl('food/updateDayStatus',array('id'=>$data->food_id)).'">Active</a>';
                    },

                ),

                array(
                    'header' => Yii::t('food', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.update').'" href="'.Yii::app()->createUrl('food/update', array('id'=>$data->food_id)).'" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.delete').'" href="" onclick="checkFoodUsage('.$data->food_id.')" class="glyphicon glyphicon-trash"></a>';
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