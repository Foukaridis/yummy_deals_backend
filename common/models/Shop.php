<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $location_id
 * @property string $location_name
 * @property string $account_id
 * @property string $location_address
 * @property integer $location_city
 * @property string $location_des
 * @property string $location_image;
 * @property string $location_tel
 * @property string $location_open_hour
 * @property string $location_open_hour_style
 * @property string $location_last_order_hour
 * @property string $location_latitude
 * @property string $location_longitude
 * @property integer $lang
 * @property integer $status
 * @property string $tax
 * @property string $shipping
 * @property double $rate
 * @property integer $rate_times
 * @property string $gmt
 * @property integer $isVerified
 * @property integer $isFeatured
 * @property string $facebook
 * @property string $twitter
 * @property string $email
 * @property string $live_chat
 */
class Shop extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'location';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('isVerified,isFeatured,lang,status,location_city, rate_times', 'numerical', 'integerOnly' => true),
            array('rate', 'numerical'),
            array('location_name, location_tel, location_last_order_hour, location_latitude, location_longitude', 'length', 'max' => 20),
            array('location_address', 'length', 'max' => 50),
            array('account_id', 'length', 'max' => 30),
            array('gmt', 'length', 'max' => 40),
            array('location_image', 'length', 'max' => 100),
            array('tax, shipping', 'length', 'max' => 500),
            array('location_des,facebook,twitter,email,live_chat', 'safe'),
            // The following rule is used by search().
            array('isVerified,isFeatured,location_id, location_name,location_city, location_address,location_image, location_des, location_tel, location_open_hour, location_last_order_hour,location_open_hour_style, location_latitude, location_longitude, lang,status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'location_id' => 'Shop',
            'location_name' => 'Shop Name',
            'account_id' => 'Owner',
            'location_city' => 'City',
            'location_address' => 'Address',
            'location_image' => 'Image',
            'location_des' => 'Description',
            'location_tel' => 'Phone',
            'location_open_hour' => 'Open Hour',
            'location_open_hour_style' => 'Style Open Hour',
            'location_last_order_hour' => 'Last Order Hour',
            'location_latitude' => 'Shop Latitude',
            'location_longitude' => 'Shop Longitude',
            'lang' => 'Lang',
            'status' => 'Status',
            'tax' => 'Tax',
            'shipping' => 'Shipping'
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

        $criteria = new CDbCriteria;

        $criteria->compare('location_id', $this->location_id);
        $criteria->compare('location_name', $this->location_name, true);
        $criteria->compare('location_city', $this->location_city);
        $criteria->compare('account_id', $this->account_id);
        $criteria->compare('location_address', $this->location_address, true);
        $criteria->compare('location_des', $this->location_des, true);
        $criteria->compare('location_image', $this->location_image, true);
        $criteria->compare('location_tel', $this->location_tel, true);
        $criteria->compare('location_open_hour', $this->location_open_hour, true);
        $criteria->compare('location_open_hour_style', $this->location_open_hour_style);
        $criteria->compare('location_last_order_hour', $this->location_last_order_hour, true);
        $criteria->compare('location_latitude', $this->location_latitude, true);
        $criteria->compare('location_longitude', $this->location_longitude, true);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('status', $this->status);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('shipping', $this->shipping);
        $criteria->compare('gmt', $this->gmt, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'location_name',
            ),
        ));

    }

    public function searchCustom($user_id, $role)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('location_id', $this->location_id);
        $criteria->compare('location_name', $this->location_name, true);
        $criteria->compare('location_city', $this->location_city);
        $criteria->compare('account_id', $this->account_id);
        $criteria->compare('location_address', $this->location_address, true);
        $criteria->compare('location_des', $this->location_des, true);
        $criteria->compare('location_image', $this->location_image, true);
        $criteria->compare('location_tel', $this->location_tel, true);
        $criteria->compare('location_open_hour', $this->location_open_hour, true);
        $criteria->compare('location_open_hour_style', $this->location_open_hour_style);
        $criteria->compare('location_last_order_hour', $this->location_last_order_hour, true);
        $criteria->compare('location_latitude', $this->location_latitude, true);
        $criteria->compare('location_longitude', $this->location_longitude, true);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('status', $this->status);
        $criteria->compare('tax', $this->tax);
        $criteria->compare('shipping', $this->shipping);
        $criteria->compare('gmt', $this->gmt, true);


        if ($role == Constants::ROLE_SHOP_OWNER) {
            $criteria->addCondition('account_id =' . $user_id);

        } elseif ($role == Constants::ROLE_MODERATOR) {
            $moderator = Account::model()->findByPk($user_id);
            $shopId = $moderator->shopId;
            $criteria->addCondition('location_id =' . $shopId);
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'location_name',
            ),
        ));
    }


    public function searchByOwner($accountId)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('account_id', $accountId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'location_name',
            ),
        ));

    }

    public function searchByModerator($accountId)
    {
        $moderator = Account::model()->findByPk($accountId);
        $shopId = $moderator->shopId;


        $criteria = new CDbCriteria;
        $criteria->compare('location_id', $shopId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'location_name',
            ),
        ));

    }

    public function getName($shopId)
    {
        $shop = $this->findByPk($shopId);
        return isset($shop) ? $shop->location_name : '';
    }

    public function checkExistName($name)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("BINARY location_name = '$name'");
        return $this->count($criteria) > 0;
    }

    public function countShopByCity($city)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('location_city', $city);
        return $this->count($criteria);
    }

    public function searchByModel()
    {

        $criteria = new CDbCriteria;
        if ($this->location_city != null)
            $criteria->compare('location_city', $this->location_city);
        if ($this->location_name != null)
            $criteria->compare('location_name', $this->location_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Constants::SIZE_PER_PAGE,
            ),
            'sort' => array(
                'defaultOrder' => 'location_name',
            ),
        ));

    }

    public function findAllShopActive()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('status', 1);
        return $this->findAll($criteria);

    }

    public function findAllShopActiveByCity($cityId)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('location_city', $cityId);
        $criteria->compare('status', 1);
        return $this->findAll($criteria);

    }

    public function findAllShopActiveByMenu($menuId)
    {

        $criteria = new CDbCriteria;
        $criteria->addCondition('location_id IN (SELECT DISTINCT shop_id FROM food WHERE food_menus=' . $menuId . ')');
        $criteria->compare('status', 1);
        $criteria->join = 'INNER JOIN account ON account_id = account.id ';
        $criteria->condition = 'account.status =:active';
        $criteria->params    = array(':active'=>1);
        return $this->findAll($criteria);

    }

    public function findAllShopActiveBySearch($keyword, $cityId, $menuId)
    {
        $criteria = new CDbCriteria;
        if ($cityId != 0) {
            $criteria->compare('location_city', $cityId);
        }
        $criteria->compare('status', 1);
        if ($menuId != 0) {
            $criteria->addCondition('location_id IN (SELECT DISTINCT shop_id FROM food WHERE food_menus=' . $menuId . ')');
        }
        if ($keyword != '') {
            $criteria->addCondition("location_name LIKE '%" . $keyword . "%'");
        }

        return $this->findAll($criteria);
    }

    public function findAllShopActiveByCityAndMenu($cityId, $menuId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('location_city', $cityId);
        $criteria->compare('status', 1);
        $criteria->addCondition('location_id IN (SELECT DISTINCT shop_id FROM food WHERE food_menus=' . $menuId . ')');
        $criteria->join = 'INNER JOIN account ON account_id = account.id ';
        $criteria->condition = 'account.status =:active';
        $criteria->params    = array(':active'=>1);

        return $this->findAll($criteria);

    }

    public function findAllShopByLatLong($lat, $long)
    {

        $criteria = new CDbCriteria;
        $criteria->addCondition('(location_latitude BETWEEN ' . $lat . '-0.3 AND ' . $lat . '+0.3) AND (location_longitude BETWEEN ' . $long . '-0.3 AND ' . $long . '+0.3)');
        $criteria->compare('status', 1);
        $criteria->join = 'INNER JOIN account ON account_id = account.id ';
        $criteria->condition = 'account.status =:active';
        $criteria->params    = array(':active'=>1);

        return $this->findAll($criteria);

    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Shop the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);

    }

    public static function checkOwnerShop($shopId, $ownerId)
    {
        $shopOwner = Shop::model()->findByPk($shopId)->account_id;
        if ($ownerId == $shopOwner)
            return true;
        else return false;
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $tax = CJSON::encode(array(
                Constants::TAX_NAME => 0,
                'tax_status' => 0
            ));

            $shipping = CJSON::encode(array(
                Constants::FLAT_RATE => 0,
                'minimum' => 0,
                'local_pickup' => 1,
                'shipping_status' => 0
            ));

            $this->tax = $tax;
            $this->shipping = $shipping;
        }
        return parent::beforeSave();
    }

}
