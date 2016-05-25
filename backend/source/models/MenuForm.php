<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class MenuForm extends FormModel
{
    public $menu_id;
    public $menu_name;
    public $menu_small_thumbnail;
    public $menu_description;
    public $parent_id;
    public $status;
    public $menuNewThumb;
    public $menuOldName;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menu_name, menu_small_thumbnail, menu_description,parent_id,status', 'required'),
            array('menu_name', 'length', 'max' => 200),
            array('menu_small_thumbnail', 'length', 'max' => 255),
            array('menuNewThumb', 'file', 'allowEmpty'=>true, 'types'=>'jpg, png'),
            array('menu_description,menuNewThumb', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'menu_name' => Yii::t('menu', 'label.menuName'),
            'menu_description' => Yii::t('menu', 'label.menuDes'),
            'menu_small_thumbnail' => Yii::t('menu', 'label.menuImage'),
            'parent_id' => Yii::t('menu', 'label.menuParent'),
            'status' => Yii::t('menu', 'label.status'),
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Menu $model */
        $model = Menu::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->menu_id = $model->menu_id;
        $this->menu_name = $model->menu_name;
        $this->menuOldName = $model->menu_name;
        $this->menu_description = $model->menu_desc;
        $this->menu_small_thumbnail = $model->menu_small_thumbnail;
        $this->parent_id = $model->parent_id;
        $this->status = $model->status;
    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var Menu $model */
        $model = new Menu();
        $model->menu_name = $this->menu_name;
        $model->menu_small_thumbnail = $this->menu_small_thumbnail;
        $model->menu_desc = $this->menu_description;
        $model->parent_id = $this->parent_id;
        $model->status = $this->status;
        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->menu_id = $model->menu_id;
            return true;
        }
    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Menu $model */
        $model = Menu::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->menu_name = $this->menu_name;
        $model->menu_small_thumbnail = $this->menu_small_thumbnail;
        $model->menu_desc = $this->menu_description;
        $model->parent_id = $this->parent_id;
        $model->status = $this->status;
        $result = $model->save();
        if (!$result)
            return false;
        return true;
    }

}