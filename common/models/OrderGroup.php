<?php

/**
 * This is the model class for table "order_group".
 *
 * The followings are the available columns in table 'order_group':
 * @property string $group_code
 * @property double $total
 * @property string $dateCreated
 * @property string $account_id
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class OrderGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total', 'numerical'),
			array('group_code, account_id', 'length', 'max'=>255),
			array('dateCreated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_code, total, dateCreated', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Orders', 'group_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_code' => 'Group Code',
			'total' => 'Total',
			'dateCreated' => 'Date Created',
            'account_id'=> 'Account'
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

		$criteria->compare('group_code',$this->group_code,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('dateCreated',$this->dateCreated,true);
        $criteria->compare('account_id',$this->account_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function updateGroup($groupId)
	{
		$group = OrderGroup::model()->findByPk($groupId);
		$orders = $group->orders;

		if(count($orders)!=0)
		{
			$total = 0;
			foreach($orders as $order)
			{
				$total += $order->total->grandTotal;
			}
			$group->total = $total;
			$group->save();
		}
		else
			OrderGroup::model()->deleteByPk($groupId);

	}

}
