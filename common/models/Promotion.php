<?php

/**
 * This is the model class for table "promotion".
 *
 * The followings are the available columns in table 'promotion':
 * @property integer $promotion_id
 * @property string $promotion_code
 * @property string $promotion_name
 * @property integer $shop_id
 * @property string $promotion_desc
 * @property string $promotion_image
 * @property integer $percent_discount
 * @property string $start_date
 * @property string $end_time
 * @property string $end_date
 * @property integer $status
 * @property integer $lang
 *
 * The followings are the available model relations:
 * @property Shop $shop
 */
class Promotion extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'promotion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('promotion_desc, promotion_image,promotion_code,promotion_name,start_date,end_date', 'required'),
            array('shop_id, status, lang', 'numerical', 'integerOnly' => true),
            array('promotion_image', 'length', 'max' => 255),
            array('start_date, end_time, end_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('promotion_id, shop_id, promotion_desc, promotion_image, percent_discount, start_date, end_date, status, lang', 'safe', 'on' => 'search'),
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
            'shop' => array(self::BELONGS_TO, 'Shop', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'promotion_id' => Yii::t('promotion', 'label.eventId'),
            'promotion_code' => Yii::t('promotion', 'label.eventCode'),
            'promotion_name' => Yii::t('promotion', 'label.eventName'),
            'shop_id' => Yii::t('promotion', 'label.eventShop'),
            'promotion_desc' => Yii::t('promotion', 'label.eventDesc'),
            'promotion_image' => Yii::t('promotion', 'label.eventImage'),
            'percent_discount' => Yii::t('promotion', 'label.eventPercent'),
            'end_time' => Yii::t('promotion', 'label.eventEndTime'),
            'start_date' => Yii::t('promotion', 'label.eventstartDate'),
            'end_date' => Yii::t('promotion', 'label.eventEndDate'),
            'status' => 'Status',
            'lang' => 'Lang',
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

        $criteria = new CDbCriteria;

        $criteria->compare('promotion_id', $this->promotion_id);
        $criteria->compare('promotion_code', $this->promotion_code);
        $criteria->compare('promotion_name', $this->promotion_name);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('promotion_desc', $this->promotion_desc, true);
        $criteria->compare('promotion_image', $this->promotion_image, true);
        $criteria->compare('percent_discount', $this->percent_discount);
        $criteria->compare('end_time', $this->end_time, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('lang', $this->lang);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function checkExistCode($code, $currentCode, $shopId)
    {
        if ($currentCode != null && $code == $currentCode) {
            return false;
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition("BINARY promotion_code = '$code' and shop_id = '$shopId'");
        return $this->count($criteria) > 0;
    }

    public function searchByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByShopAndStatus($shopId, $status)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        if ($status != 2)
            $criteria->compare('status', $status);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPromotionActiveByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        $criteria->addCondition('status=1');
        $criteria->addCondition('NOW() BETWEEN start_date AND end_date');

        return $this->findAll($criteria);
    }

    public function searchPromotionActiveByFoodAndDate($foodId,$date)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('status=1');
        $criteria->addCondition('(\''.$date.'\' BETWEEN start_date AND end_date)');
        $criteria->addCondition('(promotion_id IN (SELECT promotion_id FROM food_promotion WHERE food_id='.$foodId.'))');

        return $this->find($criteria);
    }

    public function findAllByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);

        return $this->findAll($criteria);
    }

    public function findAllPromotionOfDay()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('status=1');
        $criteria->addCondition('CONCAT(end_date, " ", end_time)>NOW()');

        return $this->findAll($criteria);
    }


    public function countPromotionNumber($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        return $this->count($criteria);
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Promotion the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
