<?php
/**
 * Created by Fruity Solution Co.Ltd
 *
 * User: Only Love.
 * Date: 12/3/13 - 5:13 PM
 */
class LanguageBehavior extends CBehavior {
    // The attachEventHandler() mathod attaches an event handler to an event.
    // So: onBeginRequest, the handleLanguageRequest() method will be called.
    public function attach($owner) {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleLanguageRequest'));
    }

    public function handleLanguageRequest($event) {
        $app = Yii::app();
        if (isset($_POST['_lang']))
        {
            $app->language = $_POST['_lang'];
            $app->user->setState('_lang', $_POST['_lang']);
            $cookie = new CHttpCookie('_lang', $_POST['_lang']);
            $cookie->expire = time() + (60*60*24*30); // (1 month)
            Yii::app()->request->cookies['_lang'] = $cookie;
        }
        else if ($app->user->hasState('_lang'))
            $app->language = $app->user->getState('_lang');
        else if(isset(Yii::app()->request->cookies['_lang']))
            $app->language = Yii::app()->request->cookies['_lang']->value;
    }
}