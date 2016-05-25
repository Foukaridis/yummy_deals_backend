<?php
/**
 * Date: 12/27/13 - 9:44 AM
 */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-9">
                <h4 class="title" style="margin-top: 20px"><?php echo !$isFoodPromotion ? Yii::t('promotion', 'label.addFoodToEvent'): 'List Menus'?></h4>
            </div>
            <div class="col-xs-3 text-right">
                <?php if($isFoodPromotion) {?>
                <a class="btn btn-success inline" style="margin-top: 10px" href="<?php echo Yii::app()->createUrl('promotion/getListFoodByShop',array('shopId'=>$shopId,'promotionId'=>$promotionId)); ?>"><?php echo Yii::t('promotion', 'label.addFoodToEvent'); ?></a>
                <?php }?>
                <a class="btn btn-danger inline" style="margin-top: 10px"
                   href="<?php echo Yii::app()->createUrl('promotion/update', array('id' => $promotionId)); ?>">
                    <?php echo Yii::t('common', 'btn.cancel'); ?></a>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'news-grid',
            'dataProvider' => $dataList,
            'columns' => array(
                array(
                    'header' => Yii::t("food", "label.foodImage"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<img height="80px" src="' . Yii::app()->createUrl('site/image', array('id' => $data->food_id, 'f' => $data->food_thumbnail, 't' => DIRECTORY_FOOD)) . '"/>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("food", "label.foodCode"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_code;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("food", "label.foodName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_name;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t("food", "label.foodMenu"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $menu = Menu::model()->findByPk($data->food_menus);
                        if ($menu != null) {
                            return $menu->menu_name;
                        } else {
                            return "No menu";
                        }
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("food", "label.shop"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $shop = Shop::model()->findByPk($data->shop_id);
                        return $shop == null ? '' : $shop->location_name;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t("food", "label.foodPrice"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->food_price;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),

                array(
                    'header' => Yii::t("menu", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->status == 0 ? "Inactive" : '<span style="color:blue"> Active' . '</span>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => 'Action',
                    'type' => 'raw',
                    'value' => function ($data) use ($promotionId,$isFoodPromotion) {
                        return FoodPromotion::model()->checkExistFoodInPromotion($promotionId, $data->food_id) ? '<a class="btn btn-danger inline" href="' . Yii::app()->createUrl('promotion/removeFromPromotion', array('promotionId' => $promotionId, 'foodId' => $data->food_id,'isFoodPromotion' => $isFoodPromotion)) . '">Remove</a>' : '<a class="btn btn-primary inline" href="' . Yii::app()->createUrl('promotion/addToPromotion', array('promotionId' => $promotionId, 'foodId' => $data->food_id,'isFoodPromotion' => $isFoodPromotion)) . '">Add</a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),
            ),
            'itemsCssClass' => 'table table-striped table-hover data-table',
        )); ?>
    </div>
</div>