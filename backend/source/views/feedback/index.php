<div class="row">
    <div class="col-xs-12">
        <?php $this->renderPartial('_searchform', array('modelSearchForm' => $searchModel)); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'feedback-grid',
            'dataProvider' => $data->search(),
            'columns' => array(
                array(
                    'header' => Yii::t("feedback", "label.userId"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->account_id;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),

                array(
                    'header' => Yii::t("feedback", "label.userName"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $name = Account::model()->findbyPk($data->account_id);
                        return $name->username;

                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),

                array(
                    'header' => Yii::t("feedback", "label.email"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $name = Account::model()->findbyPk($data->account_id);
                        return $name->email;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),
                ),

                array(
                    'header' => Yii::t("feedback", "label.tittle"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->tittle;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),

                ),
                array(
                    'header' => Yii::t("feedback", "label.description"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->description;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '20%',
                    ),

                ),

                array(
                    'header' => Yii::t("feedback", "label.status"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        $str = "";
                        $status = $data->status;
                        switch ($status) {
                            case 0:
                                $str = '<span style="color:red"> New' . '</span>';
                                break;
                            case 1:
                                $str = '<span style="color:green"> Processing' . '</span>';
                                break;
                            case 2:
                                $str = '<span style="color:blue"> Closed' . '</span>';
                                break;
                        }
                        return $str;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '10%',
                    ),
                ),

                array(
                    'header' => Yii::t("feedback", "label.create"),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->created;
                    },
                    'headerHtmlOptions' => array(
                        'width' => '15%',
                    ),

                ),
                array(
                    'header' => Yii::t('feedback', 'label.update'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('feedback', 'label.update') . '" href="' . Yii::app()->createUrl('feedback/update', array('id' => $data->id, 'type' => $data->type)) . '" class="glyphicon glyphicon-edit"></a>';
                    },
                    'headerHtmlOptions' => array(
                        'width' => '5%',
                    ),
                ),
                array(
                    'header' => Yii::t('food', 'label.delete'),
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a data-toggle="tooltip" data-placement="top" data-original-title="' . Yii::t('feedback', 'label.delete') . '" href="' . Yii::app()->createUrl('feedback/delete', array('id' => $data->id, 'type' => $data->type)) . '" onclick="return confirm(\'' . Yii::t('feedback', 'msg.confirmDelete') . '\');" class="glyphicon glyphicon-trash"></a>';
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
