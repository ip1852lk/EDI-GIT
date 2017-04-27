<?php

/**
 * This is the model class for table "yii_table_log".
 *
 * The followings are the available columns in table 'yii_table_log':
 * @property integer $id
 * @property integer $log_action
 * @property string $model
 * @property string $model_id
 * @property string $description
 * @property integer $created_by
 * @property string $created_on
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag
 *
 * The followings are the available model relations:
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class TableLog extends JActiveRecord
{

    const LOG_ACTION_CREATE = 1;
    const LOG_ACTION_UPDATE = 2;
    const LOG_ACTION_DELETE = 3;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TableLog the static model class
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
        return 'yii_table_log';
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
            array('model, model_id, log_action', 'required', 'on' => 'insert, update'),
            array('log_action, created_by, modified_by, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('model, model_id', 'length', 'max' => 45),
            array('description, modified_on', 'safe'),
            array('created_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('created_on', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'insert'),
            array('modified_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('modified_on', 'default', 'value' => '0000-00-00 00:00:00', 'on' => 'insert'),
            array('modified_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'update'),
            array('modified_on', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, log_action, model_search, model, model_id, description, created_on, cprofile_search, created_by, mprofile_search, modified_by, modified_on, delete_flag, update_flag', 'safe', 'on' => 'search'),
            // Rules for relations
            array('model, model_id, log_action', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Change Log cannot be blank.')),
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
            'log_action' => Yii::t('app', 'Log Action'),
            'model_search' => Yii::t('app', 'Model'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model PK'),
            'description' => Yii::t('app', 'Description'),
            'created_by' => Yii::t('app', 'Changed By'),
            'cprofile_search' => Yii::t('app', 'Changed By'),
            'created_on' => Yii::t('app', 'Changed On'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'logActions' => array(
                self::LOG_ACTION_CREATE => Yii::t('app', 'Create'),
                self::LOG_ACTION_UPDATE => Yii::t('app', 'Update'),
                self::LOG_ACTION_DELETE => Yii::t('app', 'Delete'),
            ),
            'logActionsForSearch' => array(
                '' => '',
                self::LOG_ACTION_CREATE => Yii::t('app', 'Create'),
                self::LOG_ACTION_UPDATE => Yii::t('app', 'Update'),
                self::LOG_ACTION_DELETE => Yii::t('app', 'Delete'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = TableLog::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.created_on DESC';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Supplier::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
        );
    }

    public $model_search;
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
        $alias = TableLog::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('cprofile', 'mprofile',);
        $criteria->compare($alias.'.log_action', $this->log_action, true);
        $criteria->compare($alias.'.model', $this->model);
        if (isset($this->model_search) && strlen($this->model_search) > 0) {
            $criteria->addInCondition($alias.'.model', array_map('trim', explode(',', $this->model_search)));	
        }
        $criteria->compare($alias.'.model_id', $this->model_id);
        $criteria->compare($alias.'.description', $this->description, true);
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
                    'model_search' => array(
                        'asc' => $alias.'.model',
                        'desc' => $alias.'.model DESC',
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
            'fileName' => Yii::t('app', 'Change-Logs').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
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
                    'field' => 'cprofile_search',
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
                    'field' => 'log_action',
                    'label' => $this->getAttributeLabel('log_action'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'itemAlias' => array('class' => 'TableLog', 'type' => 'logActions'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'description',
                    'label' => $this->getAttributeLabel('description'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => 'str_replace(array(\'<span class="label label-primary">\', \'<span class="badge alert-danger">\', \'<span class="badge alert-success">\', "</span>", "<br>"), array("", "", "", "", "\n"), $value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }
    
}
