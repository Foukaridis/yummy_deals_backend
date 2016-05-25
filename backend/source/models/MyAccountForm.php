<?php

class MyAccountForm extends CFormModel {
    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;
    public $id;
    public $username;
    public $email;
    public $role;
    public $shopId;
    public $fullName;
    public $phone;
    public $address;
    public $status;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // languageName are required
            array('username,email', 'required'),
            // length of categoryName is 100 characters, categoryDesc 300 characters
            array('username', 'length', 'max'=>30),
            array('username', 'match', 'pattern'=>'/^[a-zA-Z0-9]+$/'),
            array('role,shopId,status,id,phone,address,fullName','safe'),
        );
    }

    public function attributeLabels(){
        return array(
            'username' => Yii::t('account', 'label.username'),
            'email' => Yii::t('account', 'label.email'),
            'role' => Yii::t('account', 'label.role'),
            'shopId' => Yii::t('account', 'label.shop'),
            'status' => Yii::t('account', 'label.status'),
            'address' => Yii::t('account', 'label.address'),
            'phone' => Yii::t('account', 'label.phone'),
            'fullName' => Yii::t('account', 'label.fullName'),
        );
    }

    public function loadModel($id){
        /* @var AccountForm $model */
        $account = Account::model()->findByPk($id);
        if($account == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $this->id = $account->id;
        $this->username = $account->username;
        $this->email = $account->email;
        $this->fullName=$account->full_name;
        $this->phone=$account->phone;
        $this->address=$account->address;
        $this->shopId=$account->shopId;
        $this->role=$account->role;
        $this->status=$account->status;

    }

    public function update($id){
        /* @var Account $model */
        $model = Account::model()->findByPk($id);
        if($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model->full_name=$this->fullName;
        $model->phone=$this->phone;
        $model->address=$this->address;
//        $model->updated = DateTimeUtils::createInstance()->now();
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}