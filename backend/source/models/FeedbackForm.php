<?php

class FeedbackForm extends CFormModel
{
    public $id;
    public $account_id;
    public $tittle;
    public $description;
    public $create;
    public $status;
    public $type;
    public $note;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // languageName are required
            array('type,account_id, tittle, description, status', 'required'),
            // length of categoryName is 100 characters, categoryDesc 300 characters
            array('tittle', 'length', 'max' => 30),

            array('id,note', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'account_id' => Yii::t('feedback', 'label.username'),
            'tittle' => Yii::t('feedback', 'label.tittle'),
            'description' => Yii::t('feedback', 'label.description'),
        );
    }

    public function loadModel($id)
    {
        /* @var Feedback $model */
        $model = Feedback::model()->findByPk($id);
        if ($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));
        $this->id = $model->id;
        $this->account_id = $model->account_id;
        $this->tittle = $model->tittle;
        $this->description = $model->description;
        $this->status = $model->status;
        $this->note = $model->note;
        $this->type = $model->type;

    }

    public function save()
    {
        /* @var Feedback $model */
        $model = new Feedback();
        $model->account_id = Yii::app()->user->id;
        $model->tittle = trim($this->tittle);
        $model->description = $this->description;
        $model->status = 1;
        $model->created = DateTimeUtils::createInstance()->now();
        $model->note = $this->note;
        $model->type = $this->type;
        $result = $model->save();
        if (!$result) {
            return false;
        } else {
            $this->id = $model->id;
            return true;
        }
    }

    public function update($id)
    {
        var_dump($this);
        /* @var Feedback $model */
        $model = Feedback::model()->findByPk($id);
        if ($model == null) throw new CHttpException(400, Yii::t('common', 'msg.badRequest'));

        $model->tittle = trim($this->tittle);
        $model->description = $this->description;
        $model->status = $this->status;
        $model->note = $this->note;
        $model->type = $this->type;
//        $model->updated = DateTimeUtils::createInstance()->now();
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }
}