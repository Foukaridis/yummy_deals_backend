<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchHistoryForm extends FormModel
{
    public $status;
    public $ownerId;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status,ownerId', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'status' => 'Status',
            'ownerId'=> 'Owner'
        );
    }

    public function search()
    {
        $order = new FinanceHistory();

        $order->ownerId = $this->ownerId;
        $order->status=$this->status;
        return $order;
    }

}
