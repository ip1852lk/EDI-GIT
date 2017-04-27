

<?php

/**
 * This is the model class for table 'ed1_edi'.
 *
 * The followings are the available columns in table 'ed1_edi':
 * @property string $ED1_ID
 * @property string $ED1_TYPE
 * @property string $ED1_DOCUMENT_NO
 * @property string $ED1_FILENAME
 * @property integer $ED1_STATUS
 * @property integer $CU1_ID
 * @property integer $VD1_ID
 * @property string $ED1_MODIFIED_ON
 * @property integer $ED1_MODIFIED_BY
 * @property string $ED1_CREATED_ON
 * @property integer $ED1_CREATED_BY
 * @property string $ED1_SHOW_DEFAULT
 * @property integer $ED1_IN_OUT
 * @property integer $ED1_RESEND
 * @property integer $ED1_ACKNOWLEDGED
* @property integer $ED1_TEST_MODE

 * @property Profile $cprofile
 * @property Profile $mprofile
 *
 * The followings are the available model relations:
 */
class Edi extends JActiveRecord
{
    CONST ED1_STATUS_NOT_SENT = 0;
    CONST ED1_STATUS_PROCESSING= 1;
    CONST ED1_STATUS_SENT = 2;
    CONST ED1_STATUS_FAILED = 3;

    CONST INBOUND_STATUS = 0;
    CONST OUTBOUND_STATUS = 1;
    
    CONST RESEND = 1;
    CONST SHOW_DEFAULT_FLAG_CLEAR = ' ';
    CONST SHOW_DEFAULT_FLAG = "X";
    CONST FUNCTIONAL_ACKNOWLEDGEMENT = "997";


    /**
     * Returns the values associated with specific aliases
     * @param $type
     * @param null $code
     * @return bool
     */
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'ED1_STATUS' => array(
                self::ED1_STATUS_NOT_SENT        => Yii::t('app', 'Not Sent'),
                self::ED1_STATUS_PROCESSING      => Yii::t('app', 'Processing'),
                self::ED1_STATUS_SENT            => Yii::t('app', 'Sent'),
                self::ED1_STATUS_FAILED          => Yii::t('app', 'Failed'),
            ),
            'ED1_STATUS_LABELS' => array(
                self::ED1_STATUS_NOT_SENT        => Yii::t('app', '<i class="fa fa-circle" style="color:red;"></i>' . ' ' . 'Not Sent'),
                self::ED1_STATUS_PROCESSING      => Yii::t('app', '<i class="fa fa-circle" style="color:gold;"></i>' . ' ' .  'Processing'),
                self::ED1_STATUS_SENT            => Yii::t('app', '<i class="fa fa-circle" style="color:green;"></i>' . ' ' .  'Sent'),
                self::ED1_STATUS_FAILED          => Yii::t('app', '<i class="blink fa fa-circle" style="color:red;"></i>' . ' ' .  'Failed'),
            ),
            'ED1_STATUS_LABELS_RESENDING' => array(
                self::ED1_STATUS_NOT_SENT        => Yii::t('app', '<i class="fa fa-refresh fa-spin" title="Resending" style="cursor:default;"></i>' . ' ' . 'Not Sent'),
                self::ED1_STATUS_PROCESSING      => Yii::t('app', '<i class="fa fa-refresh fa-spin" title="Resending" style="cursor:default;"></i>' . ' ' .  'Processing'),
                self::ED1_STATUS_SENT            => Yii::t('app', '<i class="fa fa-refresh fa-spin" title="Resending" style="cursor:default;"></i>' . ' ' .  'Sent'),
                self::ED1_STATUS_FAILED          => Yii::t('app', '<i class="fa fa-refresh fa-spin" title="Resending" style="cursor:default;"></i>' . ' ' .  'Failed'),
            ),
            'EDI_IN_OUT_STATUS' => array(
                self::INBOUND_STATUS             => 'Inbound',
                self::OUTBOUND_STATUS            => 'Outbound',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }


    /**
     * Returns the values for the ED1_TYPE dropdown list with values from fillEDITypeArray()
     * @return mixed
     */
    public function getEDIType(){
        static $EDITypeArray = null;

        if(!isset($EDITypeArray)){
            $EDITypeArray = Edi::fillEDITypeArray();
        }

        return ($this->ED1_TYPE);// . ': ' . $EDITypeArray[$this->ED1_TYPE]);
    }


    /**
     * @param $UHTML
     * @param $updateLink
     * Adds a label class the the Ed1_Document_No field
     * @return string
     */
    public function returnDocumentNumberLabel($UHTML, $updateLink){
        $UHTML = '<span class="label label-info">' . $UHTML . '</span>';
        return TbHtml::link($UHTML,$updateLink);
    }

    /**
     * Contains an array of all of the EDI TYPES
     * @return array
     */
    public function fillEDITypeArray(){
        $TypeArray = array(
            100 => 'Insurance Plan Description',
            101 => 'Name and Address Lists',
            102 => 'Associated Data',
            103 => 'Abandoned Property Filings',
            104 => 'Air Shipment Information',
            105 => 'Business Entity Filings',
            106 => 'Motor Carrier Rate Proposal',
            107 => 'Request for Motor Carrier Rate Proposal',
            108 => 'Response to a Motor Carrier Rate Proposal',
            109 => 'Vessel Content Details',
            110 => 'Air Freight Details and Invoice',
            111 => 'Individual Insurance Policy and Client Information',
            112 => 'Property Damage Report',
            113 => 'Election Campaign and Lobbyist Reporting',
            114 => 'Air Shipment Status Message',
            120 => 'Vehicle Shipping Order',
            121 => 'Vehicle Service',
            124 => 'Vehicle Damage',
            125 => 'Multilevel Railcar Load Details',
            126 => 'Vehicle Application Advice',
            127 => 'Vehicle Baying Order',
            128 => 'Dealer Information',
            129 => 'Vehicle Carrier Rate Update',
            130 => 'Student Educational Record (Transcript)',
            131 => 'Student Educational Record (Transcript) Acknowledgment',
            132 => 'Human Resource Information',
            133 => 'Educational Institution Record',
            135 => 'Student Aid Origination Record',
            138 => 'Educational Testing and Prospect Request and Report',
            139 => 'Student Loan Guarantee Result',
            140 => 'Product Registration',
            141 => 'Product Service Claim Response',
            142 => 'Product Service Claim',
            143 => 'Product Service Notification',
            144 => 'Student Loan Transfer and Status Verification',
            146 => 'Request for Student Educational Record (Transcript)',
            147 => 'Response to Request for Student Educational Record (Transcript)',
            148 => 'Report of Injury, Illness or Incident',
            149 => 'Notice of Tax Adjustment or Assessment',
            150 => 'Tax Rate Notification',
            151 => 'Electronic Filing of Tax Return Data Acknowledgment',
            152 => 'Statistical Government Information',
            153 => 'Unemployment Insurance Tax Claim or Charge Information',
            154 => 'Secured Interest Filing',
            155 => 'Business Credit Report',
            157 => 'Notice of Power of Attorney',
            158 => 'Tax Jurisdiction Sourcing',
            159 => 'Motion Picture Booking Confirmation',
            160 => 'Transportation Automatic Equipment Identification',
            161 => 'Train Sheet',
            163 => 'Transportation Appointment Schedule Information',
            170 => 'Revenue Receipts Statement',
            175 => 'Court and Law Enforcement Notice',
            176 => 'Court Submission',
            179 => 'Environmental Compliance Reporting',
            180 => 'Return Merchandise Authorization and Notification',
            185 => 'Royalty Regulatory Report',
            186 => 'Insurance Underwriting Requirements Reporting',
            187 => 'Premium Audit Request and Return',
            188 => 'Educational Course Inventory',
            189 => 'Application for Admission to Educational Institutions',
            190 => 'Student Enrollment Verification',
            191 => 'Student Loan Pre-Claims and Claims',
            194 => 'Grant or Assistance Application',
            195 => 'Federal Communications Commission (FCC) License Application',
            196 => 'Contractor Cost Data Reporting',
            197 => 'Real Estate Title Evidence',
            198 => 'Loan Verification Information',
            199 => 'Real Estate Settlement Information',
            200 => 'Mortgage Credit Report',
            201 => 'Residential Loan Application',
            202 => 'Secondary Mortgage Market Loan Delivery',
            203 => 'Secondary Mortgage Market Investor Report',
            204 => 'Motor Carrier Load Tender',
            205 => 'Mortgage Note',
            206 => 'Real Estate Inspection',
            210 => 'Motor Carrier Freight Details and Invoice',
            211 => 'Motor Carrier Bill of Lading',
            212 => 'Motor Carrier Delivery Trailer Manifest',
            213 => 'Motor Carrier Shipment Status Inquiry',
            214 => 'Transportation Carrier Shipment Status Message',
            215 => 'Motor Carrier Pickup Manifest',
            216 => 'Motor Carrier Shipment Pickup Notification',
            217 => 'Motor Carrier Loading and Route Guide',
            218 => 'Motor Carrier Tariff Information',
            219 => 'Logistics Service Request',
            220 => 'Logistics Service Response',
            222 => 'Cartage Work Assignment',
            223 => 'Consolidators Freight Bill and Invoice',
            224 => 'Motor Carrier Summary Freight Bill Manifest',
            225 => 'Response to a Cartage Work Assignment',
            227 => 'Trailer Usage Report',
            228 => 'Equipment Inspection Report',
            240 => 'Motor Carrier Package Status',
            242 => 'Data Status Tracking',
            244 => 'Product Source Information',
            245 => 'Real Estate Tax Service Response',
            248 => 'Account Assignment/Inquiry and Service/Status',
            249 => 'Animal Toxicological Data',
            250 => 'Purchase Order Shipment Management Document',
            251 => 'Pricing Support',
            252 => 'Insurance Producer Administration',
            255 => 'Underwriting Information Services',
            256 => 'Periodic Compensation',
            259 => 'Residential Mortgage Insurance Explanation of Benefits',
            260 => 'Application for Mortgage Insurance Benefits',
            261 => 'Real Estate Information Request',
            262 => 'Real Estate Information Report',
            263 => 'Residential Mortgage Insurance Application Response',
            264 => 'Mortgage Loan Default Status',
            265 => 'Real Estate Title Insurance Services Order',
            266 => 'Mortgage or Property Record Change Notification',
            267 => 'Individual Life, Annuity and Disability Application',
            268 => 'Annuity Activity',
            269 => 'Health Care Benefit Coordination Verification',
            270 => 'Eligibility, Coverage or Benefit Inquiry',
            271 => 'Eligibility, Coverage or Benefit Information',
            272 => 'Property and Casualty Loss Notification',
            273 => 'Insurance/Annuity Application Status',
            274 => 'Healthcare Provider Information',
            275 => 'Patient Information',
            276 => 'Health Care Claim Status Request',
            277 => 'Health Care Information Status Notification',
            278 => 'Health Care Services Review Information',
            280 => 'Voter Registration Information',
            283 => 'Tax or Fee Exemption Certification',
            284 => 'Commercial Vehicle Safety Reports',
            285 => 'Commercial Vehicle Safety and Credentials Information Exchange',
            286 => 'Commercial Vehicle Credentials',
            288 => 'Wage Determination',
            290 => 'Cooperative Advertising Agreements',
            300 => 'Reservation (Booking Request) (Ocean)',
            301 => 'Confirmation (Ocean)',
            303 => 'Booking Cancellation (Ocean)',
            304 => 'Shipping Instructions',
            309 => 'Customs Manifest',
            310 => 'Freight Receipt and Invoice (Ocean)',
            311 => 'Canada Customs Information',
            312 => 'Arrival Notice (Ocean)',
            313 => 'Shipment Status Inquiry (Ocean)',
            315 => 'Status Details (Ocean)',
            317 => 'Delivery/Pickup Order',
            319 => 'Terminal Information',
            322 => 'Terminal Operations and Intermodal Ramp Activity',
            323 => 'Vessel Schedule and Itinerary (Ocean)',
            324 => 'Vessel Stow Plan (Ocean)',
            325 => 'Consolidation of Goods In Container',
            326 => 'Consignment Summary List',
            350 => 'Customs Status Information',
            352 => 'U.S. Customs Carrier General Order Status',
            353 => 'Customs Events Advisory Details',
            354 => 'U.S. Customs Automated Manifest Archive Status',
            355 => 'U.S. Customs Acceptance/Rejection',
            356 => 'U.S. Customs Permit to Transfer Request',
            357 => 'U.S. Customs In-Bond Information',
            358 => 'Customs Consist Information',
            361 => 'Carrier Interchange Agreement (Ocean)',
            362 => 'Cargo Insurance Advice of Shipment',
            404 => 'Rail Carrier Shipment Information',
            410 => 'Rail Carrier Freight Details and Invoice',
            412 => 'Trailer or Container Repair Billing',
            414 => 'Rail Carhire Settlements',
            417 => 'Rail Carrier Waybill Interchange',
            418 => 'Rail Advance Interchange Consist',
            419 => 'Advance Car Disposition',
            420 => 'Car Handling Information',
            421 => 'Estimated Time of Arrival and Car Scheduling',
            422 => 'Equipment Order',
            423 => 'Rail Industrial Switch List',
            424 => 'Rail Carrier Services Settlement',
            425 => 'Rail Waybill Request',
            426 => 'Rail Revenue Waybill',
            429 => 'Railroad Retirement Activity',
            431 => 'Railroad Station Master File',
            432 => 'Rail Deprescription',
            433 => 'Railroad Reciprocal Switch File',
            434 => 'Railroad Mark Register Update Activity',
            435 => 'Standard Transportation Commodity Code Master',
            436 => 'Locomotive Information',
            437 => 'Railroad Junctions and Interchanges Activity',
            440 => 'Shipment Weights',
            451 => 'Railroad Event Report',
            452 => 'Railroad Problem Log Inquiry or Advice',
            453 => 'Railroad Service Commitment Advice',
            455 => 'Railroad Parameter Trace Registration',
            456 => 'Railroad Equipment Inquiry or Advice',
            460 => 'Railroad Price Distribution Request or Response',
            463 => 'Rail Rate Reply',
            466 => 'Rate Request',
            468 => 'Rate Docket Journal Log',
            470 => 'Railroad Clearance',
            475 => 'Rail Route File Maintenance',
            485 => 'Ratemaking Action',
            486 => 'Rate Docket Expiration',
            490 => 'Rate Group Definition',
            492 => 'Miscellaneous Rates',
            494 => 'Rail Scale Rates',
            500 => 'Medical Event Reporting',
            501 => 'Vendor Performance Review',
            503 => 'Pricing History',
            504 => 'Clauses and Provisions',
            511 => 'Requisition',
            517 => 'Material Obligation Validation',
            521 => 'Income or Asset Offset',
            527 => 'Material Due-In and Receipt',
            536 => 'Logistics Reassignment',
            540 => 'Notice of Employment Status',
            561 => 'Contract Abstract',
            567 => 'Contract Completion Status',
            568 => 'Contract Payment Management Report',
            601 => 'U.S. Customs Export Shipment Information',
            602 => 'Transportation Services Tender',
            620 => 'Excavation Communication',
            622 => 'Intermodal Ramp Activity',
            625 => 'Well Information',
            650 => 'Maintenance Service Order',
            715 => 'Intermodal Group Loading Plan',
            753 => 'Request for Routing Instructions',
            754 => 'Routing Instructions',
            805 => 'Contract Pricing Proposal',
            806 => 'Project Schedule Reporting',
            810 => 'Invoice',
            811 => 'Consolidated Service Invoice/Statement',
            812 => 'Credit/Debit Adjustment',
            813 => 'Electronic Filing of Tax Return Data',
            814 => 'General Request, Response or Confirmation',
            815 => 'Cryptographic Service Message',
            816 => 'Organizational Relationships',
            818 => 'Commission Sales Report',
            819 => 'Joint Interest Billing and Operating Expense Statement',
            820 => 'Payment Order/Remittance Advice',
            821 => 'Financial Information Reporting',
            822 => 'Account Analysis',
            823 => 'Lockbox',
            824 => 'Application Advice',
            826 => 'Tax Information Exchange',
            827 => 'Financial Return Notice',
            828 => 'Debit Authorization',
            829 => 'Payment Cancellation Request',
            830 => 'Planning Schedule with Release Capability',
            831 => 'Application Control Totals',
            832 => 'Price/Sales Catalog',
            833 => 'Mortgage Credit Report Order',
            834 => 'Benefit Enrollment and Maintenance',
            835 => 'Health Care Claim Payment/Advice',
            836 => 'Procurement Notices',
            837 => 'Health Care Claim',
            838 => 'Trading Partner Profile',
            839 => 'Project Cost Reporting',
            840 => 'Request for Quotation',
            841 => 'Specifications/Technical Information',
            842 => 'Nonconformance Report',
            843 => 'Response to Request for Quotation',
            844 => 'Product Transfer Account Adjustment',
            845 => 'Price Authorization Acknowledgment/Status',
            846 => 'Inventory Inquiry/Advice',
            847 => 'Material Claim',
            848 => 'Material Safety Data Sheet',
            849 => 'Response to Product Transfer Account Adjustment',
            850 => 'Purchase Order',
            851 => 'Asset Schedule',
            852 => 'Product Activity Data',
            853 => 'Routing and Carrier Instruction',
            854 => 'Shipment Delivery Discrepancy Information',
            855 => 'Purchase Order Acknowledgment',
            856 => 'Ship Notice/Manifest',
            857 => 'Shipment and Billing Notice',
            858 => 'Shipment Information',
            859 => 'Freight Invoice',
            860 => 'Purchase Order Change Request - Buyer Initiated',
            861 => 'Receiving Advice/Acceptance Certificate',
            862 => 'Shipping Schedule',
            863 => 'Report of Test Results',
            864 => 'Text Message',
            865 => 'Purchase Order Change Acknowledgment/Request - Seller Initiated',
            866 => 'Production Sequence',
            867 => 'Product Transfer and Resale Report',
            868 => 'Electronic Form Structure',
            869 => 'Order Status Inquiry',
            870 => 'Order Status Report',
            871 => 'Component Parts Content',
            872 => 'Residential Mortgage Insurance Application',
            873 => 'Commodity Movement Services',
            874 => 'Commodity Movement Services Response',
            875 => 'Grocery Products Purchase Order',
            876 => 'Grocery Products Purchase Order Change',
            877 => 'Manufacturer Coupon Family Code Structure',
            878 => 'Product Authorization/De-authorization',
            879 => 'Price Information',
            880 => 'Grocery Products Invoice',
            881 => 'Manufacturer Coupon Redemption Detail',
            882 => 'Direct Store Delivery Summary Information',
            883 => 'Market Development Fund Allocation',
            884 => 'Market Development Fund Settlement',
            885 => 'Retail Account Characteristics',
            886 => 'Customer Call Reporting',
            887 => 'Coupon Notification',
            888 => 'Item Maintenance',
            889 => 'Promotion Announcement',
            891 => 'Deduction Research Report',
            893 => 'Item Information Request',
            894 => 'Delivery/Return Base Record',
            895 => 'Delivery/Return Acknowledgment or Adjustment',
            896 => 'Product Dimension Maintenance',
            920 => 'Loss or Damage Claim - General Commodities',
            924 => 'Loss or Damage Claim - Motor Vehicle',
            925 => 'Claim Tracer',
            926 => 'Claim Status Report and Tracer Reply',
            928 => 'Automotive Inspection Detail',
            940 => 'Warehouse Shipping Order',
            943 => 'Warehouse Stock Transfer Shipment Advice',
            944 => 'Warehouse Stock Transfer Receipt Advice',
            945 => 'Warehouse Shipping Advice',
            946 => 'Delivery Information Message',
            947 => 'Warehouse Inventory Adjustment Advice',
            980 => 'Functional Group Totals',
            990 => 'Response to a Load Tender',
            993 => 'Secured Receipt or Acknowledgment',
            994 => 'Administrative Message',
            996 => 'File Transfer',
            997 => 'Functional Acknowledgment',
            998 => 'Set Cancellation',
            999 => 'Implementation Acknowledgment',
        );
        return $TypeArray;
    }


    /**
     * Returns a formatted date for the passed value
     * @param $value Date to be formatted
     * @return bool|string formatted date, else empty string if $value is not set
     */
    public function formatDate($value){
        $result = '';
        if(isset($value)){
            $result = date('Y-m-d', strtotime($value));
        }
        return $result;
    }

    /**
     * Formats created on date
     * @return bool|string
     */
    public function formatCreatedOnDate(){
        if(isset($this->ED1_CREATED_ON)){
            return $this->formatDate($this->ED1_CREATED_ON);
        }
    }

    /**
     * Formats modified on date
     * @return bool|string
     */
    public function formatModifiedOnDate(){
        if(isset($this->ED1_MODIFIED_ON)){
            return $this->formatDate($this->ED1_MODIFIED_ON);
        }
    }


    /**
     * Gets all the types for edi Transactions that are currently used in the database
     * @return array
     */
    public static function getTypeArray() {
        $sqlConnect = "USE `comparatio_edi`;";
        $sqlStatement = "SELECT distinct ED1_TYPE FROM ed1_edi;";
        $data = array(); // data to be returned
        $connection=Yii::app()->db;
        $conn = new mysqli('127.0.0.1', $connection->username, $connection->password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->query($sqlConnect);
        $data = $conn->query($sqlStatement);
        $data = $data->fetch_all();
        $data = array($data[0][0],$data[1][0],$data[2][0],$data[3][0],);
        return $data;
    }

    /**
     * Fills an array with order types associated with ED1_TYPES. These types are related to the NO1_TYPE in Numbers model
     * @return array
     */
    public function getNumberType(){
        if(isset($this->ED1_TYPE)){
            $types = self::getNumberTypes();
            $result = isset($types[$this->ED1_TYPE]) ? $types[$this->ED1_TYPE] : null;
        }
        return isset($result) ? $result : null;
    }

    public function getNumberTypes(){
        return array(
            '850'           => array('PO', 'Orders', 'Pick Ticket'),
            '856'           => array('ASN'),
            '210'           => array('INVOICE'),
            '810'           => array('INVOICE'),
            '880'           => array('INVOICE'),
            '875'           => array('ORDER'),
            '843'           => array('QUOTE'),
            '940'           => array('PICKTICKET'),
            '855'           => array('POACK'),
            'ORDERCHECK'    => array('ORDERCHECK'),
            '820'           => array('PAYMENT_ADVICE'),
            'EZXMLPO'       => array('PO'),
            'POCSV'         => array('PO'),
            'PONNR'         => array('PO'),
            'D93A ORDERS'   => array('PO'),
            'Trend 850'     => array('PO'),
            'Trend Invoice'  => array('INVOICE'),
            'Inyo Invoice'   => array('INVOICE'),
            'Channel Advisor Invoice'  => array('INVOICE'),
            'cXML Invoice'    => array('INVOICE'),
            'eBay Invoice'    => array('INVOICE'),
            'Amazon Invoice'  => array('INVOICE'),
            '940 XML'           => array('PICKTICKET'),
            'PICK_TICKET_CSV'   => array('PICKTICKET'),
            'PICK_TICKET_CSV2'  => array('PICKTICKET'),
            '870'           => array('POACK'),
            'CXML_POACK'    => array('POACK'),
            'cXML POACK'    => array('POACK'),
            'Email_POACK'   => array('POACK'),
            '860'           => array('PO CHANGE'),
            'PONNR_CHANGE'  => array('PO CHANGE'),
            '943'           => array('TRANSFER'),
            '753'           => array('ROUTING REQUEST')
        );

    }


    /**
     * Calls an array of EDI TYPEs based on the ED1_TYPE number it is passed
     * Then it finds the row in the NO1_NUMBERS table that matches the criteria
     * @return Numbers model
     */
    public function getRelatedNumbersModel(){

        $typesArray = $this->getNumberType();

        foreach($typesArray as $type){

            if(isset($this->ED1_TYPE, $this->ED1_DOCUMENT_NO, $this->CU1_ID)){
                $numbersModel = Numbers::model()->findByAttributes(
                    array(
                        'NO1_TYPE'      => $type,
                        'NO1_NUMBER'    => $this->ED1_DOCUMENT_NO,
                        'CU1_ID'        => $this->CU1_ID,
                        'NO1_TEST_MODE' => $this->ED1_TEST_MODE,
                    )
                );

            }

            //If the Numbers model wasn't found using the CU1_ID, then try again using the VD1_ID
            if(!isset($numbersModel) && isset($this->ED1_TYPE, $this->ED1_DOCUMENT_NO, $this->VD1_ID)){
                $numbersModel = Numbers::model()->findByAttributes(
                    array(
                        'NO1_TYPE'      => $type,
                        'NO1_NUMBER'    => $this->ED1_DOCUMENT_NO,
                        'VD1_ID'        => $this->VD1_ID,
                        'NO1_TEST_MODE' => $this->ED1_TEST_MODE,
                    )
                );
            }

            if(isset($numbersModel)){
                break;
            }

        }
        return isset($numbersModel) ? $numbersModel : null;
    }

    public function stripDynamicPrefix($column){
        $result = '';
        if(substr($column->name,0,3)=='ED1'){
            $result = substr($column->name, 4, strlen($column->name));;
        }
        else{
            $result = $column->name;
        }

        return $result;
    }

    /**
     * Returns the String name with the associated const, or if resend value = 1, then return "resend"
     * @return string The english name of the valid ED1_STATUS constant
     */
    public function getStatusLabel()
    {
        $result = '';
        if(isset($this->ED1_STATUS)){
            if($this->ED1_RESEND == Edi::RESEND)
            {
                $result = Edi::itemAlias('ED1_STATUS_LABELS_RESENDING',$this->ED1_STATUS) . ' ' . $result ;
            }
            else{
                $result = Edi::itemAlias('ED1_STATUS_LABELS', $this->ED1_STATUS) . ' ' . $result ;
            }
        }
        return $result;
    }

    /**
     * Returns the associated String name with INBOUND or OUTBOUND consts
     * @return string The english name of the valid INBOUND_STATUS or OUTBOUND_STATUS constants
     */
    public function getInOutName()
    {
        $result = '';

        if(isset($this->ED1_IN_OUT)){
            $statuses = Edi::itemAlias('EDI_IN_OUT_STATUS');
            if(isset($statuses[$this->ED1_IN_OUT])){
                if($this->ED1_IN_OUT == Edi::INBOUND_STATUS){
                    $result = '<span class="label label-warning">' . '<span class="fa fa-arrow-down">' . ' ' . '</span>' .' ' . $statuses[$this->ED1_IN_OUT] . '</span>';
                }
                elseif($this->ED1_IN_OUT == EDI::OUTBOUND_STATUS){
                    $result = '<span class="label label-info">' . '<span class="fa fa-arrow-up">' . ' ' . '</span>' . ' ' . $statuses[$this->ED1_IN_OUT] . '</span>';
                }
            }
        }

        return $result;
    }

    /**
     * returns the values for the ED1_TYPE dropdown list
     * @return array
     */
    public function getStatusDropDownListLabel()
    {
        return array(
            array(
                'id' => Edi::ED1_STATUS_NOT_SENT,
                'text' => Edi::itemAlias('ED1_STATUS_LABELS', Edi::ED1_STATUS_NOT_SENT),
            ),
            array(
                'id' => Edi::ED1_STATUS_PROCESSING,
                'text' => Edi::itemAlias('ED1_STATUS_LABELS', Edi::ED1_STATUS_PROCESSING),
            ),
            array(
                'id' => Edi::ED1_STATUS_SENT,
                'text' =>  Edi::itemAlias('ED1_STATUS_LABELS', Edi::ED1_STATUS_SENT ),
            ),
            array(
                'id' => Edi::ED1_STATUS_FAILED,
                'text' =>  Edi::itemAlias('ED1_STATUS_LABELS', Edi::ED1_STATUS_FAILED ),
            )
        );
    }

//    public function getBaseURL()
//    {
//        $baseUrl = YiiBase::getPathOfAlias('webroot');
//        return $pathToFile = $baseUrl . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $this->ED1_FILENAME;
//    }

    public function getDownloadBaseURL()
    {
        $baseUrl = "C:/xampp/htdocs/edi";
        return $baseUrl;
    }


    /**
     * Creates a URL to the /edi/files folder of the server
     * Uses the filename from the database as part of the URL
     * @return string CHTML link for the file path
     */
    public function getFilePathURLDownloadLink()
    {
        $result = '';

        $pathToFile = "files";

        if(isset($this->ED1_FILENAME) && ($this->ED1_FILENAME != '')){
            $urlPath = "files/" . basename($this->ED1_FILENAME);
            if($this->ED1_IN_OUT == 0){
                $urlPath = $urlPath . "_imported";
            }
            $filePath = Yii::app()->createAbsoluteUrl($urlPath);
            $result = "<a href='$filePath' target='_blank' download='$this->ED1_FILENAME' class = 'fa fa-download'> ";
        }
        return $result;
    }

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Edi the static model class
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
        return 'ed1_edi';
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
            array('ED1_STATUS, CU1_ID, VD1_ID, ED1_MODIFIED_BY, ED1_CREATED_BY, ED1_IN_OUT, ED1_RESEND, ED1_ACKNOWLEDGED', 'numerical', 'integerOnly'=>true),
            array('ED1_TYPE', 'length', 'max'=>45),
            array('ED1_DOCUMENT_NO', 'length', 'max'=>20),
            array('ED1_FILENAME', 'length', 'max'=>255),
            array('ED1_SHOW_DEFAULT, ED1_TEST_MODE', 'length', 'max'=>1),
            array('ED1_MODIFIED_ON, ED1_CREATED_ON, vd1_search, cu1_search, corp_address_id_search, vendor_id_search, cprofile_search, mprofile_search', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ED1_ID, ED1_TYPE, ED1_DOCUMENT_NO, ED1_FILENAME, ED1_STATUS, CU1_ID, VD1_ID, ED1_MODIFIED_ON, ED1_MODIFIED_BY, ED1_CREATED_ON, ED1_CREATED_BY, ED1_SHOW_DEFAULT, ED1_IN_OUT, ED1_RESEND, ED1_ACKNOWLEDGED, edi_status_search, edi_type_search, edi_type_relation_search', 'safe', 'on' => 'search'),

            // Rules for relations
            //array('REQUIRED_COLUMNS_ONLY_FOR_RELATION_SEPARATED_BY_COMMA', 'required', 'on' => 'relation'),
        );

        $dynamicRules = Edi::getDynamicRules();
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
            'edi_type_relation' => array(self::BELONGS_TO, 'EdiTypes', 'ED1_TYPE'),
            'customer' => array(self::BELONGS_TO, 'Customer_EDI', 'CU1_ID'),
            'vendor' => array(self::BELONGS_TO, 'Vendor', 'VD1_ID'),
//            'created_by' => array(self::BELONGS_TO, 'Users', 'ED1_CREATED_BY'),//rename to created_by
//            'modified_by' => array(self::BELONGS_TO, 'Users', 'ED1_MODIFIED_BY'),//rename to modified_by
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'ED1_CREATED_BY',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'ED1_MODIFIED_BY',),
        );

    }


    public function getEdiTypeLabel(){
        $i = 0;
    }
    /**
     * Returns a list of columns that are found in the database but that are not currently defined in our Yii data structure
     * @return array
     */
    public function getColumnsNotInYii(){
        $ediTable = Yii::app()->db->schema->getTable('ed1_edi', true);

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
        $newFields = Edi::getColumnsNotInYii();
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
        $newFields = Edi::getColumnsNotInYii();
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
            'ED1_ID' => 'IDEd1',
            'ED1_TYPE' => 'Type',
            'ED1_DOCUMENT_NO' => 'Document No',
            'ED1_FILENAME' => 'Filename',
            'ED1_STATUS' => 'Status',
            'CU1_ID' => 'Customer ID',
            'VD1_ID' => 'Vendor ID',
            'ED1_MODIFIED_ON' => 'Modified On',
            'ED1_MODIFIED_BY' => 'Modified By',
            'ED1_CREATED_ON' => 'Created On',
            'ED1_CREATED_BY' => 'Created By',
            'ED1_SHOW_DEFAULT' => 'Show Default',
            'ED1_IN_OUT' => 'In/Out',
            'ED1_RESEND' => 'Resend',
            'ED1_ACKNOWLEDGED' => 'Acknowledged',
            'ED1_TEST_MODE' => 'Test Mode',
            'corp_address_id_search' => 'Corporation ID',
            'cu1_search' => 'Customer Name',
            'vendor_id_search' => 'Vendor ID',
            'vd1_search' => 'Vendor Name',
            'edi_status_search' => 'Status',
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
            'download_column' => 'Download',
        );

        if($includeDynamicLabels == true){
            $dynamicLabels = Edi::getDynamicAttributeLabels();
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
        $alias = Edi::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.ED1_ID';
        $scope->condition = 'ED1_SHOW_DEFAULT="X"';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Edi::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.ED1_ID, ' . $alias . '.ED1_TYPE',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.ED1_ID',
            ),
            'show_default'=>array(
                'condition'=>'ED1_SHOW_DEFAULT="X"',
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
        $models = Edi::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->ED1_ID)) {
                $rtv[$model->ED1_ID] = $model->ED1_TYPE;
            }
        }
        return $rtv;
    }


    public $vd1_search;
    public $vendor_id_search;
    public $cu1_search;
    public $corp_address_id_search;
    public $edi_status_search;
    public $edi_type_search;
    public $cprofile_search;
    public $mprofile_search;
    public $download_column;
    public $edi_type_relation_search;

    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = Edi::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('vendor','customer','cprofile', 'mprofile', 'edi_type_relation');
        $criteria->compare($alias . '.ED1_ID', $this->ED1_ID, true);
        $criteria->compare($alias . '.ED1_TYPE', $this->ED1_TYPE, true);
        $criteria->compare($alias . '.ED1_DOCUMENT_NO', $this->ED1_DOCUMENT_NO, true);
        $criteria->compare($alias . '.ED1_FILENAME', $this->ED1_FILENAME, true);
        $criteria->compare($alias . '.ED1_STATUS', $this->ED1_STATUS);
        $criteria->compare($alias . '.CU1_NAME', $this->CU1_ID);
        $criteria->compare($alias . '.VD1_ID', $this->VD1_ID);
        $criteria->compare($alias . '.ED1_MODIFIED_ON', $this->ED1_MODIFIED_ON, true);
        $criteria->compare($alias . '.ED1_MODIFIED_BY', $this->ED1_MODIFIED_BY);
        $criteria->compare($alias . '.ED1_CREATED_ON', $this->ED1_CREATED_ON, true);
        $criteria->compare($alias . '.ED1_CREATED_BY', $this->ED1_CREATED_BY);
        $criteria->compare($alias . '.ED1_SHOW_DEFAULT', $this->ED1_SHOW_DEFAULT, true);
        $criteria->compare($alias . '.ED1_IN_OUT', $this->ED1_IN_OUT);
        $criteria->compare($alias . '.ED1_RESEND', $this->ED1_RESEND);
        $criteria->compare($alias . '.ED1_ACKNOWLEDGED', $this->ED1_ACKNOWLEDGED);
        $criteria->compare($alias . '.ED1_TEST_MODE', $this->ED1_TEST_MODE);


        if (isset($this->vd1_search) && strlen($this->vd1_search) > 0) {
            $criteria->compare('vendor.VD1_NAME', $this->vd1_search, true);
        }

        if (isset($this->vendor_id_search) && strlen($this->vendor_id_search) > 0) {
            $criteria->compare('vendor.VENDOR_ID', $this->vendor_id_search, true);
        }

        if (isset($this->cu1_search) && strlen($this->cu1_search) > 0) {
            $criteria->compare('customer.CU1_NAME', $this->cu1_search, true);
        }

        if (isset($this->corp_address_id_search) && strlen($this->corp_address_id_search) > 0) {
            $criteria->compare('customer.CORP_ADDRESS_ID', $this->corp_address_id_search, true);
        }
        if (isset($this->edi_status_search) && strlen($this->edi_status_search) > 0) {
            $criteria->compare('ED1_STATUS', $this->edi_status_search, true);
        }
        if (isset($this->edi_type_search) && strlen($this->edi_type_search) > 0) {
            $criteria->compare('ED1_TYPE', $this->edi_type_search, true);
        }
        if (isset($this->cprofile_search) && strlen($this->cprofile_search) > 0) {
            $criteria->addCondition('CONCAT(cprofile.first_name, " ", cprofile.last_name) LIKE :cprofile_search');
            $criteria->params = array_merge($criteria->params, array(':cprofile_search' => '%' . $this->cprofile_search . '%'));
        }
        if (isset($this->mprofile_search) && strlen($this->mprofile_search) > 0) {
            $criteria->addCondition("CONCAT(mprofile.first_name, ' ', mprofile.last_name) LIKE :mprofile_search");
            $criteria->params = array_merge($criteria->params, array(':mprofile_search' => '%' . $this->mprofile_search . '%'));
        }
        if (isset($this->edi_type_relation_search) && strlen($this->edi_type_relation_search) > 0) {
            $criteria->addCondition("CONCAT(edi_type_relation.ED2_NUMBER, ' ', edi_type_relation.ED2_NAME) LIKE :edi_type_relation_search");
            $criteria->params = array_merge($criteria->params, array(':edi_type_relation_search' => '%' . $this->edi_type_relation_search . '%'));
        }

        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'ED1_created_on DESC',
                'attributes' => array(
                    'vd1_search' => array(
                        'asc' => 'vendor.VD1_NAME',
                        'desc' => 'vendor.VD1_NAME DESC',
                    ),
                    'vendor_id_search' => array(
                        'asc' => 'vendor.VENDOR_ID',
                        'desc' => 'vendor.VENDOR_ID DESC',
                    ),
                    'cu1_search' => array(
                        'asc' => 'customer.CU1_NAME',
                        'desc' => 'customer.CU1_NAME DESC',
                    ),
                    'corp_address_id_search' => array(
                        'asc' => 'customer.CORP_ADDRESS_ID',
                        'desc' => 'customer.CORP_ADDRESS_ID DESC',
                    ),
                    'edi_status_search' => array(
                        'asc' => 'ED1_STATUS',
                        'desc' => 'ED1_STATUS DESC',
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
                )
            ),
            'pagination' => array('pageSize' => 100),
        ));
    }


    /**
     * Gets and returns the formatted Pie Chart Data for the dashboard
     * author: Alex Lappen
     * Date: 9/14/2016
     * @return mixed|string
     */
    public static function getPieChartData(){
        $resultString = "";

        $connection=Yii::app()->db;
        $conn = new mysqli('127.0.0.1', $connection->username, $connection->password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sqlConnect = "USE `comparatio_edi`;";
        $conn->query($sqlConnect);

        $sql = "select if(cu1.CU1_NAME is not null,cu1.CU1_NAME,vd1.VD1_NAME) as TRADING_PARTNER_NAME, count(*) as TRANSACTION_COUNT from ed1_edi as ed1 left join cu1_customer as cu1 on cu1.CU1_ID=ed1.CU1_ID left join vd1_vendor as vd1 on vd1.VD1_ID=ed1.VD1_ID group by if(cu1.CU1_NAME is not null,CU1_NAME,VD1_NAME)  LIMIT 300000";
        $customerArray = $conn->query($sql)->fetch_all();

        foreach($customerArray as $customer){
            if($customer[0] != "") {
                $dataString = "{ name: '" . addslashes($customer[0]) . "', y: " . addslashes($customer[1]) . " }, ";
                $resultString .= $dataString;
            }
        }

        $resultString = substr_replace($resultString, "", -2);

        return $resultString;
    }

    /**
     * Gets and returns the formatted Box Chart Data for the dashboard
     * author: Alex Lappen
     * Date: 9/14/2016
     * @return mixed|string
     */
    public static function getChartData()
    {
        $connection=Yii::app()->db;
        $conn = new mysqli('127.0.0.1', $connection->username, $connection->password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sqlConnect = "USE `comparatio_edi`;";
        $conn->query($sqlConnect);

        $countArray = $conn->query("select date(ED1_CREATED_ON) as TRANSACTION_DATE, count(*) as TRANSACTION_COUNT from ed1_edi group by date(ED1_CREATED_ON) LIMIT 300000")->fetch_all();

        $drilldownArray= [];

        $resultString = "";
        $drilldownString = "";
        $length = sizeof($countArray)-1;
        $temp = 0;
        while($temp < 7){
            if($countArray[$length][0] != "" && $countArray[$length][0] != null) {
                //$dataString = "" . $countArray[$length][1] . ", ";
                $dataString = "name:'" . $countArray[$length][0] . "',y:" . $countArray[$length][1] . ",drilldown:'" . $countArray[$length][0] . "'},{";
                $resultString = $dataString . $resultString;
                $sql = "select distinct(b.cu1_name), count(a.ed1_id) from ed1_edi a left join cu1_customer b on a.cu1_id = b.cu1_id where b.cu1_name is not null AND ED1_CREATED_ON BETWEEN '" . $countArray[$length][0] . " 0:00:00' AND '" . $countArray[$length][0] . " 23:59:59' group by b.cu1_name;";
                $drilldownArray[$countArray[$length][0]] = $conn->query($sql)->fetch_all();
                $length = $length - 1;
                $temp = $temp + 1;
            }
        }

        $resultString = substr($resultString,0,strlen($resultString)-3);

        foreach($drilldownArray as $key=>$array){
            $drilldownString = $drilldownString . "{name:'" . $key . "',id:'" . $key . "',data:[ "; //]}
            foreach($array as $value){
                $drilldownString = $drilldownString . "['" . $value[0] . "'," . $value[1] . "],";
            }
            $drilldownString = substr($drilldownString,0,strlen($drilldownString)-1);
            $drilldownString = $drilldownString . "]},";
        }

        $drilldownString = substr($drilldownString,0,strlen($drilldownString)-1);

        return [$resultString,$drilldownString];
    }

    public static function getDates(){
        $dateString = '';
        for($i=0;$i<7;$i++){
            $date = date('F j',strtotime('-' . $i . ' days'));
            $dateString = '"' . $date .'"' . ',' . $dateString;
        }
        return $dateString;
    }

    public static function getSuccessFailedData(){
        $connection=Yii::app()->db;
        $conn = new mysqli('127.0.0.1', $connection->username, $connection->password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sqlConnect = "USE `comparatio_edi`;";
        $conn->query($sqlConnect);

        $result = $conn->query("SELECT ed1_in_out,count(ed1_edi.ED1_ID) FROM comparatio_edi.ed1_edi where ED1_CREATED_ON BETWEEN '2017-01-03 0:00:00' AND '2017-01-03 23:59:59' group by ED1_IN_OUT;")->fetch_all();
        $ediIn = 0;
        $ediOut = 0;
        foreach($result as $array){
            if($array[0] == '0'){
                $ediOut = $array[1];
            }elseif($array[0] == '1'){
                $ediIn = $array[1];
            }
        }
        $result = '["In",' . $ediIn . '],["Out",' . $ediOut . ']';
        return $result;
    }

//xAxis: {
//categories: [
//' . date('d',strtotime("-6 days")) . ',
//' . date("d",strtotime("-5 days")) . ',
//' . date("d",strtotime("-4 days")) . ',
//' . date("d",strtotime("-3 days")) . ',
//' . date("d",strtotime("-2 days")) . ',
//' . date("d",strtotime("-1 days")) . ',
//' . date("d") . ',
//],
//crosshair: true
//},

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
            'fileName' => Yii::t('app', 'Edi').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'ED1_CREATED_ON',
                    'label' => $this->getAttributeLabel('ED1_CREATED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_TYPE',
                    'label' => $this->getAttributeLabel('ED1_TYPE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_IN_OUT',
                    'label' => $this->getAttributeLabel('ED1_IN_OUT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_DOCUMENT_NO',
                    'label' => $this->getAttributeLabel('ED1_DOCUMENT_NO'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_FILENAME',
                    'label' => $this->getAttributeLabel('ED1_FILENAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_STATUS',
                    'label' => $this->getAttributeLabel('ED1_STATUS'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'vd1_search',
                    'label' => $this->getAttributeLabel('corp_address_id_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('customer->CORP_ADDRESS_ID')),
                    'width' => 45,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_search',
                    'label' => $this->getAttributeLabel('cu1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('customer->CU1_NAME')),
                    'width' => 45,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'vd1_search',
                    'label' => $this->getAttributeLabel('vendor_id_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('vendor->VD1_ID')),
                    'width' => 45,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'vd1_search',
                    'label' => $this->getAttributeLabel('vd1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('vendor->VD1_NAME')),
                    'width' => 45,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_MODIFIED_ON',
                    'label' => $this->getAttributeLabel('ED1_MODIFIED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_MODIFIED_BY',
                    'label' => $this->getAttributeLabel('ED1_MODIFIED_BY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_CREATED_BY',
                    'label' => $this->getAttributeLabel('ED1_CREATED_BY'),
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

