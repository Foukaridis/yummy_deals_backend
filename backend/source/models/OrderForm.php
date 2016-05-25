<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class OrderForm extends FormModel
{
    public $orderId;
    public $orderShop;
    public $orderAccount;
    public $orderPlace;
    public $orderRequirement;
    public $orderTime;
    public $status;
    public $isSendToCustomer;
    public $discount;
    public $grand_total;
    public $tax;
    public $shipping;
    public $grandTotal;
    public $foodList = array();
    public $order_time;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('foodList, orderShop,orderAccount,orderTime', 'required'),
            //array('orderCode', 'match', 'pattern'=>'/^[a-zA-Z0-9\s,.]+$/'),
            array('order_time, orderId, grand_total, orderCode, orderShop,orderAccount,orderPlace,orderRequirement,orderTime,status,isSendToCustomer', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'orderId' => Yii::t('order', 'label.orderId'),
            'orderShop' => Yii::t('order', 'label.shop'),
            'orderAccount' => Yii::t('order', 'label.account'),
            'orderPlace' => Yii::t('order', 'label.orderPlace'),
            'orderRequirement' => Yii::t('order', 'label.orderRequirement'),
            'orderTime' => Yii::t('order', 'label.orderTime'),
            'status' => 'Status',
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Orders $model */
        $model = Orders::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->orderId = $model->order_id;
        $this->orderShop = $model->shop_id;
        $this->orderAccount = $model->account_id;
        $this->orderPlace = $model->order_places;
        $this->orderTime = $model->order_time;
        $this->orderRequirement = $model->order_requirement;
        $this->status = $model->status;

    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var Orders $model */
        $model = new Orders();
        $model->shop_id = $this->orderShop;
        $model->account_id = $this->orderAccount;
        $model->order_places = $this->orderPlace;
        $model->order_requirement = $this->orderRequirement;
        $model->order_time = $this->orderTime;
        $model->created = DateTimeUtils::createInstance()->now();
        $model->status = $this->status;
        //$result = $model->save();
        if (!$model->save()) {
            var_dump($model->getErrors());
            die;
        }

        /*if (!$result) {
            return false;
        } else {
            $this->orderId = $model->order_Id;
            return true;
        }*/
    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Orders $model */
        $model = Orders::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->shop_id = $this->orderShop;
        $model->account_id = $this->orderAccount;
        $model->order_places = $this->orderPlace;
        $model->order_requirement = $this->orderRequirement;
        $model->order_time = $this->orderTime;
        $model->status = $this->status;
        $result = $model->save();

         //User for update
        $check_group = OrderGroup::model()->findByPk($model->group_code);
        if(isset($check_group)){
            OrderGroup::model()->updateGroup($model->group_code);
        }

        if (!$result)
            return false;
        return true;
    }

    public function onBeforeValidate($event)
    {
        parent::onBeforeValidate($event);

        if ($this->foodList) {
            //var_dump($this->foodList);die;
            foreach ($this->foodList as $item) {
                if (strlen($item['number']) == 0) {
                    $this->addError('number', 'Number of order is required');
                    break;
                }
                if (!is_numeric($item['number'])) {
                    $this->addError('number', 'Number of order is invalid');
                    break;
                }
                if ($item['number'] <= 0) {
                    $this->addError('number', 'Number of order must greater than zero');
                    break;
                }
            }
        }
    }
}