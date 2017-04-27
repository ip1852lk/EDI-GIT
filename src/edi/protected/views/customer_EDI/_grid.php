
<?php
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
$customer_EDIView = Yii::app()->user->checkAccess('Customer_EDI.View');
$customer_EDIUpdate = Yii::app()->user->checkAccess('Customer_EDI.Update');
$customer_EDIDelete = Yii::app()->user->checkAccess('Customer_EDI.Delete');

$cs = Yii::app()->getClientScript();
// Menu
if (isset($dependency) || isset($relation)) {
    $cs->scriptMap = array(
        'font-awesome.min.css' => false,
        'bootstrap-yii.css' => false,
        'jquery-ui-bootstrap.css' => false,
        'bootstrap-notify.css' => false,
        'bootstrap.no-icons.min.css' => false,
        'datepicker3.css' => false,
        'jquery.js' => false,
        'jquery.min.js' => false,
        'bootstrap.js' => false,
        'bootstrap.min.js' => false,
        'bootstrap.bootbox.js' => false,
        'bootstrap.bootbox.min.js' => false,
        'bootstrap.notify.js' => false,
        'bootstrap.notify.min.js' => false,
        'jquery.yiigridview.js' => false,
        'jquery.saveselection.gridview.js' => false,
        'jquery.ba-bbq.js' => false,
        'bootstrap-datepicker.js' => false,
        'bootstrap-datepicker.min.js' => false,
        'bootstrap-datepicker-noconflict.js' => false,
        'jquery.stickytableheaders.js' => false,
        'jquery.stickytableheaders.min.js' => false,
    );
    echo $this->renderPartial('//customer_EDI/_grid_menu', array(
        'model' => $model,
        'dependency' => (isset($dependency)?$dependency:null),
        'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
        'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
        'parentId' => (isset($parentId)?$parentId:null),
        'parentPk' => (isset($parentPk)?$parentPk:null),
        'relation' => (isset($relation)?$relation:null),
        'relationIndex' => (isset($relationIndex)?$relationIndex:null),
    ));
}
// Status Message
if (!isset($relation)) {
    echo '<div class="customer--edi-grid-status-msg">';
        if (Yii::app()->user->hasFlash('success')) 
            $this->widget('booster.widgets.TbAlert', array(
                'alerts' => array(
                    'success' => array('fade' => true, 'closeText' => '×'), 
                ),
            ));
        elseif (Yii::app()->user->hasFlash('error')) 
            $this->widget('booster.widgets.TbAlert', array(
                'alerts' => array(
                    'error' => array('fade' => true, 'closeText' => '×'), 
                ),
            ));
    echo '</div>';
}
// Grid Columns
if (isset($relation)) {
    $columns = array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => isset($relationSelectableRows)?$relationSelectableRows:1,
        ),
        array(
            'type' => 'raw',
            'value' => 
                '"CU1_ID==".$data->CU1_ID'
                .'."|CORP_ADDRESS_ID==".$data->CORP_ADDRESS_ID'
                .'."|CU1_NAME==".$data->CU1_NAME'
                .'."|CU1_CREATED_BY==".$data->CU1_CREATED_BY'
                .'."|CU1_CREATED_ON==".$data->CU1_CREATED_ON'
                .'."|CU1_MODIFIED_BY==".$data->CU1_MODIFIED_BY'
                .'."|CU1_MODIFIED_ON==".$data->CU1_MODIFIED_ON'
                .'."|CU1_SHOW_DEFAULT==".$data->CU1_SHOW_DEFAULT'
                .'."|CU1_RECEIVE_EDI==".$data->CU1_RECEIVE_EDI'
                .'."|CU1_SEND_EDI_INVOICES==".$data->CU1_SEND_EDI_INVOICES'
                .'."|CU1_SEND_EDI_ASN==".$data->CU1_SEND_EDI_ASN'
                .'."|CU1_SEND_EDI_ORDERS==".$data->CU1_SEND_EDI_ORDERS'
                .'."|CU1_SEND_EDI_ORDER_CONFIRMATIONS==".$data->CU1_SEND_EDI_ORDER_CONFIRMATIONS'
                .'."|CU1_SEND_ACKNOWLEDGEMENT==".$data->CU1_SEND_ACKNOWLEDGEMENT'
                .'."|CU1_ORDER_TYPE==".$data->CU1_ORDER_TYPE'
                .'."|CU1_ORDER_FORMAT==".$data->CU1_ORDER_FORMAT'
                .'."|CU1_INVOICE_FORMAT==".$data->CU1_INVOICE_FORMAT'
                .'."|CU1_ASN_FORMAT==".$data->CU1_ASN_FORMAT'
                .'."|CU1_TXT_APPROVED==".$data->CU1_TXT_APPROVED'
                .'."|CU1_SEND_FTP==".$data->CU1_SEND_FTP'
                .'."|CU1_SEND_SFTP==".$data->CU1_SEND_SFTP'
                .'."|CU1_POST_HTTP==".$data->CU1_POST_HTTP'
                .'."|CU1_RECEIVE_FTP==".$data->CU1_RECEIVE_FTP'
                .'."|CU1_PICKUP_FTP==".$data->CU1_PICKUP_FTP'
                .'."|CU1_RECEIVE_HTTP==".$data->CU1_RECEIVE_HTTP'
                .'."|CU1_PICKUP_SFTP==".$data->CU1_PICKUP_SFTP'
                .'."|CU1_REMOTE_FTP_SERVER==".$data->CU1_REMOTE_FTP_SERVER'
                .'."|CU1_REMOTE_FTP_USERNAME==".$data->CU1_REMOTE_FTP_USERNAME'
                .'."|CU1_REMOTE_FTP_PASSWORD==".$data->CU1_REMOTE_FTP_PASSWORD'
                .'."|CU1_REMOTE_FTP_DIRECTORY_SEND==".$data->CU1_REMOTE_FTP_DIRECTORY_SEND'
                .'."|CU1_REMOTE_FTP_DIRECTORY_PICKUP==".$data->CU1_REMOTE_FTP_DIRECTORY_PICKUP'
                .'."|CU1_FTP_USER==".$data->CU1_FTP_USER'
                .'."|CU1_FTP_PASSWORD==".$data->CU1_FTP_PASSWORD'
                .'."|CU1_FTP_DIRECTORY==".$data->CU1_FTP_DIRECTORY'
                .'."|CU1_REMOTE_HTTP_SERVER==".$data->CU1_REMOTE_HTTP_SERVER'
                .'."|CU1_SUPPLIER_CODE==".$data->CU1_SUPPLIER_CODE'
                .'."|CU1_RECEIVER_QUALIFIER==".$data->CU1_RECEIVER_QUALIFIER'
                .'."|CU1_RECEIVER_ID==".$data->CU1_RECEIVER_ID'
                .'."|CU1_FACILITY==".$data->CU1_FACILITY'
                .'."|CU1_TRADING_PARTNER_QUALIFIER==".$data->CU1_TRADING_PARTNER_QUALIFIER'
                .'."|CU1_TRADING_PARTNER_ID==".$data->CU1_TRADING_PARTNER_ID'
                .'."|CU1_ASN_TRADING_PARTNER_ID==".$data->CU1_ASN_TRADING_PARTNER_ID'
                .'."|CU1_CONSOLIDATE_ASN==".$data->CU1_CONSOLIDATE_ASN'
                .'."|CU1_FLAG==".$data->CU1_FLAG'
                .'."|CU1_X12_STANDARD==".$data->CU1_X12_STANDARD'
                .'."|CU1_EDI_VERSION==".$data->CU1_EDI_VERSION'
                .'."|CU1_DUNS==".$data->CU1_DUNS'
                .'."|CU1_SHARED_SECRET==".$data->CU1_SHARED_SECRET'
                .'."|CU1_REJECT_INVALID_ITEM_ORDERS==".$data->CU1_REJECT_INVALID_ITEM_ORDERS'
                .'."|CU1_INVALID_ITEM_SUBSTITUTE==".$data->CU1_INVALID_ITEM_SUBSTITUTE'
                .'."|CU1_USE_CONTRACT==".$data->CU1_USE_CONTRACT'
                .'."|CU1_SEND_CUSTOMERS_AND_ITEMS==".$data->CU1_SEND_CUSTOMERS_AND_ITEMS'
                .'."|CU1_STOP_IMPORT_WITH_ERRORS==".$data->CU1_STOP_IMPORT_WITH_ERRORS'
                .'."|CU1_USE_CLASS_ID==".$data->CU1_USE_CLASS_ID'
                .'."|CU1_CLASS_ID==".$data->CU1_CLASS_ID'
                .'."|CU1_MAP==".$data->CU1_MAP'
                .'."|CU1_ORDER_PRICE_OVERRIDE==".$data->CU1_ORDER_PRICE_OVERRIDE'
                .'."|CU1_SEND_CREDIT_INVOICES==".$data->CU1_SEND_CREDIT_INVOICES'
                .'."|CU1_852_IMPORT_FOLDER==".$data->CU1_852_IMPORT_FOLDER'
                .'."|CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS==".$data->CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS'
                .'."|CU1_COMPLETE_SHIP_TO_NAME==".$data->CU1_COMPLETE_SHIP_TO_NAME'
                .'."|CU1_ALWAYS_SEND_ASNS==".$data->CU1_ALWAYS_SEND_ASNS'
                .'."|CU1_IMPORT_FREIGHT_CODES==".$data->CU1_IMPORT_FREIGHT_CODES'
                .'."|CU1_POST_AS2==".$data->CU1_POST_AS2'
                .'."|CU1_RECEIVE_AS2==".$data->CU1_RECEIVE_AS2'
                .'."|CU1_CXML_PAYLOAD_ID==".$data->CU1_CXML_PAYLOAD_ID'
                .'."|CU1_AS2_CERTIFICATE_FILENAME==".$data->CU1_AS2_CERTIFICATE_FILENAME'
                .'."|CU1_AS2_RECEIVER_ID==".$data->CU1_AS2_RECEIVER_ID'
                .'."|CU1_AS2_TRADING_PARTNER_ID==".$data->CU1_AS2_TRADING_PARTNER_ID'
                .'."|CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID==".$data->CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID'
                .'."|CU1_USE_P21_SHIP_TO_DATA==".$data->CU1_USE_P21_SHIP_TO_DATA'
                .'."|CU1_ALLOW_DUPLICATE_PO_NUMBERS==".$data->CU1_ALLOW_DUPLICATE_PO_NUMBERS',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        'CORP_ADDRESS_ID',
        'CU1_NAME',
        'CU1_CREATED_BY',
        'CU1_CREATED_ON',
        'CU1_MODIFIED_BY',
        'CU1_MODIFIED_ON',
        'CU1_SHOW_DEFAULT',
        'CU1_RECEIVE_EDI',
        'CU1_SEND_EDI_INVOICES',
        'CU1_SEND_EDI_ASN',
        'CU1_SEND_EDI_ORDERS',
        'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
        'CU1_SEND_ACKNOWLEDGEMENT',
        'CU1_ORDER_TYPE',
        'CU1_ORDER_FORMAT',
        'CU1_INVOICE_FORMAT',
        'CU1_ASN_FORMAT',
        'CU1_TXT_APPROVED',
        'CU1_SEND_FTP',
        'CU1_SEND_SFTP',
        'CU1_POST_HTTP',
        'CU1_RECEIVE_FTP',
        'CU1_PICKUP_FTP',
        'CU1_RECEIVE_HTTP',
        'CU1_PICKUP_SFTP',
        'CU1_REMOTE_FTP_SERVER',
        'CU1_REMOTE_FTP_USERNAME',
        'CU1_REMOTE_FTP_PASSWORD',
        'CU1_REMOTE_FTP_DIRECTORY_SEND',
        'CU1_REMOTE_FTP_DIRECTORY_PICKUP',
        'CU1_FTP_USER',
        'CU1_FTP_PASSWORD',
        'CU1_FTP_DIRECTORY',
        'CU1_REMOTE_HTTP_SERVER',
        'CU1_SUPPLIER_CODE',
        'CU1_RECEIVER_QUALIFIER',
        'CU1_RECEIVER_ID',
        'CU1_FACILITY',
        'CU1_TRADING_PARTNER_QUALIFIER',
        'CU1_TRADING_PARTNER_ID',
        'CU1_ASN_TRADING_PARTNER_ID',
        'CU1_CONSOLIDATE_ASN',
        'CU1_FLAG',
        'CU1_X12_STANDARD',
        'CU1_EDI_VERSION',
        'CU1_DUNS',
        'CU1_SHARED_SECRET',
        'CU1_REJECT_INVALID_ITEM_ORDERS',
        'CU1_INVALID_ITEM_SUBSTITUTE',
        'CU1_USE_CONTRACT',
        'CU1_SEND_CUSTOMERS_AND_ITEMS',
        'CU1_STOP_IMPORT_WITH_ERRORS',
        'CU1_USE_CLASS_ID',
        'CU1_CLASS_ID',
        'CU1_MAP',
        'CU1_ORDER_PRICE_OVERRIDE',
        'CU1_SEND_CREDIT_INVOICES',
        'CU1_852_IMPORT_FOLDER',
        'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
        'CU1_COMPLETE_SHIP_TO_NAME',
        'CU1_ALWAYS_SEND_ASNS',
        'CU1_IMPORT_FREIGHT_CODES',
        'CU1_POST_AS2',
        'CU1_RECEIVE_AS2',
        'CU1_CXML_PAYLOAD_ID',
        'CU1_AS2_CERTIFICATE_FILENAME',
        'CU1_AS2_RECEIVER_ID',
        'CU1_AS2_TRADING_PARTNER_ID',
        'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
        'CU1_USE_P21_SHIP_TO_DATA',
        'CU1_ALLOW_DUPLICATE_PO_NUMBERS',

    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/customer_EDI/update", '.
            '"id" => $data->CU1_ID, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/customer_EDI/update", '.
            '"id" => $data->CU1_ID, ';
    $columns = array(
        array(
            'name' => 'CU1_ID',
            'type' => 'raw',
            'value' => '$data->returnDocumentNumberLabel(UHtml::markSearch($data, "CU1_ID"),array('.$updateLink.'))',
            'htmlOptions' => array('class'=>'DocumentNumber', 'style' => 'text-align:center;'),
        ),
        'CORP_ADDRESS_ID', //needed
        'CU1_NAME', //needed
        array(
            'name' => 'send_edi_search',
            'type' => 'raw',
            'value' => '$data->sendColumnLogic()',
            'htmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => Customer_EDI::itemAlias("SEND_COLUMN_SEARCH_TEXT"),
//            'filter' => $this->widget('booster.widgets.TbSelect2',array(
//                'name'=>'send_edi_search',
//                'asDropDownList' => true,
//                'options'=> array(
////                    'multiple' => true,
////                    'tags'=>array(
////                        0  => 'FTP',
////                        1  => 'STFP',
////                        2  => 'HTTP',
////                        3  => 'Pickup FTP'
////                    ),
//                )
//            ), true)
        ),
        array(
            'name' => 'receive_edi_search',
            'type' => 'raw',
            'value' => '$data->receiveColumnLogic()',
            'htmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => Vendor::itemAlias("RECEIVE_COLUMN_SEARCH_TEXT"),
        ),
        //'CU1_CREATED_BY', //needed
        array(
            'name' => 'cprofile_search',
            'value' => '($data->cprofile==null ? "" : $data->cprofile->fullname)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => TbHtml::activeTextField($model, 'cprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        'CU1_CREATED_ON', //needed
        //'CU1_MODIFIED_BY', //needed
        array(
            'name' => 'mprofile_search',
            'value' => '($data->mprofile==null ? "" : $data->mprofile->fullname)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => TbHtml::activeTextField($model, 'mprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        'CU1_MODIFIED_ON', //needed
        //'CU1_SHOW_DEFAULT',
        //'CU1_RECEIVE_EDI',
        //'CU1_SEND_EDI_INVOICES',
        //'CU1_SEND_EDI_ASN',
        //'CU1_SEND_EDI_ORDERS',
        //'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
//        'CU1_SEND_ACKNOWLEDGEMENT',
//        'CU1_ORDER_TYPE',
//        'CU1_ORDER_FORMAT',
//        'CU1_INVOICE_FORMAT',
//        'CU1_ASN_FORMAT',
//        'CU1_TXT_APPROVED',
//        'CU1_SEND_FTP',
//        'CU1_SEND_SFTP',
//        'CU1_POST_HTTP',
//        'CU1_RECEIVE_FTP',
//        'CU1_PICKUP_FTP',
//        'CU1_RECEIVE_HTTP',
//        'CU1_PICKUP_SFTP',
//        'CU1_REMOTE_FTP_SERVER',
//        'CU1_REMOTE_FTP_USERNAME',
//        'CU1_REMOTE_FTP_PASSWORD',
//        'CU1_REMOTE_FTP_DIRECTORY_SEND',
//        'CU1_REMOTE_FTP_DIRECTORY_PICKUP',
//        'CU1_FTP_USER',
//        'CU1_FTP_PASSWORD',
//        'CU1_FTP_DIRECTORY',
//        'CU1_REMOTE_HTTP_SERVER',
//        'CU1_SUPPLIER_CODE',
//        'CU1_RECEIVER_QUALIFIER',
//        'CU1_RECEIVER_ID',
//        'CU1_FACILITY',
//        'CU1_TRADING_PARTNER_QUALIFIER',
//        'CU1_TRADING_PARTNER_ID',
//        'CU1_ASN_TRADING_PARTNER_ID',
//        'CU1_CONSOLIDATE_ASN',
//        'CU1_FLAG',
//        'CU1_X12_STANDARD',
//        'CU1_EDI_VERSION',
//        'CU1_DUNS',
//        'CU1_SHARED_SECRET',
//        'CU1_REJECT_INVALID_ITEM_ORDERS',
//        'CU1_INVALID_ITEM_SUBSTITUTE',
//        'CU1_USE_CONTRACT',
//        'CU1_SEND_CUSTOMERS_AND_ITEMS',
//        'CU1_STOP_IMPORT_WITH_ERRORS',
//        'CU1_USE_CLASS_ID',
//        'CU1_CLASS_ID',
//        'CU1_MAP',
//        'CU1_ORDER_PRICE_OVERRIDE',
//        'CU1_SEND_CREDIT_INVOICES',
//        'CU1_852_IMPORT_FOLDER',
//        'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
//        'CU1_COMPLETE_SHIP_TO_NAME',
//        'CU1_ALWAYS_SEND_ASNS',
//        'CU1_IMPORT_FREIGHT_CODES',
//        'CU1_POST_AS2',
//        'CU1_RECEIVE_AS2',
//        'CU1_CXML_PAYLOAD_ID',
//        'CU1_AS2_CERTIFICATE_FILENAME',
//        'CU1_AS2_RECEIVER_ID',
//        'CU1_AS2_TRADING_PARTNER_ID',
//        'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
//        'CU1_USE_P21_SHIP_TO_DATA',
//        'CU1_ALLOW_DUPLICATE_PO_NUMBERS',

        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'customer--edi-grid-'.$dependencyTabDropdownIndex:'customer--edi-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $customer_EDIDelete?'{delete}':'', //($customer_EDIView?'{view} ':'').($customer_EDIUpdate?'{update} ':'').($customer_EDIDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $customer_EDIDelete, //$customer_EDIView || $customer_EDIUpdate || $customer_EDIDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/customer_EDI/view", "id" => $data->CU1_ID)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/customer_EDI/update", "id" => $data->CU1_ID)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/customer_EDI/delete", "id" => $data->CU1_ID)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".customer--edi-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'customer--edi-grid-'.$dependencyTabDropdownIndex:'customer--edi-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'customer--edi-grid-'.$dependencyTabDropdownIndex:'customer--edi-grid').'").yiiGridView("update");
                                            afterDelete(th, true, data);
                                        },
                                        error: function(XHR) {
                                            return afterDelete(th, false, XHR);
                                        }
                                    });
                                }},
                                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn", },
                            }
                        });
                        return false;
                    }',
                ),
            ),
        ),
    );
}
// Grid
$this->widget('ext.jgridview.JGridView', array(
    'id' => (isset($relation)?'customer--edi-grid-'.$relationIndex:(isset($dependency)?'customer--edi-grid-'.$dependencyTabDropdownIndex:'customer--edi-grid')),
    'dataProvider' => $model->search(),
    'filter' => $model,
    'ajaxUpdate' => isset($dependency)||isset($relation)?true:false,
    'enablePagination' => true,
    'template' => '{items} {pager}',    // '{summary} {items} {pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'columns' => $columns,
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
        'alignment' => TbPager::ALIGNMENT_CENTER,
        'maxButtonCount' => Yii::app()->params['pagerMaxButtonCount'],
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
     ),
    'selectableRows' => null,
));
?><!-- customer--edi-grid -->

