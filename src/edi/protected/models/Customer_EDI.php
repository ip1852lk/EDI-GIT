<?php

/**
 * This is the model class for table 'cu1_customer'.
 *
 * The followings are the available columns in table 'cu1_customer':
 * @property string $CU1_ID
 * @property string $CORP_ADDRESS_ID
 * @property string $CU1_NAME
 * @property integer $CU1_CREATED_BY
 * @property string $CU1_CREATED_ON
 * @property integer $CU1_MODIFIED_BY
 * @property string $CU1_MODIFIED_ON
 * @property string $CU1_SHOW_DEFAULT
 * @property integer $CU1_RECEIVE_EDI
 * @property integer $CU1_SEND_EDI_INVOICES
 * @property string $CU1_SEND_EDI_ASN
 * @property integer $CU1_SEND_EDI_ORDERS
 * @property integer $CU1_SEND_EDI_ORDER_CONFIRMATIONS
 * @property integer $CU1_SEND_ACKNOWLEDGEMENT
 * @property string $CU1_ORDER_TYPE
 * @property integer $CU1_ORDER_FORMAT
 * @property integer $CU1_INVOICE_FORMAT
 * @property integer $CU1_ASN_FORMAT
 * @property integer $CU1_TXT_APPROVED
 * @property integer $CU1_SEND_FTP
 * @property integer $CU1_SEND_SFTP
 * @property integer $CU1_POST_HTTP
 * @property integer $CU1_RECEIVE_FTP
 * @property integer $CU1_PICKUP_FTP
 * @property integer $CU1_RECEIVE_HTTP
 * @property integer $CU1_PICKUP_SFTP
 * @property string $CU1_REMOTE_FTP_SERVER
 * @property string $CU1_REMOTE_FTP_USERNAME
 * @property string $CU1_REMOTE_FTP_PASSWORD
 * @property string $CU1_REMOTE_FTP_DIRECTORY_SEND
 * @property string $CU1_REMOTE_FTP_DIRECTORY_PICKUP
 * @property string $CU1_FTP_USER
 * @property string $CU1_FTP_PASSWORD
 * @property string $CU1_FTP_DIRECTORY
 * @property string $CU1_REMOTE_HTTP_SERVER
 * @property string $CU1_SUPPLIER_CODE
 * @property string $CU1_RECEIVER_QUALIFIER
 * @property string $CU1_RECEIVER_ID
 * @property string $CU1_FACILITY
 * @property string $CU1_TRADING_PARTNER_QUALIFIER
 * @property string $CU1_TRADING_PARTNER_ID
 * @property string $CU1_ASN_TRADING_PARTNER_ID
 * @property integer $CU1_CONSOLIDATE_ASN
 * @property string $CU1_FLAG
 * @property string $CU1_X12_STANDARD
 * @property string $CU1_EDI_VERSION
 * @property string $CU1_DUNS
 * @property string $CU1_SHARED_SECRET
 * @property integer $CU1_REJECT_INVALID_ITEM_ORDERS
 * @property string $CU1_INVALID_ITEM_SUBSTITUTE
 * @property integer $CU1_USE_CONTRACT
 * @property integer $CU1_SEND_CUSTOMERS_AND_ITEMS
 * @property integer $CU1_STOP_IMPORT_WITH_ERRORS
 * @property integer $CU1_USE_CLASS_ID
 * @property string $CU1_CLASS_ID
 * @property string $CU1_MAP
 * @property integer $CU1_ORDER_PRICE_OVERRIDE
 * @property integer $CU1_SEND_CREDIT_INVOICES
 * @property string $CU1_852_IMPORT_FOLDER
 * @property integer $CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS
 * @property integer $CU1_COMPLETE_SHIP_TO_NAME
 * @property integer $CU1_ALWAYS_SEND_ASNS
 * @property integer $CU1_IMPORT_FREIGHT_CODES
 * @property integer $CU1_POST_AS2
 * @property integer $CU1_RECEIVE_AS2
 * @property string $CU1_CXML_PAYLOAD_ID
 * @property string $CU1_AS2_CERTIFICATE_FILENAME
 * @property string $CU1_AS2_RECEIVER_ID
 * @property string $CU1_AS2_TRADING_PARTNER_ID
 * @property integer $CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID
 * @property integer $CU1_USE_P21_SHIP_TO_DATA
 * @property integer $CU1_ALLOW_DUPLICATE_PO_NUMBERS

 * The followings are the available model relations:
 */

class Customer_EDI extends JActiveRecord
{

    CONST SHOW_DEFAULT_FLAG = 'X';

    CONST CU1_INVOICE_FORMAT_EDI = 0;
    CONST CU1_INVOICE_FORMAT_CXML = 1;
    CONST CU1_INVOICE_FORMAT_880 = 2;
    CONST CU1_INVOICE_FORMAT_NAMM = 3;

    CONST CU1_ASN_FORMAT_EDI = 0;
    CONST CU1_ASN_FORMAT_RDY = 1;

    CONST CU1_INVENTORY_FORMAT_EDI = 1;

    CONST CU1_ORDER_FORMAT_EDI = 0;
    CONST CU1_ORDER_FORMAT_EZ_XML = 1;
    CONST CU1_ORDER_FORMAT_FIXED = 2;
    CONST CU1_ORDER_FORMAT_CXML = 3;
    CONST CU1_ORDER_FORMAT_CXML_SIMPLE = 4;
    CONST CU1_ORDER_FORMAT_EMAIL = 5;

    CONST FTP = "FTP";
    CONST FTP_AND_SFTP = "FTP SFTP";
    CONST FTP_AND_SFTP_AND_HTTP = "FTP SFTP HTTP";
    CONST SFTP = "SFTP";
    CONST SFTP_AND_HTTP = "SFTP HTTP";
    CONST HTTP = "HTTP";
    CONST PICKUP_FTP = "Pickup FTP";
    CONST PICKUP_SFTP = "Pickup SFTP";
    CONST FTP_AND_PICKUP_SFTP = "FTP Pickup SFTP";
    CONST FTP_AND_PICKUP_SFTP_AND_HTTP = "FTP Pickup SFTP HTTP";
    CONST PICKUP_SFTP_AND_HTTP = "Pickup SFTP HTTP";

    CONST SEND_COLUMN_SEARCH_FTP = "1100";
    CONST SEND_COLUMN_SEARCH_FTP_SFTP = "1110";
    CONST SEND_COLUMN_SEARCH_FTP_HTTP = "1101";
    CONST SEND_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP = "1111";
    CONST SEND_COLUMN_SEARCH_SFTP = "1010";
    CONST SEND_COLUMN_SEARCH_SFTP_AND_HTTP = "1011";
    CONST SEND_COLUMN_SEARCH_HTTP = "1001";
    CONST SEND_COLUMN_SEARCH_PICKUP_FTP = "1000";

    CONST RECEIVE_COLUMN_SEARCH_FTP = "100";
    CONST RECEIVE_COLUMN_SEARCH_FTP_SFTP = "110";
    CONST RECEIVE_COLUMN_SEARCH_FTP_HTTP = "101";
    CONST RECEIVE_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP = "111";
    CONST RECEIVE_COLUMN_SEARCH_SFTP = "010";
    CONST RECEIVE_COLUMN_SEARCH_SFTP_AND_HTTP = "011";
    CONST RECEIVE_COLUMN_SEARCH_HTTP = "001";
    CONST RECEIVE_COLUMN_SEARCH_PICKUP_FTP = "000";



    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer_EDI the static model class
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
        return 'cu1_customer';
    }

    /**
     * Returns the values associated with specific aliases
     * @param $type
     * @param null $code
     * @return bool
     */
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'CU1_INVOICE_FORMAT' => array(
                self::CU1_INVOICE_FORMAT_EDI    => Yii::t('app', 'EDI 810'),
                self::CU1_INVOICE_FORMAT_CXML   => Yii::t('app', 'cXML'),
                self::CU1_INVOICE_FORMAT_880    => Yii::t('app', '880 EDI'),
                self::CU1_INVOICE_FORMAT_NAMM   => Yii::t('app', 'NAMM XML'),
            ),
            'CU1_ASN_FORMAT' => array(
                self::CU1_ASN_FORMAT_EDI    => Yii::t('app', 'EDI 856'),
                self::CU1_ASN_FORMAT_RDY    => Yii::t('app', 'Tab Delimited RDY'),
            ),
            'CU1_INVENTORY_FORMAT' => array(
                self::CU1_INVENTORY_FORMAT_EDI  => Yii::t('app', 'EDI 846'),
            ),
            'CU1_ORDER_FORMAT' => array(
                self::CU1_ORDER_FORMAT_EDI          => Yii::t('app', 'EDI 850'),
                self::CU1_ORDER_FORMAT_EZ_XML       => Yii::t('app', 'EZ XML'),
                self::CU1_ORDER_FORMAT_FIXED        => Yii::t('app', 'Fixed Field Text'),
                self::CU1_ORDER_FORMAT_CXML         => Yii::t('app', 'cXML'),
                self::CU1_ORDER_FORMAT_CXML_SIMPLE  => Yii::t('app', 'cXML Simole'),
                self::CU1_ORDER_FORMAT_EMAIL        => Yii::t('app', 'Email'),
            ),
            'SEND_COLUMN_SEARCH_TEXT' => array(
                self::SEND_COLUMN_SEARCH_FTP                    => Yii::t('app', 'FTP'),
                self::SEND_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP  => Yii::t('app', 'FTP & SFTP & HTTP'),
                self::SEND_COLUMN_SEARCH_FTP_SFTP               => Yii::t('app', 'FTP & SFTP'),
                self::SEND_COLUMN_SEARCH_FTP_HTTP               => Yii::t('app', 'FTP & HTTP'),
                self::SEND_COLUMN_SEARCH_SFTP                   => Yii::t('app', 'SFTP'),
                self::SEND_COLUMN_SEARCH_SFTP_AND_HTTP          => Yii::t('app', 'SFTP & HTTP'),
                self::SEND_COLUMN_SEARCH_HTTP                   => Yii::t('app', 'HTTP'),
                self::SEND_COLUMN_SEARCH_PICKUP_FTP             => Yii::t('app', 'Pickup FTP'),
            ),
            'RECEIVE_COLUMN_SEARCH_TEXT' => array(
                self::RECEIVE_COLUMN_SEARCH_FTP                     => Yii::t('app', 'Receive FTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP   => Yii::t('app', 'Receive FTP & Pickup SFTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_SFTP                => Yii::t('app', 'Receive FTP & Pickup SFTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_HTTP                => Yii::t('app', 'Receive FTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_SFTP                    => Yii::t('app', 'Pickup SFTP'),
                self::RECEIVE_COLUMN_SEARCH_SFTP_AND_HTTP           => Yii::t('app', 'Pickup SFTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_HTTP                    => Yii::t('app', 'HTTP'),
                self::RECEIVE_COLUMN_SEARCH_PICKUP_FTP              => Yii::t('app', 'Pickup FTP'),
            ),
            'SEND_COLUMN_LABELS' => array(
                self::FTP                             => Yii::t('app', '<span class="label label-default">FTP</span>'),
                self::FTP_AND_SFTP                    => Yii::t('app', '<span class="label label-default">FTP</span><span class="label label-primary">SFTP</span>'),
                self::FTP_AND_SFTP_AND_HTTP           => Yii::t('app', '<span class="label label-default">FTP</span><span class="label label-primary">SFTP</span><span class="label label-warning">HTTP</span>'),
                self::SFTP                            => Yii::t('app', '<span class="label label-primary">SFTP</span>'),
                self::SFTP_AND_HTTP                   => Yii::t('app', '<span class="label label-primary">SFTP</span><span class="label label-warning">HTTP</span>'),
                self::HTTP                            => Yii::t('app', '<span class="label label-warning">HTTP</span>'),
                self::SEND_COLUMN_SEARCH_PICKUP_FTP                       => Yii::t('app', '<span class="label label-info">Pickup FTP'),
            ),
            'RECEIVE_COLUMN_LABELS' => array(
                self::FTP                             => Yii::t('app', '<span class="label label-default">Receive FTP</span>'),
                self::FTP_AND_PICKUP_SFTP             => Yii::t('app', '<span class="label label-default">Receive FTP</span><span class="label label-primary">Pickup SFTP</span>'),
                self::FTP_AND_PICKUP_SFTP_AND_HTTP    => Yii::t('app', '<span class="label label-default">Receive FTP</span><span class="label label-primary">Pickup SFTP</span><span class="label label-warning">HTTP</span>'),
                self::PICKUP_SFTP                     => Yii::t('app', '<span class="label label-primary">Pickup SFTP</span>'),
                self::PICKUP_SFTP_AND_HTTP            => Yii::t('app', '<span class="label label-primary">Pickup SFTP</span><span class="label label-warning">HTTP</span>'),
                self::HTTP                            => Yii::t('app', '<span class="label label-warning">HTTP</span>'),
                self::PICKUP_FTP                      => Yii::t('app', '<span class="label label-info">Pickup FTP</span>'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function sendColumnLogic()
    {
        $result = '';

        if((isset($this->CU1_SEND_EDI_INVOICES) && $this->CU1_SEND_EDI_INVOICES == 1)||(isset($this->CU1_SEND_EDI_ORDERS) && $this->CU1_SEND_EDI_ORDERS == 1)||(isset($this->CU1_SEND_EDI_ASN) && $this->CU1_SEND_EDI_ASN == 1)){
            if($this->CU1_SEND_FTP == 1){
                $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP');
                if($this->CU1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP SFTP');
                    if($this->CU1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP SFTP HTTP');
                    }
                }
                else{
                    if($this->CU1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP HTTP');
                    }
                }
            }
            else{
                if($this->CU1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS','SFTP');
                    if($this->CU1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','SFTP HTTP');
                    }
                }
                else{
                    if($this->CU1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','HTTP');
                    }
                    else{
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','Pickup FTP');
                    }
                }
            }
        }

        return $result;
    }

    public function receiveColumnLogic()
    {
        $result = '';

        if(isset($this->CU1_RECEIVE_EDI) && $this->CU1_RECEIVE_EDI == 1){
            if($this->CU1_RECEIVE_FTP == 1){
                $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP');
                if($this->CU1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup SFTP');
                    if($this->CU1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->CU1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup FTP');
                    }
                }
            }
            else{
                if($this->CU1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup SFTP');
                    if($this->CU1_RECEIVE_HTTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','HTTP');
                    }
                    if($this->CU1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->CU1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup SFTP HTTP');
                    }
                    else{
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup FTP');
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Returns a version of the CU1_ID link with a label wrapped around it
     * @param $UHTML
     * @param $updateLink
     * @return string
     */
    public function returnDocumentNumberLabel($UHTML, $updateLink){
        $UHTML = '<span class="label label-info">' . $UHTML . '</span>';
        return TbHtml::link($UHTML,$updateLink);
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
            array('CU1_NAME', 'required'),
            array('CU1_CREATED_BY, CU1_MODIFIED_BY, CU1_RECEIVE_EDI, CU1_SEND_EDI_INVOICES, CU1_SEND_EDI_ORDERS, CU1_SEND_EDI_ORDER_CONFIRMATIONS, CU1_SEND_ACKNOWLEDGEMENT, CU1_ORDER_FORMAT, CU1_INVOICE_FORMAT, CU1_ASN_FORMAT, CU1_TXT_APPROVED, CU1_SEND_FTP, CU1_SEND_SFTP, CU1_POST_HTTP, CU1_RECEIVE_FTP, CU1_PICKUP_FTP, CU1_RECEIVE_HTTP, CU1_PICKUP_SFTP, CU1_CONSOLIDATE_ASN, CU1_REJECT_INVALID_ITEM_ORDERS, CU1_USE_CONTRACT, CU1_SEND_CUSTOMERS_AND_ITEMS, CU1_STOP_IMPORT_WITH_ERRORS, CU1_USE_CLASS_ID, CU1_ORDER_PRICE_OVERRIDE, CU1_SEND_CREDIT_INVOICES, CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS, CU1_COMPLETE_SHIP_TO_NAME, CU1_ALWAYS_SEND_ASNS, CU1_IMPORT_FREIGHT_CODES, CU1_POST_AS2, CU1_RECEIVE_AS2, CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID, CU1_USE_P21_SHIP_TO_DATA, CU1_ALLOW_DUPLICATE_PO_NUMBERS', 'numerical', 'integerOnly'=>true),
            array('CORP_ADDRESS_ID', 'length', 'max'=>10),
            array('CU1_NAME, CU1_SHARED_SECRET', 'length', 'max'=>100),
            array('CU1_SHOW_DEFAULT, CU1_FLAG', 'length', 'max'=>1),
            array('CU1_SEND_EDI_ASN, CU1_ORDER_TYPE, CU1_SUPPLIER_CODE, CU1_RECEIVER_ID, CU1_FACILITY, CU1_TRADING_PARTNER_ID, CU1_ASN_TRADING_PARTNER_ID, CU1_INVALID_ITEM_SUBSTITUTE', 'length', 'max'=>45),
            array('CU1_REMOTE_FTP_SERVER, CU1_REMOTE_FTP_USERNAME, CU1_REMOTE_FTP_PASSWORD, CU1_REMOTE_FTP_DIRECTORY_SEND, CU1_REMOTE_FTP_DIRECTORY_PICKUP, CU1_FTP_USER, CU1_FTP_PASSWORD, CU1_FTP_DIRECTORY, CU1_REMOTE_HTTP_SERVER', 'length', 'max'=>200),
            array('CU1_RECEIVER_QUALIFIER, CU1_TRADING_PARTNER_QUALIFIER', 'length', 'max'=>2),
            array('CU1_X12_STANDARD', 'length', 'max'=>4),
            array('CU1_EDI_VERSION', 'length', 'max'=>5),
            array('CU1_DUNS, CU1_CLASS_ID, CU1_MAP', 'length', 'max'=>50),
            array('CU1_852_IMPORT_FOLDER, CU1_CXML_PAYLOAD_ID, CU1_AS2_CERTIFICATE_FILENAME, CU1_AS2_RECEIVER_ID, CU1_AS2_TRADING_PARTNER_ID', 'length', 'max'=>255),
            array('CU1_CREATED_ON, CU1_MODIFIED_ON', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('CU1_ID, CORP_ADDRESS_ID, CU1_NAME, CU1_CREATED_BY, CU1_CREATED_ON, CU1_MODIFIED_BY, CU1_MODIFIED_ON, CU1_SHOW_DEFAULT, CU1_RECEIVE_EDI, CU1_SEND_EDI_INVOICES, CU1_SEND_EDI_ASN, CU1_SEND_EDI_ORDERS, CU1_SEND_EDI_ORDER_CONFIRMATIONS, CU1_SEND_ACKNOWLEDGEMENT, CU1_ORDER_TYPE, CU1_ORDER_FORMAT, CU1_INVOICE_FORMAT, CU1_ASN_FORMAT, CU1_TXT_APPROVED, CU1_SEND_FTP, CU1_SEND_SFTP, CU1_POST_HTTP, CU1_RECEIVE_FTP, CU1_PICKUP_FTP, CU1_RECEIVE_HTTP, CU1_PICKUP_SFTP, CU1_REMOTE_FTP_SERVER, CU1_REMOTE_FTP_USERNAME, CU1_REMOTE_FTP_PASSWORD, CU1_REMOTE_FTP_DIRECTORY_SEND, CU1_REMOTE_FTP_DIRECTORY_PICKUP, CU1_FTP_USER, CU1_FTP_PASSWORD, CU1_FTP_DIRECTORY, CU1_REMOTE_HTTP_SERVER, CU1_SUPPLIER_CODE, CU1_RECEIVER_QUALIFIER, CU1_RECEIVER_ID, CU1_FACILITY, CU1_TRADING_PARTNER_QUALIFIER, CU1_TRADING_PARTNER_ID, CU1_ASN_TRADING_PARTNER_ID, CU1_CONSOLIDATE_ASN, CU1_FLAG, CU1_X12_STANDARD, CU1_EDI_VERSION, CU1_DUNS, CU1_SHARED_SECRET, CU1_REJECT_INVALID_ITEM_ORDERS, CU1_INVALID_ITEM_SUBSTITUTE, CU1_USE_CONTRACT, CU1_SEND_CUSTOMERS_AND_ITEMS, CU1_STOP_IMPORT_WITH_ERRORS, CU1_USE_CLASS_ID, CU1_CLASS_ID, CU1_MAP, CU1_ORDER_PRICE_OVERRIDE, CU1_SEND_CREDIT_INVOICES, CU1_852_IMPORT_FOLDER, CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS, CU1_COMPLETE_SHIP_TO_NAME, CU1_ALWAYS_SEND_ASNS, CU1_IMPORT_FREIGHT_CODES, CU1_POST_AS2, CU1_RECEIVE_AS2, CU1_CXML_PAYLOAD_ID, CU1_AS2_CERTIFICATE_FILENAME, CU1_AS2_RECEIVER_ID, CU1_AS2_TRADING_PARTNER_ID, CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID, CU1_USE_P21_SHIP_TO_DATA, CU1_ALLOW_DUPLICATE_PO_NUMBERS, send_edi_search, receive_edi_search, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),

            // Rules for relations
            //array('REQUIRED_COLUMNS_ONLY_FOR_RELATION_SEPARATED_BY_COMMA', 'required', 'on' => 'relation'),
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
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'CU1_CREATED_BY',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'CU1_MODIFIED_BY',),
        );
    }

    public function getColumnsNotInYii(){
        $ediTable = Yii::app()->db->schema->getTable('cu1_customer', true);

        $databaseAttributes = $ediTable->columns;
        $yiiAttributes = $this->attributeLabels(false);
        $newAttributes = array();
        foreach($databaseAttributes as $databaseAttribute){
            foreach($yiiAttributes as $yiiAttribute => $value){
                $found = false;
                if($databaseAttribute->name == $yiiAttribute){
                    $found = true;
                    break;
                }
            }
            if($found == false){
                $newAttributes[] = $databaseAttribute;
            }
        }
        return $newAttributes;
    }


    /**
     * Checks the type of each new column and assigns the correct rules to it
     * @return array
     */
    private function getDynamicRules()
    {
        $rules = array();
        $newFields = Edi::getColumnsNotInYii();
        if (isset($newFields) && count($newFields) > 0) {
            $required = array();
            $numerical = array();
            $float = array();
            $decimal = array();
            $search = array();
            $safe = array();

            foreach ($newFields as $field) {
                if (strpos($field->dbType, 'float'))
                    array_push($float, $field->name);
                if (strpos($field->dbType, 'decimal') !== false)
                    array_push($decimal, $field->name);
                if (strpos($field->dbType, 'int') !== false)
                    array_push($numerical, $field->name);
                if (strpos($field->dbType, 'varchar') !== false || strpos($field->dbType, 'text') !== false) {
                    $field_rule = array($field->name, 'length', 'max' => $field->size, 'on' => 'insert, update');
                    array_push($rules, $field_rule);
                }
                if (strpos($field->dbType, 'datetime') !== false) {
                    $field_rule = array($field->name, 'length', 'max' => $field->size, 'on' => 'insert, update');
                    array_push($rules, $field_rule);
                } else {
                    if (strpos($field->dbType, 'date') !== false) {
                        $field_rule = array($field->name, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty' => true, 'on' => 'insert, update');
                        array_push($rules, $field_rule);
                    }
                }
                array_push($search, $field->name);
            }
            array_push($rules, array(implode(',', $required), 'required', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $numerical), 'numerical', 'integerOnly' => true, 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $float), 'type', 'type' => 'float', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $decimal), 'match', 'pattern' => '/^\s*[\-\+]?[0-9]*\.?[0-9]+([eE][\-\+]?[0-9]+)?\s*$/', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $safe), 'safe', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $search), 'safe', 'on' => 'search', 'on' => 'insert, update'));

        }
        return $rules;
    }

    public function getDynamicAttributeLabels(){
        $labels = array();
        $newFields = Customer_EDI::getColumnsNotInYii();
        if(isset($newFields) && count($newFields) > 0){
            $temp = array();
            foreach ($newFields as $field){
                $temp = array_merge(array($field->name => substr($field->name,4,strlen($field->name))),$temp);
            }
            $labels = $temp;
        }
        return $labels;
    }


        /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels($includeDynamicLabels = true)
    {
        $mainLabels = array(
            'CU1_ID' => 'ID',
            'CORP_ADDRESS_ID' => 'Corp Address ID',
            'CU1_NAME' => 'Customer Name',
            'CU1_CREATED_BY' => 'Created By',
            'CU1_CREATED_ON' => 'Created On',
            'CU1_MODIFIED_BY' => 'Modified By',
            'CU1_MODIFIED_ON' => 'Modified On',
            'CU1_SHOW_DEFAULT' => 'Show Default',
            'CU1_RECEIVE_EDI' => 'Receive EDI',
            'CU1_SEND_EDI_INVOICES' => 'Send EDI Invoices',
            'CU1_SEND_EDI_ASN' => 'Send EDI ASN',
            'CU1_SEND_EDI_ORDERS' => 'Send EDI Orders',
            'CU1_SEND_EDI_ORDER_CONFIRMATIONS' => 'Send EDI Order Confirmations',
            'CU1_SEND_ACKNOWLEDGEMENT' => 'Send Acknowledgement',
            'CU1_SEND_INVENTORY' => 'Send Inventory',
            'CU1_INVENTORY_FORMAT' => 'Inventory Format',
            'CU1_ORDER_TYPE' => 'Order Type',
            'CU1_ORDER_FORMAT' => 'Order Format',
            'CU1_INVOICE_FORMAT' => 'Invoice Format',
            'CU1_ASN_FORMAT' => 'ASN Format',
            'CU1_TXT_APPROVED' => 'TXT Approved',
            'CU1_SEND_FTP' => 'Send FTP',
            'CU1_SEND_SFTP' => 'Send SFTP',
            'CU1_POST_HTTP' => 'Post HTTP',
            'CU1_RECEIVE_FTP' => 'Receive FTP',
            'CU1_PICKUP_FTP' => 'Pickup FTP',
            'CU1_RECEIVE_HTTP' => 'Receive HTTP',
            'CU1_PICKUP_SFTP' => 'Pickup SFTP',
            'CU1_REMOTE_FTP_SERVER' => 'Remote FTP Server',
            'CU1_REMOTE_FTP_USERNAME' => 'Remote FTP Username',
            'CU1_REMOTE_FTP_PASSWORD' => 'Remote FTP Password',
            'CU1_REMOTE_FTP_DIRECTORY_SEND' => 'Remote FTP Directory Send',
            'CU1_REMOTE_FTP_DIRECTORY_PICKUP' => 'Remote FTP Directory Pickup',
            'CU1_FTP_USER' => 'FTP User',
            'CU1_FTP_PASSWORD' => 'FTP Password',
            'CU1_FTP_DIRECTORY' => 'FTP Directory',
            'CU1_REMOTE_HTTP_SERVER' => 'Remote HTTP Server',
            'CU1_SUPPLIER_CODE' => 'Supplier Code',
            'CU1_RECEIVER_QUALIFIER' => 'Receiver Qualifier',
            'CU1_RECEIVER_ID' => 'Receiver ID',
            'CU1_FACILITY' => 'Facility',
            'CU1_TRADING_PARTNER_QUALIFIER' => 'Trading Partner Qualifier',
            'CU1_TRADING_PARTNER_ID' => 'Trading Partner ID',
            'CU1_ASN_TRADING_PARTNER_ID' => 'ASN Trading Partner ID',
            'CU1_CONSOLIDATE_ASN' => 'Consolidate ASN',
            'CU1_FLAG' => 'Flag',
            'CU1_X12_STANDARD' => 'X12 Standard',
            'CU1_EDI_VERSION' => 'EDI Version',
            'CU1_DUNS' => 'Duns',
            'CU1_SHARED_SECRET' => 'Shared Secret',
            'CU1_REJECT_INVALID_ITEM_ORDERS' => 'Reject Invalid Item Orders',
            'CU1_INVALID_ITEM_SUBSTITUTE' => 'Invalid Item Substitute',
            'CU1_USE_CONTRACT' => 'Use Contract',
            'CU1_SEND_CUSTOMERS_AND_ITEMS' => 'Send Customers And Items',
            'CU1_STOP_IMPORT_WITH_ERRORS' => 'Stop Import With Errors',
            'CU1_USE_CLASS_ID' => 'Use Class',
            'CU1_CLASS_ID' => 'Class',
            'CU1_MAP' => 'Map',
            'CU1_ORDER_PRICE_OVERRIDE' => 'Order Price Override',
            'CU1_SEND_CREDIT_INVOICES' => 'Send Credit Invoices',
            'CU1_852_IMPORT_FOLDER' => '852 Import Folder',
            'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS' => 'Always Send Order Confirmations',
            'CU1_COMPLETE_SHIP_TO_NAME' => 'Complete Ship To Name',
            'CU1_ALWAYS_SEND_ASNS' => 'Always Send ASN',
            'CU1_IMPORT_FREIGHT_CODES' => 'Import Freight Codes',
            'CU1_POST_AS2' => 'Post AS2',
            'CU1_RECEIVE_AS2' => 'Receive AS2',
            'CU1_CXML_PAYLOAD_ID' => 'cXML Payload',
            'CU1_AS2_CERTIFICATE_FILENAME' => 'AS2 Certificate Filename',
            'CU1_AS2_KEY_LENGTH' => 'Key Length',
            'CU1_AS2_REQUEST_RECEIPT' => 'Request Receipt',
            'CU1_AS2_SIGN_MESSAGES' => 'Sign Messages',
            'CU1_AS2_RECEIVER_ID' => 'Receiver ID',
            'CU1_AS2_TRADING_PARTNER_ID' => 'Trading Partner ID',
            'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID' => 'Customer Sends P21 Ship To',
            'CU1_USE_P21_SHIP_TO_DATA' => 'Use P21 Ship To Data',
            'CU1_ALLOW_DUPLICATE_PO_NUMBERS' => 'Allow Duplicate PO Numbers',
            'send_edi_search' => 'Send EDI',
            'receive_edi_search'  => 'Receive EDI',
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
        );
        if($includeDynamicLabels == true){
            $dynamicLabels = Customer_EDI::getDynamicAttributeLabels();
            return array_merge($mainLabels, $dynamicLabels);
        }
        else{
            return $mainLabels;
        }
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Customer_EDI::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.CU1_ID';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Customer_EDI::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.CU1_ID, ' . $alias . '.CORP_ADDRESS_ID',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.CU1_ID',
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
        $models = Customer_EDI::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->CU1_ID)) {
                $rtv[$model->CU1_ID] = $model->CORP_ADDRESS_ID;
            }
        }
        return $rtv;
    }

    public $send_edi_search;
    public $receive_edi_search;
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
        $alias = Customer_EDI::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('cprofile', 'mprofile',);
        $criteria->compare($alias . '.CU1_ID', $this->CU1_ID, true);
        $criteria->compare($alias . '.CORP_ADDRESS_ID', $this->CORP_ADDRESS_ID, true);
        $criteria->compare($alias . '.CU1_NAME', $this->CU1_NAME, true);
        $criteria->compare($alias . '.CU1_CREATED_BY', $this->CU1_CREATED_BY);
        $criteria->compare($alias . '.CU1_CREATED_ON', $this->CU1_CREATED_ON, true);
        $criteria->compare($alias . '.CU1_MODIFIED_BY', $this->CU1_MODIFIED_BY);
        $criteria->compare($alias . '.CU1_MODIFIED_ON', $this->CU1_MODIFIED_ON, true);
        $criteria->compare($alias . '.CU1_SHOW_DEFAULT', $this->CU1_SHOW_DEFAULT, true);
        $criteria->compare($alias . '.CU1_RECEIVE_EDI', $this->CU1_RECEIVE_EDI);
        $criteria->compare($alias . '.CU1_SEND_EDI_INVOICES', $this->CU1_SEND_EDI_INVOICES);
        $criteria->compare($alias . '.CU1_SEND_EDI_ASN', $this->CU1_SEND_EDI_ASN, true);
        $criteria->compare($alias . '.CU1_SEND_EDI_ORDERS', $this->CU1_SEND_EDI_ORDERS);
        $criteria->compare($alias . '.CU1_SEND_EDI_ORDER_CONFIRMATIONS', $this->CU1_SEND_EDI_ORDER_CONFIRMATIONS);
        $criteria->compare($alias . '.CU1_SEND_ACKNOWLEDGEMENT', $this->CU1_SEND_ACKNOWLEDGEMENT);
        $criteria->compare($alias . '.CU1_ORDER_TYPE', $this->CU1_ORDER_TYPE, true);
        $criteria->compare($alias . '.CU1_ORDER_FORMAT', $this->CU1_ORDER_FORMAT);
        $criteria->compare($alias . '.CU1_INVOICE_FORMAT', $this->CU1_INVOICE_FORMAT);
        $criteria->compare($alias . '.CU1_ASN_FORMAT', $this->CU1_ASN_FORMAT);
        $criteria->compare($alias . '.CU1_TXT_APPROVED', $this->CU1_TXT_APPROVED);
        $criteria->compare($alias . '.CU1_SEND_FTP', $this->CU1_SEND_FTP);
        $criteria->compare($alias . '.CU1_SEND_SFTP', $this->CU1_SEND_SFTP);
        $criteria->compare($alias . '.CU1_POST_HTTP', $this->CU1_POST_HTTP);
        $criteria->compare($alias . '.CU1_RECEIVE_FTP', $this->CU1_RECEIVE_FTP);
        $criteria->compare($alias . '.CU1_PICKUP_FTP', $this->CU1_PICKUP_FTP);
        $criteria->compare($alias . '.CU1_RECEIVE_HTTP', $this->CU1_RECEIVE_HTTP);
        $criteria->compare($alias . '.CU1_PICKUP_SFTP', $this->CU1_PICKUP_SFTP);
        $criteria->compare($alias . '.CU1_REMOTE_FTP_SERVER', $this->CU1_REMOTE_FTP_SERVER, true);
        $criteria->compare($alias . '.CU1_REMOTE_FTP_USERNAME', $this->CU1_REMOTE_FTP_USERNAME, true);
        $criteria->compare($alias . '.CU1_REMOTE_FTP_PASSWORD', $this->CU1_REMOTE_FTP_PASSWORD, true);
        $criteria->compare($alias . '.CU1_REMOTE_FTP_DIRECTORY_SEND', $this->CU1_REMOTE_FTP_DIRECTORY_SEND, true);
        $criteria->compare($alias . '.CU1_REMOTE_FTP_DIRECTORY_PICKUP', $this->CU1_REMOTE_FTP_DIRECTORY_PICKUP, true);
        $criteria->compare($alias . '.CU1_FTP_USER', $this->CU1_FTP_USER, true);
        $criteria->compare($alias . '.CU1_FTP_PASSWORD', $this->CU1_FTP_PASSWORD, true);
        $criteria->compare($alias . '.CU1_FTP_DIRECTORY', $this->CU1_FTP_DIRECTORY, true);
        $criteria->compare($alias . '.CU1_REMOTE_HTTP_SERVER', $this->CU1_REMOTE_HTTP_SERVER, true);
        $criteria->compare($alias . '.CU1_SUPPLIER_CODE', $this->CU1_SUPPLIER_CODE, true);
        $criteria->compare($alias . '.CU1_RECEIVER_QUALIFIER', $this->CU1_RECEIVER_QUALIFIER, true);
        $criteria->compare($alias . '.CU1_RECEIVER_ID', $this->CU1_RECEIVER_ID, true);
        $criteria->compare($alias . '.CU1_FACILITY', $this->CU1_FACILITY, true);
        $criteria->compare($alias . '.CU1_TRADING_PARTNER_QUALIFIER', $this->CU1_TRADING_PARTNER_QUALIFIER, true);
        $criteria->compare($alias . '.CU1_TRADING_PARTNER_ID', $this->CU1_TRADING_PARTNER_ID, true);
        $criteria->compare($alias . '.CU1_ASN_TRADING_PARTNER_ID', $this->CU1_ASN_TRADING_PARTNER_ID, true);
        $criteria->compare($alias . '.CU1_CONSOLIDATE_ASN', $this->CU1_CONSOLIDATE_ASN);
        $criteria->compare($alias . '.CU1_FLAG', $this->CU1_FLAG, true);
        $criteria->compare($alias . '.CU1_X12_STANDARD', $this->CU1_X12_STANDARD, true);
        $criteria->compare($alias . '.CU1_EDI_VERSION', $this->CU1_EDI_VERSION, true);
        $criteria->compare($alias . '.CU1_DUNS', $this->CU1_DUNS, true);
        $criteria->compare($alias . '.CU1_SHARED_SECRET', $this->CU1_SHARED_SECRET, true);
        $criteria->compare($alias . '.CU1_REJECT_INVALID_ITEM_ORDERS', $this->CU1_REJECT_INVALID_ITEM_ORDERS);
        $criteria->compare($alias . '.CU1_INVALID_ITEM_SUBSTITUTE', $this->CU1_INVALID_ITEM_SUBSTITUTE, true);
        $criteria->compare($alias . '.CU1_USE_CONTRACT', $this->CU1_USE_CONTRACT);
        $criteria->compare($alias . '.CU1_SEND_CUSTOMERS_AND_ITEMS', $this->CU1_SEND_CUSTOMERS_AND_ITEMS);
        $criteria->compare($alias . '.CU1_STOP_IMPORT_WITH_ERRORS', $this->CU1_STOP_IMPORT_WITH_ERRORS);
        $criteria->compare($alias . '.CU1_USE_CLASS_ID', $this->CU1_USE_CLASS_ID);
        $criteria->compare($alias . '.CU1_CLASS_ID', $this->CU1_CLASS_ID, true);
        $criteria->compare($alias . '.CU1_MAP', $this->CU1_MAP, true);
        $criteria->compare($alias . '.CU1_ORDER_PRICE_OVERRIDE', $this->CU1_ORDER_PRICE_OVERRIDE);
        $criteria->compare($alias . '.CU1_SEND_CREDIT_INVOICES', $this->CU1_SEND_CREDIT_INVOICES);
        $criteria->compare($alias . '.CU1_852_IMPORT_FOLDER', $this->CU1_852_IMPORT_FOLDER, true);
        $criteria->compare($alias . '.CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS', $this->CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS);
        $criteria->compare($alias . '.CU1_COMPLETE_SHIP_TO_NAME', $this->CU1_COMPLETE_SHIP_TO_NAME);
        $criteria->compare($alias . '.CU1_ALWAYS_SEND_ASNS', $this->CU1_ALWAYS_SEND_ASNS);
        $criteria->compare($alias . '.CU1_IMPORT_FREIGHT_CODES', $this->CU1_IMPORT_FREIGHT_CODES);
        $criteria->compare($alias . '.CU1_POST_AS2', $this->CU1_POST_AS2);
        $criteria->compare($alias . '.CU1_RECEIVE_AS2', $this->CU1_RECEIVE_AS2);
        $criteria->compare($alias . '.CU1_CXML_PAYLOAD_ID', $this->CU1_CXML_PAYLOAD_ID, true);
        $criteria->compare($alias . '.CU1_AS2_CERTIFICATE_FILENAME', $this->CU1_AS2_CERTIFICATE_FILENAME, true);
        $criteria->compare($alias . '.CU1_AS2_RECEIVER_ID', $this->CU1_AS2_RECEIVER_ID, true);
        $criteria->compare($alias . '.CU1_AS2_TRADING_PARTNER_ID', $this->CU1_AS2_TRADING_PARTNER_ID, true);
        $criteria->compare($alias . '.CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID', $this->CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID);
        $criteria->compare($alias . '.CU1_USE_P21_SHIP_TO_DATA', $this->CU1_USE_P21_SHIP_TO_DATA);
        $criteria->compare($alias . '.CU1_ALLOW_DUPLICATE_PO_NUMBERS', $this->CU1_ALLOW_DUPLICATE_PO_NUMBERS);

        if(isset($this->send_edi_search)){
            $criteria->compare('concat((CU1_SEND_EDI_INVOICES | CU1_SEND_EDI_ASN | CU1_SEND_EDI_ORDERS),CU1_SEND_FTP,CU1_SEND_SFTP,CU1_POST_HTTP)', $this->send_edi_search, true);
        }

        if(isset($this->receive_edi_search)){
            $criteria->compare('concat(CU1_RECEIVE_FTP,CU1_PICKUP_SFTP,CU1_PICKUP_FTP)', $this->receive_edi_search, true);
        }

        if (isset($this->cprofile_search) && strlen($this->cprofile_search) > 0) {
            $criteria->addCondition('CONCAT(cprofile.first_name, " ", cprofile.last_name) LIKE :cprofile_search');
            $criteria->params = array_merge($criteria->params, array(':cprofile_search' => '%' . $this->cprofile_search . '%'));
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
                    'send_edi_search'=>array(
                        'asc'=>'concat((CU1_SEND_EDI_INVOICES | CU1_SEND_EDI_ASN | CU1_SEND_EDI_ORDERS),CU1_SEND_FTP,CU1_SEND_SFTP,CU1_POST_HTTP)',
                        'desc'=>'concat((CU1_SEND_EDI_INVOICES | CU1_SEND_EDI_ASN | CU1_SEND_EDI_ORDERS),CU1_SEND_FTP,CU1_SEND_SFTP,CU1_POST_HTTP) DESC'
                    ),
                    'receive_edi_search'=>array(
                        'asc'=>'concat(CU1_RECEIVE_FTP,CU1_PICKUP_SFTP,CU1_PICKUP_FTP)',
                        'desc'=>'concat(CU1_RECEIVE_FTP,CU1_PICKUP_SFTP,CU1_PICKUP_FTP) DESC'
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
            'fileName' => Yii::t('app', 'Customer_EDI').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'CU1_ID',
                    'label' => $this->getAttributeLabel('CU1_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CORP_ADDRESS_ID',
                    'label' => $this->getAttributeLabel('CORP_ADDRESS_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_NAME',
                    'label' => $this->getAttributeLabel('CU1_NAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CREATED_BY',
                    'label' => $this->getAttributeLabel('CU1_CREATED_BY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CREATED_ON',
                    'label' => $this->getAttributeLabel('CU1_CREATED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_MODIFIED_BY',
                    'label' => $this->getAttributeLabel('CU1_MODIFIED_BY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_MODIFIED_ON',
                    'label' => $this->getAttributeLabel('CU1_MODIFIED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SHOW_DEFAULT',
                    'label' => $this->getAttributeLabel('CU1_SHOW_DEFAULT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVE_EDI',
                    'label' => $this->getAttributeLabel('CU1_RECEIVE_EDI'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_EDI_INVOICES',
                    'label' => $this->getAttributeLabel('CU1_SEND_EDI_INVOICES'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_EDI_ASN',
                    'label' => $this->getAttributeLabel('CU1_SEND_EDI_ASN'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_EDI_ORDERS',
                    'label' => $this->getAttributeLabel('CU1_SEND_EDI_ORDERS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
                    'label' => $this->getAttributeLabel('CU1_SEND_EDI_ORDER_CONFIRMATIONS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_ACKNOWLEDGEMENT',
                    'label' => $this->getAttributeLabel('CU1_SEND_ACKNOWLEDGEMENT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ORDER_TYPE',
                    'label' => $this->getAttributeLabel('CU1_ORDER_TYPE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ORDER_FORMAT',
                    'label' => $this->getAttributeLabel('CU1_ORDER_FORMAT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_INVOICE_FORMAT',
                    'label' => $this->getAttributeLabel('CU1_INVOICE_FORMAT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ASN_FORMAT',
                    'label' => $this->getAttributeLabel('CU1_ASN_FORMAT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_TXT_APPROVED',
                    'label' => $this->getAttributeLabel('CU1_TXT_APPROVED'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_FTP',
                    'label' => $this->getAttributeLabel('CU1_SEND_FTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_SFTP',
                    'label' => $this->getAttributeLabel('CU1_SEND_SFTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_POST_HTTP',
                    'label' => $this->getAttributeLabel('CU1_POST_HTTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVE_FTP',
                    'label' => $this->getAttributeLabel('CU1_RECEIVE_FTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_PICKUP_FTP',
                    'label' => $this->getAttributeLabel('CU1_PICKUP_FTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVE_HTTP',
                    'label' => $this->getAttributeLabel('CU1_RECEIVE_HTTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_PICKUP_SFTP',
                    'label' => $this->getAttributeLabel('CU1_PICKUP_SFTP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_FTP_SERVER',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_FTP_SERVER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_FTP_USERNAME',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_FTP_USERNAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_FTP_PASSWORD',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_FTP_PASSWORD'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_FTP_DIRECTORY_SEND',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_FTP_DIRECTORY_SEND'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_FTP_DIRECTORY_PICKUP',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_FTP_DIRECTORY_PICKUP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_FTP_USER',
                    'label' => $this->getAttributeLabel('CU1_FTP_USER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_FTP_PASSWORD',
                    'label' => $this->getAttributeLabel('CU1_FTP_PASSWORD'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_FTP_DIRECTORY',
                    'label' => $this->getAttributeLabel('CU1_FTP_DIRECTORY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REMOTE_HTTP_SERVER',
                    'label' => $this->getAttributeLabel('CU1_REMOTE_HTTP_SERVER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SUPPLIER_CODE',
                    'label' => $this->getAttributeLabel('CU1_SUPPLIER_CODE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVER_QUALIFIER',
                    'label' => $this->getAttributeLabel('CU1_RECEIVER_QUALIFIER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVER_ID',
                    'label' => $this->getAttributeLabel('CU1_RECEIVER_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_FACILITY',
                    'label' => $this->getAttributeLabel('CU1_FACILITY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_TRADING_PARTNER_QUALIFIER',
                    'label' => $this->getAttributeLabel('CU1_TRADING_PARTNER_QUALIFIER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_TRADING_PARTNER_ID',
                    'label' => $this->getAttributeLabel('CU1_TRADING_PARTNER_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ASN_TRADING_PARTNER_ID',
                    'label' => $this->getAttributeLabel('CU1_ASN_TRADING_PARTNER_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CONSOLIDATE_ASN',
                    'label' => $this->getAttributeLabel('CU1_CONSOLIDATE_ASN'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_FLAG',
                    'label' => $this->getAttributeLabel('CU1_FLAG'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_X12_STANDARD',
                    'label' => $this->getAttributeLabel('CU1_X12_STANDARD'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_EDI_VERSION',
                    'label' => $this->getAttributeLabel('CU1_EDI_VERSION'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_DUNS',
                    'label' => $this->getAttributeLabel('CU1_DUNS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SHARED_SECRET',
                    'label' => $this->getAttributeLabel('CU1_SHARED_SECRET'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_REJECT_INVALID_ITEM_ORDERS',
                    'label' => $this->getAttributeLabel('CU1_REJECT_INVALID_ITEM_ORDERS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_INVALID_ITEM_SUBSTITUTE',
                    'label' => $this->getAttributeLabel('CU1_INVALID_ITEM_SUBSTITUTE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_USE_CONTRACT',
                    'label' => $this->getAttributeLabel('CU1_USE_CONTRACT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_CUSTOMERS_AND_ITEMS',
                    'label' => $this->getAttributeLabel('CU1_SEND_CUSTOMERS_AND_ITEMS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_STOP_IMPORT_WITH_ERRORS',
                    'label' => $this->getAttributeLabel('CU1_STOP_IMPORT_WITH_ERRORS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_USE_CLASS_ID',
                    'label' => $this->getAttributeLabel('CU1_USE_CLASS_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CLASS_ID',
                    'label' => $this->getAttributeLabel('CU1_CLASS_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_MAP',
                    'label' => $this->getAttributeLabel('CU1_MAP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ORDER_PRICE_OVERRIDE',
                    'label' => $this->getAttributeLabel('CU1_ORDER_PRICE_OVERRIDE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_SEND_CREDIT_INVOICES',
                    'label' => $this->getAttributeLabel('CU1_SEND_CREDIT_INVOICES'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_852_IMPORT_FOLDER',
                    'label' => $this->getAttributeLabel('CU1_852_IMPORT_FOLDER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
                    'label' => $this->getAttributeLabel('CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_COMPLETE_SHIP_TO_NAME',
                    'label' => $this->getAttributeLabel('CU1_COMPLETE_SHIP_TO_NAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ALWAYS_SEND_ASNS',
                    'label' => $this->getAttributeLabel('CU1_ALWAYS_SEND_ASNS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_IMPORT_FREIGHT_CODES',
                    'label' => $this->getAttributeLabel('CU1_IMPORT_FREIGHT_CODES'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_POST_AS2',
                    'label' => $this->getAttributeLabel('CU1_POST_AS2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_RECEIVE_AS2',
                    'label' => $this->getAttributeLabel('CU1_RECEIVE_AS2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CXML_PAYLOAD_ID',
                    'label' => $this->getAttributeLabel('CU1_CXML_PAYLOAD_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_AS2_CERTIFICATE_FILENAME',
                    'label' => $this->getAttributeLabel('CU1_AS2_CERTIFICATE_FILENAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_AS2_RECEIVER_ID',
                    'label' => $this->getAttributeLabel('CU1_AS2_RECEIVER_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_AS2_TRADING_PARTNER_ID',
                    'label' => $this->getAttributeLabel('CU1_AS2_TRADING_PARTNER_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
                    'label' => $this->getAttributeLabel('CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_USE_P21_SHIP_TO_DATA',
                    'label' => $this->getAttributeLabel('CU1_USE_P21_SHIP_TO_DATA'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ALLOW_DUPLICATE_PO_NUMBERS',
                    'label' => $this->getAttributeLabel('CU1_ALLOW_DUPLICATE_PO_NUMBERS'),
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

