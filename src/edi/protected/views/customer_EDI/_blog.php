<?php
/* @var $this Customer_EDIController
 * @var $data Customer_EDI
 */

$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
$customer_EDIUpdate = Yii::app()->user->checkAccess('Customer_EDI.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-users fa-lg',
    'title' => $customer_EDIUpdate ? TbHtml::link(UHtml::markSearch($data, "CU1_ID"), array("update", "id" => $data->CU1_ID)) : $data->CU1_ID,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'CU1_ID',
            'type' => 'raw',
            'value' => $customer_EDIUpdate ? TbHtml::link(UHtml::markSearch($data, "CU1_ID"), array("update", "id" => $data->CU1_ID)) : $data->CU1_ID,
        ),
        array(
            'name' => 'CORP_ADDRESS_ID',
        ),
        array(
            'name' => 'CU1_NAME',
        ),
        array(
            'name' => 'CU1_CREATED_BY',
        ),
        array(
            'name' => 'CU1_CREATED_ON',
        ),
        array(
            'name' => 'CU1_MODIFIED_BY',
        ),
        array(
            'name' => 'CU1_MODIFIED_ON',
        ),
        array(
            'name' => 'CU1_SHOW_DEFAULT',
        ),
        array(
            'name' => 'CU1_RECEIVE_EDI',
        ),
        array(
            'name' => 'CU1_SEND_EDI_INVOICES',
        ),
        array(
            'name' => 'CU1_SEND_EDI_ASN',
        ),
        array(
            'name' => 'CU1_SEND_EDI_ORDERS',
        ),
        array(
            'name' => 'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
        ),
        array(
            'name' => 'CU1_SEND_ACKNOWLEDGEMENT',
        ),
        array(
            'name' => 'CU1_ORDER_TYPE',
        ),
        array(
            'name' => 'CU1_ORDER_FORMAT',
        ),
        array(
            'name' => 'CU1_INVOICE_FORMAT',
        ),
        array(
            'name' => 'CU1_ASN_FORMAT',
        ),
        array(
            'name' => 'CU1_TXT_APPROVED',
        ),
        array(
            'name' => 'CU1_SEND_FTP',
        ),
        array(
            'name' => 'CU1_SEND_SFTP',
        ),
        array(
            'name' => 'CU1_POST_HTTP',
        ),
        array(
            'name' => 'CU1_RECEIVE_FTP',
        ),
        array(
            'name' => 'CU1_PICKUP_FTP',
        ),
        array(
            'name' => 'CU1_RECEIVE_HTTP',
        ),
        array(
            'name' => 'CU1_PICKUP_SFTP',
        ),
        array(
            'name' => 'CU1_REMOTE_FTP_SERVER',
        ),
        array(
            'name' => 'CU1_REMOTE_FTP_USERNAME',
        ),
        array(
            'name' => 'CU1_REMOTE_FTP_PASSWORD',
        ),
        array(
            'name' => 'CU1_REMOTE_FTP_DIRECTORY_SEND',
        ),
        array(
            'name' => 'CU1_REMOTE_FTP_DIRECTORY_PICKUP',
        ),
        array(
            'name' => 'CU1_FTP_USER',
        ),
        array(
            'name' => 'CU1_FTP_PASSWORD',
        ),
        array(
            'name' => 'CU1_FTP_DIRECTORY',
        ),
        array(
            'name' => 'CU1_REMOTE_HTTP_SERVER',
        ),
        array(
            'name' => 'CU1_SUPPLIER_CODE',
        ),
        array(
            'name' => 'CU1_RECEIVER_QUALIFIER',
        ),
        array(
            'name' => 'CU1_RECEIVER_ID',
        ),
        array(
            'name' => 'CU1_FACILITY',
        ),
        array(
            'name' => 'CU1_TRADING_PARTNER_QUALIFIER',
        ),
        array(
            'name' => 'CU1_TRADING_PARTNER_ID',
        ),
        array(
            'name' => 'CU1_ASN_TRADING_PARTNER_ID',
        ),
        array(
            'name' => 'CU1_CONSOLIDATE_ASN',
        ),
        array(
            'name' => 'CU1_FLAG',
        ),
        array(
            'name' => 'CU1_X12_STANDARD',
        ),
        array(
            'name' => 'CU1_EDI_VERSION',
        ),
        array(
            'name' => 'CU1_DUNS',
        ),
        array(
            'name' => 'CU1_SHARED_SECRET',
        ),
        array(
            'name' => 'CU1_REJECT_INVALID_ITEM_ORDERS',
        ),
        array(
            'name' => 'CU1_INVALID_ITEM_SUBSTITUTE',
        ),
        array(
            'name' => 'CU1_USE_CONTRACT',
        ),
        array(
            'name' => 'CU1_SEND_CUSTOMERS_AND_ITEMS',
        ),
        array(
            'name' => 'CU1_STOP_IMPORT_WITH_ERRORS',
        ),
        array(
            'name' => 'CU1_USE_CLASS_ID',
        ),
        array(
            'name' => 'CU1_CLASS_ID',
        ),
        array(
            'name' => 'CU1_MAP',
        ),
        array(
            'name' => 'CU1_ORDER_PRICE_OVERRIDE',
        ),
        array(
            'name' => 'CU1_SEND_CREDIT_INVOICES',
        ),
        array(
            'name' => 'CU1_852_IMPORT_FOLDER',
        ),
        array(
            'name' => 'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
        ),
        array(
            'name' => 'CU1_COMPLETE_SHIP_TO_NAME',
        ),
        array(
            'name' => 'CU1_ALWAYS_SEND_ASNS',
        ),
        array(
            'name' => 'CU1_IMPORT_FREIGHT_CODES',
        ),
        array(
            'name' => 'CU1_POST_AS2',
        ),
        array(
            'name' => 'CU1_RECEIVE_AS2',
        ),
        array(
            'name' => 'CU1_CXML_PAYLOAD_ID',
        ),
        array(
            'name' => 'CU1_AS2_CERTIFICATE_FILENAME',
        ),
        array(
            'name' => 'CU1_AS2_RECEIVER_ID',
        ),
        array(
            'name' => 'CU1_AS2_TRADING_PARTNER_ID',
        ),
        array(
            'name' => 'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
        ),
        array(
            'name' => 'CU1_USE_P21_SHIP_TO_DATA',
        ),
        array(
            'name' => 'CU1_ALLOW_DUPLICATE_PO_NUMBERS',
        ),
    ),
));
$this->endWidget();

