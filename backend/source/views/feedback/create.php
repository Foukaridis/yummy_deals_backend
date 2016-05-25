<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <h4 class="title"><?php echo Yii::t('feedback', 'title.createFeedback'); ?></h4>
            </div>
            <div class="col-xs-6 text-right">
                <?php if ($_REQUEST['type'] == 1) { ?> <!--Feedback-->
                    <a class="btn btn-danger inline"
                       href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => 'feedback')) ?>"
                       style="margin-left: 5px">Back</a>
                <?php } else if ($_REQUEST['type'] == 2) { ?> <!--Report-->
                    <a class="btn btn-danger inline"
                       href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => 'report')) ?>"
                       style="margin-left: 5px">Back</a>
                <?php } else { ?> <!--GET FEATURED-->
                    <a class="btn btn-danger inline"
                       href="<?php echo Yii::app()->createUrl('feedback/index', array('type' => '')) ?>"
                       style="margin-left: 5px">Back</a>
                <?php } ?>
            </div>
        </div>
        <hr class="line"/>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>