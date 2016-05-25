<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class CityForm extends FormModel
{
    public $cityId;
    public $cityName;
    public $cityCurrentName;
    public $cityCurrentPostCode;
    public $cityPostCode;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cityName, cityPostCode', 'required'),
            array('cityName', 'length', 'max' => 100),
            array('cityPostCode', 'length', 'max' => 20,'message'=>'post code max length is 20 characters !'),
            array('cityPostCode', 'match', 'pattern'=>'/^[a-zA-Z0-9\s]+$/','message'=>'post code is invalid !'),
            array('cityName', 'match', 'pattern'=>'/^[a-zA-Z0-9\s,.]+$/','message'=>'city name is invalid !'),
            array('cityId,cityName,cityPostCode', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'cityId' => Yii::t('city','label.cityId'),
            'cityName' => Yii::t('city','label.cityName'),
            'cityPostCode' => Yii::t('city','label.cityPostCode'),
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var City $model */
        $model = City::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->cityId = $model->cityId;
        $this->cityName = $model->cityName;
        $this->cityCurrentName = $model->cityName;
        $this->cityPostCode = $model->cityPostCode;
        $this->cityCurrentPostCode = $model->cityPostCode;
    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var City $model */
        $model = new City();
        $model->cityPostCode = $this->cityPostCode;
        $model->cityName = $this->cityName;
        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->cityId = $model->cityId;
            return true;
        }
    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var City $model */
        $model = City::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->cityPostCode = $this->cityPostCode;
        $model->cityName = $this->cityName;
        $result = $model->save();
        if (!$result)
            return false;
        return true;
    }
}