<?php
/**
 * Created by Lorge 
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:00 AM
 */

class Controller extends CController{
    public $breadcrumbs = array();
    public $menu = array();
    public $title = '';
    protected $appKey = '1db8fb72a473939e3f7a8b27a88b2f29a80b8fae';

    public $siteSetting = array();
    public $uploadFolder;

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF, // background color
                'foreColor' => 0xFF6600, // font color
                'transparent' => true, // background transparent
                'testLimit' => 1, // how many times should the same CAPTCHA be displayed
                'minLength' => 6, // min length of generated word
                'maxLength' => 7, // max length of generated word
                'width' => 100, // width of the CAPTCHA image
                'height' => 50, // height of the CAPTCHA image
                'offset' => 0, // space between characters
                'padding' => 4 // padding around the text
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    protected function beforeAction($action){
        $this->uploadFolder = Yii::getPathOfAlias(UPLOAD_DIR);
        return parent::beforeAction($action);
    }
}