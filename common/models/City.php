<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property integer $cityId
 * @property string $cityPostCode
 * @property string $cityName
 */
class City extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'city';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cityPostCode, cityName', 'required'),
            array('cityPostCode', 'length', 'max' => 20),
            array('cityName', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cityId, cityPostCode, cityName', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'cityId' => 'City',
            'cityPostCode' => 'City Post Code',
            'cityName' => 'City Name',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('cityId', $this->cityId);
        $criteria->compare('cityPostCode', $this->cityPostCode, true);
        $criteria->compare('cityName', $this->cityName, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Constants::SIZE_PER_PAGE,
            ),
        ));
    }

    public function searchByName($name)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('cityName', $name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Constants::SIZE_PER_PAGE,
            ),
        ));
    }

    public function checkExistName($name, $currentName)
    {
        $flag = false;

        if ($currentName != null) {
            if ($name == $currentName)
                $flag = true;
        }

        if (!$flag) {
            $criteria = new CDbCriteria;
            //$criteria->compare('cityName', $name);
/*
            The default collation which MySQL uses to make comparisons is case insensitive .
            You need to specify a case sensitive collation or binary .
            You can either do this when creating the column, or in the query .

            For example:

            SELECT UserID FROM sys_users WHERE UserID = 'NREW' COLLATE latin1_bin
            The proper collation depends on your character set . For latin1, the default, you can use latin1_bin. For utf8, utf8_bin .
            SELECT UserID FROM sys_users WHERE BINARY UserID='NREW'
*/
            $criteria->addCondition('BINARY cityName = "'.$name.'"');
            return $this->count($criteria) > 0 ? true : false;
        }
        return false;
    }

    public function checkExistPostCode($name, $currentName)
    {
        $flag = false;
        if ($currentName != null) {
            if ($name == $currentName)
                $flag = true;
        }
        if (!$flag) {
            $criteria = new CDbCriteria;
            $criteria->compare('cityPostCode', $name);
            return $this->count($criteria) > 0 ? true : false;
        }
        return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return City the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
