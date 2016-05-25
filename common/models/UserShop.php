<?php

/**
 * This is the model class for table "user_shop".
 *
 * The followings are the available columns in table 'user_shop':
 * @property integer $id
 * @property integer $shopId
 * @property string $accountId
 * @property integer $order_count
 */
class UserShop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_shop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shopId, accountId', 'required'),
			array('shopId, order_count', 'numerical', 'integerOnly'=>true),
			array('accountId', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, shopId, accountId, order_count', 'safe', 'on'=>'search'),
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
			'shopId' => 'Shop',
			'accountId' => 'Account',
			'order_count' => 'Order Count',
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
		$criteria->compare('shopId',$this->shopId);
		$criteria->compare('accountId',$this->accountId,true);
		$criteria->compare('order_count',$this->order_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchByShop($shopId)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function searchByAccountId($shopId,$accountId)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('shopId',$shopId);
        $criteria->compare('accountId',$accountId,true);

        return $this->find($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserShop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
