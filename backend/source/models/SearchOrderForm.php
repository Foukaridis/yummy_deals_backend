<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchOrderForm extends FormModel
{
    public $status;
    public $shop_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status,shop_id', 'safe'),
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
        $order = new Orders();

        $order->shop_id = $shopId;
        $order->status=$this->status;
        return $order;
    }

}
