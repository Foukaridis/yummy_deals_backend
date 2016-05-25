<?php
/**
 */

class SettingController extends Controller
{
    public $layout = Constants::LAYOUT_MAIN;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
            array('allow', // allow authentication user to perform 'languages', ...
                'actions' => array(
                    'adminAccount',
                    'settings',
                    'updateSetting',

                ),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    private function updateUpdateTime()
    {
        /* @var Settings $model */
        $model = Settings::model()->findByPk(1382069049);
        $model->setting_value = DateTimeUtils::createInstance()->nowStr();
        try {
            $model->save();
        } catch (Exception $e) {
            // Nothing to do
        }
    }

    public function actionAdminAccount()
    {
        $this->title = Yii::t('setting', 'title.adminAccount');

        /** @var AdminForm $model */
        $model = new AdminForm();
        $model = $model->loadModel('admin');

        $oldPassword = $model->adminOldPass;
        $model->adminOldPass = '';

        if (isset($_POST['AdminForm'])) {
            $model->attributes = $_POST['AdminForm'];
            if (sha1($model->adminOldPass) != $oldPassword || $model->adminNewPass != $model->adminConfPass) {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorOldPass'));
                $model = $model->loadModel('admin');
                $model->adminOldPass = '';
            } else {
                $result = $model->update('admin');
                if ($result === SettingForm::ERROR_NONE) {
                    $this->redirect(Yii::app()->createUrl('shop/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }

        $this->render('adminAccount', array(
            'model' => $model,
        ));
    }


    public function actionSettings()
    {
        $this->title = Yii::t('setting', 'title.settings');
        /** @var Settings $model */
        $model = new Settings;

        $this->render('settingAdmin', array(
            'model' => $model,
        ));
    }

    public function actionUpdateSetting()
    {
        $this->title = Yii::t('setting', 'title.updateSetting');

        $id = 1382069043;
        /** @var SettingForm $model */
        $model = new SettingForm;
        $model = $model->loadModel($id);

        if (isset($_POST['SettingForm'])) {
            $model->attributes = $_POST['SettingForm'];
            // Serialize settingData
            $model->settingData = CJSON::encode($_POST['SettingForm']['settingData']);

            $result = $model->update($id);
            if ($result === SettingForm::ERROR_NONE) {
                $this->redirect(Yii::app()->createUrl('setting/updateSetting'));
            } else {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
            }
        }

        $this->render('updateSetting', array(
            'model' => $model,
        ));
    }
}