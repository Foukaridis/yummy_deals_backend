<?php
/**
 * Created by Fruity Solution Co.Ltd.
 * User: Only Love
 * Date: 11/15/13 - 10:40 PM
 * 
 * Please keep copyright headers of source code files when use it.
 * Thank you!
 */

class TaxShippingForm extends CFormModel{

    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;

    public $tax_rate;
    public $tax_status;

    public $shipping_rate;
    public $minimum;
    public $shipping_status;
    public $local_pickup;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('shipping_rate, tax_rate, minimum', 'required'),
            array('shipping_rate, tax_rate', 'numerical'),
            array('local_pickup, tax_status, shipping_status, minimum', 'numerical', 'integerOnly' => true),
            array('local_pickup, tax_status, shipping_status, minimum, shipping_rate', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */

    public function attributeLabels()
    {
        return array(
            'tax_rate'=>'Tax Rate',
            'tax_status'=>'Enable Tax',
            'shipping_rate'=>ucwords(str_replace('_',' ',Constants::FLAT_RATE)),
            'minimum'=>'Free Shipping Minimum Order Amount',
            'shipping_status'=>'Enable Shipping',
            'local_pickup'=>'Enable Local Pickup',
        );
    }

    public function loadModel($id){
        /* @var Shop $news */
        $news = Shop::model()->findByPk($id);
        if($news == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $tax=  CJSON::decode($news->tax);
        $shipping=  CJSON::decode($news->shipping);

        $model = new TaxShippingForm;
        $model->tax_rate = $tax[Constants::TAX_NAME];
        $model->tax_status = $tax['tax_status'];
        $model->shipping_rate = $shipping[Constants::FLAT_RATE];
        $model->minimum = $shipping['minimum'];
        $model->shipping_status = $shipping['shipping_status'];
        $model->local_pickup = $shipping['local_pickup'];

        return $model;
    }


    public function update($id){
        /* @var Shop $model */
        $news = Shop::model()->findByPk($id);
        if($news == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $tax=  CJSON::encode(array(
            Constants::TAX_NAME =>$this->tax_rate,
            'tax_status'=>$this->tax_status
        ));

        $shipping=  CJSON::encode(array(
            Constants::FLAT_RATE=>$this->shipping_rate,
            'minimum'=>$this->minimum,
            'local_pickup'=>$this->local_pickup,
            'shipping_status'=>$this->shipping_status
        ));
        $news->tax = $tax;
        $news->shipping = $shipping;
        if($news->save()){
            return self::ERROR_NONE;
        }else{
            return self::ERROR_DB;
        }
    }


}