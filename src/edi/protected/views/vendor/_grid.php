
<?php
/* @var $this VendorController
 * @var $model Vendor
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$vendorAdmin = Yii::app()->user->checkAccess('Vendor.*');
$vendorView = Yii::app()->user->checkAccess('Vendor.View');
$vendorUpdate = Yii::app()->user->checkAccess('Vendor.Update');
$vendorDelete = Yii::app()->user->checkAccess('Vendor.Delete');

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
    echo $this->renderPartial('//vendor/_grid_menu', array(
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
    echo '<div class="vendor-grid-status-msg">';
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
                '"VD1_ID==".$data->VD1_ID'
                .'."|VENDOR_ID==".$data->VENDOR_ID'
                .'."|VD1_NAME==".$data->VD1_NAME'
                .'."|VD1_CREATED_BY==".$data->VD1_CREATED_BY'
                .'."|VD1_CREATED_ON==".$data->VD1_CREATED_ON'
                .'."|VD1_MODIFIED_BY==".$data->VD1_MODIFIED_BY'
                .'."|VD1_MODIFIED_ON==".$data->VD1_MODIFIED_ON'
                .'."|VD1_SHOW_DEFAULT==".$data->VD1_SHOW_DEFAULT'
                .'."|VD1_RECEIVE_EDI==".$data->VD1_RECEIVE_EDI'
                .'."|VD1_SEND_EDI_PO==".$data->VD1_SEND_EDI_PO'
                .'."|VD1_SEND_ACKNOWLEDGEMENT==".$data->VD1_SEND_ACKNOWLEDGEMENT'
                .'."|VD1_PO_FORMAT==".$data->VD1_PO_FORMAT'
                .'."|VD1_SEND_FTP==".$data->VD1_SEND_FTP'
                .'."|VD1_SEND_SFTP==".$data->VD1_SEND_SFTP'
                .'."|VD1_POST_HTTP==".$data->VD1_POST_HTTP'
                .'."|VD1_RECEIVE_FTP==".$data->VD1_RECEIVE_FTP'
                .'."|VD1_PICKUP_FTP==".$data->VD1_PICKUP_FTP'
                .'."|VD1_PICKUP_SFTP==".$data->VD1_PICKUP_SFTP'
                .'."|VD1_RECEIVE_HTTP==".$data->VD1_RECEIVE_HTTP'
                .'."|VD1_REMOTE_FTP_SERVER==".$data->VD1_REMOTE_FTP_SERVER'
                .'."|VD1_REMOTE_FTP_USERNAME==".$data->VD1_REMOTE_FTP_USERNAME'
                .'."|VD1_REMOTE_FTP_PASSWORD==".$data->VD1_REMOTE_FTP_PASSWORD'
                .'."|VD1_REMOTE_FTP_DIRECTORY_SEND==".$data->VD1_REMOTE_FTP_DIRECTORY_SEND'
                .'."|VD1_REMOTE_FTP_DIRECTORY_PICKUP==".$data->VD1_REMOTE_FTP_DIRECTORY_PICKUP'
                .'."|VD1_FTP_USER==".$data->VD1_FTP_USER'
                .'."|VD1_FTP_PASSWORD==".$data->VD1_FTP_PASSWORD'
                .'."|VD1_FTP_DIRECTORY==".$data->VD1_FTP_DIRECTORY'
                .'."|VD1_REMOTE_HTTP_SERVER==".$data->VD1_REMOTE_HTTP_SERVER'
                .'."|VD1_SUPPLIER_CODE==".$data->VD1_SUPPLIER_CODE'
                .'."|VD1_RECEIVER_QUALIFIER==".$data->VD1_RECEIVER_QUALIFIER'
                .'."|VD1_RECEIVER_ID==".$data->VD1_RECEIVER_ID'
                .'."|VD1_FACILITY==".$data->VD1_FACILITY'
                .'."|VD1_TRADING_PARTNER_QUALIFIER==".$data->VD1_TRADING_PARTNER_QUALIFIER'
                .'."|VD1_TRADING_PARTNER_ID==".$data->VD1_TRADING_PARTNER_ID'
                .'."|VD1_TRADING_PARTNER_GS_ID==".$data->VD1_TRADING_PARTNER_GS_ID'
                .'."|VD1_FLAG==".$data->VD1_FLAG'
                .'."|VD1_X12_STANDARD==".$data->VD1_X12_STANDARD'
                .'."|VD1_EDI_VERSION==".$data->VD1_EDI_VERSION'
                .'."|VD1_DUNS==".$data->VD1_DUNS'
                .'."|VD1_SHARED_SECRET==".$data->VD1_SHARED_SECRET'
                .'."|VD1_SEND_EDI_PO_CHANGE==".$data->VD1_SEND_EDI_PO_CHANGE'
                .'."|VD1_SEND_ITEM_USAGE==".$data->VD1_SEND_ITEM_USAGE'
                .'."|VD1_ITEM_USAGE_FORMAT==".$data->VD1_ITEM_USAGE_FORMAT'
                .'."|VD1_ITEM_USAGE_SOURCE==".$data->VD1_ITEM_USAGE_SOURCE'
                .'."|VD1_POST_AS2==".$data->VD1_POST_AS2'
                .'."|VD1_RECEIVE_AS2==".$data->VD1_RECEIVE_AS2'
                .'."|VD1_CHECK_P21_EDI_FLAG==".$data->VD1_CHECK_P21_EDI_FLAG'
                .'."|VD1_CXML_PAYLOAD_ID==".$data->VD1_CXML_PAYLOAD_ID'
                .'."|VD1_SEND_EDI_PAYMENT_ADVICE==".$data->VD1_SEND_EDI_PAYMENT_ADVICE'
                .'."|VD1_PAYMENT_ADVICE_FORMAT==".$data->VD1_PAYMENT_ADVICE_FORMAT'
                .'."|VD1_BANK_ROUTING_NUMBER==".$data->VD1_BANK_ROUTING_NUMBER'
                .'."|VD1_BANK_ACCOUNT_NUMBER==".$data->VD1_BANK_ACCOUNT_NUMBER'
                .'."|VD1_AS2_CERTIFICATE_FILENAME==".$data->VD1_AS2_CERTIFICATE_FILENAME'
                .'."|VD1_AS2_RECEIVER_ID==".$data->VD1_AS2_RECEIVER_ID'
                .'."|VD1_AS2_TRADING_PARTNER_ID==".$data->VD1_AS2_TRADING_PARTNER_ID',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        'VENDOR_ID',
        'VD1_NAME',
        'VD1_CREATED_BY',
        'VD1_CREATED_ON',
        'VD1_MODIFIED_BY',
        'VD1_MODIFIED_ON',
        'VD1_SHOW_DEFAULT',
        'VD1_RECEIVE_EDI',
        'VD1_SEND_EDI_PO',
        'VD1_SEND_ACKNOWLEDGEMENT',
        'VD1_PO_FORMAT',
        'VD1_SEND_FTP',
        'VD1_SEND_SFTP',
        'VD1_POST_HTTP',
        'VD1_RECEIVE_FTP',
        'VD1_PICKUP_FTP',
        'VD1_PICKUP_SFTP',
        'VD1_RECEIVE_HTTP',
        'VD1_REMOTE_FTP_SERVER',
        'VD1_REMOTE_FTP_USERNAME',
        'VD1_REMOTE_FTP_PASSWORD',
        'VD1_REMOTE_FTP_DIRECTORY_SEND',
        'VD1_REMOTE_FTP_DIRECTORY_PICKUP',
        'VD1_FTP_USER',
        'VD1_FTP_PASSWORD',
        'VD1_FTP_DIRECTORY',
        'VD1_REMOTE_HTTP_SERVER',
        'VD1_SUPPLIER_CODE',
        'VD1_RECEIVER_QUALIFIER',
        'VD1_RECEIVER_ID',
        'VD1_FACILITY',
        'VD1_TRADING_PARTNER_QUALIFIER',
        'VD1_TRADING_PARTNER_ID',
        'VD1_TRADING_PARTNER_GS_ID',
        'VD1_FLAG',
        'VD1_X12_STANDARD',
        'VD1_EDI_VERSION',
        'VD1_DUNS',
        'VD1_SHARED_SECRET',
        'VD1_SEND_EDI_PO_CHANGE',
        'VD1_SEND_ITEM_USAGE',
        'VD1_ITEM_USAGE_FORMAT',
        'VD1_ITEM_USAGE_SOURCE',
        'VD1_POST_AS2',
        'VD1_RECEIVE_AS2',
        'VD1_CHECK_P21_EDI_FLAG',
        'VD1_CXML_PAYLOAD_ID',
        'VD1_SEND_EDI_PAYMENT_ADVICE',
        'VD1_PAYMENT_ADVICE_FORMAT',
        'VD1_BANK_ROUTING_NUMBER',
        'VD1_BANK_ACCOUNT_NUMBER',
        'VD1_AS2_CERTIFICATE_FILENAME',
        'VD1_AS2_RECEIVER_ID',
        'VD1_AS2_TRADING_PARTNER_ID',

    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/vendor/update", '.
            '"id" => $data->VD1_ID, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/vendor/update", '.
            '"id" => $data->VD1_ID, ';
    $columns = array(
        array(
            'name' => 'VENDOR_ID',
            'type' => 'raw',
            'value' => '$data->returnDocumentNumberLabel(UHtml::markSearch($data, "VENDOR_ID"),array('.$updateLink.'))',
            'htmlOptions' => array('class'=>'VendorID', 'style' => 'text-align:center;'),
        ),
        'VD1_NAME', //needed
//        array(
//            'name' => 'send_edi_search',
//            'type' => 'raw',
//            'value' => '$data->sendColumnLogic()',
//        ),
        array(
            'name' => 'send_edi_search',
            'type' => 'raw',
            'value' => '$data->sendColumnLogic()',
            'htmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 90px; text-align: center;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => Vendor::itemAlias("SEND_COLUMN_SEARCH_TEXT"),
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
        'VD1_CREATED_ON', //needed
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
        'VD1_MODIFIED_ON', //needed

        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'vendor-grid-'.$dependencyTabDropdownIndex:'vendor-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $vendorDelete?'{delete}':'', //($vendorView?'{view} ':'').($vendorUpdate?'{update} ':'').($vendorDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $vendorDelete, //$vendorView || $vendorUpdate || $vendorDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/vendor/view", "id" => $data->VD1_ID)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/vendor/update", "id" => $data->VD1_ID)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/vendor/delete", "id" => $data->VD1_ID)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".vendor-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'vendor-grid-'.$dependencyTabDropdownIndex:'vendor-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'vendor-grid-'.$dependencyTabDropdownIndex:'vendor-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'vendor-grid-'.$relationIndex:(isset($dependency)?'vendor-grid-'.$dependencyTabDropdownIndex:'vendor-grid')),
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
?><!-- vendor-grid -->

