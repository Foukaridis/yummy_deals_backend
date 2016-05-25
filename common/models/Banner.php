<?php

/**
 * This is the model class for table "banner".
 *
 * The followings are the available columns in table 'banner':
 * @property integer $bannerId
 * @property string $bannerName
 * @property string $bannerImage
 * @property integer $shopId
 * @property integer $status
 */
class Banner extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bannerName, bannerImage, shopId', 'required'),
			array('shopId, status', 'numerical', 'integerOnly'=>true),
			array('bannerName, bannerImage', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bannerId, bannerName, bannerImage, shopId, status', 'safe', 'on'=>'search'),
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
			'bannerId' => 'Banner',
			'bannerName' => 'Banner Name',
			'bannerImage' => 'Banner Image',
			'shopId' => 'Shop',
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

		$criteria->compare('bannerId',$this->bannerId);
		$criteria->compare('bannerName',$this->bannerName,true);
		$criteria->compare('bannerImage',$this->bannerImage,true);
		$criteria->compare('shopId',$this->shopId);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'bannerName',
            ),
		));
	}

    public function searchByShop($shopId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'bannerName',
            ),
        ));
    }
    public function searchByShopAndStatus($shopId, $status)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shopId', $shopId);
        if ($status != 2)
            $criteria->compare('status', $status);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getBannersActiveByShop($shopId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);
        $criteria->compare('status',1);

        return $this->findAll($criteria);
    }
    public function findAllByShop($shopId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('shopId',$shopId);

        return $this->findAll($criteria);
    }

    public function countBannerNumber($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shopId', $shopId);
        return $this->count($criteria);
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
