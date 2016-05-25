<?php

/**
 * This is the model class for table "menus".
 *
 * The followings are the available columns in table 'menus':
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $menu_small_thumbnail
 * @property string $menu_desc
 * @property integer $parent_id
 * @property integer $lang
 * @property integer $status
 */
class Menu extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang,status', 'numerical', 'integerOnly'=>true),
			array('menu_name', 'length', 'max'=>200),
			array('menu_small_thumbnail', 'length', 'max'=>255),
			array('menu_desc', 'safe'),
			// The following rule is used by search().
			array('menu_id, menu_name, menu_small_thumbnail, menu_desc, lang, parent_id,status', 'safe', 'on'=>'search'),
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
			'menu_id' => 'Menu',
			'menu_name' => 'Menu Name',
			'menu_small_thumbnail' => 'Menu Small Thumbnail',
			'menu_desc' => 'Menu Desc',
            'parent_id' => 'Menu Parent',
            'status' => 'Status',
			'lang' => 'Lang',
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

		$criteria=new CDbCriteria;

		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('menu_small_thumbnail',$this->menu_small_thumbnail,true);
		$criteria->compare('menu_desc',$this->menu_desc,true);
        $criteria->compare('parent_id',$this->parent_id,true);
        $criteria->compare('status',$this->status);
		$criteria->compare('lang',$this->lang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => Constants::SIZE_PER_PAGE,
			),
            'sort' => array(
                'defaultOrder' => 'menu_name',
            ),
		));
	}

    public function checkExistName($name)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("BINARY menu_name = '$name'");
        return $this->count($criteria)>0;
    }

    public function searchByName($Name)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('menu_name',$Name,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'menu_name',
            ),
        ));
    }

    public function getListAllCategoryForUpDate($categoryId)
    {

        $criteria = new CDbCriteria;
        $criteria->addCondition('menu_id!='.$categoryId);

        return $this->findAll($criteria);
    }

    public function getChildMenusByParent($parentId)
    {

        $criteria = new CDbCriteria;
        $criteria->compare('parent_id',$parentId);

        return $this->findAll($criteria);
    }

    public function getListMenuByShop($shop_id)
    {
        $criteria=new CDbCriteria;
        $criteria->addCondition('menu_id IN (SELECT DISTINCT food_menus FROM food WHERE shop_id='.$shop_id.' and status=1)');
        return $this->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
