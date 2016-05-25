<?php


class FoodForm extends FormModel
{
    public $food_id;
    public $food_code;
    public $food_name;
    public $food_price;
    public $food_shop_id;
    public $food_description;
    public $food_menu;
    public $status_in_day;
    public $food_image;
    public $status;
    public $food_current_code;
    public $foodNewImage;
    public $available;
    public $rate;
    public $rate_times;
	
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('food_name,food_code, food_description,food_menu,food_image,food_shop_id,food_price,status_in_day,status, available', 'required'),
            array('food_name', 'length', 'max' => 200),
            array('food_name', 'match', 'pattern'=>'/^[a-zA-Z0-9\s,.]+$/','message'=>'menu name is invalid !'),
            array('food_code', 'length', 'max' => 20),
            array('food_code', 'match', 'pattern'=>'/^[a-zA-Z0-9]+$/','message'=>'menu code is invalid !'),
            array('food_price', 'match', 'pattern'=>'/^[0-9,.]+$/','message'=>'menu price is not number !'),
            array('food_image', 'length', 'max' => 225),
            array('foodNewImage', 'file', 'allowEmpty'=>true, 'types'=>'jpg, png'),
            array('foodNewImage', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'food_id' => Yii::t('food', 'label.foodId'),
            'food_code' => Yii::t('food', 'label.foodCode'),
            'food_name' => Yii::t('food', 'label.foodName'),
            'food_description' => Yii::t('food', 'label.foodDesc'),
            'food_menu' => Yii::t('food', 'label.foodMenu'),
            'food_image' => Yii::t('food', 'label.foodImage'),
            'food_price' => Yii::t('food', 'label.foodPrice'),
            'status_in_day' => Yii::t('food', 'label.dayStatus'),
            'status' => Yii::t('food', 'label.status'),
            'available' => Yii::t('food', 'label.available'),
            'rate' => Yii::t('shop', 'label.rate'),
            'rate_times' => Yii::t('shop', 'label.rateTimes'),
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Food $model */
        $model = Food::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $this->food_id = $model->food_id;
        $this->food_code = $model->food_code;
        $this->food_current_code = $model->food_code;
        $this->food_name = $model->food_name;
        $this->food_price = round($model->food_price, 2);
        $this->food_description = $model->food_desc;
        $this->food_image = $model->food_thumbnail;
        $this->food_menu = $model->food_menus;
        $this->status_in_day = $model->status_in_day;
        $this->food_shop_id = $model->shop_id;
        $this->status = $model->status;
        $this->available = $model->available;
        $this->rate = $model->rate;
        $this->rate_times = $model->rate_times;
    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var Food $model */
        $model = new Food();
        $model->unsetAttributes();

        $model->food_name = $this->food_name;
        $model->food_code = $this->food_code;
        $model->food_price = round($this->food_price, 2);
        $model->food_desc = $this->food_description;
        $model->food_menus = $this->food_menu;
        $model->food_thumbnail = $this->food_image;
        $model->shop_id = $this->food_shop_id;
        $model->status_in_day = $this->status_in_day;
        $model->status = $this->status;
        $model->available = $this->available;
        $model->rate = $this->rate;
        $model->rate_times = $this->rate_times;
//        var_dump($model);
//        die;

        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->food_id = $model->food_id;
            return true;
        }

    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Food $model */
        $model = Food::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->food_code = $this->food_code;
        $model->food_name = $this->food_name;
        $model->food_price = round($this->food_price, 2);
        $model->food_desc = $this->food_description;
        $model->food_menus = $this->food_menu;
        $model->food_thumbnail = $this->food_image;
        $model->shop_id = $this->food_shop_id;
        $model->status_in_day = $this->status_in_day;
        $model->status = $this->status;
        $model->available = $this->available;
        $model->rate = $this->rate;
        $model->rate_times = $this->rate_times;
		
        $result = $model->save();
        if (!$result) {
            return false;
        }
        return true;
    }
}