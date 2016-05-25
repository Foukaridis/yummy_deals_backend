<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$total = isset($total) ? $total : 0;
if(isset($model->orderId))
{
    $order_total = OrderTotal::model()->find('orderId ='.$model->orderId);
    $tax = isset($order_total) ? $order_total->tax : 0;
    $shipping = isset($order_total) ? $order_total->shipping : 0;
    $grandTotal = isset($order_total) ? $order_total->grandTotal : 0;
}
else
{
    $tax =  0;
    $shipping =  0;
    $grandTotal =  0;
}


$shop = Shop::model()->findByPk($shopId);
$tax_data=  CJSON::decode($shop->tax);
$shipping_data=  CJSON::decode($shop->shipping);
$tax_rate =  $tax_data['tax_status'] == 1 ?  $tax_data[Constants::TAX_NAME]: 0;
?>

<div class="space"></div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'createNews-form',
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

    <?php if (Yii::app()->user->hasFlash('_error_')): ?>
        <div class="form-group">
            <?php echo $form->errorSummary($model, '') ?>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <label class="control-label">Customer</label><br/>
                <?php echo CHtml::link(Yii::t('common', 'label.select'), '#myModalCustomer', array(
                    'class ' => 'btn btn-success',
                    'data-toggle' => 'modal',
                ))
                ?>
                <span id="show_select_customer">

                </span>
            </div>

        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-2">
                <label class="control-label">Date</label><br/>
                <?php echo $form->textField($model, 'orderTime', array('class' => 'datepicker1 form-control', 'readOnly' => TRUE)); ?>
            </div>
            <div class="col-md-2">
                <label class="control-label">Time</label><br/>
                <?php echo $form->textField($model, 'order_time', array('id' => 'order_time', 'type' => 'text', 'class' => 'form-control', 'readonly' => 'TRUE')); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->label($model, Yii::t('banner', 'label.status'), array('class' => 'control-label')); ?>
                <?php echo $form->dropDownList($model, 'status',
                    array(Constants::ORDER_NEW => 'New', Constants::ORDER_IN_PROCESS => 'Received',Constants::ORDER_CANCEL=>'Cancel',Constants::ORDER_READY => 'Ready', Constants::ORDER_ON_THE_WAY => 'On the way', Constants::ORDER_ON_THE_WAY => 'On the way', Constants::ORDER_DELIVERED => 'Delivered', Constants::ORDER_FAIL_DELIVERY => 'Fail delivery'),
                    array(
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-8">
                <?php echo $form->label($model, Yii::t('order', 'label.orderPlace') . '<span style="color: #ff0000"> *</span>', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model, 'orderPlace', array(
                    'type' => 'text',
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'orderPlace'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-8">
                <?php echo $form->label($model, Yii::t('order', 'label.requirement'), array('class' => 'control-label')); ?>
                <?php echo $form->textArea($model, 'orderRequirement', array(
                    'type' => 'text',
                    'class' => 'form-control',
                )); ?>
                <?php echo $form->error($model, 'orderRequirement'); ?>
            </div>
        </div>
        <div class="space"></div>
        <div class="row">
            <div class="col-md-8">
                <label class="control-label"><?php echo Yii::t('order', 'title.foodItem') ?></label><br/>
                <?php //echo $form->label($model, Yii::t('order', 'title.foodItem'), array('class' => 'control-label')); ?>
                <?php echo CHtml::link(Yii::t('common', 'label.select'), '#myModal', array(
                    'class ' => 'btn btn-success',
                    'data-toggle' => 'modal',
                    'onclick' => 'showAllFood()',
                ))
                ?>
                <?php /*echo CHtml::button(Yii::t('common','label.select'), array(
                    'type' => 'button',
                    'class ' => 'btn btn-success',
                )); */
                ?>
            </div>
        </div>

        <?php echo $form->hiddenField($model, 'grand_total', array('id'=>'grand_total')); ?>
        <?php echo $form->hiddenField($model, 'shipping'); ?>
        <?php echo $form->hiddenField($model, 'tax'); ?>
        <?php echo $form->hiddenField($model, 'grandTotal'); ?>


        <div class="space"></div>
        <div class="row">
            <div class="col-md-8">
                <table id="table_<?php /*echo $unique */ ?>" class="table  data-table" style="width: 100%">
                    <thead>
                    <tr>
                        <th style="" class="">Food</th>
                        <th class="text-left">Number</th>
                        <th style="">Price</th>
                        <th style="">Promotion(%)</th>
                        <th style="">Total</th>
                        <!--                        <th style="width: 60px">Last-Total</th>-->
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="show_select_into">

                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-1">SubTotal:
                    </div>
                    <div class="col-md-4" id="show_total"><?php echo $total ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">Shipping:
                    </div>
                    <div class="col-md-4" id="show_shipping"><?php echo $shipping ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">Tax:
                    </div>
                    <div class="col-md-4" id="show_tax"><?php echo $tax ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">Grand Total:
                    </div>
                    <div class="col-md-4" id="show_grandTotal"><?php echo $grandTotal ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="space"></div>

    </div>


    <div class="space"></div>
    <?php if($model->status!=Constants::ORDER_DELIVERED){?>
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-2">
                <?php echo $form->checkBox($model, 'isSendToCustomer', array('value' => 1, 'uncheckValue' => 0)); ?>
                <?php echo $form->label($model, 'Send to customer ', array('class' => 'control-label')); ?>
            </div>
        </div>
        <?php echo CHtml::button(Yii::t('common', $model->orderId != null ? 'btn.update' : 'btn.create'), array(
            'type' => 'submit',
            'class ' => 'btn btn-success',
        )); ?>
    </div>
    <?php }?>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>


<div class="modal" id="myModalCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog myModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    Customer
                </h4>
            </div>
            <div class="modal-body">
                <div id="showError"></div>

                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'widget-customer-grid',
                    'dataProvider' => $customer,
                    'ajaxUpdate' => 'true',
                    //'emptyText' => Yii::t('requests', 'label.noResult'),
                    'pager' => array(
                        'header' => '',
                    ),
                    'columns' => array(

                        array(
                            'header' => 'Id',
                            'name' => 'id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::radioButton('selectCustomer', '', array('value' => $data->id, 'onclick' => "selectCustomerWidget('$data->id')"));
                            }),
                        array(
                            'header' => 'Name',
                            'name' => 'full_name',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->full_name;
                            }
                        ),
                        'phone',
                        'email'
                    ),
                    'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable',
                )); ?>

            </div>
            <div class="modal-footer myModal-footer">
                <button data-dismiss="modal" aria-hidden="true" class="btn blue" type="button"><i
                        class=" icon-caret-left"></i> <?php echo Yii::t('common', 'label.close') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog myModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo Yii::t('order', 'title.food'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div id="showError"></div>
                <?php
                $foodList = array();
                if (is_array($model->foodList) && count($model->foodList) > 0) {
                    foreach ($model->foodList as $item) {
                        if (isset($item['id']) && $item['id'] != 0)
                            $foodList[] = $item['id'];
                    }
                }
                ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'widget-clients-grid',
                    'dataProvider' => $food->search($foodList),
                    'ajaxUpdate' => 'true',
                    //'emptyText' => Yii::t('requests', 'label.noResult'),
                    'pager' => array(
                        'header' => '',
                    ),
                    'columns' => array(

                        array(
                            'header' => 'Id',
                            'name' => 'food_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::checkBox('selectFood', '', array('id' => 'check_food_' . $data->food_id, 'value' => $data->food_id, 'onclick' => "selectFoodWidget('$data->food_id',this)"));
                            }),
                        array(
                            'header' => 'Name',
                            'name' => 'food_name',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->food_name;
                            }
                        ),
                    ),
                    'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable',
                )); ?>

            </div>
            <div class="modal-footer myModal-footer">
                <button data-dismiss="modal" aria-hidden="true" class="btn blue" type="button"><i
                        class=" icon-caret-left"></i> <?php echo Yii::t('common', 'label.close') ?></button>
            </div>
        </div>
    </div>
</div>


<script>
    function showAllFood() {
        $('#widget-clients-grid').yiiGridView('update', {
            data: $('#createNews-form').serialize()
        });
    }

    function removeCustomer() {
        $('#show_select_customer').html('');
    }

    function selectCustomerWidget(id) {
        params = {
            id: id
        };
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/order/selectCustomerInto')?>',
            type: 'POST',
            data: $.param(params),
            //dataType: 'json',
            success: function (data) {
                $('#show_select_customer').html(data);
            }
        });
    }

    /*food place*/
    function getTotal() {
        total = 0;
        $('.food_item_total').each(function () {
            total = total + parseFloat($(this).val());
        });
        tax_rate = <?php echo $tax_rate ?>;
        tax_total = total*tax_rate/100;
        total_included_tax = total + tax_total;

        <?php
        if($shipping_data['shipping_status'] == 1)
        {
            $minimum =  $shipping_data['minimum'];
            $flat_rate = $shipping_data[Constants::FLAT_RATE];
        ?>
            minimum = <?php echo $minimum ?>;
            if(total_included_tax >= minimum && minimum !=0 )
                shipping_fee = 0;
            else
            {
                flat_rate = <?php echo $flat_rate?>;
                shipping_fee = flat_rate;
            }
        <?php } else { ?>
            shipping_fee =0;
        <?php } ?>
        shipping_tax = shipping_fee*tax_rate/100;
        tax_total = tax_total + shipping_tax;

        order_grand_total= total + tax_total + shipping_fee;

        $('#show_total').html(total);
        $('#grand_total').val(total);
        $('#show_tax').html(tax_total);
        $('#OrderForm_tax').val(tax_total);
        $('#show_shipping').html(shipping_fee);
        $('#OrderForm_shipping').val(shipping_fee);
        $('#show_grandTotal').html(order_grand_total);
        $('#OrderForm_grandTotal').val(order_grand_total);
    }

    function changeNumberFood(id) {
        //check data later
        price = $('#food_price_' + id).val();
        number = $('#food_number_' + id).val();
        total = price * number;

        $('#food_total_' + id).val(total);
        getTotal();
    }
    function removeFood(id) {
        $('#food_' + id).remove();
        $('#check_food_' + id).attr('checked', false);
        getTotal();
    }

    function selectFoodWidget(id, A) {
        value = 0;
        if ($(A).is(':checked'))
            value = 1;
        if (value == 1) {
            selectFood(id, 1, 0);
        } else {
            $('#food_' + id).remove();
            getTotal();
        }

    }

    function selectFood(id, number, price) {
        params = {
            id: id,
            number: number,
            price: price,
            date: $('#OrderForm_orderTime').val()
        };
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/order/selectFoodInto')?>',
            type: 'POST',
            data: $.param(params),
            //dataType: 'json',
            success: function (data) {
                c = 0;
                $('#show_select_into tr').each(function () {
                    if ($(this).attr('id') == 'food_' + id) {
                        c = 1;
                    }
                });
                if (c == 0)
                    $('#show_select_into').append(data);
                getTotal();
            }
        });
    }
    <?php if($model->foodList){
    $script = '';
     foreach($model->foodList as $item){
    $script .= "selectFood(".$item['id'].",'".$item['number']."',".$item['price']."); ";
    };
    Yii::app()->getClientScript()->registerScript('foodList', $script,CClientScript::POS_END);
    }


            $dateTimePickerScript = "
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

            $('.datepicker1').datepicker({
                format: 'yyyy-mm-dd',
                onRender: function(date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                },
            });

            $('#order_time').timepicker({
                todayHighlight: true,
                showMeridian: false,
            });

";
            Yii::app()->getClientScript()->registerScript('dateTimePickerScript', $dateTimePickerScript);
    if($model->orderAccount){
        $account = "
            selectCustomerWidget('".$model->orderAccount."');
        ";
        Yii::app()->getClientScript()->registerScript('orderAccount', $account);
    }
    ?>
</script>
