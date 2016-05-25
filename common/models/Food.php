<?php

/**
 * This is the model class for table "food".
 *
 * The followings are the available columns in table 'food':
 * @property string $food_id
 * @property string $food_name
 * @property string $food_code
 * @property integer $shop_id
 * @property double $food_price
 * @property string $food_thumbnail
 * @property string $food_small_thumbnail
 * @property integer $food_menus
 * @property string $food_desc
 * @property integer $status_in_day
 * @property integer $status
 * @property integer $lang
 * @property integer $available
 * @property double $rate
 * @property integer $rate_times
 *
 * The followings are the available model relations:
 * @property Shop $shop
 */
class Food extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'food';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('food_name,food_code, food_thumbnail, food_menus,shop_id,food_desc', 'required'),
            array('shop_id, food_menus, lang, status, available, rate_times', 'numerical', 'integerOnly' => true),
            array('food_price, rate', 'numerical'),
            array('food_code', 'length', 'max' => 20),
            array('food_name', 'length', 'max' => 200),
            array('food_thumbnail, food_small_thumbnail', 'length', 'max' => 255),
            array('food_desc', 'safe'),
            // The following rule is used by search().
            array('food_id, food_name, shop_id, food_price, food_thumbnail, food_small_thumbnail, food_menus, status_in_day, food_desc,status, lang', 'safe', 'on' => 'search'),
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
            'foodPromotionR'=>array(self::HAS_MANY,'FoodPromotion','food_id'),
            'shop' => array(self::BELONGS_TO, 'Shop', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'food_id' => 'Menus',
            'food_name' => 'Menu Name',
            'food_code' => 'Menu Code',
            'shop_id' => 'Shop',
            'food_price' => 'Menu Price',
            'food_thumbnail' => 'Menu Thumbnail',
            'food_small_thumbnail' => 'Menu Small Thumbnail',
            'food_menus' => 'Menu Menus',
            'food_desc' => 'Menu Desc',
            'status_in_day' => 'Status in day',
            'status' => 'Status',
            'lang' => 'Lang',
            'available'=> 'Available'
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
    public function search($foodList = array())
    {

        $criteria = new CDbCriteria;

        $criteria->compare('food_id', $this->food_id, true);
        $criteria->compare('food_code', $this->food_code, true);
        $criteria->compare('food_name', $this->food_name, true);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('food_price', $this->food_price);
        $criteria->compare('food_thumbnail', $this->food_thumbnail, true);
        $criteria->compare('food_small_thumbnail', $this->food_small_thumbnail, true);
        $criteria->compare('food_menus', $this->food_menus);
        $criteria->compare('food_desc', $this->food_desc, true);
        $criteria->compare('status_in_day', $this->status_in_day);
        $criteria->compare('status', $this->status);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('available', $this->available);

        if(is_array($foodList) && count($foodList)>0){
            //$foodList_string = '('.implode(', ',$foodList).')';
            $criteria->addNotInCondition('food_id',$foodList);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'food_id DESC',
            ),
        ));
    }

    public function checkExistCode($code, $currentCode, $shopId)
    {
        if ($currentCode != null && $code == $currentCode) {
            return false;
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition("BINARY food_code = '$code' and shop_id = '$shopId'");
        return $this->count($criteria) > 0;
    }

    public function searchByShop($shopId)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'food_name',
            ),
        ));
    }

    public function searchByModel()
    {

        $criteria = new CDbCriteria;
        if ($this->food_name != null)
            $criteria->compare('food_name', $this->food_name, true);
        if ($this->food_menus != null)
            $criteria->compare('food_menus', $this->food_menus);
        if ($this->shop_id != null)
            $criteria->compare('shop_id', $this->shop_id);
        if ($this->status_in_day != null)
            $criteria->compare('status_in_day', $this->status_in_day);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'food_name',
            ),
        ));
    }

    public function searchByPromotion($promotionId)
    {

        $criteria = new CDbCriteria;
        $criteria->addCondition('food_id in (select food_id from food_promotion where promotion_id='.$promotionId.')');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'food_name',
            ),
        ));
    }

    public function findAllByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);

        return $this->findAll($criteria);
    }

    public function findAllByMenu($menuId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('food_menus', $menuId);

        return $this->findAll($criteria);
    }


    public function countFoodNumber($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        return $this->count($criteria);
    }

    public function countFoodByShopAndMenu($shopId, $menuId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        $criteria->compare('food_menus', $menuId);
        return $this->count($criteria);
    }

    public function getFoodsByShopAndMenu($shopId, $menuId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        $criteria->compare('food_menus', $menuId);
        $criteria->compare('status_in_day', 1);
        $criteria->compare('status', 1);
        return $this->findAll($criteria);
    }

    public function getFoodsOfDayByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        $criteria->compare('status_in_day', 1);
        $criteria->compare('status', 1);

        return $this->findAll($criteria);
    }

    public function getFoodsByPromotion($promotionId)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('food_id IN (SELECT food_id FROM food_promotion WHERE promotion_id='.$promotionId.')');
        $criteria->compare('status_in_day', 1);
        $criteria->compare('status', 1);

        return $this->findAll($criteria);
    }
    public function getFoodsBySearch($keyword, $cityId, $menuId)
    {
        $criteria = new CDbCriteria;
        if($cityId != 0){
            $criteria->addCondition('shop_id IN (SELECT location_id FROM location WHERE location_city='.$cityId.')');
        }
        if($menuId != 0){
            $criteria->compare('food_menus', $menuId);
        }
        $criteria->compare('status_in_day', 1);
        $criteria->compare('status', 1);
        if($keyword != ''){
            $criteria->addCondition("food_name LIKE '%".$keyword."%'");
        }

        return $this->findAll($criteria);
    }
    public function getAvailable($available= FALSE)
    {

        if ($available === FALSE) {
            $available = $this->available;
        }
        $str = array(
            Constants::AVAILABLE => '<span class="label label-success" style="font-size: 90%;">Available</span>',
            Constants::OUT_OF_STOCK => '<span class="label label-danger" style="font-size: 90%;">Out of stock</span>',
        );
        return isset($str[$available]) ? $str[$available] : '';

    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Food the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	public function getFoodName($foodId)
    {
        $food = $this->findByPk($foodId);
        return isset($food) ? $food->food_name : '';
    }
}
