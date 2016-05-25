<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'admin':
 * @property string $id
 * @property integer $type
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $role
 * @property integer $shopId
 * @property string $full_name
 * @property string $address
 * @property string $phone
 * @property integer $status
 * @property Request $request
 */
class Account extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'account';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role,status', 'numerical', 'integerOnly' => true),
            array('id, username, password, email, role', 'required'),
            array('username', 'unique', 'message' => 'This user\'s name already exists'),
            array('email', 'unique', 'message' => 'This email already exists'),
            array('id, username', 'length', 'max' => 30),
            array('password', 'length', 'max' => 60),
            array('email', 'length', 'max' => 100),
            array('email', 'email'),
            array('status, role', 'length', 'max' => 1),
            array('phone', 'length', 'max' => 30),
            array('full_name', 'length', 'max' => 150),
            array('address', 'length', 'max' => 300),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password,email,role,status,shopId,full_name, address, phone', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'request' => array(self::HAS_ONE, 'Request', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'shopId' => 'Shop',
            'status' => 'Status',
            'full_name' => 'Full Name',
            'address' => 'Address',
            'phone' => 'Phone',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($inactiveRole = null)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('shopId', $this->shopId);
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('status', $this->status);

        if ($inactiveRole != null)
            $criteria->addCondition('role != ' . $inactiveRole);

        //Start for excel
        $data = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
        //End for excel
        $_SESSION['Place-excel'] = $data;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Constants::SIZE_PER_PAGE,
            ),
        ));
    }

    public function searchShopCustomer($shopId)
    {
        $customers = UserShop::model()->findAll('shopId =' . $shopId);
        $customerIds = array();
        foreach ($customers as $single) {
            $customerIds[] = $single->accountId;
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition("id", $customerIds);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByShop($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('id IN (SELECT DISTINCT account_id FROM orders WHERE STATUS=1)');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchEmployee($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('shopId =' . $shopId);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }


    public function searchByModel()
    {
        $criteria = new CDbCriteria;
        if ($this->full_name != null)
            $criteria->addSearchCondition('full_name', $this->full_name);
        if ($this->role != null)
            $criteria->compare('role', $this->role, true);
        else
            $criteria->addInCondition('role', array(Constants::ROLE_CHEF, Constants::ROLE_DELIVERYMAN, Constants::ROLE_MODERATOR));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));

    }

    public function checkExistEmail($email)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('email', $email);
        return $this->count($criteria) > 0;
    }

    public function getAccountByEmail($email)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('email', $email);
        return $this->find($criteria);
    }

    public function checkExistUserName($userName)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('username', $userName);
        return $this->count($criteria) > 0;
    }

    public function getAccount($userName, $pass)
    {
        $criteria = new CDbCriteria;
//        $criteria->condition = "(username LIKE :username AND password LIKE :password)
//        OR (email LIKE :email AND type LIKE :type)";
//        $criteria->params = array(
//            ':username' => $userName,
//            ':password' => $pass,
//            ':email' => $userName,
//            ':type' => Constants::ACCOUNT_FACEBOOK);
        $criteria->compare('username', $userName);
        $criteria->compare('password', $pass);
        return $this->find($criteria);
    }

    public function getListAccountRoleOwnerAndNoShop()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('id NOT IN (SELECT DISTINCT account_id FROM location) AND role=1');
        $criteria->compare('status', 1);

        return $this->findAll($criteria);
    }

    public function getAccountByShopID($shopId)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('id IN (SELECT DISTINCT account_id FROM location where location_id=' . $shopId . ')');
        $criteria->compare('status', 1);

        return $this->find($criteria);
    }

    public function getListAccountRoleOwner()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('role=1');
        $criteria->compare('status', 1);

        return $this->findAll($criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Account the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function getRole($role = FALSE)
    {
        if ($role === FALSE) {
            $role = $this->role;
        }
        $str = array(
            Constants::ROLE_CHEF => '<span class="label label-default" style="font-size: 90%;">Chef</span>',
            Constants::ROLE_DELIVERYMAN => '<span class="label label-success" style="font-size: 90%;">Delivery Man</span>',
            Constants::ROLE_MODERATOR => '<span class="label label-warning" style="font-size: 90%;">Moderator</span>',
            Constants::ROLE_CUSTOMER => '<span class="label label-info" style="font-size: 90%;">Customer</span>',
            Constants::ROLE_SHOP_OWNER => '<span class="label label-danger" style="font-size: 90%;">Shop Owner</span>',
            Constants::ROLE_ADMIN => '<span class="label label-danger" style="font-size: 90%;">Admin</span>',
        );
        return isset($str[$role]) ? $str[$role] : '';
    }

    public function getName($accountId)
    {
        $account = $this->findByPk($accountId);
        return isset($account) ? $account->full_name : '';
    }

    public function getRoleName($role = FALSE)
    {
        if ($role === FALSE) {
            $role = $this->role;
        }
        $str = array(
            Constants::ROLE_CHEF => 'Chef',
            Constants::ROLE_DELIVERYMAN => 'Delivery Man',
            Constants::ROLE_MODERATOR => 'Moderator',
            Constants::ROLE_CUSTOMER => 'Customer',
            Constants::ROLE_SHOP_OWNER => 'Shop Owner',
            Constants::ROLE_ADMIN => 'Admin',
        );
        return isset($str[$role]) ? $str[$role] : '';
    }

    public function getCustomInformation($data)
    {
        $cuongden = json_decode($data->data_custom, TRUE);
        $trmp = '';
        if (is_array($cuongden)) {
            foreach ($cuongden as $key1 => $value1) {
                $trmp .= CustomField::model()->getNameById($key1).":".$value1."<br/>";
            }
        }
        return $trmp;
    }

}
