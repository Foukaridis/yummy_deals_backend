<?php

/**
 * This is the model class for table "order_total".
 *
 * The followings are the available columns in table 'order_group':
 * @property integer $id
 * @property double $total
 * @property double $tax
 * @property double $shipping
 * @property double $grandTotal
 * @property string $dateCreated
 * @property string $orderId
 *
 */
class OrderTotal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_total';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('orderId', 'length', 'max' => 255),
            array('total, tax, shipping, grandTotal', 'numerical'),
			array('dateCreated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, total, dateCreated, tax, shipping, grandTotal', 'safe', 'on'=>'search'),
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
			'total' => 'Total',
            'orderId' => 'Order',
            'dateCreated' => 'Date Created',
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
        $criteria->compare('orderId',$this->orderId);
        $criteria->compare('total',$this->total);
		$criteria->compare('dateCreated',$this->dateCreated,true);
        $criteria->compare('tax',$this->tax,true);
        $criteria->compare('shipping',$this->shipping,true);
        $criteria->compare('grandTotal',$this->grandTotal,true);
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getOrderTotal($order_id)
	{
		$criteria=new CDbCriteria();
		$criteria->condition = 'orderId ='.$order_id;
		$result = $this->find($criteria);
		if(isset($result))
		return $result->grandTotal;
		else
			return "0";

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderTotal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
