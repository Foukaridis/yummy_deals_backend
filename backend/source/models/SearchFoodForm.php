<?php

/**
 * This is the form model class for table "location".
 *
 * The followings are the available columns in table 'location':
 */
class SearchFoodForm extends FormModel
{
    public $foodName;
    public $foodMenu;
    public $foodShop;
    public $dayStatus;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('foodName, foodMenu, foodShop,dayStatus', 'safe'),
            array('foodName', 'match', 'pattern' => '/^[a-zA-Z0-9\s]+$/'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'foodName' => 'menu name',
            'foodMenu' => 'category',
            'foodShop' => 'shop',
            'dayStatus' => 'Day status',
        );
    }

    public function search()
    {
        /** @var Food $model */
        $model = new Food();
        if ($this->foodName != null) {
            $model->food_name = $this->foodName;
        }
        if ($this->foodMenu != 0) {
            $model->food_menus = $this->foodMenu;
        }
        if ($this->foodShop != 0) {
            $model->shop_id = $this->foodShop;
        }
        if ($this->dayStatus != 2) {
            $model->status_in_day = $this->dayStatus;
        }

        return $model;
    }


}
