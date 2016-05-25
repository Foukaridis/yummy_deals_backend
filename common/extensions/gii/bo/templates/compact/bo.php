<?php
/**
 * Created by L'orge.
 * User: Only Love
 * Date: 11/27/13 - 5:52 PM
 */
?>
<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
 * This is the form model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
 */
class <?php echo $formClass; ?>Form extends FormModel{
<?php foreach($columns as $column): ?>
    public <?php echo '$'.$column->name.";\n"; ?>
<?php endforeach; ?>

    /**
    * @return array validation rules for model attributes.
    */
    public function rules(){
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        <?php foreach($rules as $rule): ?>
            <?php echo $rule.",\n"; ?>
        <?php endforeach; ?>
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels(){
    return array(
    <?php foreach($labels as $name=>$label): ?>
        <?php echo "'$name' => Yii::t('".lcfirst($formClass)."', 'label.$name'),\n"; ?>
    <?php endforeach; ?>
    );
    }

    /**
    * Create instance form $id of model
    */
    public function loadModel($id){
        /** @var <?php echo $modelClass; ?> $model */
        $model = <?php echo $modelClass; ?>::model()->findByPk($id);
        if($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

    <?php foreach($columns as $key=>$column): ?>
        $this-><?php echo $column->name; ?> = $model-><?php echo $key.";\n"; ?>
    <?php endforeach; ?>
    }

    /**
    * Save to database
    */
    public function save(){
        $model = new <?php echo $modelClass; ?>;
    <?php $first=true; ?>
    <?php foreach($columns as $key=>$column): ?>
        <?php if($first){$first = false; ?>
    $this-><?php echo $column->name; ?> = $model-><?php echo $key; ?> = DateTimeUtils::nowStr();
        <?php }else{ ?>
    $model-><?php echo $key; ?> = $this-><?php echo $column->name.";\n"; ?>
        <?php } ?>
    <?php endforeach; ?>
        $result = $model->save();
        if(!$result)
            return self::ERROR_DB;
        return self::ERROR_NONE;
    }

    /**
    * Save to database
    */
    public function update($id){
        /** @var <?php echo $modelClass; ?> $model */
        $model = <?php echo $modelClass; ?>::model()->findByPk($id);
        if($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

    <?php $first=true; ?>
    <?php foreach($columns as $key=>$column): ?>
        <?php if($first){$first = false;}else{ ?>
        $model-><?php echo $key; ?> = $this-><?php echo $column->name.";\n"; ?>
        <?php } ?>
    <?php endforeach; ?>
        $result = $model->save();
        if(!$result)
            return self::ERROR_DB;
        return self::ERROR_NONE;
    }
}