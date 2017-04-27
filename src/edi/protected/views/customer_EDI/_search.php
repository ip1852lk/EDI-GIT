<?php
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 * @var $form TbActiveForm
 */

$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
?>
<div class="customer--edi-search-container" style="display:none">
    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'warning',
        'title' => Yii::t('app', 'Advanced Search'),
        'headerIcon' => 'fa fa-filter fa-lg',
    ));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'showErrors' => false,
        'showRequiredSymbol' => false,
        'htmlOptions' => array('class' => 'customer--edi-search-form'),
    ));
        echo $form->textFieldGroup($model, 'CORP_ADDRESS_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 10)),
        ));
        echo $form->textFieldGroup($model, 'CU1_NAME', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        echo $form->textFieldGroup($model, 'CU1_CREATED_BY', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_CREATED_ON', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_MODIFIED_BY', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_MODIFIED_ON', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SHOW_DEFAULT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 1)),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVE_EDI', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_EDI_INVOICES', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ASN', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ORDERS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_EDI_ORDER_CONFIRMATIONS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_ACKNOWLEDGEMENT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_ORDER_TYPE', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_ORDER_FORMAT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_INVOICE_FORMAT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_ASN_FORMAT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_TXT_APPROVED', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_FTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_SFTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_POST_HTTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVE_FTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_PICKUP_FTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVE_HTTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_PICKUP_SFTP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_SERVER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_USERNAME', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_PASSWORD', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_SEND', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_PICKUP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_FTP_USER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_FTP_PASSWORD', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_FTP_DIRECTORY', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REMOTE_HTTP_SERVER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 200)),
        ));
        echo $form->textFieldGroup($model, 'CU1_SUPPLIER_CODE', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVER_QUALIFIER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVER_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_FACILITY', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_TRADING_PARTNER_QUALIFIER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        ));
        echo $form->textFieldGroup($model, 'CU1_TRADING_PARTNER_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_ASN_TRADING_PARTNER_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_CONSOLIDATE_ASN', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_FLAG', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 1)),
        ));
        echo $form->textFieldGroup($model, 'CU1_X12_STANDARD', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 4)),
        ));
        echo $form->textFieldGroup($model, 'CU1_EDI_VERSION', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 5)),
        ));
        echo $form->textFieldGroup($model, 'CU1_DUNS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        ));
        echo $form->textFieldGroup($model, 'CU1_SHARED_SECRET', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        echo $form->textFieldGroup($model, 'CU1_REJECT_INVALID_ITEM_ORDERS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_INVALID_ITEM_SUBSTITUTE', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        ));
        echo $form->textFieldGroup($model, 'CU1_USE_CONTRACT', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_CUSTOMERS_AND_ITEMS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_STOP_IMPORT_WITH_ERRORS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_USE_CLASS_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_CLASS_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        ));
        echo $form->textFieldGroup($model, 'CU1_MAP', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        ));
        echo $form->textFieldGroup($model, 'CU1_ORDER_PRICE_OVERRIDE', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_SEND_CREDIT_INVOICES', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_852_IMPORT_FOLDER', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_COMPLETE_SHIP_TO_NAME', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_ALWAYS_SEND_ASNS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_IMPORT_FREIGHT_CODES', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_POST_AS2', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_RECEIVE_AS2', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_CXML_PAYLOAD_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'CU1_AS2_CERTIFICATE_FILENAME', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'CU1_AS2_RECEIVER_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'CU1_AS2_TRADING_PARTNER_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_USE_P21_SHIP_TO_DATA', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'CU1_ALLOW_DUPLICATE_PO_NUMBERS', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-search',
                'label' => Yii::t('app', 'Search'),
                'htmlOptions' => array('class' => 'btn-sm'),
            ));
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_BUTTON,
                'context' => 'default',
                'icon' => 'fa fa-times',
                'label' => Yii::t('app', 'Close'),
                'htmlOptions' => array('class' => 'customer--edi-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div><!-- customer--edi-search-form -->

