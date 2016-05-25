<?php

/**
 * This is the model class for table "feedback".
 *
 * The followings are the available columns in table 'feedback':
 * @property integer $id
 * @property integer $account_id
 * @property string $tittle
 * @property string $description
 * @property string $created
 * @property string $status
 * @property string $type
 * @property string $note
 */
class Feedback extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'feedback';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type,tittle, description', 'required'),
            array('id, account_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('type,note,tittle, description', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'account_id' => 'Account',
            'tittle' => 'Tittle',
            'description' => 'Description',
            'created' => 'Created',
            'status' => 'Status',
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

        if ($this->type == 'feedback') {
            $criteria->compare('type', 1);
        } elseif ($this->type == 'report') {
            $criteria->compare('type', 2);
        } else {
            $criteria->compare('type', 3);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('account_id', $this->account_id,true);
        $criteria->compare('tittle', $this->tittle, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Constants::SIZE_PER_PAGE,
            ),
        ));
    }

    public function searchByAccId($account_id)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('account_id', $account_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Feedback the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
