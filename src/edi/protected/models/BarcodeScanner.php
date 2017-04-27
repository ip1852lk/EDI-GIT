<?php

/**
 * This is the model class for table 'bs1_barcode_scanner'.
 *
 * The followings are the available columns in table 'bs1_barcode_scanner':
 * @property string $id
 * @property string $us1_id
 * @property string $bs1_mac_address
 * @property integer $bs1_model
 * @property integer $bs1_com_port
 * @property integer $bs1_speed
 * @property integer $bs1_data_bit
 * @property integer $bs1_parity
 * @property integer $bs1_stop_bit
 * @property integer $bs1_flow_control
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Profile $user
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class BarcodeScanner extends JActiveRecord
{

    const MODEL_P360 = 1;
    const MODEL_CS1504 = 2;
    const MODEL_CS2000 = 3;

    const COM_1 = 1;
    const COM_2 = 2;
    const COM_3 = 3;
    const COM_4 = 4;
    const COM_5 = 5;
    const COM_6 = 6;
    const COM_7 = 7;
    const COM_8 = 8;
    const COM_9 = 9;
    const COM_10 = 10;

    const SPEED_300 = 1;
    const SPEED_600 = 2;
    const SPEED_1200 = 3;
    const SPEED_1800 = 4;
    const SPEED_2400 = 5;
    const SPEED_4800 = 6;
    const SPEED_7200 = 7;
    const SPEED_9600 = 8;
    const SPEED_14400 = 9;
    const SPEED_19200 = 10;
    const SPEED_38400 = 11;
    const SPEED_57600 = 12;
    const SPEED_115200 = 13;
    const SPEED_128000 = 14;

    const DATA_BIT_5 = 1;
    const DATA_BIT_6 = 2;
    const DATA_BIT_7 = 3;
    const DATA_BIT_8 = 4;

    const PARITY_EVEN = 1;
    const PARITY_ODD = 2;
    const PARITY_NONE = 3;
    const PARITY_MARK = 4;
    const PARITY_SPACE = 5;

    const STOP_BIT_1 = 1;
    const STOP_BIT_1_5 = 2;
    const STOP_BIT_2 = 3;

    const FLOW_CONTROL_ON_OFF = 1;
    const FLOW_CONTROL_HARDWARE = 2;
    const FLOW_CONTROL_NONE = 3;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BarcodeScanner the static model class
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
        return 'bs1_barcode_scanner';
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
            array('bs1_mac_address', 'uniqueMacAddress', 'on' => 'insert, update'),
            array('us1_id, bs1_mac_address, bs1_model', 'required', 'on' => 'insert, update'),
            array('bs1_model', 'in', 'range' => array(self::MODEL_P360, self::MODEL_CS1504, self::MODEL_CS2000), 'on' => 'insert, update'),
            array('bs1_com_port', 'in', 'range' => array(self::COM_1, self::COM_2, self::COM_3, self::COM_4, self::COM_5, self::COM_6, self::COM_7, self::COM_8, self::COM_9, self::COM_10), 'on' => 'insert, update'),
            array('bs1_data_bit', 'in', 'range' => array(self::DATA_BIT_5, self::DATA_BIT_6, self::DATA_BIT_7, self::DATA_BIT_8), 'on' => 'insert, update'),
            array('bs1_parity', 'in', 'range' => array(self::PARITY_EVEN, self::PARITY_ODD, self::PARITY_NONE, self::PARITY_MARK, self::PARITY_SPACE), 'on' => 'insert, update'),
            array('bs1_stop_bit', 'in', 'range' => array(self::STOP_BIT_1, self::STOP_BIT_1_5, self::STOP_BIT_2), 'on' => 'insert, update'),
            array('bs1_flow_control', 'in', 'range' => array(self::FLOW_CONTROL_ON_OFF, self::FLOW_CONTROL_HARDWARE, self::FLOW_CONTROL_NONE), 'on' => 'insert, update'),
            array('bs1_model, bs1_com_port, bs1_speed, bs1_data_bit, bs1_parity, bs1_stop_bit, bs1_flow_control, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('us1_id, created_by, modified_by', 'length', 'max' => 20),
            array('bs1_mac_address', 'length', 'max' => 50),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, us1_id, us1_search, bs1_mac_address, bs1_model, bs1_com_port, bs1_speed, bs1_data_bit, bs1_parity, bs1_stop_bit, bs1_flow_control, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('us1_id', 'required', 'on' => 'relation', 'message' => Yii::t('app', '"User" is required.')),
        );
    }

    public function uniqueMacAddress($attribute)
    {
        if (isset($this->{$attribute}) && isset($this->bs1_mac_address) && strlen($this->bs1_mac_address) > 0) {
            if ($this->isNewRecord)
                $count = BarcodeScanner::model()->count('t.us1_id=:us1_id AND t.bs1_mac_address=:bs1_mac_address', array(
                    ':us1_id' => $this->us1_id,
                    ':bs1_mac_address' => $this->bs1_mac_address,
                ));
            else
                $count = BarcodeScanner::model()->count('t.id<>:id AND t.us1_id=:us1_id AND t.bs1_mac_address=:bs1_mac_address', array(
                    ':id' => $this->id,
                    ':us1_id' => $this->us1_id,
                    ':bs1_mac_address' => $this->bs1_mac_address,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', '":us1_id" has already been registered on this computer, ":bs1_mac_address".', array(
                    ':us1_id' => $this->user->fullname,
                    ':bs1_mac_address' => $this->bs1_mac_address,
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
            'user' => array(self::BELONGS_TO, 'Profile', 'us1_id'),
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
            'us1_id' => Yii::t('app', 'User'),
            'us1_search' => Yii::t('app', 'User'),
            'bs1_mac_address' => Yii::t('app', 'Mac Address'),
            'bs1_model' => Yii::t('app', 'Model'),
            'bs1_com_port' => Yii::t('app', 'Com Port'),
            'bs1_speed' => Yii::t('app', 'Speed'),
            'bs1_data_bit' => Yii::t('app', 'Data Bit'),
            'bs1_parity' => Yii::t('app', 'Parity'),
            'bs1_stop_bit' => Yii::t('app', 'Stop Bit'),
            'bs1_flow_control' => Yii::t('app', 'Flow Control'),
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
            'model' => array(
                self::MODEL_P360 => Yii::t('app', 'P360'),
                self::MODEL_CS1504 => Yii::t('app', 'CS1504'),
                self::MODEL_CS2000 => Yii::t('app', 'CS2000'),
            ),
            'modelForSearch' => array(
                '' => '',
                self::MODEL_P360 => Yii::t('app', 'P360'),
                self::MODEL_CS1504 => Yii::t('app', 'CS1504'),
                self::MODEL_CS2000 => Yii::t('app', 'CS2000'),
            ),
            'comPort' => array(
                self::COM_1 => Yii::t('app', 'COM 1'),
                self::COM_2 => Yii::t('app', 'COM 2'),
                self::COM_3 => Yii::t('app', 'COM 3'),
                self::COM_4 => Yii::t('app', 'COM 4'),
                self::COM_5 => Yii::t('app', 'COM 5'),
                self::COM_6 => Yii::t('app', 'COM 6'),
                self::COM_7 => Yii::t('app', 'COM 7'),
                self::COM_8 => Yii::t('app', 'COM 8'),
                self::COM_9 => Yii::t('app', 'COM 9'),
                self::COM_10 => Yii::t('app', 'COM 10'),
            ),
            'comPortForSearch' => array(
                '' => '',
                self::COM_1 => Yii::t('app', 'COM 1'),
                self::COM_2 => Yii::t('app', 'COM 2'),
                self::COM_3 => Yii::t('app', 'COM 3'),
                self::COM_4 => Yii::t('app', 'COM 4'),
                self::COM_5 => Yii::t('app', 'COM 5'),
                self::COM_6 => Yii::t('app', 'COM 6'),
                self::COM_7 => Yii::t('app', 'COM 7'),
                self::COM_8 => Yii::t('app', 'COM 8'),
                self::COM_9 => Yii::t('app', 'COM 9'),
                self::COM_10 => Yii::t('app', 'COM 10'),
            ),
            'speed' => array(
                self::SPEED_300 => Yii::t('app', '300'),
                self::SPEED_600 => Yii::t('app', '600'),
                self::SPEED_1200 => Yii::t('app', '1200'),
                self::SPEED_1800 => Yii::t('app', '1800'),
                self::SPEED_2400 => Yii::t('app', '2400'),
                self::SPEED_4800 => Yii::t('app', '4800'),
                self::SPEED_7200 => Yii::t('app', '7200'),
                self::SPEED_9600 => Yii::t('app', '9600'),
                self::SPEED_14400 => Yii::t('app', '14400'),
                self::SPEED_19200 => Yii::t('app', '19200'),
                self::SPEED_38400 => Yii::t('app', '38400'),
                self::SPEED_57600 => Yii::t('app', '57600'),
                self::SPEED_115200 => Yii::t('app', '115200'),
                self::SPEED_128000 => Yii::t('app', '128000'),
            ),
            'speedForSearch' => array(
                '' => '',
                self::SPEED_300 => Yii::t('app', '300'),
                self::SPEED_600 => Yii::t('app', '600'),
                self::SPEED_1200 => Yii::t('app', '1200'),
                self::SPEED_1800 => Yii::t('app', '1800'),
                self::SPEED_2400 => Yii::t('app', '2400'),
                self::SPEED_4800 => Yii::t('app', '4800'),
                self::SPEED_7200 => Yii::t('app', '7200'),
                self::SPEED_9600 => Yii::t('app', '9600'),
                self::SPEED_14400 => Yii::t('app', '14400'),
                self::SPEED_19200 => Yii::t('app', '19200'),
                self::SPEED_38400 => Yii::t('app', '38400'),
                self::SPEED_57600 => Yii::t('app', '57600'),
                self::SPEED_115200 => Yii::t('app', '115200'),
                self::SPEED_128000 => Yii::t('app', '128000'),
            ),
            'dataBit' => array(
                self::DATA_BIT_5 => Yii::t('app', '5'),
                self::DATA_BIT_6 => Yii::t('app', '6'),
                self::DATA_BIT_7 => Yii::t('app', '7'),
                self::DATA_BIT_8 => Yii::t('app', '8'),
            ),
            'dataBitForSearch' => array(
                '' => '',
                self::DATA_BIT_5 => Yii::t('app', '5'),
                self::DATA_BIT_6 => Yii::t('app', '6'),
                self::DATA_BIT_7 => Yii::t('app', '7'),
                self::DATA_BIT_8 => Yii::t('app', '8'),
            ),
            'parity' => array(
                self::PARITY_EVEN => Yii::t('app', 'Even'),
                self::PARITY_ODD => Yii::t('app', 'Odd'),
                self::PARITY_NONE => Yii::t('app', 'None'),
                self::PARITY_MARK => Yii::t('app', 'Mark'),
                self::PARITY_SPACE => Yii::t('app', 'Space'),
            ),
            'parityForSearch' => array(
                '' => '',
                self::PARITY_EVEN => Yii::t('app', 'Even'),
                self::PARITY_ODD => Yii::t('app', 'Odd'),
                self::PARITY_NONE => Yii::t('app', 'None'),
                self::PARITY_MARK => Yii::t('app', 'Mark'),
                self::PARITY_SPACE => Yii::t('app', 'Space'),
            ),
            'stopBit' => array(
                self::STOP_BIT_1 => Yii::t('app', '1'),
                self::STOP_BIT_1_5 => Yii::t('app', '1.5'),
                self::STOP_BIT_2 => Yii::t('app', '2'),
            ),
            'stopBitForSearch' => array(
                '' => '',
                self::STOP_BIT_1 => Yii::t('app', '1'),
                self::STOP_BIT_1_5 => Yii::t('app', '1.5'),
                self::STOP_BIT_2 => Yii::t('app', '2'),
            ),
            'flowControl' => array(
                self::FLOW_CONTROL_ON_OFF => Yii::t('app', 'Xon/Xoff'),
                self::FLOW_CONTROL_HARDWARE => Yii::t('app', 'Hardware'),
                self::FLOW_CONTROL_NONE => Yii::t('app', 'None'),
            ),
            'flowControlForSearch' => array(
                '' => '',
                self::FLOW_CONTROL_ON_OFF => Yii::t('app', 'Xon/Xoff'),
                self::FLOW_CONTROL_HARDWARE => Yii::t('app', 'Hardware'),
                self::FLOW_CONTROL_NONE => Yii::t('app', 'None'),
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
            'bs1_model' => 'model',
            'bs1_com_port' => 'comPort',
            'bs1_speed' => 'speed',
            'bs1_data_bit' => 'dataBit',
            'bs1_parity' => 'parity',
            'bs1_stop_bit' => 'stopBit',
            'bs1_flow_control' => 'flowControl',
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
        $alias = BarcodeScanner::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.us1_id';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = BarcodeScanner::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id',
                'together' => true,
                'with' => array('user', 'cprofile', 'mprofile',),
                'order' => 'user.first_name, user.last_name',
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
        $models = BarcodeScanner::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) && isset($model->user))
                $rtv[$model->id] = $model->user->fullname;
        }
        return $rtv;
    }

    public $us1_search;
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
        $alias = BarcodeScanner::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('user', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.us1_id', $this->us1_id);
        if (isset($this->us1_search) && strlen($this->us1_search) > 0) {
            $criteria->addCondition('CONCAT(user.first_name, " ", user.last_name) LIKE :us1_search');
            $criteria->params = array_merge($criteria->params, array(':us1_search' => '%' . $this->us1_search . '%'));
        }
        $criteria->compare($alias . '.bs1_mac_address', $this->bs1_mac_address, true);
        $criteria->compare($alias . '.bs1_model', $this->bs1_model);
        $criteria->compare($alias . '.bs1_com_port', $this->bs1_com_port);
        $criteria->compare($alias . '.bs1_speed', $this->bs1_speed);
        $criteria->compare($alias . '.bs1_data_bit', $this->bs1_data_bit);
        $criteria->compare($alias . '.bs1_parity', $this->bs1_parity);
        $criteria->compare($alias . '.bs1_stop_bit', $this->bs1_stop_bit);
        $criteria->compare($alias . '.bs1_flow_control', $this->bs1_flow_control);
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
                        'asc' => 'user.first_name, user.last_name',
                        'desc' => 'user.first_name DESC, user.last_name DESC',
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
            'fileName' => Yii::t('app', 'BarcodeScanner').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
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
                    'field' => 'bs1_mac_address',
                    'label' => $this->getAttributeLabel('bs1_mac_address'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_model',
                    'label' => $this->getAttributeLabel('bs1_model'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'model'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_com_port',
                    'label' => $this->getAttributeLabel('bs1_com_port'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'comPort'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_speed',
                    'label' => $this->getAttributeLabel('bs1_speed'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'speed'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_data_bit',
                    'label' => $this->getAttributeLabel('bs1_data_bit'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'dataBit'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_parity',
                    'label' => $this->getAttributeLabel('bs1_parity'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'parity'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_stop_bit',
                    'label' => $this->getAttributeLabel('bs1_stop_bit'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'stopBit'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'bs1_flow_control',
                    'label' => $this->getAttributeLabel('bs1_flow_control'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => array('class' => 'BarcodeScanner', 'type' => 'flowControl'),
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

