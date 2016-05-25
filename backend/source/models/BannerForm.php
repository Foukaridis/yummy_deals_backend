<?php

/**
 * This is the form model class for table "category".
 *
 * The followings are the available columns in table 'category':
 */
class BannerForm extends FormModel
{
    public $bannerId;
    public $bannerName;
    public $bannerImage;
    public $shopId;
    public $status;
    public $bannerNewThumb;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bannerName, bannerImage,shopId, status', 'required'),
            array('bannerName,bannerImage', 'length', 'max' => 100),
            array('bannerName', 'match', 'pattern'=>'/^[a-zA-Z0-9\s,.]+$/'),
            array('bannerNewThumb', 'file', 'allowEmpty'=>true, 'types'=>'jpg, png'),
            array('bannerNewThumb', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bannerId' => Yii::t('banner','label.bannerId'),
            'shopId' => Yii::t('banner','label.bannerShop'),
            'bannerName' => Yii::t('banner','label.bannerName'),
            'bannerImage' => Yii::t('banner','label.bannerImage'),
            'status' => 'Status',
        );
    }

    /**
     * Create instance form $id of model
     */
    public function loadModel($id)
    {
        /** @var Banner $model */
        $model = Banner::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));
        $this->bannerId = $model->bannerId;
        $this->bannerName = $model->bannerName;
        $this->bannerImage = $model->bannerImage;
        $this->shopId = $model->shopId;
        $this->status = $model->status;
    }

    /**
     * Save to database
     */
    public function save()
    {
        /** @var Banner $model */
        $model = new Banner();
        $model->bannerName = $this->bannerName;
        $model->bannerImage = $this->bannerImage;
        $model->shopId = $this->shopId;
        $model->status = $this->status;
        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->bannerId = $model->bannerId;
            return true;
        }
    }

    /**
     * Save to database
     */
    public function update($id)
    {
        /** @var Banner $model */
        $model = Banner::model()->findByPk($id);
        if ($model == null) throw new CException(404, Yii::t('common', 'msg.canNotFoundResource'));

        $model->bannerName = $this->bannerName;
        $model->bannerImage = $this->bannerImage;
        $model->shopId = $this->shopId;
        $model->status = $this->status;
        $result = $model->save();
        if (!$result)
            return false;
        return true;
    }
}