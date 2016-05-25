<?php
/**
 * Created by Lorge 
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:00 AM
 */

class WebUser extends CWebUser {
    private $_model;

    public function init(){
        parent::init();
    }

    // Load user model.
    protected function loadUser($id = null)
    {
        if ($this->_model === null) {
            if ($id !== null)
                $this->_model = Account::model()->findByPk($id);
        }
        return $this->_model;
    }

    // Load user model.
    public function refreshUser($id = null)
    {
        if ($id !== null)
            $this->_model = Account::model()->findByPk($id);
    }



    // This is a function that checks the field 'role'
    // in the User model to be equal to 1, that means it's admin
    // access it by Yii::app()->user->isAdmin()
    function isAdmin()
    {
        $user = $this->getCurrentUser();
        if ($user != null) {
            return intval($user->role) == Constants::ROLE_ADMIN;
        } else {
            return false;
        }
    }

    // access it by Yii::app()->user->isClientAdmin()
    function isShopOwner()
    {
        $user = $this->getCurrentUser();
        if ($user != null) {
            return intval($user->role) == Constants::ROLE_SHOP_OWNER;
        } else {
            return false;
        }
    }
    function isEmployee()
    {
        $user = $this->getCurrentUser();
        if ($user != null) {
            if(intval($user->role) == Constants::ROLE_DELIVERYMAN or intval($user->role) == Constants::ROLE_CHEF)
                return true;
            else
                return false;
        } else {
            return false;
        }
    }
	function isModerator()
    {
        $user = $this->getCurrentUser();
        if ($user != null) {
            return intval($user->role) == Constants::ROLE_MODERATOR;
        } else {
            return false;
        }
    }
	function isCustomer()
    {
        $user = $this->getCurrentUser();
        if ($user != null) {
            if(intval($user->role) == Constants::ROLE_CUSTOMER)
                return true;
            else
                return false;
        } else {
            return false;
        }
    }
    // access it by Yii::app()->user->currentUser
    public function getCurrentUser()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user;
    }
	
}