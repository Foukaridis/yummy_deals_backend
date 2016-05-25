<?php
define ('DIRECTORY_SHOP', "shops");
define ('DIRECTORY_PROMOTION', "promotions");
define ('DIRECTORY_BANNER', "banners");
define ('DIRECTORY_MENU', "menus");
define ('DIRECTORY_FOOD', "foods");


if(!isset($root_dir)) $root_dir = dirname(dirname(dirname(dirname(dirname(__FILE__)))));

//config host
$host_name='http://friilance.co.za';
$site_base_url ='/yummydeals';
define ('HOST_URL', $host_name.$site_base_url);

Yii::setPathOfAlias('common', $root_dir . '/common/');
Yii::setPathOfAlias('backend', $root_dir . '/backend/source/');
// Config upload dirs file
Yii::setPathOfAlias('uploads', $root_dir . '/uploads/');
return CMap::mergeArray(
    require($root_dir . '/common/config/main.php'),
    array(
        'name' => 'Restaurant Backend',
        'basePath' => $root_dir . '/backend/source/',
        'runtimePath' => $root_dir . '/backend/source/runtime/',
        'defaultController' => 'site/login',
        'preload' => array('log'),
        'language' => 'en',
        'import' => array(
            'backend.components.*',
            'backend.controllers.*',
            'backend.models.*',
            'backend.libraries.*',
            'backend.messages.*',
        ),
        'components' => array(
            'assetManager'=>array(
                'basePath'=>$root_dir . '/backend/static/assets/',
                'baseUrl'=>$site_base_url.'/backend/static/assets/'
            ),
            'clientScript' => array(
                'coreScriptPosition'=>CClientScript::POS_END,
                'defaultScriptPosition'=>CClientScript::POS_END,
                'defaultScriptFilePosition'=>CClientScript::POS_END
            ),
            'user'=>array(
                'allowAutoLogin'=>true,
                'class' => 'backend.components.WebUser',
                'loginUrl'=>array('site/login'),
            ),
            'errorHandler' => array(
                'errorAction'=>'site/error'
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'caseSensitive' => true,
                'rules'=>array(
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                ),
                'showScriptName'=>false,
                'urlSuffix'=>'.html',
            ),
            'mail' => array(
                'viewPath' => 'backend.views.mail',
            ),
        ),
    ),
    (file_exists(dirname(__FILE__) . '/main-env.php') ? require(dirname(__FILE__) . '/main-env.php') : array()),
    (file_exists(dirname(__FILE__) . '/main-local.php') ? require(dirname(__FILE__) . '/main-local.php') : array())
);
