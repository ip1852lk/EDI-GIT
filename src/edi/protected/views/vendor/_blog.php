<?php
/* @var $this VendorController
 * @var $data Vendor
 */

$vendorAdmin = Yii::app()->user->checkAccess('Vendor.*');
$vendorUpdate = Yii::app()->user->checkAccess('Vendor.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-users fa-lg',
    'title' => $vendorUpdate ? TbHtml::link(UHtml::markSearch($data, "VD1_ID"), array("update", "id" => $data->VD1_ID)) : $data->VD1_ID,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'VD1_ID',
            'type' => 'raw',
            'value' => $vendorUpdate ? TbHtml::link(UHtml::markSearch($data, "VD1_ID"), array("update", "id" => $data->VD1_ID)) : $data->VD1_ID,
        ),
        array(
            'name' => 'VENDOR_ID',
        ),
        array(
            'name' => 'VD1_NAME',
        ),
        array(
            'name' => 'VD1_CREATED_BY',
        ),
        array(
            'name' => 'VD1_CREATED_ON',
        ),
        array(
            'name' => 'VD1_MODIFIED_BY',
        ),
        array(
            'name' => 'VD1_MODIFIED_ON',
        ),
        array(
            'name' => 'VD1_SHOW_DEFAULT',
        ),
        array(
            'name' => 'VD1_RECEIVE_EDI',
        ),
        array(
            'name' => 'VD1_SEND_EDI_PO',
        ),
        array(
            'name' => 'VD1_SEND_ACKNOWLEDGEMENT',
        ),
        array(
            'name' => 'VD1_PO_FORMAT',
        ),
        array(
            'name' => 'VD1_SEND_FTP',
        ),
        array(
            'name' => 'VD1_SEND_SFTP',
        ),
        array(
            'name' => 'VD1_POST_HTTP',
        ),
        array(
            'name' => 'VD1_RECEIVE_FTP',
        ),
        array(
            'name' => 'VD1_PICKUP_FTP',
        ),
        array(
            'name' => 'VD1_PICKUP_SFTP',
        ),
        array(
            'name' => 'VD1_RECEIVE_HTTP',
        ),
        array(
            'name' => 'VD1_REMOTE_FTP_SERVER',
        ),
        array(
            'name' => 'VD1_REMOTE_FTP_USERNAME',
        ),
        array(
            'name' => 'VD1_REMOTE_FTP_PASSWORD',
        ),
        array(
            'name' => 'VD1_REMOTE_FTP_DIRECTORY_SEND',
        ),
        array(
            'name' => 'VD1_REMOTE_FTP_DIRECTORY_PICKUP',
        ),
        array(
            'name' => 'VD1_FTP_USER',
        ),
        array(
            'name' => 'VD1_FTP_PASSWORD',
        ),
        array(
            'name' => 'VD1_FTP_DIRECTORY',
        ),
        array(
            'name' => 'VD1_REMOTE_HTTP_SERVER',
        ),
        array(
            'name' => 'VD1_SUPPLIER_CODE',
        ),
        array(
            'name' => 'VD1_RECEIVER_QUALIFIER',
        ),
        array(
            'name' => 'VD1_RECEIVER_ID',
        ),
        array(
            'name' => 'VD1_FACILITY',
        ),
        array(
            'name' => 'VD1_TRADING_PARTNER_QUALIFIER',
        ),
        array(
            'name' => 'VD1_TRADING_PARTNER_ID',
        ),
        array(
            'name' => 'VD1_TRADING_PARTNER_GS_ID',
        ),
        array(
            'name' => 'VD1_FLAG',
        ),
        array(
            'name' => 'VD1_X12_STANDARD',
        ),
        array(
            'name' => 'VD1_EDI_VERSION',
        ),
        array(
            'name' => 'VD1_DUNS',
        ),
        array(
            'name' => 'VD1_SHARED_SECRET',
        ),
        array(
            'name' => 'VD1_SEND_EDI_PO_CHANGE',
        ),
        array(
            'name' => 'VD1_SEND_ITEM_USAGE',
        ),
        array(
            'name' => 'VD1_ITEM_USAGE_FORMAT',
        ),
        array(
            'name' => 'VD1_ITEM_USAGE_SOURCE',
        ),
        array(
            'name' => 'VD1_POST_AS2',
        ),
        array(
            'name' => 'VD1_RECEIVE_AS2',
        ),
        array(
            'name' => 'VD1_CHECK_P21_EDI_FLAG',
        ),
        array(
            'name' => 'VD1_CXML_PAYLOAD_ID',
        ),
        array(
            'name' => 'VD1_SEND_EDI_PAYMENT_ADVICE',
        ),
        array(
            'name' => 'VD1_PAYMENT_ADVICE_FORMAT',
        ),
        array(
            'name' => 'VD1_BANK_ROUTING_NUMBER',
        ),
        array(
            'name' => 'VD1_BANK_ACCOUNT_NUMBER',
        ),
        array(
            'name' => 'VD1_AS2_CERTIFICATE_FILENAME',
        ),
        array(
            'name' => 'VD1_AS2_RECEIVER_ID',
        ),
        array(
            'name' => 'VD1_AS2_TRADING_PARTNER_ID',
        ),
    ),
));
$this->endWidget();

