<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchPromotionForm extends FormModel
{
    public $status;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'status' => 'Status',
        );
    }

    public function search($shopId)
    {
        $offer = new Promotion();
        $offer->shop_id = $shopId;
        $offer->status = $this->status;
        return $offer;
    }

}
