<?php

/**
 * This is the model class for table 'md1_master_data'.
 *
 * The followings are the available columns in table 'md1_master_data':
 * @property string $id
 * @property string $contract_bin_id
 * @property string $customer_bin_id
 * @property string $customer_part_no
 * @property string $item_id
 * @property string $item_desc
 * @property string $extended_desc
 * @property double $capacity
 * @property double $min_qty
 * @property double $max_qty
 * @property double $reorder_qty
 * @property double $on_hand_qty
 * @property double $p21_on_hand_qty
 * @property double $price
 * @property double $unit_size
 * @property string $unit_of_measure
 * @property double $frequency
 * @property integer $preferred_location_id
 * @property string $line
 * @property string $line_feed
 * @property string $line_station
 * @property string $bt1_id
 * @property string $pf1_id
 * @property string $co1_id
 * @property string $cu2_id
 * @property string $ra1_id
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property BinType $binType
 * @property Company $company
 * @property Customer2 $customer2
 * @property ProductFamily $productFamily
 * @property Rack $rack
 * @property OrderLine[] $orderLines
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class MasterData extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MasterData the static model class
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
        return 'md1_master_data';
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
            array('contract_bin_id', 'uniqueMasterData', 'on' => 'insert, update'),
            array('bt1_id, co1_id, cu2_id, ra1_id, contract_bin_id, item_id, item_desc, capacity, min_qty, max_qty, reorder_qty, price, unit_size, unit_of_measure', 'required', 'on' => 'insert, update'),
            array('preferred_location_id, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('capacity, min_qty, max_qty, reorder_qty, on_hand_qty, p21_on_hand_qty, price, unit_size, frequency', 'numerical'),
            array('capacity, min_qty, max_qty, reorder_qty', 'numerical', 'min' => 1, 'on' => 'insert, update'),
            array('price, unit_size', 'numerical', 'min' => 0.001, 'on' => 'insert, update'),
            array('contract_bin_id, customer_bin_id, extended_desc, line, line_feed, line_station', 'length', 'max' => 255),
            array('customer_part_no, item_id', 'length', 'max' => 40),
            array('item_desc', 'length', 'max' => 100),
            array('unit_of_measure, bt1_id, pf1_id, co1_id, cu2_id, ra1_id, created_by, modified_by', 'length', 'max' => 20),
            array('pf1_id', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'insert, update'),
            array('total_value, created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, contract_bin_id, customer_bin_id, customer_part_no, item_id, item_desc, extended_desc, capacity, min_qty, max_qty, reorder_qty, on_hand_qty, p21_on_hand_qty, price, unit_size, unit_of_measure, frequency, preferred_location_id, line, line_feed, line_station, bt1_id, bt1_search, pf1_id, pf1_search, co1_id, co1_search, cu2_id, cu2_search, ra1_id, ra1_search, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('contract_bin_id', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Master Data cannot be blank.')),
        );
    }

    public function uniqueMasterData($attribute)
    {
        if (isset($this->{$attribute}) &&
            isset($this->co1_id) && $this->co1_id > 0 &&
            isset($this->cu2_id) && $this->cu2_id > 0 &&
            isset($this->ra1_id) && $this->ra1_id > 0)
        {
            if ($this->isNewRecord)
                $count = MasterData::model()->count('t.contract_bin_id=:contract_bin_id AND t.co1_id=:co1_id AND t.cu2_id=:cu2_id AND t.ra1_id=:ra1_id', array(
                    ':contract_bin_id' => $this->contract_bin_id,
                    ':co1_id' => $this->co1_id,
                    ':cu2_id' => $this->cu2_id,
                    ':ra1_id' => $this->ra1_id,
                ));
            else
                $count = MasterData::model()->count('t.id<>:id AND t.contract_bin_id=:contract_bin_id AND t.co1_id=:co1_id AND t.cu2_id=:cu2_id AND t.ra1_id=:ra1_id', array(
                    ':id' => $this->id,
                    ':contract_bin_id' => $this->contract_bin_id,
                    ':co1_id' => $this->co1_id,
                    ':cu2_id' => $this->cu2_id,
                    ':ra1_id' => $this->ra1_id,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', 'The Contract Bin ID, ":contract_bin_id", has already been taken in ":co1_id", ":cu2_id" and ":ra1_id".', array(
                    ':contract_bin_id' => $this->contract_bin_id,
                    ':co1_id' => '[' . Yii::t('app', 'Company') . ']' . $this->company->co1_name,
                    ':cu2_id' => '[' . Yii::t('app', 'Sub-Customer') . ']' . $this->customer2->customer_name,
                    ':ra1_id' => '[' . Yii::t('app', 'Rack') . ']' . $this->rack->ship_to_name,
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
            'binType' => array(self::BELONGS_TO, 'BinType', 'bt1_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'co1_id'),
            'customer2' => array(self::BELONGS_TO, 'Customer2', 'cu2_id'),
            'productFamily' => array(self::BELONGS_TO, 'ProductFamily', 'pf1_id'),
            'rack' => array(self::BELONGS_TO, 'Rack', 'ra1_id'),
            'orderLines' => array(self::HAS_MANY, 'OrderLine', 'md1_id'),
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),
        );
    }

    /**
     * Returns the status icon of this master data's on-hand quantity.
     * @return string
     */
    public function getStatusIcon()
    {
        if (isset($this->p21_on_hand_qty)) {
            if ($this->p21_on_hand_qty > $this->max_qty)
                return '<i class="fa fa-square fa-fw" style="color: orange"></i>';
            elseif ($this->p21_on_hand_qty < $this->min_qty)
                return '<i class="fa fa-square fa-fw" style="color: #ff0000"></i>';
            else
                return '<i class="fa fa-square fa-fw" style="color: green"></i>';
        } else
            return '';
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'contract_bin_id' => Yii::t('app', 'Contract Bin ID'),
            'customer_bin_id' => Yii::t('app', 'Customer Bin ID'),
            'customer_part_no' => Yii::t('app', 'Customer Part No.'),
            'item_id' => Yii::t('app', 'Item Code'),
            'item_desc' => Yii::t('app', 'Item Desc.'),
            'extended_desc' => Yii::t('app', 'Extended Desc.'),
            'capacity' => Yii::t('app', 'Capacity'),
            'min_qty' => Yii::t('app', 'Min Qty.'),
            'max_qty' => Yii::t('app', 'Max Qty.'),
            'reorder_qty' => Yii::t('app', 'Reorder Qty.'),
            'on_hand_qty' => Yii::t('app', 'On-Hand Qty.'),
            'p21_on_hand_qty' => Yii::t('app', 'On-Hand Qty.'),
            'price' => Yii::t('app', 'Price'),
            'Total Value' => Yii::t('app', 'Price'),
            'unit_size' => Yii::t('app', 'Unit Size'),
            'unit_of_measure' => Yii::t('app', 'Unit Of Measure'),
            'frequency' => Yii::t('app', 'Frequency'),
            'preferred_location_id' => Yii::t('app', 'Preferred Location'),
            'line' => Yii::t('app', 'Line'),
            'line_feed' => Yii::t('app', 'Reorder Code'),
            'line_station' => Yii::t('app', 'Line Station'),
            'bt1_id' => Yii::t('app', 'Bin Type'),
            'bt1_search' => Yii::t('app', 'Bin Type'),
            'pf1_id' => Yii::t('app', 'Product Family'),
            'pf1_search' => Yii::t('app', 'Product Family'),
            'co1_id' => Yii::t('app', 'Company'),
            'co1_search' => Yii::t('app', 'Company'),
            'cu2_id' => Yii::t('app', 'Customer'),
            'cu2_search' => Yii::t('app', 'Customer'),
            'ra1_id' => Yii::t('app', 'Rack'),
            'ra1_search' => Yii::t('app', 'Rack'),
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
        $alias = MasterData::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.contract_bin_id';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = MasterData::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.contract_bin_id',
                'together' => true,
                'with' => array('binType', 'productFamily', 'company', 'customer2', 'rack', 'cprofile', 'mprofile',),
                'order' => $alias . '.contract_bin_id',
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
        $models = MasterData::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) && isset($model->company) && isset($model->customer2) && isset($model->rack))
                $rtv[$model->id] =
                    '['.$model->company->co1_name.', '.$model->customer2->customer_name.', '.$model->rack->ship_to_name.'] '.
                    $model->contract_bin_id;
        }
        return $rtv;
    }

    public $total_value;
    public $bt1_search;
    public $pf1_search;
    public $co1_search;
    public $cu2_search;
    public $ra1_search;
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
        $alias = MasterData::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('binType', 'productFamily', 'company', 'customer2', 'rack', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.contract_bin_id', $this->contract_bin_id, true);
        $criteria->compare($alias . '.customer_bin_id', $this->customer_bin_id, true);
        $criteria->compare($alias . '.customer_part_no', $this->customer_part_no, true);
        $criteria->compare($alias . '.item_id', $this->item_id, true);
        $criteria->compare($alias . '.item_desc', $this->item_desc, true);
        $criteria->compare($alias . '.extended_desc', $this->extended_desc, true);
        $criteria->compare($alias . '.capacity', $this->capacity);
        $criteria->compare($alias . '.min_qty', $this->min_qty);
        $criteria->compare($alias . '.max_qty', $this->max_qty);
        $criteria->compare($alias . '.reorder_qty', $this->reorder_qty);
        $criteria->compare($alias . '.on_hand_qty', $this->on_hand_qty);
        $criteria->compare($alias . '.p21_on_hand_qty', $this->p21_on_hand_qty);
        $criteria->compare($alias . '.price', $this->price);
        $criteria->compare($alias . '.unit_size', $this->unit_size);
        $criteria->compare($alias . '.unit_of_measure', $this->unit_of_measure, true);
        $criteria->compare($alias . '.frequency', $this->frequency);
        $criteria->compare($alias . '.preferred_location_id', $this->preferred_location_id);
        $criteria->compare($alias . '.line', $this->line, true);
        $criteria->compare($alias . '.line_feed', $this->line_feed, true);
        $criteria->compare($alias . '.line_station', $this->line_station, true);
        $criteria->compare($alias . '.bt1_id', $this->bt1_id);
        if (isset($this->bt1_search) && strlen($this->bt1_search) > 0) {
            $criteria->compare('binType.bt1_code', $this->bt1_search, true);
        }
        $criteria->compare($alias . '.pf1_id', $this->pf1_id);
        if (isset($this->pf1_search) && strlen($this->pf1_search) > 0) {
            $criteria->addCondition('CONCAT(productFamily.pf1_family, " ", productFamily.pf1_commodity) LIKE :pf1_search');
            $criteria->params = array_merge($criteria->params, array(':pf1_search' => '%' . $this->pf1_search . '%'));
        }
        $criteria->compare($alias . '.co1_id', $this->co1_id);
        if (isset($this->co1_search) && strlen($this->co1_search) > 0) {
            $criteria->compare('company.co1_name', $this->co1_search, true);
        }
        $criteria->compare($alias . '.cu2_id', $this->cu2_id);
        if (isset($this->cu2_search) && strlen($this->cu2_search) > 0) {
            $criteria->compare('customer2.customer_name', $this->cu2_search, true);
        }
        $criteria->compare($alias . '.ra1_id', $this->ra1_id);
        if (isset($this->ra1_search) && strlen($this->ra1_search) > 0) {
            $criteria->compare('rack.ship_to_name', $this->ra1_search, true);
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
                    'bt1_search' => array(
                        'asc' => 'binType.bt1_code',
                        'desc' => 'binType.bt1_code DESC',
                    ),
                    'pf1_search' => array(
                        'asc' => 'productFamily.pf1_family, productFamily.pf1_commodity',
                        'desc' => 'productFamily.pf1_family DESC, productFamily.pf1_commodity DESC',
                    ),
                    'co1_search' => array(
                        'asc' => 'company.co1_name',
                        'desc' => 'company.co1_name DESC',
                    ),
                    'cu2_search' => array(
                        'asc' => 'customer2.customer_name',
                        'desc' => 'customer2.customer_name DESC',
                    ),
                    'ra1_search' => array(
                        'asc' => 'rack.ship_to_name',
                        'desc' => 'rack.ship_to_name DESC',
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
     * Export data into Excel, PDF, or CVS
     * @param boolean $stream true - export without footprint, false - export with footprint
     */
    public function export($stream)
    {
        return Yii::app()->export->exportData($this, array(
            'dataProvider' => null, 
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => $stream,
            'fileName' => Yii::t('app', 'MasterData').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'contract_bin_id',
                    'label' => $this->getAttributeLabel('contract_bin_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'customer_bin_id',
                    'label' => $this->getAttributeLabel('customer_bin_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'customer_part_no',
                    'label' => $this->getAttributeLabel('customer_part_no'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'item_id',
                    'label' => $this->getAttributeLabel('item_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'item_desc',
                    'label' => $this->getAttributeLabel('item_desc'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'extended_desc',
                    'label' => $this->getAttributeLabel('extended_desc'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'capacity',
                    'label' => $this->getAttributeLabel('capacity'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'min_qty',
                    'label' => $this->getAttributeLabel('min_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'max_qty',
                    'label' => $this->getAttributeLabel('max_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'reorder_qty',
                    'label' => $this->getAttributeLabel('reorder_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'on_hand_qty',
                    'label' => $this->getAttributeLabel('on_hand_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'p21_on_hand_qty',
                    'label' => $this->getAttributeLabel('p21_on_hand_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'price',
                    'label' => $this->getAttributeLabel('price'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'unit_size',
                    'label' => $this->getAttributeLabel('unit_size'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'unit_of_measure',
                    'label' => $this->getAttributeLabel('unit_of_measure'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'frequency',
                    'label' => $this->getAttributeLabel('frequency'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'preferred_location_id',
                    'label' => $this->getAttributeLabel('preferred_location_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'line',
                    'label' => $this->getAttributeLabel('line'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'line_feed',
                    'label' => $this->getAttributeLabel('line_feed'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'line_station',
                    'label' => $this->getAttributeLabel('line_station'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bt1_search',
                    'label' => $this->getAttributeLabel('bt1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'binType->bi1_code',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'pf1_search',
                    'label' => $this->getAttributeLabel('pf1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('productFamily->pf1_family', 'productFamily->pf1_commodity'), 'separator' => ' '),
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
                    'value' => 'company->co1_name',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu2_search',
                    'label' => $this->getAttributeLabel('cu2_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'customer2->customer_name',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ra1_search',
                    'label' => $this->getAttributeLabel('ra1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'rack->ship_to_name',
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

