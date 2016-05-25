<?php

/**
 * This is the model class for table "order_food".
 *
 * The followings are the available columns in table 'order_food':
 * @property integer $id
 * @property integer $order_id
 * @property integer $food_id
 * @property integer $number
 * @property double $price
 */
class OrderFood extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_food';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, food_id, number, price', 'required'),
			array('order_id, food_id, number', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, food_id, number, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'food_id' => 'Food',
			'number' => 'Number',
			'price' => 'Price',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('food_id',$this->food_id);
		$criteria->compare('number',$this->number);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getOrderTotal($order_id)
    {
        $command=Yii::app()->db->createCommand();
        $command->select('SUM(number * price) AS total');
        $command->from($this->tableName());
        $command->where('order_id=:id', array(':id'=>$order_id));
        return $command->queryScalar();
    }

    public function getOrderFoodByOrder($order_id)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('order_id',$order_id);

        return $this->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderFood the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
