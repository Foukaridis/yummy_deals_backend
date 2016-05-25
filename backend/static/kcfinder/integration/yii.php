<?php
/**
 * set with your webroot application (this is not YII framework path)
 */
$yii_path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));

// -- main logic
$current_cwd = getcwd();
// we need ability to share SESSION between kcfinder and YII ?
chdir($yii_path);
// get current after change directory ...
$curr = getcwd();

// set $yii and $config path value
// THIS IS YII Framework directory, relative with your application. 
// For easier purpose, I just copy paste my code in index.php
// ---
$yii=$curr.'/common/lib/yii-1.1.14.f0fee9/framework/yii.php';

$config=$curr.'/backend/source/config/main.php';
if(!isset($site_base_url)) $site_base_url = '/jschm';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

Yii::createWebApplication($config);

/**
 * SET WITH YOUR VALUE ------------------------
 * decide your own PATH here
 * for description then you need to read kcfinder manual
 */
$uploadURL = $site_base_url.'/frontend/www';//Yii::app()->params['fileDownloadPath'];
$uploadDir = dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/frontend/www';//Yii::app()->params['fileDownloadPath'];

$session = new CHttpSession;
$session->setSavePath(Yii::app()->session->savePath);
$session->open();
$session['KCFINDER'] = array();
$session['KCFINDER'] = array(
    'disabled'=> false,//!UserIdentity::canBrowseServer(),
    'uploadURL'=> $uploadURL,
    'uploadDir'=>$uploadDir,
);
// then back to our path
chdir($current_cwd);

spl_autoload_unregister(array('YiiBase','autoload'));
spl_autoload_register('__autoload');
spl_autoload_register(array('YiiBase','autoload'));
?>