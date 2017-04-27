<?php 
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 * @var $form TbActiveForm
 */

$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Customer  Edi') : $model->CU1_NAME,
    'headerIcon' => 'fa fa-users fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'customer--edi-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => !isset($dependency) ? 'js:function(form, data, hasError) { 
            if (!hasError) { 
                bootbox.dialog({
                    title: \'' . Yii::t('app', 'Saving...') . '\',
                    message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\',
                });
                return true;
            }
        }' : 'js:function(form, data, hasError) {return true;}',
    ),
));
    echo $form->errorSummary(array($model));
    echo $form->textFieldGroup($model, 'CORP_ADDRESS_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 10)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_NAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        'prepend' => '<i class="fa fa-user"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
//    echo $form->textFieldGroup($model, 'CU1_CREATED_BY', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_CREATED_ON', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_MODIFIED_BY', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_MODIFIED_ON', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SHOW_DEFAULT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 1)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_RECEIVE_EDI', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_EDI_INVOICES', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ASN', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ORDERS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ORDER_CONFIRMATIONS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_ACKNOWLEDGEMENT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ORDER_TYPE', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ORDER_FORMAT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_INVOICE_FORMAT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ASN_FORMAT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_TXT_APPROVED', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_FTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_SFTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_POST_HTTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_RECEIVE_FTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_PICKUP_FTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_RECEIVE_HTTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_PICKUP_SFTP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_SERVER', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_USERNAME', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_PASSWORD', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_SEND', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_PICKUP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_FTP_USER', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_FTP_PASSWORD', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_FTP_DIRECTORY', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REMOTE_HTTP_SERVER', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SUPPLIER_CODE', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
    echo $form->textFieldGroup($model, 'CU1_RECEIVER_QUALIFIER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        'prepend' => '<i class="fa fa-check-circle"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_RECEIVER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
//    echo $form->textFieldGroup($model, 'CU1_FACILITY', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
    echo $form->textFieldGroup($model, 'CU1_TRADING_PARTNER_QUALIFIER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        'prepend' => '<i class="fa fa-check-circle"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_TRADING_PARTNER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),

    ));
//    echo $form->textFieldGroup($model, 'CU1_ASN_TRADING_PARTNER_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_CONSOLIDATE_ASN', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_FLAG', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 1)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_X12_STANDARD', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 4)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_EDI_VERSION', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 5)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_DUNS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SHARED_SECRET', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_REJECT_INVALID_ITEM_ORDERS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_INVALID_ITEM_SUBSTITUTE', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_USE_CONTRACT', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_CUSTOMERS_AND_ITEMS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_STOP_IMPORT_WITH_ERRORS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_USE_CLASS_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_CLASS_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_MAP', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ORDER_PRICE_OVERRIDE', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_SEND_CREDIT_INVOICES', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_852_IMPORT_FOLDER', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_COMPLETE_SHIP_TO_NAME', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ALWAYS_SEND_ASNS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_IMPORT_FREIGHT_CODES', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
    echo $form->textFieldGroup($model, 'CU1_POST_AS2', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'prepend' => '<i class="fa fa-arrow-up"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_RECEIVE_AS2', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'prepend' => '<i class="fa fa-arrow-down"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
//    echo $form->textFieldGroup($model, 'CU1_CXML_PAYLOAD_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
//    ));
    echo $form->textFieldGroup($model, 'CU1_AS2_CERTIFICATE_FILENAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-file-o"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_AS2_RECEIVER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'CU1_AS2_TRADING_PARTNER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
//    echo $form->textFieldGroup($model, 'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_USE_P21_SHIP_TO_DATA', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'CU1_ALLOW_DUPLICATE_PO_NUMBERS', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'customer--edi-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';

    $this->widget(
        'booster.widgets.TbTabs',
        array(
            'type' => 'tabs',
            'justified' => true,
            'tabs' => array(
                array('label' => 'General',
                    'content'=>$this->renderPartial("_general_tab", array('model' => $model, 'form' => $form), true),
                    'active' => true
                ),
                array('label' => 'Send',
                    'content' => $this->renderPartial("_send_tab", array('model' => $model, 'form' => $form), true),
                ),
                array('label' => 'Receive',
                    'content' => $this->renderPartial("_receive_tab", array('model' => $model, 'form' => $form), true),
                ),
                array('label' => 'Additional',
                    'content' => $this->renderPartial("_additional_tab", array('model' => $model, 'form' => $form), true),
                ),
            ),
        )
    );
    $this->endWidget();
$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//$cs = Yii::app()->clientScript;
//$cs->registerScript(__CLASS__ . 'customer__edi_relation', '
//    // Relations in Customer_EDI: Customer
//    $("#customer--edi-form").on("click", "#customer-select-btn", function() {
//        window.openRelationPopup(
//            "'.$this->createUrl('/customer/relation', array(
//                'parentPk' => isset($parentPk) ? $parentPk : null,
//                'parentId' => isset($parentId) ? $parentId : null,
//                'relationIndex' => 1,
//                'relationSelectableRows' => 1,
//            )).'", 
//            "customer-relation-select-btn-1", 
//            "customer-relation-close-btn-1", 
//            function() {
//                var rows = $("#customer-grid-1 tbody input[type=checkbox]:checked").map(function() {
//                    return $(this).parent().next().html();
//                }).get();
//                $.each(rows, function(i, row) {
//                    metadata = row.split("|");
//                    $.each(metadata, function(k, column) {
//                        value = column.split("==");
//                        if (value[0] == "id") 
//                            $("#Customer_EDI_cu1_id").val(value[1]);
//                        if (value[0] == "cu1_name") 
//                            $("#Customer_cu1_name").val(value[1]);
//                    });
//                });
//                window.relationBootbox.modal("hide");
//            },
//            "'.Yii::t('app', 'Please select a CUSTOMER in the list.').'", 
//            "'.Yii::t('app', 'Loading...').'", 
//            "'.Yii::t('app', 'Server Error').'", 
//            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
//        );
//        return false;
//    });
//    $("#customer-clear-btn").click(function() {
//        $("#Customer_EDI_cu1_id").val("");
//        $("#Customer_cu1_name").val("");
//        return false;
//    });
//');

?><!-- customer--edi-form -->
