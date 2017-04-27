<?php

/**
 * This is the model class for table 'vd1_vendor'.
 *
 * The followings are the available columns in table 'vd1_vendor':
 * @property string $VD1_ID
 * @property string $VENDOR_ID
 * @property string $VD1_NAME
 * @property integer $VD1_CREATED_BY
 * @property string $VD1_CREATED_ON
 * @property integer $VD1_MODIFIED_BY
 * @property string $VD1_MODIFIED_ON
 * @property string $VD1_SHOW_DEFAULT
 * @property integer $VD1_RECEIVE_EDI
 * @property integer $VD1_SEND_EDI_PO
 * @property integer $VD1_SEND_ACKNOWLEDGEMENT
 * @property integer $VD1_PO_FORMAT
 * @property integer $VD1_SEND_FTP
 * @property integer $VD1_SEND_SFTP
 * @property integer $VD1_POST_HTTP
 * @property integer $VD1_RECEIVE_FTP
 * @property integer $VD1_PICKUP_FTP
 * @property integer $VD1_PICKUP_SFTP
 * @property integer $VD1_RECEIVE_HTTP
 * @property string $VD1_REMOTE_FTP_SERVER
 * @property string $VD1_REMOTE_FTP_USERNAME
 * @property string $VD1_REMOTE_FTP_PASSWORD
 * @property string $VD1_REMOTE_FTP_DIRECTORY_SEND
 * @property string $VD1_REMOTE_FTP_DIRECTORY_PICKUP
 * @property string $VD1_FTP_USER
 * @property string $VD1_FTP_PASSWORD
 * @property string $VD1_FTP_DIRECTORY
 * @property string $VD1_REMOTE_HTTP_SERVER
 * @property string $VD1_SUPPLIER_CODE
 * @property string $VD1_RECEIVER_QUALIFIER
 * @property string $VD1_RECEIVER_ID
 * @property string $VD1_FACILITY
 * @property string $VD1_TRADING_PARTNER_QUALIFIER
 * @property string $VD1_TRADING_PARTNER_ID
 * @property string $VD1_TRADING_PARTNER_GS_ID
 * @property string $VD1_FLAG
 * @property string $VD1_X12_STANDARD
 * @property string $VD1_EDI_VERSION
 * @property string $VD1_DUNS
 * @property string $VD1_SHARED_SECRET
 * @property integer $VD1_SEND_EDI_PO_CHANGE
 * @property integer $VD1_SEND_ITEM_USAGE
 * @property integer $VD1_ITEM_USAGE_FORMAT
 * @property string $VD1_ITEM_USAGE_SOURCE
 * @property integer $VD1_POST_AS2
 * @property integer $VD1_RECEIVE_AS2
 * @property integer $VD1_CHECK_P21_EDI_FLAG
 * @property string $VD1_CXML_PAYLOAD_ID
 * @property integer $VD1_SEND_EDI_PAYMENT_ADVICE
 * @property integer $VD1_PAYMENT_ADVICE_FORMAT
 * @property string $VD1_BANK_ROUTING_NUMBER
 * @property string $VD1_BANK_ACCOUNT_NUMBER
 * @property string $VD1_AS2_CERTIFICATE_FILENAME
 * @property string $VD1_AS2_RECEIVER_ID
 * @property string $VD1_AS2_TRADING_PARTNER_ID
 * @property integer $VD1_AS2_REQUEST_RECEIPT
 * @property integer $VD1_AS2_SIGN_MESSAGES
 * @property Profile $cprofile
 * @property Profile $mprofile
 *
 * The followings are the available model relations:
 */
class Vendor extends JActiveRecord
{

    CONST VD1_PAYMENT_ADVICE_FORMAT_820 = 0;
    CONST VD1_PAYMENT_ADVICE_FORMAT_CXML = 1;

    CONST VD1_PO_FORMAT_EDI_X12 = 0;
    CONST VD1_PO_FORMAT_EZ_XML = 1;
    CONST VD1_PO_FORMAT_FIXED_FIELD_TEXT = 2;

    CONST VD1_ITEM_USAGE_FORMAT_852 = 0;
    CONST VD1_ITEM_USAGE_FORMAT_CSV = 1;
    CONST VD1_ITEM_USAGE_FORMAT_XML = 2;

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

    CONST NOT_SET = "Not Set";

    CONST SHOW_DEFAULT_FLAG = "X";

    /**
     * Returns the values associated with specific aliases
     * @param $type
     * @param null $code
     * @return bool
     */
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'PAYMENT_ADVICE_FORMAT' => array(
                self::VD1_PAYMENT_ADVICE_FORMAT_820   => Yii::t('app', '820'),
                self::VD1_PAYMENT_ADVICE_FORMAT_CXML  => Yii::t('app', 'cXML'),
            ),
            'PO_FORMAT' => array(
                self::VD1_PO_FORMAT_EDI_X12           => Yii::t('app', 'EDI X12'),
                self::VD1_PO_FORMAT_EZ_XML            => Yii::t('app', 'EZ XML'),
                self::VD1_PO_FORMAT_FIXED_FIELD_TEXT  => Yii::t('app', 'Fixed Field Text'),
            ),
            'ITEM_USAGE_FORMAT' => array(
                self::VD1_ITEM_USAGE_FORMAT_852       => Yii::t('app', '852'),
                self::VD1_ITEM_USAGE_FORMAT_CSV       => Yii::t('app', 'CVS'),
                self::VD1_ITEM_USAGE_FORMAT_XML       => Yii::t('app', 'XML'),
            ),
            'SEND_COLUMN_SEARCH_TEXT' => array(
                self::SEND_COLUMN_SEARCH_FTP             => Yii::t('app', 'FTP'),
                self::SEND_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP            => Yii::t('app', 'FTP & SFTP & HTTP'),
                self::SEND_COLUMN_SEARCH_FTP_SFTP            => Yii::t('app', 'FTP & SFTP'),
                self::SEND_COLUMN_SEARCH_FTP_HTTP            => Yii::t('app', 'FTP & HTTP'),
                self::SEND_COLUMN_SEARCH_SFTP            => Yii::t('app', 'SFTP'),
                self::SEND_COLUMN_SEARCH_SFTP_AND_HTTP           => Yii::t('app', 'SFTP & HTTP'),
                self::SEND_COLUMN_SEARCH_HTTP            => Yii::t('app', 'HTTP'),
                self::SEND_COLUMN_SEARCH_PICKUP_FTP      => Yii::t('app', 'Pickup FTP'),
            ),
            'RECEIVE_COLUMN_SEARCH_TEXT' => array(
                self::RECEIVE_COLUMN_SEARCH_FTP             => Yii::t('app', 'Receive FTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_AND_SFTP_AND_HTTP            => Yii::t('app', 'Receive FTP & Pickup SFTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_SFTP            => Yii::t('app', 'Receive FTP & Pickup SFTP'),
                self::RECEIVE_COLUMN_SEARCH_FTP_HTTP            => Yii::t('app', 'Receive FTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_SFTP            => Yii::t('app', 'Pickup SFTP'),
                self::RECEIVE_COLUMN_SEARCH_SFTP_AND_HTTP           => Yii::t('app', 'Pickup SFTP & HTTP'),
                self::RECEIVE_COLUMN_SEARCH_HTTP            => Yii::t('app', 'HTTP'),
                self::RECEIVE_COLUMN_SEARCH_PICKUP_FTP      => Yii::t('app', 'Pickup FTP'),
            ),
            'SEND_COLUMN_LABELS' => array(
                self::FTP                             => Yii::t('app', '<span class="label label-default">FTP</span>'),
                self::FTP_AND_SFTP                    => Yii::t('app', '<span style="margin-right: 3px;" class="label label-default">FTP</span><span style="margin-right: 3px;" class="label label-primary">SFTP</span>'),
                self::FTP_AND_SFTP_AND_HTTP           => Yii::t('app', '<span style="margin-right: 3px;" class="label label-default">FTP </span><span style="margin-right: 3px;" class="label label-primary">SFTP</span><span class="label label-warning">HTTP</span>'),
                self::SFTP                            => Yii::t('app', '<span class="label label-primary">SFTP</span>'),
                self::SFTP_AND_HTTP                   => Yii::t('app', '<span style="margin-right: 3px;" class="label label-primary">SFTP</span><span class="label label-warning">HTTP</span>'),
                self::HTTP                            => Yii::t('app', '<span class="label label-warning">HTTP</span>'),
                self::PICKUP_FTP                      => Yii::t('app', '<span class="label label-info">Pickup FTP'),
            ),
            'RECEIVE_COLUMN_LABELS' => array(
                self::FTP                             => Yii::t('app', '<span class="label label-default">Receive FTP</span>'),
                self::FTP_AND_PICKUP_SFTP             => Yii::t('app', '<span style="margin-right: 3px;" class="label label-default">Receive FTP</span><span style="margin-right: 3px;" class="label label-primary">Pickup SFTP</span>'),
                self::FTP_AND_PICKUP_SFTP_AND_HTTP    => Yii::t('app', '<span style="margin-right: 3px;" class="label label-default">Receive FTP</span><span style="margin-right: 3px;" class="label label-primary">Pickup SFTP</span><span style="margin-right: 3px;" class="label label-warning">HTTP</span>'),
                self::PICKUP_SFTP                     => Yii::t('app', '<span style="margin-right: 3px;" class="label label-primary">Pickup SFTP</span>'),
                self::PICKUP_SFTP_AND_HTTP            => Yii::t('app', '<span style="margin-right: 3px;" class="label label-primary">Pickup SFTP</span><span class="label label-warning">HTTP</span>'),
                self::HTTP                            => Yii::t('app', '<span class="label label-warning">HTTP</span>'),
                self::PICKUP_FTP                      => Yii::t('app', '<span class="label label-info">Pickup FTP</span>'),
            ),
            'SEND_COLUMN_LABELS_EXPORT' => array(
                self::FTP                             => 'FTP',
                self::FTP_AND_SFTP                    => 'FTP, SFTP',
                self::FTP_AND_SFTP_AND_HTTP           => 'FTP, SFTP, HTTP',
                self::SFTP                            => 'SFTP',
                self::SFTP_AND_HTTP                   => 'SFTP, HTTP',
                self::HTTP                            => 'HTTP',
                self::PICKUP_FTP                      => 'Pickup, FTP',
            ),
            'RECEIVE_COLUMN_LABELS_EXPORT' => array(
                self::FTP                             => 'Receive FTP',
                self::FTP_AND_PICKUP_SFTP             => 'Receive FTP, Pickup SFTP',
                self::FTP_AND_PICKUP_SFTP_AND_HTTP    => 'Receive FTP, Pickup SFTP, HTTP',
                self::PICKUP_SFTP                     => 'Pickup SFTP',
                self::PICKUP_SFTP_AND_HTTP            => 'Pickup SFTP, HTTP',
                self::HTTP                            => 'HTTP',
                self::PICKUP_FTP                      => 'Pickup FTP',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function afterFind(){
        if(!isset($this->VD1_NAME) || $this->VD1_NAME == ""){
            $this->VD1_NAME = Vendor::NOT_SET;
        }
        if(!isset($this->VENDOR_ID) || $this->VENDOR_ID == ""){
            $this->VENDOR_ID = Vendor::NOT_SET;
        }
        if($this->scenario=='index'){

        }
        return parent::afterFind();
    }

    public function beforeSave(){

        if(isset($this->VD1_NAME) && $this->VD1_NAME == Vendor::NOT_SET){
            $this->VD1_NAME = "";
        }

        if(isset($this->VENDOR_ID) && $this->VENDOR_ID == Vendor::NOT_SET){
            $this->VENDOR_ID = "";
        }
        return parent::beforeSave();
    }

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Vendor the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Returns a version of the Vendor ID link with a label wrapped around it
     * @param $UHTML
     * @param $updateLink
     * @return string
     */
    public function returnDocumentNumberLabel($UHTML, $updateLink){
        $UHTML = '<span class="label label-info">' . $UHTML . '</span>';
        return TbHtml::link($UHTML,$updateLink);
    }

    /**
     * sendColumnLogic takes care of all of the logic that goes on when deciding what send EDI tags should be shown.
     * It gets it's values from the itemAlias
     * @return bool|mixed|string
     */
    public function sendColumnLogic()
    {
        $result = '';

        if(isset($this->VD1_SEND_EDI_PO) && $this->VD1_SEND_EDI_PO == 1){
            if($this->VD1_SEND_FTP == 1){
                $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP');
                if($this->VD1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','FTP HTTP');
                    }
                }
            }
            else{
                if($this->VD1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS','SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS','SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_POST_HTTP == 1){
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

    public function sendColumnLogicExport()
    {
        $result = '';

        if(isset($this->VD1_SEND_EDI_PO) && $this->VD1_SEND_EDI_PO == 1){
            if($this->VD1_SEND_FTP == 1){
                $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','FTP');
                if($this->VD1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','FTP SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','FTP SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','FTP HTTP');
                    }
                }
            }
            else{
                if($this->VD1_SEND_SFTP == 1){
                    $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','Pickup FTP');
                    }
                    else{
                        $result = Vendor::itemAlias('SEND_COLUMN_LABELS_EXPORT','HTTP');
                    }
                }
            }
        }

        return $result;
    }

    /**
     * receiveColumnLogic takes care of all of the logic that goes on when deciding what receive EDI tags should be shown.
     * It gets it's values from the itemAlias
     * @return bool|mixed|string
     */
    public function receiveColumnLogic()
    {
        $result = '';

        if(isset($this->VD1_RECEIVE_EDI) && $this->VD1_RECEIVE_EDI == 1){
            if($this->VD1_RECEIVE_FTP == 1){
                $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP');
                if($this->VD1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup SFTP');
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','FTP Pickup FTP');
                    }
                }
            }
            else{
                if($this->VD1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','Pickup FTP');
                    }
                    else{
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS','HTTP');
                    }
                }
            }
        }

        return $result;
    }

    public function receiveColumnLogicExport()
    {
        $result = '';

        if(isset($this->VD1_RECEIVE_EDI) && $this->VD1_RECEIVE_EDI == 1){
            if($this->VD1_RECEIVE_FTP == 1){
                $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','FTP');
                if($this->VD1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','FTP Pickup SFTP');
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','FTP Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','FTP Pickup FTP');
                    }
                }
            }
            else{
                if($this->VD1_PICKUP_SFTP == 1){
                    $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','Pickup SFTP');
                    if($this->VD1_POST_HTTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','Pickup SFTP HTTP');
                    }
                }
                else{
                    if($this->VD1_PICKUP_FTP == 1){
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','HTTP');
                    }
                    else{
                        $result = Vendor::itemAlias('RECEIVE_COLUMN_LABELS_EXPORT','Pickup FTP');
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Returns a list of columns that are found in the database but that are not currently defined in our Yii data structure
     * @return array
     */
    public function getColumnsNotInYii(){
        $ediTable = Yii::app()->db->schema->getTable('vd1_vendor', true);

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
    private function getDynamicRules(){
        $rules = array();
        $newFields = Vendor::getColumnsNotInYii();
        if(isset($newFields) && count($newFields) > 0){
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
                }
                else{
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
        $newFields = Vendor::getColumnsNotInYii();
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
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'vd1_vendor';
    }

    /**
     * REQUIRED
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $mainRules = array(
            array('VD1_NAME', 'required'),
            array('VD1_CREATED_BY, VD1_MODIFIED_BY, VD1_RECEIVE_EDI, VD1_SEND_EDI_PO, VD1_SEND_ACKNOWLEDGEMENT, VD1_PO_FORMAT, VD1_SEND_FTP, VD1_SEND_SFTP, VD1_POST_HTTP, VD1_RECEIVE_FTP, VD1_PICKUP_FTP, VD1_PICKUP_SFTP, VD1_RECEIVE_HTTP, VD1_SEND_EDI_PO_CHANGE, VD1_SEND_ITEM_USAGE, VD1_ITEM_USAGE_FORMAT, VD1_POST_AS2, VD1_RECEIVE_AS2, VD1_CHECK_P21_EDI_FLAG, VD1_SEND_EDI_PAYMENT_ADVICE, VD1_PAYMENT_ADVICE_FORMAT', 'numerical', 'integerOnly'=>true),
            array('VENDOR_ID', 'length', 'max'=>10),
            array('VD1_NAME, VD1_SHARED_SECRET', 'length', 'max'=>100),
            array('VD1_SHOW_DEFAULT, VD1_FLAG', 'length', 'max'=>1),
            array('VD1_REMOTE_FTP_SERVER, VD1_REMOTE_FTP_USERNAME, VD1_REMOTE_FTP_PASSWORD, VD1_REMOTE_FTP_DIRECTORY_SEND, VD1_REMOTE_FTP_DIRECTORY_PICKUP, VD1_FTP_USER, VD1_FTP_PASSWORD, VD1_FTP_DIRECTORY, VD1_REMOTE_HTTP_SERVER', 'length', 'max'=>200),
            array('VD1_SUPPLIER_CODE, VD1_RECEIVER_ID, VD1_FACILITY, VD1_TRADING_PARTNER_ID, VD1_TRADING_PARTNER_GS_ID', 'length', 'max'=>45),
            array('VD1_RECEIVER_QUALIFIER, VD1_TRADING_PARTNER_QUALIFIER', 'length', 'max'=>2),
            array('VD1_X12_STANDARD', 'length', 'max'=>4),
            array('VD1_EDI_VERSION', 'length', 'max'=>5),
            array('VD1_DUNS, VD1_BANK_ROUTING_NUMBER, VD1_BANK_ACCOUNT_NUMBER', 'length', 'max'=>50),
            array('VD1_ITEM_USAGE_SOURCE, VD1_CXML_PAYLOAD_ID, VD1_AS2_CERTIFICATE_FILENAME, VD1_AS2_RECEIVER_ID, VD1_AS2_TRADING_PARTNER_ID', 'length', 'max'=>255),
            array('VD1_CREATED_ON, VD1_MODIFIED_ON, VD1_AS2_REQUEST_RECEIPT, VD1_AS2_SIGN_MESSAGES, send_edi_search', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('VD1_ID, VENDOR_ID, VD1_NAME, VD1_CREATED_BY, VD1_CREATED_ON, VD1_MODIFIED_BY, VD1_MODIFIED_ON, VD1_SHOW_DEFAULT, VD1_RECEIVE_EDI, VD1_SEND_EDI_PO, VD1_SEND_ACKNOWLEDGEMENT, VD1_PO_FORMAT, VD1_SEND_FTP, VD1_SEND_SFTP, VD1_POST_HTTP, VD1_RECEIVE_FTP, VD1_PICKUP_FTP, VD1_PICKUP_SFTP, VD1_RECEIVE_HTTP, VD1_REMOTE_FTP_SERVER, VD1_REMOTE_FTP_USERNAME, VD1_REMOTE_FTP_PASSWORD, VD1_REMOTE_FTP_DIRECTORY_SEND, VD1_REMOTE_FTP_DIRECTORY_PICKUP, VD1_FTP_USER, VD1_FTP_PASSWORD, VD1_FTP_DIRECTORY, VD1_REMOTE_HTTP_SERVER, VD1_SUPPLIER_CODE, VD1_RECEIVER_QUALIFIER, VD1_RECEIVER_ID, VD1_FACILITY, VD1_TRADING_PARTNER_QUALIFIER, VD1_TRADING_PARTNER_ID, VD1_TRADING_PARTNER_GS_ID, VD1_FLAG, VD1_X12_STANDARD, VD1_EDI_VERSION, VD1_DUNS, VD1_SHARED_SECRET, VD1_SEND_EDI_PO_CHANGE, VD1_SEND_ITEM_USAGE, VD1_ITEM_USAGE_FORMAT, VD1_ITEM_USAGE_SOURCE, VD1_POST_AS2, VD1_RECEIVE_AS2, VD1_CHECK_P21_EDI_FLAG, VD1_CXML_PAYLOAD_ID, VD1_SEND_EDI_PAYMENT_ADVICE, VD1_PAYMENT_ADVICE_FORMAT, VD1_BANK_ROUTING_NUMBER, VD1_BANK_ACCOUNT_NUMBER, VD1_AS2_CERTIFICATE_FILENAME, VD1_AS2_RECEIVER_ID, VD1_AS2_TRADING_PARTNER_ID, VD1_AS2_REQUEST_RECEIPT, VD1_AS2_SIGN_MESSAGES, send_edi_search, ftp, receive_edi_search, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),

            // Rules for relations
            //array('REQUIRED_COLUMNS_ONLY_FOR_RELATION_SEPARATED_BY_COMMA', 'required', 'on' => 'relation'),
        );

        $dynamicRules = Vendor::getDynamicRules();
        return array_merge($mainRules, $dynamicRules);
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
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'VD1_CREATED_BY',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'VD1_MODIFIED_BY',),
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels($includeDynamicLabels = true)
    {
        $mainLabels = array(
            'VD1_ID' => 'ID',
            'VENDOR_ID' => 'Vendor ID',
            'VD1_NAME' => 'Vendor Name',
            'VD1_CREATED_BY' => 'Created By',
            'VD1_CREATED_ON' => 'Created On',
            'VD1_MODIFIED_BY' => 'Modified By',
            'VD1_MODIFIED_ON' => 'Modified On',
            'VD1_SHOW_DEFAULT' => 'Show Default',
            'VD1_RECEIVE_EDI' => 'Receive Edi',
            'VD1_SEND_EDI_PO' => 'Send EDI Po',
            'VD1_SEND_ACKNOWLEDGEMENT' => 'Send Acknowledgement',
            'VD1_PO_FORMAT' => 'PO Format',
            'VD1_SEND_FTP' => 'Send FTP',
            'VD1_SEND_SFTP' => 'Send SFTP',
            'VD1_POST_HTTP' => 'Post HTTP',
            'VD1_RECEIVE_FTP' => 'Receive FTP',
            'VD1_PICKUP_FTP' => 'Pickup FTP',
            'VD1_PICKUP_SFTP' => 'Pickup SFTP',
            'VD1_RECEIVE_HTTP' => 'Receive HTTP',
            'VD1_REMOTE_FTP_SERVER' => 'Remote FTP Server',
            'VD1_REMOTE_FTP_USERNAME' => 'Remote FTP Username',
            'VD1_REMOTE_FTP_PASSWORD' => 'Remote FTP Password',
            'VD1_REMOTE_FTP_DIRECTORY_SEND' => 'Remote FTP Directory Send',
            'VD1_REMOTE_FTP_DIRECTORY_PICKUP' => 'Remote FTP Directory Pickup',
            'VD1_FTP_USER' => 'FTP User',
            'VD1_FTP_PASSWORD' => 'FTP Password',
            'VD1_FTP_DIRECTORY' => 'FTP Directory',
            'VD1_REMOTE_HTTP_SERVER' => 'Remote HTTP Server',
            'VD1_SUPPLIER_CODE' => 'Supplier Code',
            'VD1_RECEIVER_QUALIFIER' => 'Receiver Qualifier',
            'VD1_RECEIVER_ID' => 'Receiver ID',
            'VD1_FACILITY' => 'Facility',
            'VD1_TRADING_PARTNER_QUALIFIER' => 'Trading Partner Qualifier',
            'VD1_TRADING_PARTNER_ID' => 'Trading Partner ID',
            'VD1_TRADING_PARTNER_GS_ID' => 'GS ID',
            'VD1_FLAG' => 'Flag',
            'VD1_X12_STANDARD' => 'X12 Standard',
            'VD1_EDI_VERSION' => 'EDI Version',
            'VD1_DUNS' => 'Duns',
            'VD1_SHARED_SECRET' => 'Shared Secret',
            'VD1_SEND_EDI_PO_CHANGE' => 'Send EDI PO Change',
            'VD1_SEND_ITEM_USAGE' => 'Send Item Usage',
            'VD1_ITEM_USAGE_FORMAT' => 'Item Usage Format',
            'VD1_ITEM_USAGE_SOURCE' => 'Item Usage Source',
            'VD1_POST_AS2' => 'Post AS2',
            'VD1_RECEIVE_AS2' => 'Receive AS2',
            'VD1_CHECK_P21_EDI_FLAG' => 'Check P21 EDI Flag',
            'VD1_CXML_PAYLOAD_ID' => 'cXML Payload',
            'VD1_SEND_EDI_PAYMENT_ADVICE' => 'Send EDI Payment Advice',
            'VD1_PAYMENT_ADVICE_FORMAT' => 'Payment Advice Format',
            'VD1_BANK_ROUTING_NUMBER' => 'Bank Routing Number',
            'VD1_BANK_ACCOUNT_NUMBER' => 'Bank Account Number',
            'VD1_AS2_CERTIFICATE_FILENAME' => 'AS2 Certificate Filename',
            'VD1_AS2_RECEIVER_ID' => 'AS2 Receiver ID',
            'VD1_AS2_REQUEST_RECEIPT' => 'AS2 Request Receipt',
            'VD1_AS2_SIGN_MESSAGES' => 'AS2 Sign Messages',
            'VD1_AS2_KEY_LENGTH' => 'AS2 Key Length',
            'send_edi_search' => 'Send EDI',
            'receive_edi_search' => 'Receive EDI',
            'ftp' => 'FTP',
            'VD1_AS2_TRADING_PARTNER_ID' => 'AS2 Trading Partner ID',
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
        );
        if($includeDynamicLabels == true){
            $dynamicLabels = Vendor::getDynamicAttributeLabels();
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
        $alias = Vendor::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.VD1_ID';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Vendor::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.VD1_ID, ' . $alias . '.VENDOR_ID',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.VD1_ID',
            ),
            'show_default'=>array(
                'condition'=>'VD1_SHOW_DEFAULT="X"',
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
        $models = Vendor::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->VD1_ID)) {
                $rtv[$model->VD1_ID] = $model->VENDOR_ID;
            }
        }
        return $rtv;
    }


    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */

    public $send_edi_search;
    public $receive_edi_search;
    public $cprofile_search;
    public $mprofile_search;

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = Vendor::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria;
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('cprofile', 'mprofile',);
        $criteria->compare($alias . '.VD1_ID', $this->VD1_ID, true);
        $criteria->compare($alias . '.VENDOR_ID', $this->VENDOR_ID, false);
        $criteria->compare($alias . '.VD1_NAME', $this->VD1_NAME, true);
        $criteria->compare($alias . '.VD1_CREATED_BY', $this->VD1_CREATED_BY);
        $criteria->compare($alias . '.VD1_CREATED_ON', $this->VD1_CREATED_ON, true);
        $criteria->compare($alias . '.VD1_MODIFIED_BY', $this->VD1_MODIFIED_BY);
        $criteria->compare($alias . '.VD1_MODIFIED_ON', $this->VD1_MODIFIED_ON, true);
        $criteria->compare($alias . '.VD1_SHOW_DEFAULT', $this->VD1_SHOW_DEFAULT, true);
        $criteria->compare($alias . '.VD1_RECEIVE_EDI', $this->VD1_RECEIVE_EDI);
        $criteria->compare($alias . '.VD1_SEND_EDI_PO', $this->VD1_SEND_EDI_PO);
        $criteria->compare($alias . '.VD1_SEND_ACKNOWLEDGEMENT', $this->VD1_SEND_ACKNOWLEDGEMENT);
        $criteria->compare($alias . '.VD1_PO_FORMAT', $this->VD1_PO_FORMAT);
        $criteria->compare($alias . '.VD1_SEND_FTP', $this->VD1_SEND_FTP);
        $criteria->compare($alias . '.VD1_SEND_SFTP', $this->VD1_SEND_SFTP);
        $criteria->compare($alias . '.VD1_POST_HTTP', $this->VD1_POST_HTTP);
        $criteria->compare($alias . '.VD1_RECEIVE_FTP', $this->VD1_RECEIVE_FTP);
        $criteria->compare($alias . '.VD1_PICKUP_FTP', $this->VD1_PICKUP_FTP);
        $criteria->compare($alias . '.VD1_PICKUP_SFTP', $this->VD1_PICKUP_SFTP);
        $criteria->compare($alias . '.VD1_RECEIVE_HTTP', $this->VD1_RECEIVE_HTTP);
        $criteria->compare($alias . '.VD1_REMOTE_FTP_SERVER', $this->VD1_REMOTE_FTP_SERVER, true);
        $criteria->compare($alias . '.VD1_REMOTE_FTP_USERNAME', $this->VD1_REMOTE_FTP_USERNAME, true);
        $criteria->compare($alias . '.VD1_REMOTE_FTP_PASSWORD', $this->VD1_REMOTE_FTP_PASSWORD, true);
        $criteria->compare($alias . '.VD1_REMOTE_FTP_DIRECTORY_SEND', $this->VD1_REMOTE_FTP_DIRECTORY_SEND, true);
        $criteria->compare($alias . '.VD1_REMOTE_FTP_DIRECTORY_PICKUP', $this->VD1_REMOTE_FTP_DIRECTORY_PICKUP, true);
        $criteria->compare($alias . '.VD1_FTP_USER', $this->VD1_FTP_USER, true);
        $criteria->compare($alias . '.VD1_FTP_PASSWORD', $this->VD1_FTP_PASSWORD, true);
        $criteria->compare($alias . '.VD1_FTP_DIRECTORY', $this->VD1_FTP_DIRECTORY, true);
        $criteria->compare($alias . '.VD1_REMOTE_HTTP_SERVER', $this->VD1_REMOTE_HTTP_SERVER, true);
        $criteria->compare($alias . '.VD1_SUPPLIER_CODE', $this->VD1_SUPPLIER_CODE, true);
        $criteria->compare($alias . '.VD1_RECEIVER_QUALIFIER', $this->VD1_RECEIVER_QUALIFIER, true);
        $criteria->compare($alias . '.VD1_RECEIVER_ID', $this->VD1_RECEIVER_ID, true);
        $criteria->compare($alias . '.VD1_FACILITY', $this->VD1_FACILITY, true);
        $criteria->compare($alias . '.VD1_TRADING_PARTNER_QUALIFIER', $this->VD1_TRADING_PARTNER_QUALIFIER, true);
        $criteria->compare($alias . '.VD1_TRADING_PARTNER_ID', $this->VD1_TRADING_PARTNER_ID, true);
        $criteria->compare($alias . '.VD1_TRADING_PARTNER_GS_ID', $this->VD1_TRADING_PARTNER_GS_ID, true);
        $criteria->compare($alias . '.VD1_FLAG', $this->VD1_FLAG, true);
        $criteria->compare($alias . '.VD1_X12_STANDARD', $this->VD1_X12_STANDARD, true);
        $criteria->compare($alias . '.VD1_EDI_VERSION', $this->VD1_EDI_VERSION, true);
        $criteria->compare($alias . '.VD1_DUNS', $this->VD1_DUNS, true);
        $criteria->compare($alias . '.VD1_SHARED_SECRET', $this->VD1_SHARED_SECRET, true);
        $criteria->compare($alias . '.VD1_SEND_EDI_PO_CHANGE', $this->VD1_SEND_EDI_PO_CHANGE);
        $criteria->compare($alias . '.VD1_SEND_ITEM_USAGE', $this->VD1_SEND_ITEM_USAGE);
        $criteria->compare($alias . '.VD1_ITEM_USAGE_FORMAT', $this->VD1_ITEM_USAGE_FORMAT);
        $criteria->compare($alias . '.VD1_ITEM_USAGE_SOURCE', $this->VD1_ITEM_USAGE_SOURCE, true);
        $criteria->compare($alias . '.VD1_POST_AS2', $this->VD1_POST_AS2);
        $criteria->compare($alias . '.VD1_RECEIVE_AS2', $this->VD1_RECEIVE_AS2);
        $criteria->compare($alias . '.VD1_CHECK_P21_EDI_FLAG', $this->VD1_CHECK_P21_EDI_FLAG);
        $criteria->compare($alias . '.VD1_CXML_PAYLOAD_ID', $this->VD1_CXML_PAYLOAD_ID, true);
        $criteria->compare($alias . '.VD1_SEND_EDI_PAYMENT_ADVICE', $this->VD1_SEND_EDI_PAYMENT_ADVICE);
        $criteria->compare($alias . '.VD1_PAYMENT_ADVICE_FORMAT', $this->VD1_PAYMENT_ADVICE_FORMAT);
        $criteria->compare($alias . '.VD1_BANK_ROUTING_NUMBER', $this->VD1_BANK_ROUTING_NUMBER, true);
        $criteria->compare($alias . '.VD1_BANK_ACCOUNT_NUMBER', $this->VD1_BANK_ACCOUNT_NUMBER, true);
        $criteria->compare($alias . '.VD1_AS2_CERTIFICATE_FILENAME', $this->VD1_AS2_CERTIFICATE_FILENAME, true);
        $criteria->compare($alias . '.VD1_AS2_RECEIVER_ID', $this->VD1_AS2_RECEIVER_ID, true);
        $criteria->compare($alias . '.VD1_AS2_TRADING_PARTNER_ID', $this->VD1_AS2_TRADING_PARTNER_ID, true);
        $criteria->compare($alias . '.VD1_AS2_REQUEST_RECEIPT', $this->VD1_AS2_REQUEST_RECEIPT, true);
        $criteria->compare($alias . '.VD1_AS2_SIGN_MESSAGES', $this->VD1_AS2_SIGN_MESSAGES, true);

        if(isset($this->send_edi_search)){
            $criteria->compare('concat(VD1_SEND_EDI_PO,VD1_SEND_FTP,VD1_SEND_SFTP,VD1_POST_HTTP)', $this->send_edi_search, true);
        }
        if(isset($this->receive_edi_search)){
            $criteria->compare('concat(VD1_RECEIVE_FTP,VD1_PICKUP_SFTP,VD1_PICKUP_FTP)', $this->receive_edi_search, true);
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
                        'asc'=>'concat(VD1_SEND_FTP,VD1_SEND_SFTP,VD1_POST_HTTP)',
                        'desc'=>'concat(VD1_SEND_FTP,VD1_SEND_SFTP,VD1_POST_HTTP) DESC'
                    ),
                    'receive_edi_search'=>array(
                        'asc'=>'concat(VD1_RECEIVE_FTP,VD1_PICKUP_SFTP,VD1_PICKUP_FTP)',
                        'desc'=>'concat(VD1_RECEIVE_FTP,VD1_PICKUP_SFTP,VD1_PICKUP_FTP) DESC'
                    ),
                    'VENDOR_ID' =>array(
                        'asc' => 'CAST(VENDOR_ID AS UNSIGNED) ASC',
                        'desc' => 'CAST(VENDOR_ID AS UNSIGNED) DESC',
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
            'fileName' => Yii::t('app', 'Vendor').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'VENDOR_ID',
                    'label' => $this->getAttributeLabel('VENDOR_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_NAME',
                    'label' => $this->getAttributeLabel('VD1_NAME'),
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
                    'field' => 'VD1_CREATED_ON',
                    'label' => $this->getAttributeLabel('VD1_CREATED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
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
                array(
                    'field' => 'VD1_MODIFIED_ON',
                    'label' => $this->getAttributeLabel('VD1_MODIFIED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'send_edi_search',
                    'label' => $this->getAttributeLabel('send_edi_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'sendColumnLogicExport()',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'receive_edi_search',
                    'label' => $this->getAttributeLabel('receive_edi_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'receiveColumnLogicExport()',
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_REMOTE_FTP_SERVER',
                    'label' => $this->getAttributeLabel('VD1_REMOTE_FTP_SERVER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_REMOTE_FTP_USERNAME',
                    'label' => $this->getAttributeLabel('VD1_REMOTE_FTP_USERNAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_REMOTE_FTP_PASSWORD',
                    'label' => $this->getAttributeLabel('VD1_REMOTE_FTP_PASSWORD'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_REMOTE_FTP_DIRECTORY_SEND',
                    'label' => $this->getAttributeLabel('VD1_REMOTE_FTP_DIRECTORY_SEND'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_REMOTE_FTP_DIRECTORY_PICKUP',
                    'label' => $this->getAttributeLabel('VD1_REMOTE_FTP_DIRECTORY_PICKUP'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_FTP_USER',
                    'label' => $this->getAttributeLabel('VD1_FTP_USER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_POST_AS2',
                    'label' => $this->getAttributeLabel('VD1_POST_AS2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_RECEIVE_AS2',
                    'label' => $this->getAttributeLabel('VD1_RECEIVE_AS2'),
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

