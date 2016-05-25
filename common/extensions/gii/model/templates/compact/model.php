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
 * Created by L'orge - lorge.info
 * User: Only Love
 * Date: <?php echo date("Y/m/d - H:i A", time()); ?>
 *
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 *
 *
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass; ?> {
	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return '<?php echo $tableName; ?>';
	}

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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
<?php foreach($labels as $name=>$label): ?>
    <?php
        $as = explode ('_', $name);
        $l = '';
        foreach($as as $i => $item){
            if($i == 0)
                $l .= $item;
            else
                $l .= ucfirst($item);
        }
        $l =  "Yii::t('$tableName', 'label.$l')";
    ?>
        <?php echo "'$name' => $l,\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search(){
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

<?php
foreach($columns as $name=>$column)
{
	if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
	}
}
?>

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

<?php if($connectionId!='db'):?>
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection(){
		return Yii::app()-><?php echo $connectionId ?>;
	}

<?php endif?>
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return <?php echo $modelClass; ?> the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}



    /**
     * @param <?php echo $modelClass; ?> $model the model <?php echo $tableName; ?> is criteria
     * @return CDbCriteria the criteria of <?php echo $modelClass; ?> class
     */
    protected function createCriteria($model){
        if($model == null) $model = new <?php echo $modelClass; ?>;

        $criteria = new CDbCriteria;
<?php foreach($columns as $name=>$column):
        if($column->type==='string')
        {
?>
        if(!empty($model-><?php echo $name ;?>)){
            $criteria->addCondition("<?php echo $name ;?> = '$model-><?php echo $name ;?>'");
        }
<?php   } else { ?>
        if($model-><?php echo $name ;?> != null){
            $criteria->addCondition("<?php echo $name ;?> = $model-><?php echo $name ;?>");
        }
<?php   } ?>
<?php endforeach; ?>

        return $criteria;
    }
}
