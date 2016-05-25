<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchFeedbackForm extends FormModel
{
    public $account_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account_id', 'safe'),
            array('account_id', 'match', 'pattern'=>'/^[a-zA-Z0-9\s]+$/'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'account_id' => 'account_id',
        );
    }


}
