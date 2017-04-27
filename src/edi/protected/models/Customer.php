<?php

/**
 * This is the model class for table "cu1_scustomer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property integer $cu1_type
 * @property string $cu1_code
 * @property string $cu1_name
 * @property string $cu1_phone
 * @property string $cu1_fax
 * @property string $cu1_url
 * @property string $cu1_logo
 * @property string $cu1_address1
 * @property string $cu1_address2
 * @property string $cu1_city
 * @property integer $st1_id
 * @property string $cu1_postal_code
 * @property string $cu1_country
 * @property integer $cu1_duplicate_barcodes
 * @property integer $cu1_split_up_orders
 * @property integer $cu1_txt_approved
 * @property integer $cu1_inventory_management
 * @property integer $cu1_import_external_xml_usage
 * @property integer $cu1_new_contract_number
 * @property integer $cu1_convert_reorder_qty_into_each
 * @property integer $cu1_upto_order_mode
 * @property integer $cu1_show_on_hand_qty_from_p21
 * @property integer $cu1_multiply_reorder_qty
 * @property string $cu1_missing_order_emails
 * @property string $cu1_teamwork_desk_id
 * @property integer $created_by
 * @property string $created_on
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag
 *
 * The followings are the available model relations:
 * @property InvalidScan[] $invalidScans
 * @property Plant[] $plants
 * @property Profile[] $users
 * @property Customer2[] $customer2s
 * @property State $state
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class Customer extends JActiveRecord
{

    const TYPE_CMI = 1;
    const TYPE_VMI = 2;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer the static model class
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
        return 'cu1_customer_yii';
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
            array('cu1_code', 'unique', 'on' => 'insert, update'),
            array(', , ', 'required', 'on' => 'insert, update'),
            array('cu1_type', 'in', 'range' => array(self::TYPE_CMI, self::TYPE_VMI), 'on' => 'insert, update'),
            array('cu1_type, cu1_duplicate_barcodes, cu1_split_up_orders, cu1_txt_approved, cu1_inventory_management, cu1_import_external_xml_usage, cu1_new_contract_number, cu1_convert_reorder_qty_into_each, cu1_upto_order_mode, cu1_show_on_hand_qty_from_p21, cu1_multiply_reorder_qty, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('cu1_code', 'length', 'max' => 10),
            array('cu1_name, cu1_url, cu1_logo, cu1_address1, cu1_address2, cu1_missing_order_emails', 'length', 'max' => 250),
            array(
                'cu1_missing_order_emails',
                'match', 'pattern' => '/^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})[, ]*)+$/',
                'message' => Yii::t('app', 'Invalid email format in Missing Order Emails'),
            ),
            array('cu1_url', 'url'),
            array('cu1_logo', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => Yii::t('app', 'Size should be less then 2MB.'), 'allowEmpty' => true, 'safe' => true, 'on' => 'insert, update'),
            array('cu1_name, cu1_url, cu1_logo, cu1_address1, cu1_address2', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            array('st1_id, created_by, modified_by', 'length', 'max' => 20),
            array('cu1_phone, cu1_fax, cu1_postal_code', 'length', 'max' => 25),
            array('cu1_city, cu1_country', 'length', 'max' => 50),
            array('cu1_teamwork_desk_id, created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('cu1_teamwork_desk_id, id, cu1_type, cu1_code, cu1_name, cu1_phone, cu1_fax, cu1_url, cu1_logo, cu1_address1, cu1_address2, cu1_city, st1_id, st1_search, cu1_postal_code, cu1_country, cu1_duplicate_barcodes, cu1_split_up_orders, cu1_txt_approved, cu1_inventory_management, cu1_import_external_xml_usage, cu1_new_contract_number, cu1_convert_reorder_qty_into_each, cu1_upto_order_mode, cu1_show_on_hand_qty_from_p21, cu1_multiply_reorder_qty, cu1_missing_order_emails, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('cu1_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Customer cannot be blank.')),
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
            'invalidScans' => array(self::HAS_MANY, 'InvalidScan', 'cu1_id'),
            'plants' => array(self::HAS_MANY, 'Plant', 'cu1_id'),
            'users' => array(self::HAS_MANY, 'Profile', 'cu1_id',),
            'customer2s' => array(self::HAS_MANY, 'Customer2', 'cu1_id'),
            'state' => array(self::BELONGS_TO, 'State', 'st1_id',),
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),
        );
    }
    /**
     * REQUIRED
     * @return integer the id of the customer in our system
     */
    public static function processTeamWorkDeskCustomer($customer){

        $criteria = new CDbCriteria();
        $criteria->params = array();

        $criteria->compare('cu1_teamwork_desk_id', $customer['id']);
        $model = Customer::model()->find($criteria);

        if(!isset($model)){
            $criteria = new CDbCriteria();
            $criteria->params = array();

            $criteria->compare('cu1_name', $customer['firstName'] . ' ' . $customer['lastName']);
            $model = Customer::model()->find($criteria);
        }

        if(!isset($model)){
            $model = new Customer();
            $model->cu1_name = $customer['firstName'] . ' ' . $customer['lastName'];
            $model->cu1_teamwork_desk_id = $customer['id'];
            $model->cu1_type = Customer::TYPE_CMI;
            if($model->validate()){
                $model->save();
            }
        }

        return $model->id;
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'cu1_type' => Yii::t('app', 'Type'),
            'cu1_code' => Yii::t('app', 'Customer Code'),
            'cu1_name' => Yii::t('app', 'Customer Name'),
            'cu1_phone' => Yii::t('app', 'Phone'),
            'cu1_fax' => Yii::t('app', 'Fax'),
            'cu1_url' => Yii::t('app', 'URL'),
            'cu1_logo' => Yii::t('app', 'Logo'),
            'cu1_address1' => Yii::t('app', 'Address1'),
            'cu1_address2' => Yii::t('app', 'Address2'),
            'cu1_city' => Yii::t('app', 'City'),
            'st1_id' => Yii::t('app', 'State'),
            'st1_search' => Yii::t('app', 'State'),
            'cu1_postal_code' => Yii::t('app', 'Postal Code'),
            'cu1_country' => Yii::t('app', 'Country'),
            'cu1_duplicate_barcodes' => Yii::t('app', 'Allow Duplicate Scans'),
            'cu1_split_up_orders' => Yii::t('app', 'Split Up Orders'),
            'cu1_txt_approved' => Yii::t('app', 'Text Approved'),
            'cu1_inventory_management' => Yii::t('app', 'Enable Inventory Management'),
            'cu1_import_external_xml_usage' => Yii::t('app', 'Import External XML Usage'),
            'cu1_new_contract_number' => Yii::t('app', 'New Contract Number'),
            'cu1_convert_reorder_qty_into_each' => Yii::t('app', 'Convert Reorder Qty. into Each'),
            'cu1_upto_order_mode' => Yii::t('app', 'Up-to Order Mode'),
            'cu1_show_on_hand_qty_from_p21' => Yii::t('app', 'Show On-Hand Qty. from P21'),
            'cu1_multiply_reorder_qty' => Yii::t('app', 'Multiply Reorder Qty.'),
            'cu1_missing_order_emails' => Yii::t('app', 'Missing Order Emails'),
            'created_by' => Yii::t('app', 'Created By'),
            'cprofile_search' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
            'cu1_teamwork_desk_id' => Yii::t('app', 'TeamWork Desk ID'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'customerTypes' => array(
                self::TYPE_CMI => Yii::t('app', 'CMI'),
                self::TYPE_VMI => Yii::t('app', 'VMI'),
            ),
            'customerTypesForSearch' => array(
                '' => '',
                self::TYPE_CMI => Yii::t('app', 'CMI'),
                self::TYPE_VMI => Yii::t('app', 'VMI'),
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
            'cu1_type' => 'customerTypes',
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
        $alias = Customer::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.cu1_code';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Customer::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.cu1_code, ' . $alias . '.cu1_name',
                'together' => true,
                'with' => array('state', 'cprofile', 'mprofile',),
                'order' => $alias . '.cu1_code',
            ),
        );
    }

    /**
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry
     * @return array
     */
    public static function getListData($criteria = null, $addEmptyItem = true)
    {
        if ($criteria === null) {
            $criteria = new CDbCriteria();
            $criteria->params = array();
        }
        $models = Customer::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->cu1_code) && isset($model->cu1_name))
                $rtv[$model->id] = $model->cu1_code . ' - ' . $model->cu1_name;
        }
        return $rtv;
    }

    public $st1_search;
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
        $alias = Customer::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('cprofile', 'mprofile', 'state',);
        $criteria->compare($alias.'.cu1_type', $this->cu1_type);
        $criteria->compare($alias.'.cu1_code', $this->cu1_code, true);
        $criteria->compare($alias.'.cu1_name', $this->cu1_name, true);
        $criteria->compare($alias.'.cu1_phone', $this->cu1_phone, true);
        $criteria->compare($alias.'.cu1_fax', $this->cu1_fax, true);
        $criteria->compare($alias.'.cu1_url', $this->cu1_url, true);
        $criteria->compare($alias.'.cu1_logo', $this->cu1_logo, true);
        $criteria->compare($alias.'.cu1_address1', $this->cu1_address1, true);
        $criteria->compare($alias.'.cu1_address2', $this->cu1_address2, true);
        $criteria->compare($alias.'.cu1_city', $this->cu1_city, true);
        if (isset($this->st1_id) && $this->st1_id > 0) {
            $criteria->compare($alias.'.st1_id', $this->st1_id);
        }
        $criteria->compare($alias.'.cu1_postal_code', $this->cu1_postal_code, true);
        $criteria->compare($alias.'.cu1_country', $this->cu1_country, true);
        $criteria->compare($alias . '.cu1_duplicate_barcodes', $this->cu1_duplicate_barcodes);
        $criteria->compare($alias . '.cu1_split_up_orders', $this->cu1_split_up_orders);
        $criteria->compare($alias . '.cu1_txt_approved', $this->cu1_txt_approved);
        $criteria->compare($alias . '.cu1_inventory_management', $this->cu1_inventory_management);
        $criteria->compare($alias . '.cu1_import_external_xml_usage', $this->cu1_import_external_xml_usage);
        $criteria->compare($alias . '.cu1_new_contract_number', $this->cu1_new_contract_number);
        $criteria->compare($alias . '.cu1_convert_reorder_qty_into_each', $this->cu1_convert_reorder_qty_into_each);
        $criteria->compare($alias . '.cu1_upto_order_mode', $this->cu1_upto_order_mode);
        $criteria->compare($alias . '.cu1_show_on_hand_qty_from_p21', $this->cu1_show_on_hand_qty_from_p21);
        $criteria->compare($alias . '.cu1_multiply_reorder_qty', $this->cu1_multiply_reorder_qty);
        $criteria->compare($alias . '.cu1_missing_order_emails', $this->cu1_missing_order_emails, true);
        $criteria->compare($alias . '.cu1_teamwork_desk_id', $this->cu1_teamwork_desk_id, true);
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
                    'st1_search' => array(
                        'asc' => 'state.st1_code, state.st1_name',
                        'desc' => 'state.st1_code DESC, state.st1_name DESC',
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
            'fileName' => Yii::t('app', 'Customers').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'cu1_type',
                    'label' => $this->getAttributeLabel('cu1_type'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => array('class' => 'Customer', 'type' => 'customerTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_code',
                    'label' => $this->getAttributeLabel('cu1_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_name',
                    'label' => $this->getAttributeLabel('cu1_name'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_phone',
                    'label' => $this->getAttributeLabel('cu1_phone'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_teamwork_desk_id',
                    'label' => $this->getAttributeLabel('cu1_teamwork_desk_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_fax',
                    'label' => $this->getAttributeLabel('cu1_fax'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_url',
                    'label' => $this->getAttributeLabel('cu1_url'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_logo',
                    'label' => $this->getAttributeLabel('cu1_logo'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_address1',
                    'label' => $this->getAttributeLabel('cu1_address1'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_address2',
                    'label' => $this->getAttributeLabel('cu1_address2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_city',
                    'label' => $this->getAttributeLabel('cu1_city'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'st1_id',
                    'label' => $this->getAttributeLabel('st1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'state->st1_name',
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_postal_code',
                    'label' => $this->getAttributeLabel('cu1_postal_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_country',
                    'label' => $this->getAttributeLabel('cu1_country'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_duplicate_barcodes',
                    'label' => $this->getAttributeLabel('cu1_duplicate_barcodes'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_split_up_orders',
                    'label' => $this->getAttributeLabel('cu1_split_up_orders'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_txt_approved',
                    'label' => $this->getAttributeLabel('cu1_txt_approved'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_inventory_management',
                    'label' => $this->getAttributeLabel('cu1_inventory_management'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_import_external_xml_usage',
                    'label' => $this->getAttributeLabel('cu1_import_external_xml_usage'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_new_contract_number',
                    'label' => $this->getAttributeLabel('cu1_new_contract_number'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_convert_reorder_qty_into_each',
                    'label' => $this->getAttributeLabel('cu1_convert_reorder_qty_into_each'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_upto_order_mode',
                    'label' => $this->getAttributeLabel('cu1_upto_order_mode'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_show_on_hand_qty_from_p21',
                    'label' => $this->getAttributeLabel('cu1_show_on_hand_qty_from_p21'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_multiply_reorder_qty',
                    'label' => $this->getAttributeLabel('cu1_multiply_reorder_qty'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_missing_order_emails',
                    'label' => $this->getAttributeLabel('cu1_missing_order_emails'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
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
