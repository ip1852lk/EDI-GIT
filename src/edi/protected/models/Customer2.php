<?php

/**
 * This is the model class for table 'cu2_customer'.
 *
 * The followings are the available columns in table 'cu2_customer':
 * @property string $id
 * @property integer $cu2_type
 * @property integer $cu2_consignment_location_id
 * @property string $cu1_id
 * @property string $lo1_id
 * @property integer $corp_address_id
 * @property string $customer_name
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Contract[] $contracts
 * @property Customer $customer
 * @property Location $location
 * @property MasterData[] $MasterDataRecords
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class Customer2 extends JActiveRecord
{

    const TYPE_P21 = 1;
    const TYPE_NON_P21 = 2;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer2 the static model class
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
        return 'cu2_customer';
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
            array('corp_address_id', 'uniqueP21Customer', 'on' => 'insert, update'),
            array('cu2_type, lo1_id, cu1_id, corp_address_id, customer_name', 'required', 'on' => 'insert, update'),
            array('cu2_type', 'in', 'range' => array(self::TYPE_P21, self::TYPE_NON_P21), 'on' => 'insert, update'),
            array('cu2_consignment_location_id, corp_address_id, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('cu1_id, lo1_id, created_by, modified_by', 'length', 'max' => 20, 'on' => 'insert, update'),
            array('customer_name', 'length', 'max' => 100, 'on' => 'insert, update'),
            //array('cu2_contracts', 'length', 'max' => 250, 'on' => 'insert, update'),
            array('cu2_contracts, created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cu2_type, cu2_consignment_location_id, cu1_id, cu1_search, lo1_id, lo1_search, rg1_search, co1_search, corp_address_id, customer_name, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('customer_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Sub-Customer cannot be blank.')),
        );
    }

    public function uniqueP21Customer($attribute)
    {
        if (isset($this->{$attribute}) &&
            isset($this->lo1_id) && $this->lo1_id > 0 &&
            isset($this->cu1_id) && $this->cu1_id > 0)
        {
            if ($this->isNewRecord)
                $count = Customer2::model()->count('t.lo1_id=:lo1_id AND t.cu1_id=:cu1_id AND t.corp_address_id=:corp_address_id', array(
                    ':lo1_id' => $this->lo1_id,
                    ':cu1_id' => $this->cu1_id,
                    ':corp_address_id' => $this->corp_address_id,
                ));
            else
                $count = Customer2::model()->count('t.id<>:id AND t.lo1_id=:lo1_id AND t.cu1_id=:cu1_id AND t.corp_address_id=:corp_address_id', array(
                    ':id' => $this->id,
                    ':lo1_id' => $this->lo1_id,
                    ':cu1_id' => $this->cu1_id,
                    ':corp_address_id' => $this->corp_address_id,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', 'Corp. Address ID, ":corp_address_id", has already been registered on ":cu1_name" and ":lo1_name".', array(
                    ':corp_address_id' => $this->{$attribute},
                    ':lo1_name' => $this->location->lo1_name,
                    ':cu1_name' => $this->customer->cu1_name,
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
            'contracts' => array(self::HAS_MANY, 'Contract', 'cu2_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'cu1_id'),
            'location' => array(self::BELONGS_TO, 'Location', 'lo1_id'),
            'masterDataRecords' => array(self::HAS_MANY, 'MasterData', 'cu2_id'),
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
            'cu2_type' => Yii::t('app', 'Type'),
            'cu2_consignment_location_id' => Yii::t('app', 'Consignment ID'),
            'cu2_contracts' => Yii::t('app', 'P21 Contracts'),
            'cu1_id' => Yii::t('app', 'Customer'),
            'cu1_search' => Yii::t('app', 'Customer'),
            'lo1_id' => Yii::t('app', 'Location'),
            'lo1_search' => Yii::t('app', 'Location'),
            'rg1_search' => Yii::t('app', 'Region'),
            'co1_search' => Yii::t('app', 'Company'),
            'corp_address_id' => Yii::t('app', 'Corp. Address ID'),
            'customer_name' => Yii::t('app', 'P21 Customer Name'),
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

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'customerTypes' => array(
                self::TYPE_P21 => Yii::t('app', 'P21'),
                self::TYPE_NON_P21 => Yii::t('app', 'Non-P21'),
            ),
            'customerTypesForSearch' => array(
                '' => '',
                self::TYPE_P21 => Yii::t('app', 'P21'),
                self::TYPE_NON_P21 => Yii::t('app', 'Non-P21'),
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
            'cu2_type' => 'customerTypes',
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
        $alias = Customer2::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.cu1_id, ' . $alias . '.customer_name';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Customer2::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.cu2_type, .corp_address_id, .customer_name',
                'together' => true,
                'with' => array('location', 'location.region', 'location.region.company', 'customer', 'cprofile', 'mprofile',),
                'order' => $alias . '.cu1_id, ' . $alias . '.customer_name',
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
        $models = Customer2::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) &&
                isset($model->customer) &&
                isset($model->location) &&
                isset($model->location->region) &&
                isset($model->location->region0->company))
            {
                $rtv[$model->id] = '[' . $model->customer->cu1_name . ']' . $model->corp_address_id . ' - ' . $model->customer_name;
            }
        }
        return $rtv;
    }

    public $cu2_contracts;
    public $cu1_search;
    public $lo1_search;
    public $rg1_search;
    public $co1_search;
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
        $alias = Customer2::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('location', 'location.region', 'location.region.company', 'customer', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.cu2_type', $this->cu2_type);
        $criteria->compare($alias . '.cu2_consignment_location_id', $this->cu2_consignment_location_id);
        $criteria->compare($alias . '.cu1_id', $this->cu1_id);
        if (isset($this->cu1_search) && strlen($this->cu1_search) > 0) {
            $criteria->compare('customer.cu1_name', $this->cu1_search, true);
        }
        $criteria->compare($alias . '.lo1_id', $this->lo1_id);
        if (isset($this->lo1_search) && strlen($this->lo1_search) > 0) {
            $criteria->compare('location.lo1_name', $this->lo1_search, true);
        }
        if (isset($this->rg1_search) && strlen($this->rg1_search) > 0) {
            $criteria->compare('region.rg1_name', $this->rg1_search, true);
        }
        if (isset($this->co1_search) && strlen($this->co1_search) > 0) {
            $criteria->compare('company.co1_name', $this->co1_search, true);
        }
        $criteria->compare($alias . '.corp_address_id', $this->corp_address_id);
        $criteria->compare($alias . '.customer_name', $this->customer_name, true);
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
                    'cu1_search' => array(
                        'asc' => 'customer.cu1_name',
                        'desc' => 'customer.cu1_name DESC',
                    ),
                    'lo1_search' => array(
                        'asc' => 'location.lo1_name',
                        'desc' => 'location.lo1_name DESC',
                    ),
                    'rg1_search' => array(
                        'asc' => 'region.rg1_name',
                        'desc' => 'region.rg1_name DESC',
                    ),
                    'co1_search' => array(
                        'asc' => 'company.co1_name',
                        'desc' => 'company.co1_name DESC',
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
            'fileName' => Yii::t('app', 'Sub-Customer').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'cu2_type',
                    'label' => $this->getAttributeLabel('cu2_type'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => array('class' => 'Customer2', 'type' => 'customerTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'customer_name',
                    'label' => $this->getAttributeLabel('customer_name'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'corp_address_id',
                    'label' => $this->getAttributeLabel('corp_address_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
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
                    'field' => 'co1_search',
                    'label' => $this->getAttributeLabel('co1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'location->region->company->co1_name',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'lo1_search',
                    'label' => $this->getAttributeLabel('lo1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'location->lo1_name',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu2_consignment_location_id',
                    'label' => $this->getAttributeLabel('cu2_consignment_location_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
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

