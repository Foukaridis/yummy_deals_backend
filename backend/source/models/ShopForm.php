<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class ShopForm extends FormModel
{
    public $location_id;
    public $location_name;
    public $location_address;
    public $location_city;
    public $location_des;
    public $location_image;
    public $location_tel;
    public $location_last_order_hour;
    public $location_open_hour;
    public $location_open_hour_style;
    public $latitude;
    public $longitude;
    public $shopTempImage;
    public $shopStartTime;
    public $shopEndTime;
    public $status;
    public $oldLocationName;
    public $account_id;
    public $rate;
    public $rate_times;
    public $gmt;
    public $isVerified;
    public $isFeatured;
    public $facebook;
    public $twitter;
    public $email;
    public $live_chat;
	
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('isVerified,isFeatured,location_name, location_city, account_id, location_tel, latitude, longitude, location_open_hour, location_address, status, gmt', 'required'),
            array('location_name, location_tel, location_last_order_hour, latitude, longitude', 'length', 'max' => 20),
            array('location_name', 'match', 'pattern' => '/^[a-zA-Z0-9\s,.]+$/'),
			//array('location_tel', 'match', 'pattern' => '/^[2-9]\d{2}-\d{3}-\d{4}$/'),
            //array('location_tel', 'match', 'pattern' => '/^[0-9.-,]+$/'),
            //array('latitude, longitude', 'match', 'pattern' => '/^[0-9.-,]+$/'),
            array('location_address', 'length', 'max' => 50),
            array('gmt', 'length', 'max' => 40),
            array('location_image', 'length', 'max' => 100),
            array('shopTempImage', 'file', 'allowEmpty'=>true, 'types'=>'jpg, png','message'=>'thumbnail types are jpg and png'),
            array('isVerified,isFeatured,location_des, shopTempImage, location_open_hour_style,facebook,twitter,email,live_chat', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'location_name' => Yii::t('shop', 'label.shopName'),
            'location_address' => Yii::t('shop', 'label.shopAddress'),
            'account_id' => 'Owner',
            'location_city' => Yii::t('shop', 'label.shopCity'),
            'location_tel' => Yii::t('shop', 'label.shopPhone'),
            'location_des' => Yii::t('shop', 'label.shopDesc'),
            'latitude' => Yii::t('shop', 'label.latitude'),
            'longitude' => Yii::t('shop', 'label.longitude'),
            'location_open_hour' => Yii::t('shop', 'label.openHour'),
            'location_open_hour_style' => Yii::t('shop', 'label.openHourStyle'),
            'location_last_order_hour' => Yii::t('shop', 'label.lastOrder'),
            'status' => Yii::t('shop', 'label.status'),
			'rate' => Yii::t('shop', 'label.rate'),
            'rate_times' => Yii::t('shop', 'label.rateTimes'),
            'gmt' => Yii::t('shop', 'label.gmt'),
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Shop $model */
        $model = Shop::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $this->location_id = $model->location_id;
        $this->location_name = $model->location_name;
        $this->account_id= $model->account_id;
        $this->oldLocationName = $model->location_name;
        $this->location_city = $model->location_city;
        $this->location_address = $model->location_address;
        $this->location_image = $model->location_image;
        $this->location_tel = $model->location_tel;
        $this->location_des = $model->location_des;
        $this->latitude = $model->location_latitude;
        $this->longitude = $model->location_longitude;
        $this->location_last_order_hour = $model->location_last_order_hour;
        $this->status = $model->status;
		$this->rate = $model->rate;
        $this->rate_times = $model->rate_times;
        $this->gmt = $model->gmt;
        $this->isFeatured = $model->isFeatured;
        $this->isVerified = $model->isVerified;
        $this->facebook = $model->facebook;
        $this->twitter = $model->twitter;
        $this->email = $model->email;
        $this->live_chat = $model->live_chat;
    }

    /**
     * Save to database
     */
    public function save()
    {
        $model = new Shop();
        $model->location_name = $this->location_name;
        $model->account_id= $this->account_id;
        $model->location_address = $this->location_address;
        $model->location_city = $this->location_city;
        $model->location_tel = $this->location_tel;
        $model->location_image = $this->location_image;
        $model->location_des = $this->location_des;
        $model->location_latitude = $this->latitude;
        $model->location_longitude = $this->longitude;
        $model->location_last_order_hour = $this->location_last_order_hour;
        $model->status = $this->status;
        $model->rate = $this->rate;
        $model->rate_times = $this->rate_times;
        $model->gmt = $this->gmt;
        $model->isFeatured = $this->isFeatured;
        $model->isVerified = $this->isVerified;
        $model->facebook = $this->facebook;
        $model->twitter = $this->twitter;
        $model->email = $this->email;
        $model->live_chat = $this->live_chat;

        $result = $model->save();
        if (!$result) {
            return false;
        } else {

            $dateTb = Datetb::model()->findAll();
            $sourceTimezone  = $model->gmt;
            $destinationTimezone  = 'GMT';

            $gmtOpenAM = Constants::convertTime("7:00 AM", $sourceTimezone, $destinationTimezone);
            $gmtCloseAM = Constants::convertTime("11:00 AM", $sourceTimezone, $destinationTimezone);
            $gmtOpenPM = Constants::convertTime("2:00 PM", $sourceTimezone, $destinationTimezone);
            $gmtClosePM = Constants::convertTime("10:00 PM", $sourceTimezone, $destinationTimezone);


            foreach ($dateTb as $mDate) {
                /** @var OpenHourDetail $openHour */
                $openHour = new OpenHourDetail();
                $openHour->shopId = $model->location_id;
                $openHour->dateId = $mDate->dateId;
                $openHour->openAM = $gmtOpenAM;
                $openHour->closeAM = $gmtCloseAM;
                $openHour->openPM = $gmtOpenPM;
                $openHour->closePM = $gmtClosePM;

                $openHour->save();
            }

            $this->location_id = $model->location_id;
            return true;
        }

    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Shop $model */
        $model = Shop::model()->findByPk($id);
        $old_gmt = $model->gmt;
        $new_gmt = $this->gmt;

        $gmt = 'GMT';

        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->location_name = $this->location_name;
        $model->account_id= $this->account_id;
        $model->location_city = $this->location_city;
        $model->location_address = $this->location_address;
        $model->location_tel = $this->location_tel;
        $model->location_image = $this->location_image;
        $model->location_des = $this->location_des;
        $model->location_latitude = $this->latitude;
        $model->location_longitude = $this->longitude;
        $model->location_last_order_hour = $this->location_last_order_hour;
        $model->status = $this->status;
        $model->rate = $this->rate;
        $model->rate_times = $this->rate_times;
        $model->gmt = $this->gmt;
        $model->isFeatured = $this->isFeatured;
        $model->isVerified = $this->isVerified;
        $model->facebook = $this->facebook;
        $model->twitter = $this->twitter;
        $model->email = $this->email;
        $model->live_chat = $this->live_chat;

        $result = $model->save();
        if (!$result)
            return false;
        else {

            if($old_gmt != $new_gmt)
            {
                $dateTb = Datetb::model()->findAll();

                foreach ($dateTb as $mDate) {
                    $dateId = $mDate->dateId;

                    /** @var OpenHourDetail $openHour */
                    $openHour = OpenHourDetail::model()->find("dateId = $dateId AND shopId = $id");
                    $new_object = Constants::convertObjectTime($openHour, $gmt, $old_gmt);
                    $new_object1 = Constants::convertObjectTime($new_object, $new_gmt, $gmt);

                    $openHour->openAM = $new_object1->openAM;
                    $openHour->closeAM = $new_object1->closeAM;
                    $openHour->openPM = $new_object1->openPM;
                    $openHour->closePM = $new_object1->closePM;

                    $openHour->save();
                }
            }

            return true;
        }
    }
}
