<?php

/**
 * This is the model class for table "food_promotion".
 *
 * The followings are the available columns in table 'food_promotion':
 * @property integer $id
 * @property integer $promotion_id
 * @property integer $food_id
 */
class FoodPromotion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'food_promotion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('promotion_id, food_id', 'required'),
			array('promotion_id, food_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, promotion_id, food_id', 'safe', 'on'=>'search'),
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
            'promotionR'=>array(self::BELONGS_TO,'Promotion','promotion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'promotion_id' => 'Promotion',
			'food_id' => 'Food',
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
		$criteria->compare('promotion_id',$this->promotion_id);
		$criteria->compare('food_id',$this->food_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function checkExistFoodInPromotion($promotionId,$foodId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('promotion_id',$promotionId);
        $criteria->compare('food_id',$foodId);

        return $this->count($criteria)>0;
    }

    public function findFoodPromotion($promotionId,$foodId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('promotion_id',$promotionId);
        $criteria->compare('food_id',$foodId);

        return $this->find($criteria);
    }

    public function findAllFoodPromotionByPromotion($promotionId)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('promotion_id',$promotionId);

        return $this->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FoodPromotion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
