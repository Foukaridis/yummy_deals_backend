<?php

class MailUtils {
    public static function createInstance(){
        return new MailUtils();
    }


    private function updateMailSetting(){
        /** @var Settings $systemMail */
        $systemMail = Settings::model()->find("setting_key = 'SYSTEM_EMAIL'");
        $systemMailData = CJSON::decode($systemMail->setting_data);

        Yii::app()->mail->getTransport()->setHost($systemMailData["host"]);
        Yii::app()->mail->getTransport()->setUsername($systemMailData["username"]);
        Yii::app()->mail->getTransport()->setPassword($systemMailData["password"]);
        Yii::app()->mail->getTransport()->setPort($systemMailData["port"]);
        Yii::app()->mail->getTransport()->setEncryption($systemMailData["encryption"]);
    }

    private function getYourMail(){
        $yourEmail = Settings::model()->find("setting_key = 'YOUR_EMAIL'");
        $yourEmailData = CJSON::decode($yourEmail->setting_data);
        return $yourEmailData["yourEmail"];
    }

    /**
     * @param string $email
     * @param Admin $admin
     * @param string $newPassword
     */

    public function sendMailToCustomerWhenReceived($order,$foodList){
        // Config system email
        $this->updateMailSetting();
        $account= Account::model()->findByPk($order->account_id);
        $message = new YiiMailMessage;
        //this points to the file providerRegister.php inside the view path
        $message->view = "sentToCustomerWhenReceived";
        $params = array('account' => $account,'order'=>$order,'foodList'=>$foodList);
        $message->subject = 'Multi Restaurants System : your order '.$order->order_id . ' is received';
        $message->setBody($params, 'text/html');
        $message->setTo($account->email);
        $message->from = Yii::app()->mail->getTransport()->getUsername();
        Yii::app()->mail->send($message);
    }

    public function sendMailToCustomerWhenReject($order,$foodList){
        // Config system email
        $this->updateMailSetting();
        $account= Account::model()->findByPk($order->account_id);
        $message = new YiiMailMessage;
        //this points to the file providerRegister.php inside the view path
        $message->view = "sentToCustomerWhenReject";
        $params = array('account' => $account,'order'=>$order,'foodList'=>$foodList);
        $message->subject = 'Multi Restaurants System : your order '.$order->order_id . ' is cancel';
        $message->setBody($params, 'text/html');
        $message->setTo($account->email);
        $message->from = Yii::app()->mail->getTransport()->getUsername();
        Yii::app()->mail->send($message);
    }

    public function sendMailToCustomerWhenReady($order,$foodList){
        // Config system email
        $this->updateMailSetting();
        $account= Account::model()->findByPk($order->account_id);
        $message = new YiiMailMessage;
        //this points to the file providerRegister.php inside the view path
        $message->view = "sentToCustomerWhenReady";
        $params = array('account' => $account,'order'=>$order,'foodList'=>$foodList);
        $message->subject = 'Multi Restaurants System : your order '.$order->order_id . ' is ready';
        $message->setBody($params, 'text/html');
        $message->setTo($account->email);
        $message->from = Yii::app()->mail->getTransport()->getUsername();
        Yii::app()->mail->send($message);
    }

    public function sendMailToShopOwner($order){
        // Config system email
        $this->updateMailSetting();
        $customer= Account::model()->findByPk($order->account_id);
        $owner= Account::model()->getAccountByShopID($order->shop_id);
        $shop=Shop::model()->findByPk($order->shop_id);
        $foodList=OrderFood::model()->getOrderFoodByOrder($order->order_id);
        $message = new YiiMailMessage;
//        var_dump($owner->email);die;
        //this points to the file providerRegister.php inside the view path
        $message->view = "sentToShopOwner";
        $params = array('owner'=>$owner,'customer' => $customer,'shop'=>$shop,'order'=>$order,'foodList'=>$foodList);
        $message->subject = 'Multi Restaurants System : your restaurant is received order : '.$order->order_id;
        $message->setBody($params, 'text/html');
        $message->setTo($owner->email);
        $message->from = Yii::app()->mail->getTransport()->getUsername();
        Yii::app()->mail->send($message);
    }

    public function sendMailToNewShopOwner($account,$type){
        if($account->role == Constants::ROLE_SHOP_OWNER)
        {
            $this->updateMailSetting();
            $message = new YiiMailMessage;
            $url = HOST_URL.'/'.'backend';
            $message->view = "sentToNewShopOwner";
            $params = array('account'=>$account,'url' => $url, 'type'=> $type);
            if($type == 'approve'){
                $message->subject = 'Multi Restaurants System : Your account has been upgraded to shop owner';
            }else{
                $message->subject = 'Multi Restaurants System : Your request has been rejected';
            }
            $message->setBody($params, 'text/html');
            $message->setTo($account->email);
            $message->from = Yii::app()->mail->getTransport()->getUsername();
            Yii::app()->mail->send($message);
        }

    }

    public function sendMailToNewUserFacebook($account){
            $this->updateMailSetting();
            $message = new YiiMailMessage;
            $url = HOST_URL.'/'.'backend';
            $message->view = "sentToNewUserFacebook";
            $params = array('account'=>$account,'url' => $url);
            $message->subject = "Multi Restaurants System: Password is generated";
            $message->setBody($params, 'text/html');
            $message->setTo($account->email);
            $message->from = Yii::app()->mail->getTransport()->getUsername();
            $check =  Yii::app()->mail->send($message);
        if($check){
            return "Good";
        }else{
            return "Xit";
        }
    }

    public function sendResetPasswordMail($admin,$email,$newPassword){
        // Config system email
        $this->updateMailSetting();
        $message = new YiiMailMessage;
        $url = HOST_URL.'/'.'backend';
        //this points to the file providerRegister.php inside the view path
        $message->view = "resetPassword";
        $params = array('username' => $admin->username,'newPassword'=>$newPassword,'url' => $url);
        $message->subject = Yii::t('setting', 'mail.resetPassword');
        $message->setBody($params, 'text/html');
        $message->setTo($email);
        $message->from = Yii::app()->mail->getTransport()->getUsername();
        Yii::app()->mail->send($message);
    }

     public function sendListEmailAddress($title,$content,$arrayAccount){
        $this->updateMailSetting();
        $message = new YiiMailMessage;
        $message->view = "sentMessage";

        foreach($arrayAccount as $account){
            $params = array('account'=>$account,'content' => $content);
            $message->subject = $title;
            $message->setBody($params, 'text/html');
            $message->setTo($account->email);
            $message->from = Yii::app()->mail->getTransport()->getUsername();
            Yii::app()->mail->send($message);
            //anti-spam
            sleep(5);
        }
    }

}