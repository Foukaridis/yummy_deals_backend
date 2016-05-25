<?php
/* @var $this CommentController */
/* @var $comment Comment */
?>

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-2">
				<h4 class="title" style="margin-top: 20px"><?php echo Yii::t('comment', 'title.comment'); ?></h4>
			</div>
			<div class="col-xs-8">
				<?php $this->renderPartial('_searchform', array('comment' => $model, 'id'=>$shop->location_id)); ?>
			</div>
			<div class="col-xs-2 text-right" style="margin-top: 20px">
				<a class="btn btn-danger inline"
				   href="<?php echo Yii::app()->createUrl('shop/update', array('id' => $shop->location_id)); ?>">
					<?php
					echo Yii::t('common', 'Back to ' . $shop->location_name); ?></a>
			</div>
		</div>
		<hr class="line"/>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id' => 'comment-grid',
			'dataProvider' => $comment->search(),
			'columns' => array(
				'id',
//				'location_id',
				array(
					'header' => Yii::t("comment", "label.food"),
					'type' => 'raw',
					'value' => function ($data) {
						return Food::model()->getFoodName($data->food_id);
					},
					'headerHtmlOptions' => array(
						'width' => '20%',
					),

				),
				array(
					'header' => Yii::t("comment", "label.account"),
					'type' => 'raw',
					'value' => function ($data) {
						return Account::model()->getName($data->account_id);
					},
					'headerHtmlOptions' => array(
						'width' => '20%',
					),

				),
				array(
					'header' => Yii::t("comment", "label.title"),
					'type' => 'raw',
					'value' => function ($data) {
						return $data->title;
					},
					'headerHtmlOptions' => array(
						'width' => '25%',
					),

				),
				//'content',
				'rate',
				'created',
				array(
					'header' => Yii::t('food', 'label.view'),
					'type' => 'raw',
					'value' => function ($data) {
						return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.Yii::t('common', 'label.view').'" href="'.Yii::app()->createUrl('comment/view', array('id'=>$data->id)).'" class="glyphicon glyphicon-search"></a>';
					},
					'headerHtmlOptions' => array(
						'width' => '5%',
					),
				),
				array(
					'header' => Yii::t('common', 'label.delete'),
					'type' => 'raw',
					'value' => function ($data) {
						return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('common', 'label.delete') . '" href="' . Yii::app()->createUrl('comment/delete', array('id' => $data->id)) . '" onclick="return confirm(\'' . Yii::t('comment', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
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