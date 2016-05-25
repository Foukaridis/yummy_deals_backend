<?php

/**
 * This is the model class for table "open_hour_detail".
 *
 * The followings are the available columns in table 'open_hour_detail':
 * @property integer $id
 * @property integer $shopId
 * @property integer $dateId
 * @property string $openAM
 * @property string $closeAM
 * @property string $openPM
 * @property string $closePM
 *
 * The followings are the available model relations:
 * @property Shop $shop
 */
class OpenHourDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'open_hour_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shopId, dateId', 'required'),
			array('shopId, dateId', 'numerical', 'integerOnly'=>true),
			array('openAM, closeAM, openPM, closePM', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, shopId, dateId, openAM, closeAM, openPM, closePM', 'safe', 'on'=>'search'),
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
			'shop' => array(self::BELONGS_TO, 'Shop', 'shopId'),
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
			'dateId' => 'Date',
			'openAM' => 'Open AM',
			'closeAM' => 'Close AM',
			'openPM' => 'Open PM',
			'closePM' => 'Close PM',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('shopId',$this->shopId);
		$criteria->compare('dateId',$this->dateId);
		$criteria->compare('openAM',$this->openAM,true);
		$criteria->compare('closeAM',$this->closeAM,true);
		$criteria->compare('openPM',$this->openPM,true);
		$criteria->compare('closePM',$this->closePM,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function searchByShop($shopId)
    {

        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getByShop($shopId)
    {

        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);

        return $this->findAll($criteria);
    }



    public function getOpenHourByShopAndDate($shopId,$date)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);
        $criteria->compare('dateId',$date);

        return $this->find($criteria);
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OpenHourDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
