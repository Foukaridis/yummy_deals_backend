<?php
/**
 * Created by Fruity Solution Co.Ltd
 *
 * User: Only Love.
 * Date: 12/4/13 - 3:45 PM
 */

class AdminForm extends CFormModel {
    const
        ERROR_NONE = 0,
        ERROR_EXISTS = 1,
        ERROR_DB = 2;
    public $adminId;
    public $adminName;
    public $adminEmail;
    public $adminOldPass;
    public $adminNewPass;
    public $adminConfPass;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // languageName are required
            array('adminName, adminOldPass, adminNewPass, adminConfPass,adminEmail', 'required'),
            // length of categoryName is 100 characters, categoryDesc 300 characters
            array('adminName', 'length', 'max'=>30),
            array('adminName', 'match', 'pattern'=>'/^[a-zA-Z0-9]+$/'),
            array('adminOldPass, adminNewPass, adminConfPass', 'length', 'max'=>30),
            array('adminConfPass', 'compare', 'compareAttribute'=>'adminNewPass'),
        );
    }

    public function attributeLabels(){
        return array(
            'adminName' => Yii::t('setting', 'label.adminName'),
            'adminEmail' => Yii::t('setting', 'label.adminEmail'),
            'adminOldPass' => Yii::t('setting', 'label.adminOldPass'),
            'adminNewPass' => Yii::t('setting', 'label.adminNewPass'),
            'adminConfPass' => Yii::t('setting', 'label.adminConfPass'),
        );
    }

    public function loadModel($id){
        /* @var Account $admin */
        $admin = Account::model()->findByPk($id);
        if($admin == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model = new AdminForm();
        $model->adminId = $admin->id;
        $model->adminName = $admin->username;
        $model->adminOldPass = $admin->password;
        $model->adminEmail = $admin->email;
        return $model;
    }

    public function update($id){
        /* @var Account $model */
        $model = Account::model()->findByPk($id);
        if($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model->username = trim($this->adminName);
        $model->password = sha1($this->adminNewPass);
        $model->email=$this->adminEmail;
//        $model->updated = DateTimeUtils::createInstance()->now();
        if($model->save()){
            return self::ERROR_NONE;
        }else{
            return self::ERROR_DB;
        }
    }
}