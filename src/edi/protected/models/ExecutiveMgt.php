<?php

/**
 * This is the model class for table 'em1_executive_mgt'.
 *
 * The followings are the available columns in table 'em1_executive_mgt':
 * @property string $id
 * @property string $em1_desc
 * @property string $us1_id
 * @property string $lo1_id
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Location $location
 * @property Profile $executive
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class ExecutiveMgt extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ExecutiveMgt the static model class
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
        return 'em1_executive_mgt';
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
            array('us1_id', 'uniqueExecutiveMgt', 'on' => 'insert, update'),
            array('us1_id, lo1_id', 'required', 'on' => 'insert, update'),
            array('delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('em1_desc', 'length', 'max' => 250),
            array('us1_id, lo1_id, created_by, modified_by', 'length', 'max' => 20),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, em1_desc, us1_id, us1_search, lo1_id, lo1_search, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('us1_id', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Executive Mgt. cannot be blank.')),
        );
    }

    public function uniqueExecutiveMgt($attribute)
    {
        if (isset($this->{$attribute}) && isset($this->lo1_id) && $this->lo1_id > 0) {
            if ($this->isNewRecord)
                $count = ExecutiveMgt::model()->count('t.us1_id=:us1_id AND t.lo1_id=:lo1_id', array(
                    ':us1_id' => $this->us1_id,
                    ':lo1_id' => $this->lo1_id,
                ));
            else
                $count = ExecutiveMgt::model()->count('t.id<>:id AND t.us1_id=:us1_id AND t.lo1_id=:lo1_id', array(
                    ':id' => $this->id,
                    ':us1_id' => $this->us1_id,
                    ':lo1_id' => $this->lo1_id,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', 'The executive manager, ":us1_id", has already been registered on ":lo1_id".', array(
                    ':us1_id' => $this->executive->fullname,
                    ':lo1_id' => $this->location->lo1_name,
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
            'location' => array(self::BELONGS_TO, 'Location', 'lo1_id'),
            'executive' => array(self::BELONGS_TO, 'Profile', 'us1_id'),
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
            'em1_desc' => Yii::t('app', 'Description'),
            'us1_id' => Yii::t('app', 'Executive'),
            'us1_search' => Yii::t('app', 'Executive'),
            'lo1_id' => Yii::t('app', 'Location'),
            'lo1_search' => Yii::t('app', 'Location'),
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
        $alias = ExecutiveMgt::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.lo1_id, ' . $alias . '.us1_id';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = ExecutiveMgt::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id',
                'together' => true,
                'with' => array('executive', 'location', 'cprofile', 'mprofile',),
                'order' => $alias . '.lo1_id, ' . $alias . '.us1_id',
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
        $models = ExecutiveMgt::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) && isset($model->executive))
                $rtv[$model->id] = $model->executive->fullname;
        }
        return $rtv;
    }

    public $us1_search;
    public $lo1_search;
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
        $alias = ExecutiveMgt::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('executive', 'location', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.em1_desc', $this->em1_desc, true);
        $criteria->compare($alias . '.us1_id', $this->us1_id);
        if (isset($this->us1_search) && strlen($this->us1_search) > 0) {
            $criteria->addCondition('CONCAT(executive.first_name, " ", executive.last_name) LIKE :us1_search');
            $criteria->params = array_merge($criteria->params, array(':us1_search' => '%' . $this->us1_search . '%'));
        }
        $criteria->compare($alias . '.lo1_id', $this->lo1_id);
        if (isset($this->lo1_search) && strlen($this->lo1_search) > 0) {
            $criteria->compare('location.lo1_name', $this->lo1_search, true);
        }
        if (isset($this->cprofile_search) && strlen($this->cprofile_search) > 0) {
            $criteria->addCondition('CONCAT(cprofile.first_name, " ", cprofile.last_name) LIKE :cprofile_search');
            $criteria->params = array_merge($criteria->params, array(':cprofile_search' => '%' . $this->cprofile_search . '%'));
        }
        if (isset($this->created_on) && strlen($this->created_on) > 0) {
            $criteria->addCondition("$alias.created_on BETWEEN :created_on_1 AND :created_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':created_on_1' => date('Y-m-d', strtotime($this->created_on)).' 00:00:00',
                ':created_on_2' => date('Y-m-d', strtotime($this->created_on)).' 23:59:59',
            ));
        }
        if (isset($this->mprofile_search) && strlen($this->mprofile_search) > 0) {
            $criteria->addCondition("CONCAT(mprofile.first_name, ' ', mprofile.last_name) LIKE :mprofile_search");
            $criteria->params = array_merge($criteria->params, array(':mprofile_search' => '%' . $this->mprofile_search . '%'));
        }
        if (isset($this->modified_on) && strlen($this->modified_on) > 0) {
            $criteria->addCondition("$alias.modified_on BETWEEN :modified_on_1 AND :modified_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':modified_on_1' => date('Y-m-d', strtotime($this->modified_on)).' 00:00:00',
                ':modified_on_2' => date('Y-m-d', strtotime($this->modified_on)).' 23:59:59',
            ));
        }
       $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'us1_search' => array(
                        'asc' => 'executive.first_name, executive.last_name',
                        'desc' => 'executive.first_name DESC, executive.last_name DESC',
                    ),
                    'lo1_search' => array(
                        'asc' => 'location.lo1_name',
                        'desc' => 'location.lo1_name DESC',
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
            'fileName' => Yii::t('app', 'ExecutiveMgt').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'lo1_search',
                    'label' => $this->getAttributeLabel('lo1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'location->lo1_name',
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'us1_search',
                    'label' => $this->getAttributeLabel('us1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'executive->fullname',
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'em1_desc',
                    'label' => $this->getAttributeLabel('em1_desc'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
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
            ),
        ));
    }

}

