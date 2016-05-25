<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchShopForm extends FormModel
{
    public $shopName;
    public $shopCity;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shopName', 'safe'),
            array('shopCity', 'safe'),
            array('shopName', 'match', 'pattern'=>'/^[a-zA-Z0-9\s]+$/'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'shopName' => 'shop name',
            'shopCity' => 'City',
        );
    }

    public function search()
    {
        /** @var Shop $model */
        $model = new Shop();
        if($this->shopName!=null)
        {
            $model->location_name=$this->shopName;
        }
        if($this->shopCity!=0)
        {
            $model->location_city=$this->shopCity;
        }
        return $model;
    }

}
