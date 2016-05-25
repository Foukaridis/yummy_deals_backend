<?php

class RegisterForm extends CFormModel
{
    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;

    public $username;
    public $email;
    public $newPass;
    public $confPass;

    public $full_name;
    public $phone;
    public $address;
    public $message;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // languageName are required
            array('address,phone,full_name,username, newPass, confPass,email', 'required'),
            // length of categoryName is 100 characters, categoryDesc 300 characters
            array('email', 'email'),
            array('username', 'length', 'max' => 30),
            array('username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'),
            array('newPass, confPass', 'length', 'max' => 30),
            array('confPass', 'compare', 'compareAttribute' => 'newPass'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('account', 'label.email'),
            'newPass' => Yii::t('account', 'label.newPass'),
            'confPass' => Yii::t('account', 'label.confNewPass'),
        );
    }


    public function save()
    {
        /* @var Account $model */
        $model = new Account();
        $model->id = DateTimeUtils::createInstance()->nowStr();
        $model->username = trim($this->username);
        $model->password = sha1($this->newPass);
        $model->email = $this->email;
        $model->role = 0;
        $model->status = 0;
        $model->full_name = $this->full_name;
        $model->address = $this->address;
        $model->phone = $this->phone;

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}