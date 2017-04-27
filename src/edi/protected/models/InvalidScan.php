<?php

/**
 * This is the model class for table 'is1_invalid_scan'.
 *
 * The followings are the available columns in table 'is1_invalid_scan':
 * @property string $id
 * @property integer $is1_error_code
 * @property string $us1_id
 * @property string $cu1_id
 * @property integer $or1_type
 * @property string $contract_bin_id
 * @property double $or2_scanned_qty
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Profile $user
 * @property Customer $customer
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class InvalidScan extends JActiveRecord
{

    const ERROR_UNKNOWN_BIN = 1;
    const ERROR_INVALID_QTY = 2;
    const ERROR_DUPLICATE_SCAN = 3;

    const TYPE_REPLENISHMENT = 1;
    const TYPE_PART_CONSUMPTION = 2;
    const TYPE_RECEIVING = 3;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvalidScan the static model class
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
        return 'is1_invalid_scan';
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
            array('is1_error_code, or1_type, us1_id, cu1_id, contract_bin_id', 'required', 'on' => 'insert, update'),
            array('is1_error_code', 'in', 'range' => array(self::ERROR_UNKNOWN_BIN, self::ERROR_INVALID_QTY, self::ERROR_DUPLICATE_SCAN)),
            array('or1_type', 'in', 'range' => array(self::TYPE_REPLENISHMENT, self::TYPE_PART_CONSUMPTION, self::TYPE_RECEIVING)),
            array('is1_error_code, or1_type, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('or2_scanned_qty', 'numerical'),
            array('us1_id, cu1_id, created_by, modified_by', 'length', 'max' => 20),
            array('contract_bin_id', 'length', 'max' => 255),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, is1_error_code, us1_id, us1_search, cu1_id, cu1_search, contract_bin_id, or1_type, or2_scanned_qty, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            //array('REQUIRED_COLUMNS_ONLY_FOR_RELATION_SEPARATED_BY_COMMA', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Invalid Scan cannot be blank.')),
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
            'user' => array(self::BELONGS_TO, 'Profile', 'us1_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'cu1_id'),
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
            'is1_error_code' => Yii::t('app', 'Error Code'),
            'us1_id' => Yii::t('app', 'User'),
            'cu1_id' => Yii::t('app', 'Customer'),
            'or1_type' => Yii::t('app', 'Order Type'),
            'contract_bin_id' => Yii::t('app', 'Contract Bin ID'),
            'or2_scanned_qty' => Yii::t('app', 'Quantity'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Scan Date'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'errorTypes' => array(
                self::ERROR_UNKNOWN_BIN => Yii::t('app', 'Unknown Bin'),
                self::ERROR_INVALID_QTY => Yii::t('app', 'Invalid Qty.'),
                self::ERROR_DUPLICATE_SCAN => Yii::t('app', 'Duplicate Scan'),
            ),
            'errorTypesForSearch' => array(
                '' => '',
                self::ERROR_UNKNOWN_BIN => Yii::t('app', 'Unknown Bin'),
                self::ERROR_INVALID_QTY => Yii::t('app', 'Invalid Qty.'),
                self::ERROR_DUPLICATE_SCAN => Yii::t('app', 'Duplicate Scan'),
            ),
            'orderTypes' => array(
                self::TYPE_REPLENISHMENT => Yii::t('app', 'Replenishment'),
                self::TYPE_PART_CONSUMPTION => Yii::t('app', 'Part Consumption'),
                self::TYPE_RECEIVING => Yii::t('app', 'Receiving'),
            ),
            'orderTypesForSearch' => array(
                '' => '',
                self::TYPE_REPLENISHMENT => Yii::t('app', 'Replenishment'),
                self::TYPE_PART_CONSUMPTION => Yii::t('app', 'Part Consumption'),
                self::TYPE_RECEIVING => Yii::t('app', 'Receiving'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function logAlias($attribute, $value)
    {
        $result = $value;
        $itemAliasKeys = array(
            'is1_error_code' => 'errorTypes',
            'or1_type' => 'orderTypes',
        );
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = self::itemAlias($itemAliasKeys[$attribute], $value);
            if (!$result)
                $result = $value;
        }
        return $result;
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = InvalidScan::model()->getTableAlias(false, false);
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
        $alias = InvalidScan::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.contract_bin_id',
                'together' => true,
                'with' => array('user', 'customer', 'cprofile', 'mprofile',),
                'order' => $alias . '.created_on DESC',
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
        $models = InvalidScan::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id))
                $rtv[$model->id] = $model->contract_bin_id;
        }
        return $rtv;
    }

    public $us1_search;
    public $cu1_search;
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
        $alias = InvalidScan::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('user', 'customer', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.is1_error_code', $this->is1_error_code);
        $criteria->compare($alias . '.us1_id', $this->us1_id);
        if (isset($this->us1_search) && strlen($this->us1_search) > 0) {
            $criteria->addCondition("CONCAT(user.first_name, ' ', user.last_name) LIKE :us1_search");
            $criteria->params = array_merge($criteria->params, array(':us1_search' => '%' . $this->us1_search . '%'));
        }
        $criteria->compare($alias . '.cu1_id', $this->cu1_id);
        if (isset($this->cu1_search) && strlen($this->cu1_search) > 0) {
            $criteria->compare('customer.cu1_name', $this->cu1_search, true);
        }
        $criteria->compare($alias . '.contract_bin_id', $this->contract_bin_id, true);
        $criteria->compare($alias . '.or1_type', $this->or1_type);
        $criteria->compare($alias . '.or2_scanned_qty', $this->or2_scanned_qty);
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
                        'asc' => 'user.first_name, user.last_name',
                        'desc' => 'user.first_name DESC, user.last_name DESC',
                    ),
                    'cu1_search' => array(
                        'asc' => 'customer.cu1_name',
                        'desc' => 'customer.cu1_name DESC',
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
            'fileName' => Yii::t('app', 'InvalidScan').'-'.date('Y-m-d-H-i-s'),
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
                    'field' => 'is1_error_code',
                    'label' => $this->getAttributeLabel('is1_error_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'InvalidScan', 'type' => 'errorTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'us1_search',
                    'label' => $this->getAttributeLabel('us1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'user->fullname',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_search',
                    'label' => $this->getAttributeLabel('cu1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'customer->cu1_name',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'or1_type',
                    'label' => $this->getAttributeLabel('or1_type'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'InvalidScan', 'type' => 'orderTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'contract_bin_id',
                    'label' => $this->getAttributeLabel('contract_bin_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'or2_scanned_qty',
                    'label' => $this->getAttributeLabel('or2_scanned_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
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

