<?php

class EmailForm extends CFormModel {
    public $title;
    public $content;
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
            array('title,content', 'required'),
            array('title', 'length', 'max'=>100),
        );
    }

    public function attributeLabels(){
        return array(
            'title' => Yii::t('account', 'label.title'),
            'content' => Yii::t('account', 'label.content'),
        );
    }
}