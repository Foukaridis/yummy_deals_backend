<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class OpenHourDetailForm extends FormModel
{
    public $id;
    public $shopId;
    public $dateId;
    public $openAM;
    public $closeAM;
    public $openPM;
    public $closePM;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shopId, dateId', 'required'),
            array('openAM,openPM,closeAM,closePM', 'match', 'pattern'=>'/^[a-zA-Z0-9\s:]+$/'),
            array('openAM,openPM,closeAM,closePM,dateId,shopId', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'shopId' => 'shop',
            'dateId' => 'date',
            'openAM' => 'Open AM',
            'closeAM' => 'Close AM',
            'openPM' => 'Open PM',
            'closePM' => 'Close PM',
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var OpenHourDetail $model */
        $model = OpenHourDetail::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->id=$model->id;
        $this->shopId = $model->shopId;
        $this->dateId = $model->dateId;
        $this->openAM = $model->openAM;
        $this->closeAM = $model->closeAM;
        $this->openPM = $model->openPM;
        $this->closePM = $model->closePM;
    }

    public function update($id)
    {
        /** @var OpenHourDetail $model */
        $model = OpenHourDetail::model()->findByPk($id);

        $sourceTimezone = $model->shop->gmt;
        $destinationTimezone  = 'GMT';

        //$gmtOpenAM = Constants::convertTime($this->openAM, $sourceTimezone, $destinationTimezone);
        //$gmtCloseAM = Constants::convertTime($this->closeAM, $sourceTimezone, $destinationTimezone);
        //$gmtOpenPM = Constants::convertTime($this->openPM, $sourceTimezone, $destinationTimezone);
        //$gmtClosePM = Constants::convertTime($this->closePM, $sourceTimezone, $destinationTimezone);

        $new_object = Constants::convertObjectTime($this, $sourceTimezone, $destinationTimezone);

        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->openAM = $new_object->openAM;
        $model->closeAM = $new_object->closeAM;
        $model->openPM = $new_object->openPM;
        $model->closePM = $new_object->closePM;

        $result = $model->save();
        if (!$result)
            return false;
        return true;
    }
}