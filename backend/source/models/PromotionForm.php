<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class PromotionForm extends FormModel
{
    public $eventId;
    public $eventCode;
    public $eventCurrentCode;
    public $eventName;
    public $eventDesc;
    public $eventImage;
    public $eventShop;
    public $percentDiscount;
    public $eventStartDate;
    public $eventEndDate;
    public $eventEndTime;
    public $eventStatus;
    public $eventNewThumb;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('eventDesc, eventEndDate,eventStartDate, eventStatus ,eventShop,eventCode,eventName,percentDiscount', 'required'),
            array('eventImage', 'length', 'max' => 255),
            array('eventNewThumb', 'file', 'allowEmpty'=>true, 'types'=>'jpg, png'),
            array('eventImage,eventNewThumb,eventEndTime,eventCurrentCode', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'eventId' => Yii::t('promotion','label.eventId'),
            'eventShop' => Yii::t('promotion','label.eventShop'),
            'eventCode' => Yii::t('promotion','label.eventCode'),
            'eventName' => Yii::t('promotion','label.eventName'),
            'eventDesc' => Yii::t('promotion','label.eventDesc'),
            'eventImage' => Yii::t('promotion','label.eventImage'),
            'percentDiscount' => Yii::t('promotion','label.eventPercent'),
            'eventStartDate' => Yii::t('promotion','label.eventStartDate'),
            'eventEndDate' => Yii::t('promotion','label.eventEndDate'),
            'eventEndTime' => Yii::t('promotion','label.eventEndTime'),
            'eventStatus' => 'Status',
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Promotion $model */
        $model = Promotion::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->eventId = $model->promotion_id;
        $this->eventCode=$model->promotion_code;
        $this->eventCurrentCode=$model->promotion_code;
        $this->eventName=$model->promotion_name;
        $this->eventShop = $model->shop_id;
        $this->eventDesc = $model->promotion_desc;
        $this->percentDiscount = $model->percent_discount;
        $this->eventStartDate = $model->start_date;
        $this->eventEndDate = $model->end_date;
        $this->eventEndTime = $model->end_time;
        $this->eventStatus = $model->status;
        $this->eventImage = $model->promotion_image;
    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var Promotion $model */
        $model = new Promotion();
        $model->promotion_code=$this->eventCode;
        $model->promotion_name=$this->eventName;
        $model->shop_id = $this->eventShop;
        $model->promotion_desc = $this->eventDesc;
        $model->promotion_image = $this->eventImage;
        $model->percent_discount = $this->percentDiscount;
        $model->end_time = $this->eventEndTime;
        $model->start_date = $this->eventStartDate;
        $model->end_date = $this->eventEndDate;
        $model->status = $this->eventStatus;
        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->eventId = $model->promotion_id;
            return true;
        }
    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Promotion $model */
        $model = Promotion::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->shop_id = $this->eventShop;
        $model->promotion_code=$this->eventCode;
        $model->promotion_name=$this->eventName;
        $model->promotion_desc = $this->eventDesc;
        $model->promotion_image = $this->eventImage;
        $model->percent_discount = $this->percentDiscount;
        $model->start_date = $this->eventStartDate;
        $model->end_time = $this->eventEndTime;
        $model->end_date = $this->eventEndDate;
        $model->status = $this->eventStatus;
        $result = $model->save();
        if (!$result)
            return false;
        return true;
    }
}