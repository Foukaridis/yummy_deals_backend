<?php

/**
 * Created by Lorge.
 * User: Only Love
 * Date: 12/27/13 - 9:31 AM
 */
class AccountController extends Controller
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
            array('allow',
                'actions' => array('index', 'create', 'update', 'delete', 'updateToShopOwner', 'export','sendEmail'),
                'expression' => 'Yii::app()->user->isAdmin()',
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('updateEmployee'),
                'expression' => 'Yii::app()->user->isShopOwner()',
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('updateMyAccount', 'updateMyPassword', 'viewOrder'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $inactiveRole = Constants::ROLE_ADMIN;

        $account = new Account('search');

        $account->unsetAttributes();
        if (isset($_GET['Account'])) {
            $account->attributes = $_GET['Account'];
        }

        $model = new Account();

        $roles = array();
        $roles[Constants::ROLE_CUSTOMER] = 'Customer';
        $roles[Constants::ROLE_SHOP_OWNER] = 'Shop Owner';
        $roles[Constants::ROLE_CHEF] = 'Chef';
        $roles[Constants::ROLE_DELIVERYMAN] = 'Delivery Man';
        $roles[Constants::ROLE_MODERATOR] = 'Moderator';

        $this->render('index', array(
            'model' => $model,
            'account' => $account,
            'roles' => $roles,
            'inactiveRole' => $inactiveRole,
        ));
    }

    public function actionViewOrder($id)
    {
        $model = new Orders();
        $model->unsetAttributes();
        $dataList = null;
        $dataList = $model->searchByUser($id);

        $this->render('viewOrder', array(
            'dataList' => $dataList,
        ));
    }


    public function actionCreate()
    {
        $model = new AccountForm();
        if (isset($_POST['AccountForm'])) {
            $model->attributes = $_POST['AccountForm'];
            if ($this->validateForm($model, true)) {
                if (isset($model->newPass) && $model->newPass != '') {
                    $model->oldPass = sha1($model->newPass);
                }
                if ($model->save()) {
                    $this->redirect(Yii::app()->createUrl('account/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }

        $roles = array();
        $roles[Constants::ROLE_SHOP_OWNER] = 'Shop Owner';
        $roles[Constants::ROLE_CUSTOMER] = 'Customer';

        $this->render('create', array(
            'model' => $model,
            'roles' => $roles
        ));

    }

    public function actionUpdate($id)
    {
        $model = new AccountForm();
        $model->loadModel($id);

        if (isset($_POST['AccountForm'])) {
            $model->attributes = $_POST['AccountForm'];
            if ($this->validateForm($model, false)) {
                if (isset($model->newPass) && $model->newPass != '') {
                    $model->oldPass = sha1($model->newPass);
                }
                if ($model->update($id)) {
                    $this->redirect(Yii::app()->createUrl('account/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }
        $roles = array();
        //$roles[Constants::ROLE_MODERATOR] = 'Moderator';
        $roles[Constants::ROLE_SHOP_OWNER] = 'Shop Owner';
        $roles[Constants::ROLE_CUSTOMER] = 'Customer';

        $this->render('update', array(
            'model' => $model,
            'roles' => $roles
        ));
    }

    public function actionUpdateEmployee($id)
    {
        $model = new AccountForm();
        $model->loadModel($id);

        $shopId = $model->shopId;

        $userId = Yii::app()->user->id;
        $shop = Shop::model()->findByPk($shopId);

        if ($userId != $shop->account_id)
            $this->redirect(Yii::app()->createUrl('error/errorPermission'));

        if (isset($_POST['AccountForm'])) {
            $model->attributes = $_POST['AccountForm'];
            if ($this->validateForm($model, false)) {
                if (isset($model->newPass) && $model->newPass != '') {
                    $model->oldPass = sha1($model->newPass);
                }
                if ($model->update($id)) {
                    $this->redirect(Yii::app()->createUrl('account/index'));
                } else {
                    Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
                }
            }
        }
        $roles = array();
        $roles[Constants::ROLE_MODERATOR] = 'Moderator';
        $roles[Constants::ROLE_CHEF] = 'Chef';
        $roles[Constants::ROLE_DELIVERYMAN] = 'Delivery Man';

        $this->render('updateEmployee', array(
            'model' => $model,
            'roles' => $roles
        ));
    }

    public function actionUpdateMyAccount($id)
    {
        $userId = Yii::app()->user->id;
        if ($userId != $id) {
            $this->redirect(Yii::app()->createUrl('error/errorPermission'));

        }
        $model = new MyAccountForm();
        $model->loadModel($id);

        if (isset($_POST['MyAccountForm'])) {
            $model->attributes = $_POST['MyAccountForm'];
            if ($model->update($id)) {
//                $this->redirect(Yii::app()->createUrl('account/index'));
            } else {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
            }
        }

        $this->render('updateMyAccount', array(
            'model' => $model,
        ));
    }

    public function actionUpdateMyPassword($id)
    {
        $model = new MyPasswordForm();
        $model->loadModel($id);

        if (isset($_POST['MyPasswordForm'])) {
            $model->attributes = $_POST['MyPasswordForm'];
            if ($model->update($id)) {
                $this->redirect(Yii::app()->createUrl('account/updateMyAccount', array('id' => $id)));
            } else {
                Yii::app()->user->setFlash('_error_', Yii::t('common', 'msg.errorSaveData'));
            }
        }

        $this->render('updateMyPassword', array(
            'model' => $model,
        ));
    }

    public function actionUpdateToShopOwner($id, $type)
    {
        $account = Account::model()->findByPk($id);
        if ($type == 'approve') {
            $account->role = Constants::ROLE_SHOP_OWNER;
            $account->save();
            Request::model()->deleteAll('user_id =' . $id);
        } else {
            Request::model()->deleteAll('user_id =' . $id);
        }
        MailUtils::createInstance()->sendMailToNewShopOwner($account, $type);
    }

    public function actionDelete($id)
    {
        /** @var Account $model */
        $model = Account::model()->findByPk($id);
        if ($model != null) {
            $model->status = 0;
            $model->save();
        }
        $this->redirect(Yii::app()->createUrl('account/index'));
    }

    public function validateForm($model, $isCreate)
    {
        /** @var AccountForm $model */
        if (Account::model()->checkExistUserName($model->username) && $isCreate) {
            Yii::app()->user->setFlash('_error_', 'User name is existed !');
            return false;
        } else if (isset($model->newPass) && $model->newPass != '') {
            if (strlen($model->newPass) < 6) {
                Yii::app()->user->setFlash('_error_', 'password need at less 6 characters !');
                return false;
            }
        } else {
            if ($isCreate) {
                Yii::app()->user->setFlash('_error_', 'password is not empty !');
                return false;
            }
        }
        return true;
    }

    public function actionExport()
    {
        ini_set("max_execution_time", 0);

        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);

        $page_size = 50;

        $dataProvider = $_SESSION['Place-excel'];

        $dataProvider->setPagination(false);
        $data = $dataProvider->getData();
        $count = $dataProvider->getTotalItemCount();
        //The total number of pages to calculate
        $page_count = (int)($count / $page_size) + 1;
        $current_page = 0;

        $n = 0;
        foreach ($data as $product) {
            if ($n % $page_size === 0) {
                $current_page = $current_page + 1;

                //The report output head
                $objectPHPExcel->getActiveSheet()->mergeCells('B1:H1');
                $objectPHPExcel->getActiveSheet()->setCellValue('B1', 'Account information sheet');
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setSize(24);
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('B1')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'Date:' . date("Y year m month J day"));
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'Page' . $current_page . '/' . $page_count . '');
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('H2')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                //Output table head
                $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'Id');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'User Name');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'Full name');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'Account Type');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'Email');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'Role');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'Status');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

                //Set center
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //Set the border
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')
                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                //Set the color
                $objectPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');

            }
            //Detailed output
            $objectPHPExcel->getActiveSheet()->setCellValue('B' . ($n + 4), $product->id);
            $objectPHPExcel->getActiveSheet()->setCellValue('C' . ($n + 4), $product->username);
            $objectPHPExcel->getActiveSheet()->setCellValue('D' . ($n + 4), $product->full_name);
            if ($product->type == Constants::ACCOUNT_NORMAL) {
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 4), Yii::t("account", "label.normal"));
            } else {
                $objectPHPExcel->getActiveSheet()->setCellValue('E' . ($n + 4), Yii::t("account", "label.facebook"));
            }
            $objectPHPExcel->getActiveSheet()->setCellValue('F' . ($n + 4), $product->email);
            $objectPHPExcel->getActiveSheet()->setCellValue('G' . ($n + 4), $product->getRoleName());
            if ($product->status == 0)
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . ($n + 4), "Deleted");
            else
                $objectPHPExcel->getActiveSheet()->setCellValue('H' . ($n + 4), "Active");


            //$objectPHPExcel->getActiveSheet()->setCellValue('Q'.($n+4) ,$memberName);

            //Set the border
            $currentRowNum = $n + 4;
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':H' . $currentRowNum)
                ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':H' . $currentRowNum)
                ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':H' . $currentRowNum)
                ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':H' . $currentRowNum)
                ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('B' . ($n + 4) . ':H' . $currentRowNum)
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $n = $n + 1;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="account.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function actionSendEmail(){
        $model = new EmailForm();
        $emailSender = new MailUtils();
        if (isset($_POST['EmailForm'])) {
            $model->attributes = $_POST['EmailForm'];
            $dataProvider = $_SESSION['Place-excel'];
            $dataProvider->setPagination(false);
            $listAccount = $dataProvider->getData();
            $emailSender->sendListEmailAddress($model->title,$model->content,$listAccount);
            $model->content = "";
            $model->title = "";
            $model->message = "Send mesage success";
            $this->render('sendEmail', array(
                'model' => $model,
            ));
        }else{
            $this->render('sendEmail', array(
                'model' => $model,
            ));
        }
    }

}