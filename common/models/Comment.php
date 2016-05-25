<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property integer $location_id
 * @property integer $food_id
 * @property string $account_id
 * @property string $title
 * @property string $content
 * @property double $rate
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Shop $shop
 * @property Food $food
 */
class Comment extends CActiveRecord
{
	public $food_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location_id, food_id, account_id, title, content, rate, created', 'required'),
			array('location_id, food_id', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('account_id', 'length', 'max'=>30),
			array('title', 'length', 'max'=>200),
			array('content', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, location_id, food_id, account_id, title, content, rate, created', 'safe', 'on'=>'search'),
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
			'shop' => array(self::BELONGS_TO, 'Shop', 'location_id'),
			'food' => array(self::BELONGS_TO, 'Food', 'food_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'location_id' => 'Location',
			'food_id' => 'Food',
			'account_id' => 'Account',
			'title' => 'Title',
			'content' => 'Content',
			'rate' => 'Rate',
			'created' => 'Created',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('location_id',$this->location_id);
		$criteria->compare('food_id',$this->food_id);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('created',$this->created,true);



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function updateCommentCount($location_id, $food_id)
	{
		Constants::updateObjectRate($food_id,Constants::TYPE_FOOD);
		Constants::updateObjectRate($location_id,Constants::TYPE_SHOP);

	}
}
