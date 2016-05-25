<div class="row">

    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-3">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('finance', 'title.balance') ?></h4>
            </div>
<!--            <div class="col-xs-9 text-right">-->
<!--                <font style="font-size: 18pt; padding-right: 30px; text-shadow: 0 0 6px green, 0 0 5px green, 0 0 5px purple; color: white">Welcome --><?php //echo Account::model()->findByPk(yii::app()->user->id)->full_name; ?><!--</font>-->
<!--                --><?php //echo CHtml::link(Yii::t('finance', 'label.withdraw.money'), '#myModal', array(
//                    'class ' => 'btn inline btn-success',
//                    'data-toggle' => 'modal',
//                ))
//                ?>
<!--                <a class="btn btn-success inline"-->
<!--                   href="--><?php //echo Yii::app()->createUrl('finance/withdrawHistory'); ?><!--">--><?php //echo Yii::t('finance', 'title.admin.withdraw.history'); ?><!--</a>-->
<!--                <a class="btn btn-danger inline"-->
<!--                   href="--><?php //echo Yii::app()->createUrl('shop/index'); ?><!--">--><?php //echo Yii::t('common', 'btn.cancel'); ?><!--</a>-->
<!--            </div>-->
        </div>
        <hr class="line"/>
        <div class="row">
            <div class="col-xs-8">
                <h4>You have credit: <span
                        style="font-size: 14pt; color :#7dc374"><?php echo Constants::GLOBALS_CURRENCY . $bill['budget'] ?></span>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-4">
                <h4 class="title" style="margin-top: 20px"><?php
                    echo Yii::t('finance', 'title.finance') ?></h4>
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
            'rowCssClassExpression' => '($data->status==0) ? "background-row-gray" : "background-row-white"',
            'columns' => array(
                array(
                    'header' => Yii::t("finance", "label.shopId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return Shop::model()->findByPk($data->shopId)->location_name;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t("finance", "label.budget"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->budget;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),
                array(
                    'header' => Yii::t("banner", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $str = "";
                        $status = $data->status;
                        switch ($status) {
                            case 0:
                                $str = '<span style="color:red"> Inactive' . '</span>';
                                break;
                            case 1:
                                $str = '<span style="color:green"> Active' . '</span>';
                                break;
                        }
                        return $str;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),

                array(
                    'header' => Yii::t("finance", "label.updateTime"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->updateTime;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),

            ),
            'itemsCssClass' => 'table table-hover',
        )); ?>
    </div>
</div>

<!--modal-->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog myModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    Enter amount
                </h4>
            </div>

            <div class="modal-body">
                <input type="text" id="withdraw-amount" value="" class="form-control">

                <div id="modal-message" style="padding-top: 30px"></div>
            </div>
            <div class="modal-footer myModal-footer">
                <a class="btn inline btn-success" id="button-submit-modal" href="javascript:sendWithdrawRequest()">Submit</a>
                <button data-dismiss="modal" aria-hidden="true" class="btn blue" type="button"><i
                        class=" icon-caret-left"></i> <?php echo Yii::t('common', 'label.close') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    function sendWithdrawRequest() {
        var amount = $('#withdraw-amount').val();
        $.ajax({
            url: '<?php echo $this->createUrl('/finance/withdraw')?>',
            type: 'POST',
            data: {amount: amount},
            success: function (data) {
                if (data == 0) {
                    alert('You cannot withdraw over your balance');
                    $("#withdraw-amount").val(0);
                }
                else if (data == 1) {
                    alert('Your request has been sent');
                    $("#withdraw-amount").val(0);
                }

                else if (data == 2) {
                    alert('Please input a valid number');
                    $("#withdraw-amount").val(0);
                }

            }
        });
    }
</script>