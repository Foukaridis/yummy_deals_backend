<?php

class AccountForm extends CFormModel {
    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;
    public $id;
    public $username;
    public $email;
    public $oldPass;
    public $newPass;
    public $confPass;
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
            // array('username', 'match', 'pattern'=>'/^[a-zA-Z0-9]+$/'),
            array('oldPass, newPass, confPass', 'length', 'max'=>30),
            array('confPass', 'compare', 'compareAttribute'=>'newPass'),
            array('role,shopId,status,id,phone,address,fullName,oldPass, newPass, confPass','safe'),
        );
    }

    public function attributeLabels(){
        return array(
            'username' => Yii::t('account', 'label.userName'),
            'email' => Yii::t('account', 'label.email'),
            'oldPass' => Yii::t('account', 'label.ldPass'),
            'newPass' => Yii::t('account', 'label.newPass'),
            'confPass' => Yii::t('account', 'label.confNewPass'),
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
        $this->oldPass = $account->password;
        $this->email = $account->email;
        $this->fullName=$account->full_name;
        $this->phone=$account->phone;
        $this->address=$account->address;
        $this->shopId=$account->shopId;
        $this->role=$account->role;
        $this->status=$account->status;

    }

    public function save(){
        /* @var Account $model */
        $model = new Account();
        $model->id=DateTimeUtils::createInstance()->nowStr();
        $model->username = trim($this->username);
        $model->password = $this->oldPass;
        $model->email=$this->email;
        $model->full_name=$this->fullName;
        $model->phone=$this->phone;
        $model->address=$this->address;
        $model->role=$this->role;
        $model->status=$this->status;

        if($model->save()){
            $this->id=$model->id;
            return true;
        }else{
            return false;
        }
    }

    public function update($id){
        /* @var Account $model */
        $model = Account::model()->findByPk($id);
        if($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model->username = trim($this->username);
        $model->password =$this->oldPass;
        $model->email=$this->email;
        $model->full_name=$this->fullName;
        $model->phone=$this->phone;
        $model->address=$this->address;
        $model->role=$this->role;
        $model->status=$this->status;
//        $model->updated = DateTimeUtils::createInstance()->now();
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}