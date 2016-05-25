<?php

/**
 * This is the model class for table "finance".
 *
 * The followings are the available columns in table 'finance':
 * @property integer $id
 * @property string $shopId
 * @property double $budget
 * @property string $updateTime
 * @property integer $status
 */
class Finance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'finance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('budget', 'numerical'),
			array('shopId', 'length', 'max'=>255),
			array('updateTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, shopId, budget, updateTime, status', 'safe', 'on'=>'search'),
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
			'budget' => 'Budget',
			'updateTime' => 'Update Time',
			'status' => 'Status',
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
		$criteria->compare('shopId',$this->shopId,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('updateTime',$this->updateTime,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchByShopAndStatus($shopId, $status)
    {
        $criteria = new CDbCriteria;
        if ($shopId != 0)
            $criteria->compare('shopId', $shopId);
        if ($status != 5)
            $criteria->compare('status', $status);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'updateTime',
            ),
        ));
    }

	public function searchByOwner($accountId)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('shopId IN('.$accountId.')');

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'updateTime',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Finance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
