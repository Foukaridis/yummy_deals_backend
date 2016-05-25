<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'searchComment-form',
        'action'=>Yii::app()->createUrl('comment/searchByShop',array('id'=>$id)),
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
            <div class="col-md-4">
                <?php echo $form->hiddenField($comment, 'food_id');
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name' => 'foodName',
//                     METHOD 1: JavaScript + No Params ==========================================
/*
                    'sourceUrl' => array('auto/completeFood'),
                    'value' =>($comment->food_name) ? $comment->food_name: $comment->food_name,
                    'options' => array(
                        'showAnim' => 'fold',
                        'select' => 'js:function(event, response)
                        {
                            jQuery("#Comment_food_id").val(response.item["id"]);
                        }'
                    ),
*/

//                    METHOD 2: Ajax + Params =========START====================================
                    'value' =>($comment->food_name) ? $comment->food_name: $comment->food_name,
                    'source'=>'js: function(request, response) {
                       $.ajax({
                           url: "'.$this->createUrl('auto/completeFood').'",
                           type: "POST",
                           dataType: "json",
                           data: {
                               term: request.term,
                               location_id: '.$id.'
                           },
                           success: function (data) {
                            response(data);
                           }
                       })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'select' => 'js:function(event, response)
                        {
                            jQuery("#Comment_food_id").val(response.item["id"]);
                        }'
                    ),

 //                 ===================================END========================================
                    'htmlOptions' => array(
                        'type' => 'text',
                        'class' => 'form-control',
                        'placeholder' => 'Food Name',
                    ),
                ));
                ?>

            </div>



            <div class="col-md-2">
                <?php echo CHtml::button(Yii::t('common','btn.search'), array(
                    'type' => 'submit',
                    'class ' => 'btn btn-success',
                )); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>