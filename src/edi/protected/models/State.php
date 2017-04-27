<?php

/**
 * This is the model class for table "st1_state".
 *
 * The followings are the available columns in table 'st1_state':
 * @property integer $id
 * @property string $st1_code
 * @property string $st1_name
 *
 * The followings are the available model relations:
 * @property Customer[] $customers
 * @property Supplier[] $suppliers
 * @property Facility[] $facilities
 * @property Profile[] $profiles
 */
class State extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return State the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * REQUIRED
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'st1_state';
    }

    /**
     * REQUIRED
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('st1_code, st1_name', 'required', 'on' => 'insert, update'),
            array('st1_code', 'length', 'max' => 10),
            array('st1_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, st1_code, st1_name', 'safe', 'on' => 'search'),
            // Rules for relations
            array('st1_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'State cannot be blank.')),
        );
    }

    /**
     * REQUIRED
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customers' => array(CActiveRecord::HAS_MANY, 'Customer', 'st1_id',),
            'suppliers' => array(CActiveRecord::HAS_MANY, 'Supplier', 'st1_id',),
            'facilities' => array(CActiveRecord::HAS_MANY, 'Facility', 'st1_id',),
            'profiles' => array(CActiveRecord::HAS_MANY, 'Profile', 'st1_id',),
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'st1_code' => 'State Code',
            'st1_name' => 'State Name',
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = State::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.st1_name';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = State::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.st1_code, ' . $alias . '.st1_name',
                'order' => $alias . '.st1_name',
            ),
        );
    }

    public function getFullName()
    {
        if (strlen($this->st1_code) > 0 && strlen($this->st1_name) > 0)
            //return $this->st1_name . ' - ' . $this->st1_code;
            return $this->st1_name;
        else
            return '';
    }

    /**
     * REQUIRED
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry if it is true
     * @return array
     */
    public static function getListData($criteria = null, $addEmptyItem = true)
    {
        if ($criteria === null) {
            $criteria = new CDbCriteria();
            $criteria->params = array();
        }
        $models = State::model()->relation()->cache(24 * 60 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->st1_name)) {
                $rtv[$model->id] = $model->st1_name;
            }
        }
        return $rtv;
    }

    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = State::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->compare($alias.'.st1_code', $this->st1_code, true);
        $criteria->compare($alias.'.st1_name', $this->st1_name, true);
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => $pageSize<1000 ? array('pageSize' => $pageSize) : false,
        ));
    }

}
