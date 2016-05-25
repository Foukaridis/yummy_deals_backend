<?php

/**
 * This is the model class for table "financehistory".
 *
 * The followings are the available columns in table 'finance':
 * @property integer $id
 * @property double $amount
 * @property string $ownerId
 * @property string $createdTime
 * @property string $approvedTime
 * @property integer $status
 */
class FinanceHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'financehistory';
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
			array('amount', 'numerical'),
			array('ownerId', 'length', 'max'=>20),
			array('createdTime, approvedTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, approvedTime, createdTime, status', 'safe', 'on'=>'search'),
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
			'amount' => 'Amount',
			'approvedTime' => 'Approved Time',
			'createdTime' => 'Created Time',
			'status' => 'Status',
			'ownerId' => 'Owner',
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
		$criteria->compare('approvedTime',$this->approvedTime,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('createdTime',$this->createdTime,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('ownerId',$this->ownerId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchByOwner($ownerId)
    {
        $criteria = new CDbCriteria;
        if ($ownerId != 0)
			$criteria->compare('ownerId', $ownerId);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'approvedTime DESC',
            ),
        ));
    }


	public function searchByOwnerAndStatus($ownerId, $status)
	{
		$criteria = new CDbCriteria;
		if ($ownerId != 0)
			$criteria->compare('ownerId', $ownerId);
		if ($status != 5)
			$criteria->compare('status', $status);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'approvedTime DESC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FinanceHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
