<?php
/**
 * Created by 
 *
 * User: Only Love.
 * Date: 11/29/13 - 4:22 PM
 */

class ActiveRecord extends CActiveRecord{
    protected function createCriteria($model){
        return new CDbCriteria;
    }

    public function selectCount($model = null){
        $criteria = $this->createCriteria($model);
        return $this->count($criteria);
    }

    public function select($model = null){
        $criteria = $this->createCriteria($model);
        return $this->find($criteria);
    }

    public function selectList($model = null){
        $criteria = $this->createCriteria($model);
        return $this->findAll($criteria);
    }

    public function deleteList(){
        $criteria = $this->createCriteria($this);
        return $this->deleteAll($criteria);
    }

    public function selectDistinct($model = null, $fieldName){
        $criteria = $this->createCriteria($model);
        $criteria->distinct = true;
        $criteria->group = $fieldName;
        return $this->findAll($criteria);
    }
}