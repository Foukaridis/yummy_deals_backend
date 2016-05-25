<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'feedback':
 * @property integer $setting_id
 * @property string $setting_key
 * @property string $setting_value
 * @property string $setting_data
 * @property string $setting_bankinfo
 * @property string $setting_currency
 * @property string $location_latitude
 * @property string $location_longitude
 */
class Settings extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setting_id,location_latitude,location_longitude', 'required'),
			array('setting_id', 'numerical', 'integerOnly'=>true),
			array('setting_key', 'length', 'max'=>60),
			array('setting_currency', 'length', 'max'=>10),
			array('setting_value', 'length', 'max'=>255),
			array('setting_data, setting_currency, setting_bankinfo', 'safe'),
			// The following rule is used by search().
			array('setting_id, setting_key, setting_value, setting_data', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'setting_id' => 'Setting',
			'setting_key' => 'Setting Key',
			'setting_value' => 'Setting Value',
			'setting_data' => 'Setting Data',
            'setting_bankinfo'=> 'Setting Bank Information',
			'setting_currency'=> 'Currency'
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

		$criteria=new CDbCriteria;

		$criteria->compare('setting_id',$this->setting_id);
		$criteria->compare('setting_key',$this->setting_key,true);
		$criteria->compare('setting_value',$this->setting_value,true);
		$criteria->compare('setting_data',$this->setting_data,true);
        $criteria->compare('setting_bankinfo',$this->setting_data,true);
		$criteria->compare('setting_currency',$this->setting_currency,true);

        $criteria->order = 'setting_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function createCriteria($model = null){
        if($model==null) return new CDbCriteria;

        $criteria = new CDbCriteria;
        return $criteria;
    }
}
