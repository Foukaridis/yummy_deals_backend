<?php
/* @var $this CommentController */
/* @var $model Comment */
?>

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-6">
				<h4 class="title">Comment detail  #<?php echo $model->id?></h4>
			</div>
			<div class="col-xs-6 text-right">
				<a class="btn btn-danger inline" href="<?php echo Yii::app()->createUrl('comment/searchByShop',array('id'=>$model->location_id)); ?>"><?php echo Yii::t('common', 'btn.cancel'); ?></a>
			</div>
		</div>
		<hr class="line"/>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered table-striped">
			<tr>
				<th class="col-xs-3"><?php echo Yii::t('comment', 'label.id');?></th>
				<td><?php echo $model->id; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.food');?></th>
				<td><?php echo Food::model()->getFoodName($model->food_id). ' | ID: '.$model->food_id ; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.account');?></th>
				<td><?php
					$customer = Account::model()->findByPk($model->account_id);
					echo  isset($customer)? $customer->full_name.' | Username: '. $customer->username : ''; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.title');?></th>
				<td><?php echo $model->title; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.content');?></th>
				<td><?php echo $model->content; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.rate');?></th>
				<td><?php echo $model->rate; ?></td>
			</tr>
			<tr>
				<th><?php echo Yii::t('comment', 'label.created');?></th>
				<td><?php echo $model->created; ?></td>
			</tr>
		</table>
	</div>
</div>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>