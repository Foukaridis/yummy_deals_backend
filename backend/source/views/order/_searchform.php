<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'createSearch-form',
        'action'=>Yii::app()->createUrl('order/searchByShop',array('id'=>$shop->location_id)),
        'method' => 'POST',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'panel-body',
            'enctype' => 'multipart/form-data',
            'role' => 'form',
        ),
    )); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->dropDownList($modelSearchForm,'status',
                    array(Constants::ORDER_NEW => 'New', Constants::ORDER_IN_PROCESS => 'Received',Constants::ORDER_CANCEL=>'Cancel',Constants::ORDER_READY => 'Ready', Constants::ORDER_ON_THE_WAY => 'On the way', Constants::ORDER_ON_THE_WAY => 'On the way', Constants::ORDER_DELIVERED => 'Delivered', Constants::ORDER_FAIL_DELIVERY => 'Fail delivery'),
                    array(
                    'class' => 'form-control','prompt'=>'Select',
                    'onchange'=>"$('#createSearch-form').submit();",
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>