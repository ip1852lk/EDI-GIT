<?php

/**
 * This is the model class for table 'ar1_account_rep'.
 *
 * The followings are the available columns in table 'ar1_account_rep':
 * @property string $id
 * @property string $ar1_desc
 * @property string $us1_id
 * @property string $pl1_id
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Plant $plant
 * @property Profile $representative
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class AccountRep extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AccountRep the static model class
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
        return 'ar1_account_rep';
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
            array('us1_id', 'uniqueRepresentative', 'on' => 'insert, update'),
            array('us1_id, pl1_id', 'required', 'on' => 'insert, update'),
            array('delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('ar1_desc', 'length', 'max' => 250),
            array('us1_id, pl1_id, created_by, modified_by', 'length', 'max' => 20),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ar1_desc, us1_id, us1_search, pl1_id, pl1_search, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('us1_id', 'required', 'on' => 'relation', 'message' => Yii::t('app', '"Account Representative" is required.')),
        );
    }

    public function uniqueRepresentative($attribute)
    {
        if (isset($this->{$attribute}) && isset($this->pl1_id) && $this->pl1_id > 0) {
            if ($this->isNewRecord)
                $count = AccountRep::model()->count('t.us1_id=:us1_id AND t.pl1_id=:pl1_id', array(
                    ':us1_id' => $this->us1_id,
                    ':pl1_id' => $this->pl1_id,
                ));
            else
                $count = AccountRep::model()->count('t.id<>:id AND t.us1_id=:us1_id AND t.pl1_id=:pl1_id', array(
                    ':id' => $this->id,
                    ':us1_id' => $this->us1_id,
                    ':pl1_id' => $this->pl1_id,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', 'The account representative, ":us1_id", has already been registered on ":pl1_id".', array(
                    ':us1_id' => $this->representative->fullname,
                    ':pl1_id' => $this->plant->pl1_name,
                )));
        }
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
            'plant' => array(self::BELONGS_TO, 'Plant', 'pl1_id'),
            'representative' => array(self::BELONGS_TO, 'Profile', 'us1_id'),
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'ar1_desc' => Yii::t('app', 'Description'),
            'us1_id' => Yii::t('app', 'Representative'),
            'us1_search' => Yii::t('app', 'Representative'),
            'pl1_id' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']),
            'pl1_search' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = AccountRep::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.pl1_id,'. $alias . '.us1_id';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = AccountRep::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id',
                'together' => true,
                'with' => array('representative', 'plant', 'cprofile', 'mprofile',),
                'order' => 'plant.pl1_name, representative.first_name, representative.last_name',
            ),
        );
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
        $models = AccountRep::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) && isset($model->representative) && isset($model->plant))
                $rtv[$model->id] = '['.$model->plant.'] '.$model->representative->fullname;
        }
        return $rtv;
    }

    public $us1_search;
    public $pl1_search;
    public $cprofile_search;
    public $mprofile_search;

    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = AccountRep::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('representative', 'plant', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.ar1_desc', $this->ar1_desc, true);
        $criteria->compare($alias . '.us1_id', $this->us1_id);
        if (isset($this->us1_search) && strlen($this->us1_search)) {
            $criteria->addCondition('CONCAT(representative.first_name, " ", representative.last_name) LIKE :us1_search');
            $criteria->params = array_merge($criteria->params, array(':us1_search' => '%' . $this->us1_search . '%'));
        }
        $criteria->compare($alias . '.pl1_id', $this->pl1_id);
        if (isset($this->pl1_search) && strlen($this->pl1_search)) {
            $criteria->compare('plant.pl1_name', $this->pl1_search, true);
        }
        if (isset($this->created_on) && strlen($this->created_on) > 0) {
            $criteria->addCondition("$alias.created_on BETWEEN :created_on_1 AND :created_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':created_on_1' => date('Y-m-d', strtotime($this->created_on)).' 00:00:00',
                ':created_on_2' => date('Y-m-d', strtotime($this->created_on)).' 23:59:59',
            ));
        }
        if (isset($this->cprofile_search) && strlen($this->cprofile_search) > 0) {
            $criteria->addCondition('CONCAT(cprofile.first_name, " ", cprofile.last_name) LIKE :cprofile_search');
            $criteria->params = array_merge($criteria->params, array(':cprofile_search' => '%' . $this->cprofile_search . '%'));
        }
        if (isset($this->modified_on) && strlen($this->modified_on) > 0) {
            $criteria->addCondition("$alias.modified_on BETWEEN :modified_on_1 AND :modified_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':modified_on_1' => date('Y-m-d', strtotime($this->modified_on)).' 00:00:00',
                ':modified_on_2' => date('Y-m-d', strtotime($this->modified_on)).' 23:59:59',
            ));
        }
        if (isset($this->mprofile_search) && strlen($this->mprofile_search) > 0) {
            $criteria->addCondition("CONCAT(mprofile.first_name, ' ', mprofile.last_name) LIKE :mprofile_search");
            $criteria->params = array_merge($criteria->params, array(':mprofile_search' => '%' . $this->mprofile_search . '%'));
        }
       $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'us1_search' => array(
                        'asc' => 'representative.first_name, representative.last_name',
                        'desc' => 'representative.first_name DESC, representative.last_name DESC',
                    ),
                    'pl1_search' => array(
                        'asc' => 'plant.pl1_name',
                        'desc' => 'plant.pl1_name DESC',
                    ),
                    'cprofile_search' => array(
                        'asc' => 'cprofile.first_name, cprofile.last_name',
                        'desc' => 'cprofile.first_name DESC, cprofile.last_name DESC',
                    ),
                    'mprofile_search' => array(
                        'asc' => 'mprofile.first_name, mprofile.last_name',
                        'desc' => 'mprofile.first_name DESC, mprofile.last_name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => $pageSize<1000 ? array('pageSize' => $pageSize) : false,
        ));
    }

    /**
     * Export data into Excel, CVS or PDF
     * @param boolean $stream true - export without footprint, false - export with footprint
     */
    public function export($stream)
    {
        return Yii::app()->export->exportData($this, array(
            'dataProvider' => null, 
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => $stream,
            'fileName' => Yii::t('app', 'AccountRepresentative').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'pl1_search',
                    'label' => $this->getAttributeLabel('pl1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'plant->pl1_name',
                    'width' => 40,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'us1_search',
                    'label' => $this->getAttributeLabel('us1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'representative->fullname',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ar1_desc',
                    'label' => $this->getAttributeLabel('ar1_desc'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'created_by',
                    'label' => $this->getAttributeLabel('cprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('cprofile->first_name', 'cprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'created_on',
                    'label' => $this->getAttributeLabel('created_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_by',
                    'label' => $this->getAttributeLabel('mprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('mprofile->first_name', 'mprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_on',
                    'label' => $this->getAttributeLabel('modified_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }

}

