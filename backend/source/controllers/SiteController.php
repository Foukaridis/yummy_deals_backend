<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:13 AM
 */

class SiteController extends Controller
{

    public $layout = Constants::LAYOUT_LOGIN;
    public $dashboardAction = "shop/index";

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            // perform access control for CRUD operations
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login', 'register', 'error', 'getUrlImage', 'forgot', 'resetPassword'),
                'users' => array('*'),
            ),
            /*array('allow',
                'actions' => array('logout', 'image'),
                'expression' => '$user->isAdmin',
            ),*/
            array('allow',
                'actions' => array('logout', 'image'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

//    public static function allowOnlyOwner()
//    {
//        if (Yii::app()->user->isAdmin) {
//            return true;
//        } else {
//            $example = Products::model()->findByPk($_GET["id"]);
//            return $example->product_providers_id === Yii::app()->user->id;
//        }
//    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->layout = Constants::LAYOUT_ERROR;
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        if (!Yii::app()->user->isGuest) {
            if (property_exists(Yii::app()->user, 'returnUrl') && isset(Yii::app()->user->returnUrl) && Yii::app()->user->returnUrl != '/' && Yii::app()->returnUrl != 'site/login')
                $this->redirect(Yii::app()->user->returnUrl);
            else{
                if (Yii::app()->user->role == Constants::ROLE_ADMIN || Yii::app()->user->role == Constants::ROLE_SHOP_OWNER || Yii::app()->user->role == Constants::ROLE_MODERATOR)
                    $this->redirect(Yii::app()->createUrl($this->dashboardAction));
                else
                    $this->redirect(Yii::app()->createUrl('account/updateMyAccount', array('id'=>Yii::app()->user->id)));
            }
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                if (property_exists(Yii::app()->user, 'returnUrl') && isset(Yii::app()->user->returnUrl) && Yii::app()->user->returnUrl != '/' && Yii::app()->returnUrl != 'site/login')
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    if (Yii::app()->user->role == Constants::ROLE_ADMIN || Yii::app()->user->role == Constants::ROLE_SHOP_OWNER || Yii::app()->user->role == Constants::ROLE_MODERATOR)
                        $this->redirect(Yii::app()->createUrl($this->dashboardAction));
                    else
                        $this->redirect(Yii::app()->createUrl('account/updateMyAccount',array('id'=>Yii::app()->user->id)));

            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionRegister()
    {
        $model = new RegisterForm;
        if (isset($_POST['RegisterForm'])) {

            $model->attributes = $_POST['RegisterForm'];
            $account = Account::model()->findByAttributes(array('username' => $model->username));
            if ($account != null) {
                $model->addError('username', 'User name is existed !');
            } else {
                $account = Account::model()->findByAttributes(array('email' => $model->email));
                if ($account != null) {
                    $model->addError('email', 'Email is existed !');
                } else {
                    if ($model->save()) {
                        $model->addError('message', 'Register Success!');
                    }else{
                        $model->addError('message','Register Failed!');
                    }
                }
            }
        }
        $this->render('register', array('model' => $model));
    }


    public function actionForgot()
    {
        // display the login form
        $this->render('forgot');
    }

    public function actionResetPassword()
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!Account::model()->checkExistEmail($email)) {
                echo CJSON::encode(array(
                    'status' => 'ERROR',
                    'message' => 'User not exists!',
                ));
            } else {
                $newPassword = StringUtils::createInstance()->generateRandomString();
                $user = Account::model()->find("email ='" .$email."'" );
                if ($user != null) {
                    $user->password = StringUtils::createInstance()->hashStr($newPassword);
                    if ($user->save()) {
                        MailUtils::createInstance()->sendResetPasswordMail($user, $email, $newPassword);
                        echo CJSON::encode(array(
                            'status' => 'SUCCESS',
                            'message' => 'Your password is reset!',
                        ));
                    } else {
                        echo CJSON::encode(array(
                            'status' => 'ERROR',
                            'message' => 'Data can not be saved, please contact administrator',
                        ));
                    }
                } else {
                    echo CJSON::encode(array(
                        'status' => 'ERROR',
                        'message' => 'User not exists!',
                    ));
                }
            }
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionImage($id, $f, $t)
    {
        $imgFile = $this->uploadFolder . DIRECTORY_SEPARATOR . $t . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $f;
        if (file_exists($imgFile)) {
            $info = getimagesize($imgFile);
            header("Content-type: {$info['mime']}");
            readfile($imgFile);
        } else {
            $info = getimagesize($this->uploadFolder . DIRECTORY_SEPARATOR . Constants::NO_IMAGE);
            header("Content-type: {$info['mime']}");
            readfile($this->uploadFolder . DIRECTORY_SEPARATOR . Constants::NO_IMAGE);
        }
    }

    public static function actionGetUrlImage($id, $f, $t)
    {
        return HOST_URL . '/' . UPLOAD_DIR . '/' . $t . '/' . $id . '/' . $f;
    }

}