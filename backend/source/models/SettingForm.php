<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 11/15/13 - 10:40 PM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class SettingForm extends CFormModel{
    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;
    public $settingId;
    public $settingKey;
    public $settingValue;
    public $settingData;
    public $settingBankinfo;
    public $settingCurrency;
    public $locationLatitude;
    public $locationLongitude;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('settingKey,locationLatitude,locationLongitude', 'required'),
            array('settingKey', 'length', 'max'=>60),
            array('settingValue', 'length', 'max'=>255),
            array('settingData, settingBankinfo, settingCurrency', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'settingKey'=>Yii::t('admin', 'label.settingKey'),
            'settingValue'=>Yii::t('admin', 'label.settingValue'),
            'settingData'=>Yii::t('admin', 'label.settingData'),
        );
    }

    public function loadModel($id){
        /* @var Settings $news */
        $news = Settings::model()->findByPk($id);
        if($news == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model = new SettingForm;
        $model->settingId = $news->setting_id;
        $model->settingKey = $news->setting_key;
        $model->settingValue = $news->setting_value;
        $model->settingData = $news->setting_data;
        $model->settingBankinfo = $news->setting_bankinfo;
        $model->settingCurrency = $news->setting_currency;
        $model->locationLatitude = $news->location_latitude;
        $model->locationLongitude = $news->location_longitude;

        return $model;
    }

    public function save(){
        $setting = new Settings;
        $setting->setting_id = DateTimeUtils::createInstance()->nowStr();
        $setting->setting_key = trim($this->settingKey);
        $setting->setting_value = trim($this->settingValue);
        $setting->setting_data = trim($this->settingData);
        $setting->setting_bankinfo = $this->settingBankinfo;
        $setting->setting_currency = $this->settingCurrency;
        $setting->location_latitude = $this->locationLatitude;
        $setting->location_longitude = $this->locationLongitude;

        if(Settings::model()->selectCount($setting)) return self::ERROR_EXISTS;
        if($setting->save()){
            return self::ERROR_NONE;
        }else{
            return self::ERROR_DB;
        }
    }

    public function update($id){
        /* @var Settings $model */
        $model = Settings::model()->findByPk($id);
        if($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model->setting_key = trim($this->settingKey);
        $model->setting_value = trim($this->settingValue);
        $model->setting_data = trim($this->settingData);
        $model->setting_bankinfo = $this->settingBankinfo;
        $model->setting_currency = trim($this->settingCurrency);
        $model->location_latitude = trim($this->locationLatitude);
        $model->location_longitude = trim($this->locationLongitude);

        if($model->save()){
            return self::ERROR_NONE;
        }else{
            return self::ERROR_DB;
        }
    }
}