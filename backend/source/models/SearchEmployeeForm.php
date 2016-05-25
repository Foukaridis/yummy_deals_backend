<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchEmployeeForm extends FormModel
{
    public $full_name;
    public $role;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('full_name', 'safe'),
            array('role', 'safe'),
            array('role','numerical', 'integerOnly'=>true),
            array('full_name', 'match', 'pattern'=>'/^[a-zA-Z0-9\s]+$/'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'full_name' => 'Full Name',
            'role' => 'Role',
        );
    }

    public function search()
    {
        /** @var Account $model */
        $model = new Account();
        if($this->full_name!=null)
        {
            $model->full_name=$this->full_name;
        }
        if($this->role!= -1)
        {
            $model->role=$this->role;
        }
        return $model;
    }

}
