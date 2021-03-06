<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchMenuForm extends FormModel
{
    public $menuName;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menuName', 'safe'),
            array('menuName', 'match', 'pattern'=>'/^[a-zA-Z0-9\s]+$/'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'menuName' => 'Menu name',
        );
    }
}
