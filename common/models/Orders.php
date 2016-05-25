<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $order_id
 * @property string $account_id
 * @property integer $shop_id
 * @property string $order_places
 * @property string $order_requirement
 * @property string $order_time
 * @property integer $status
 * @property string $paymentMethod
 * @property string $paymentStatus
 * @property string $created
 * @property string $group_code
 * @property string $chef_id
 * @property string $deliveryman_id
 *
 * The followings are the available model relations:
 * @property OrderTotal $total
 */
class Orders extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account_id, shop_id, created', 'required'),
            array('shop_id, order_id, paymentMethod, paymentStatus, status', 'numerical', 'integerOnly' => true),
            array('account_id, status, group_code, chef_id, deliveryman_id', 'length', 'max' => 30),
            array('order_time', 'length', 'max' => 100),
            array('status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('order_id, account_id, shop_id, order_places, order_requirement, paymentMethod, paymentStatus, order_time, status, created', 'safe', 'on' => 'search'),
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
            'orderItemR' => array(self::HAS_MANY, 'OrderFood', 'order_id'),
            'total' => array(self::HAS_ONE, 'OrderTotal', 'orderId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'order_id' => 'Order',
            'account_id' => 'Account',
            'shop_id' => 'Shop',
            'order_places' => 'Order Places',
            'order_requirement' => 'Order Requirement',
            'order_time' => 'Order Time',
            'status' => 'Status',
            'created' => 'Created',
            'paymentMethod' => 'Payment Method',
            'paymentStatus' => 'Payment Status',
            'group_code'=> 'Group',
            'chef_id'=>'Chef',
            'deliveryman_id'=>'Deliveryman',

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

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('account_id', $this->account_id, true);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('order_places', $this->order_places, true);
        $criteria->compare('order_requirement', $this->order_requirement, true);
        $criteria->compare('order_time', $this->order_time, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('paymentMethod', $this->paymentMethod, true);
        $criteria->compare('paymentStatus', $this->paymentStatus, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('group_code', $this->group_code, true);
        $criteria->compare('chef_id', $this->chef_id, true);
        $criteria->compare('deliveryman_id', $this->deliveryman_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'order_time',
            ),
        ));
    }

    public function searchCustom($user_id, $role, $shopId = false)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('account_id', $this->account_id, true);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('order_places', $this->order_places, true);
        $criteria->compare('order_requirement', $this->order_requirement, true);
        $criteria->compare('order_time', $this->order_time, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('paymentMethod', $this->paymentMethod, true);
        $criteria->compare('paymentStatus', $this->paymentStatus, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('group_code', $this->group_code, true);
        $criteria->compare('chef_id', $this->chef_id, true);
        $criteria->compare('deliveryman_id', $this->deliveryman_id, true);

        if($shopId != null)
        {
            $criteria->addCondition('shop_id =' . $shopId);
        }
        if($role == Constants::ROLE_SHOP_OWNER)
        {
            $shops = Shop::model()->findAll('account_id ="'.$user_id.'"');
            $shopIds = array();
            foreach($shops as $single)
            {
                $shopIds[]= $single->location_id;
            }
            $criteria->addInCondition("shop_id", $shopIds);
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'order_time',
            ),
        ));
    }

    public function searchByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'order_time',
            ),
        ));
    }
	public function searchByOwner($userId)
    {
        $shops = Shop::model()->findAll('account_id ="'.$userId.'"');
        $shopIds = array();
        foreach($shops as $single)
        {
            $shopIds[]= $single->location_id;
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition("shop_id", $shopIds);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'order_time',
            ),
        ));
    }

    public function searchByShopAndStatus($shopId, $status)
    {
        $criteria = new CDbCriteria;
        if ($shopId != 0)
            $criteria->compare('shop_id', $shopId);
        else
        {
            if (Yii::app()->user->role == Constants::ROLE_SHOP_OWNER) {

                $shops = Shop::model()->findAll('account_id ="'.Yii::app()->user->id.'"');
                $shopIds = array();
                foreach($shops as $single)
                {
                    $shopIds[]= $single->location_id;
                }
                $criteria->addInCondition("shop_id", $shopIds);
            }
        }
        $criteria->compare('status', $status);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'order_time',
            ),
        ));
    }

    public function searchByUser($userId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('account_id', $userId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'created DESC',
            ),
        ));
    }

    public function searchByShopAndUser($shopId, $userId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('account_id', $userId);
        $criteria->compare('shop_id', $shopId);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'created DESC',
            ),
        ));
    }

    public function getExistOrder($accountId, $shopId, $create_time)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('shop_id', $shopId);
        $criteria->compare('account_id', $accountId);
        $criteria->compare('created', $create_time);

        return $this->find($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function getStatus($status= FALSE)
    {
        if ($status === FALSE) {
            $status = $this->status;
        }
        $str = array(
            Constants::ORDER_NEW => '<span style="color: blue">NEW</span>',
            Constants::ORDER_IN_PROCESS => '<span style="color: green">IN PROCESS</span>',
            Constants::ORDER_READY => '<span style="color: blue">READY</span>',
            Constants::ORDER_ON_THE_WAY =>'<span style="color: green">ON THE WAY</span>',
            Constants::ORDER_DELIVERED=> '<span style="color: #808080">DELIVERED</span>',
            Constants::ORDER_CANCEL => '<span style="color: red">CANCEL</span>',
            Constants::ORDER_FAIL_DELIVERY => '<span style="color: red">FAIL DELIVERY</span>',

        );
        return isset($str[$status]) ? $str[$status] : '';

    }

    public function calculateFinance($shopId,$ownerId,$grand_total)
    {
        $check_budget = Finance::model()->find("shopId ='" . $shopId."'");
        $check_owner_budget = FinanceOwner::model()->find("ownerId ='" . $ownerId."'");

        if (isset ($check_budget)) {
            $old_budget = $check_budget->budget;
            $check_budget->budget = $old_budget + $grand_total;
            $check_budget->updateTime = date('Y-m-d H:i:s', strtotime('Now'));
            $check_budget->save();
        } else {

            $budget = new Finance();
            $budget->shopId = $shopId;
            $budget->updateTime = date('Y-m-d H:i:s', strtotime('Now'));
            $budget->budget = $grand_total;
            $budget->status = 1;
            $budget->save();
        }


        if (isset ($check_owner_budget)) {
            $old_owner_budget = $check_owner_budget->budget;
            $check_owner_budget->budget = $old_owner_budget + $grand_total;
            $check_owner_budget->updateTime = date('Y-m-d H:i:s', strtotime('Now'));
            $check_owner_budget->save();
        } else {

            $budget = new FinanceOwner();
            $budget->ownerId = $ownerId;
            $budget->updateTime = date('Y-m-d H:i:s', strtotime('Now'));
            $budget->budget = $grand_total;
            $budget->status = 1;
            $budget->save();
        }
    }



}
