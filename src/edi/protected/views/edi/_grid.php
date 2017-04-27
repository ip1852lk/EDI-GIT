<?php
/* @var $this EdiController
 * @var $model Edi
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$ediAdmin = Yii::app()->user->checkAccess('Edi.*');
$ediView = Yii::app()->user->checkAccess('Edi.View');
$ediUpdate = 0;
$ediDelete = 0;
$vendorUpdate = Yii::app()->user->checkAccess('Vendor.Update');
$customerUpdate = Yii::app()->user->checkAccess('Customer.Update');

$cs = Yii::app()->getClientScript();
// Menu

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();

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
    echo $this->renderPartial('//edi/_grid_menu', array(
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
    echo '<div class="edi-grid-status-msg">';
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

$vendorUpdateLink =
    '"/vendor/update", '.
    '"id" => $data->VD1_ID, ';

$customerUpdateLink =
    '"/customer/update", '.
    '"id" => $data->CU1_ID, ';

// Grid Columns
if (isset($relation)) {
    $columns = array(
        array(
            'type' => 'raw',
            'value' =>
                '"ED1_ID==".$data->ED1_ID'
                .'."|ED1_TYPE==".$data->ED1_TYPE'
                .'."|ED1_DOCUMENT_NO==".$data->ED1_DOCUMENT_NO'
                .'."|ED1_FILENAME==".$data->ED1_FILENAME'
                .'."|ED1_STATUS==".$data->ED1_STATUS'
                .'."|CU1_ID==".$data->CU1_ID'
                .'."|VD1_ID==".$data->VD1_ID'
                .'."|ED1_MODIFIED_ON==".$data->ED1_MODIFIED_ON'
                .'."|ED1_MODIFIED_BY==".$data->ED1_MODIFIED_BY'
                .'."|ED1_CREATED_ON==".$data->ED1_CREATED_ON'
                .'."|ED1_CREATED_BY==".$data->ED1_CREATED_BY'
                .'."|ED1_SHOW_DEFAULT==".$data->ED1_SHOW_DEFAULT'
                .'."|ED1_IN_OUT==".$data->ED1_IN_OUT'
                .'."|ED1_RESEND==".$data->ED1_RESEND'
                .'."|ED1_ACKNOWLEDGED==".$data->ED1_ACKNOWLEDGED',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        'ED1_TYPE',
        'ED1_DOCUMENT_NO',
        'ED1_FILENAME',
        'ED1_STATUS',
        'CU1_ID',
        'VD1_ID',
        'ED1_MODIFIED_ON',
        'ED1_MODIFIED_BY',
        'ED1_CREATED_ON',
        'ED1_CREATED_BY',
        'ED1_SHOW_DEFAULT',
        'ED1_IN_OUT',
        'ED1_RESEND',
        'ED1_ACKNOWLEDGED',

    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/edi/update", '.
            '"id" => $data->ED1_ID, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/edi/update", '.
            '"id" => $data->ED1_ID, ';
    $columns = array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows' => 2,
            'headerHtmlOptions' => array('class'=>'edi-grid-checkboxes'),
            'filterHtmlOptions' => array('class'=>'edi-grid-checkboxes'),
            'htmlOptions'=>array('class'=>'edi-grid-checkboxes'),
        ),
        array(
            'name' => 'ED1_DOCUMENT_NO',
            'type' => 'raw',
            'value' => '$data->returnDocumentNumberLabel(UHtml::markSearch($data, "ED1_DOCUMENT_NO"),array('.$updateLink.'))',
            'htmlOptions' => array('class'=>'DocumentNumber', 'style' => 'text-align:center;'),
        ),
        //'ED1_CREATED_ON', //white-space: nowrap; overflow-x: hidden; text-overflow-ellipsis: true
        array(
            'name' => 'ED1_CREATED_ON',
            'type' => 'raw',
            'value' => '$data->formatCreatedOnDate()',
            'htmlOptions' => array('style' => 'width: 90px;white-space: nowrap; overflow-x: hidden; text-overflow-ellipsis: true;'),
        ),
        array(
            'name' => 'edi_status_search',
            'type' => 'raw',
            'value' => '$data->getStatusLabel()',
            'htmlOptions' => array('style' => 'width: 90px;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 150px;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 150px;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => Edi::itemAlias("ED1_STATUS"),
        ),
        array(
            'name' => 'ED1_TYPE',
            'type' => 'raw',
            'value' => '$data->getEDIType()',
            //'filter' => Edi::model()->getTypeArray(),
        ),
        array(
            'name' => 'ED1_IN_OUT',
            'type' => 'raw',
            'value' => '$data->getInOutName()',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'name' => 'corp_address_id_search',
            'type' => 'raw',
            'value' => $customerUpdate ? 'TbHtml::link(isset($data->customer)?$data->customer->CORP_ADDRESS_ID:"", array('.$customerUpdateLink.'))' : 'isset($data->customer)?$data->customer->CORP_ADDRESS_ID:""',
            'htmlOptions' => array('class' => '', 'style' => 'width: 140px;'),
        ),
        array(
            'name' => 'cu1_search',
            'type' => 'raw',
            'value' => $customerUpdate ? 'TbHtml::link(isset($data->customer)?$data->customer->CU1_NAME:"", array('.$customerUpdateLink.'))' : 'isset($data->customer)?$data->customer->CU1_NAME:""',
            'htmlOptions' => array('class' => '', 'style' => 'width: 140px;'),
        ),
        array(
            'name' => 'vendor_id_search',
            'type' => 'raw',
            'value' => $vendorUpdate ? 'TbHtml::link(isset($data->vendor)?$data->vendor->VENDOR_ID:"", array('.$vendorUpdateLink.'))' : 'isset($data->vendor)?$data->vendor->VENDOR_ID:""',
            'htmlOptions' => array('class' => '', 'style' => 'width: 140px;'),
        ),
        array(
            'name' => 'vd1_search',
            'type' => 'raw',
            'value' => $vendorUpdate ? 'TbHtml::link(isset($data->vendor)?$data->vendor->VD1_NAME:"", array('.$vendorUpdateLink.'))' : 'isset($data->vendor)?$data->vendor->VD1_NAME:""',
            'htmlOptions' => array('class' => '', 'style' => 'width: 140px;'),
        ),
        //LOGS?
//        'ED1_CREATED_BY',
//        'ED1_MODIFIED_BY',
//        array(
//            'name' => 'cprofile_search',
//            'value' => '($data->cprofile==null ? "" : $data->cprofile->fullname)',
//            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filter' => TbHtml::activeTextField($model, 'cprofile_search', array(
//                'maxlength' => 100,
//                'class' => 'form-control',
//            )),
//            'visible' => !isset($dependency),
//        ),
//        array(
//            'name' => 'mprofile_search',
//            'value' => '($data->mprofile==null ? "" : $data->mprofile->fullname)',
//            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filter' => TbHtml::activeTextField($model, 'mprofile_search', array(
//                'maxlength' => 100,
//                'class' => 'form-control',
//            )),
//            'visible' => !isset($dependency),
//        ),
//        array(
//            'name' => 'ED1_MODIFIED_ON',
//            'type' => 'raw',
//            'value' => '$data->formatModifiedOnDate()',
//        ),
        array(
            'name' => 'download_column',
            'type' => 'raw',
            'value'=> '$data->getFilePathURLDownloadLink()',
            'htmlOptions' => array('style' => 'width: 30; text-align: center;'),
        ),
        array(
            'header' => 'View',
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view} ', //($ediView?'{view} ':).($ediUpdate?'{update} ':'').($ediDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 30; text-align: center;'),

            'visible' => true,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-search',
                    'visible'=>function($row_number, $data){
                        return isset($data->ED1_FILENAME) && strlen($data->ED1_FILENAME);// && file_exists($data->getDownloadBaseURL()); //not show this button
                    },
                    'url' => '$data->ED1_ID',
                    'options' => array('title' => Yii::t('app', 'View File')),
                    'click' => 'function(event){
                        event.preventDefault();

                        $.ajax({
                            type: "GET",
                            contentType: "application/json",
                            cache: false,
                            url: "'.$this->createUrl('/edi/ajaxGetEdiFileContents').'",
                            dataType: "JSON",
                            data: {
                                YII_CSRF_TOKEN: "' . Yii::app()->request->csrfToken . '",
                                ED1_ID: ($(this).attr(\'href\')),
                            }
                        }).success(function(data) {
                            if(data.status == 200){
                                console.log("file-content: " + data.result["file-content"]);

                                // Assign the file contents to an invisible div on the page
                                // When you create the Jbox, set its content to be the content of the invisible div
                                // After you load the data into the invisible div, display the jbox

                                var myModal = new jBox(\'Modal\', {
                                    title: data.result["file-name"],
                                    content: data.result["file-content"],
                                    maxWidth: 500,
                                    maxHeight: 700,
                                });

                                myModal.open();
                            }else{
                                notifyUser(data.statusText);
                            }

                        }).error(function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        });



                        return false;
                    }',
                ),
            ),
        ),

        array(
            'header' => 'Resend',
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{resend} ', //($ediView?'{view} ':'').($ediUpdate?'{update} ':'').($ediDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => true,
            'buttons' => array(
                'resend' => array(
                    'icon' => 'fa fa-repeat',
                    'url' => 'array("/edi/resend", "id" => $data->ED1_ID)',
                    'options' => array('title' => Yii::t('app', 'Resend')),
                ),
            ),
        ),

//        array(
//            'header' => TbHtml::dropDownList(
//                'pageSize',
//                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
//                Yii::app()->params['pageSizeSet'],
//                array(
//                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'edi-grid-'.$dependencyTabDropdownIndex:'edi-grid')."', {data:{pageSize:$(this).val()}})",
//                )
//            ),
//            'class' => 'booster.widgets.TbButtonColumn',
////            'template' => ($ediDelete?'{delete}':''),
//            'template' => (''),
//            //'template' => ($ediAdmin?'{resend} ':'').($ediView?'{view} ':'').($ediUpdate?'{update} ':'').($ediDelete?'{delete}':''),
//            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
////            'visible' => ,//$ediDelete, $ediView || $ediUpdate || $ediDelete,
//            'buttons' => array(
//                'resend' => array(
//                    'icon' => 'fa fa-repeat',
//                    'url' => 'array("/edi/resend", "id" => $data->ED1_ID)',
//                    'options' => array('title' => Yii::t('app', 'Resend')),
//                ),
//                'view' => array(
//                    'icon' => 'fa fa-lg fa-eye',
//                    'url' => 'array("/edi/view", "id" => $data->ED1_ID)',
//                    'options' => array('title' => Yii::t('app', 'View')),
//                ),
//                'update' => array(
//                    'icon' => 'fa fa-lg fa-pencil',
//                    'url' => 'array("/edi/update", "id" => $data->ED1_ID)',
//                    'options' => array('title' => Yii::t('app', 'Update')),
//                ),
//                'delete' => array(
//                    'icon' => 'fa fa-lg fa-trash-o',
//                    'url' => 'array("/edi/delete", "id" => $data->ED1_ID)',
//                    'options' => array('title' => Yii::t('app', 'Delete')),
//                    'click' => 'function(){
//                        var th = this;
//                        var afterDelete = function(link,success,data){ $(".edi-grid-status-msg").html(data); };
//                        bootbox.dialog({
//                            title: "' . Yii::t('app', 'Delete Record?') . '",
//                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
//                            buttons: {
//                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
//                                    $("#'.(isset($dependency)?'edi-grid-'.$dependencyTabDropdownIndex:'edi-grid').'").yiiGridView("update", {
//                                        type: "POST",
//                                        url: $(th).attr("href"),
//                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
//                                        success: function(data) {
//                                            $("#'.(isset($dependency)?'edi-grid-'.$dependencyTabDropdownIndex:'edi-grid').'").yiiGridView("update");
//                                            afterDelete(th, true, data);
//                                        },
//                                        error: function(XHR) {
//                                            return afterDelete(th, false, XHR);
//                                        }
//                                    });
//                                }},
//                                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn", },
//                            }
//                        });
//                        return false;
//                    }',
//                ),
//            ),
//        ),
    );
}
// Grid
$this->widget('ext.jgridview.JGridView', array(
    'id' => 'edi-grid',//(isset($relation)?'edi-grid-'.$relationIndex:(isset($dependency)?'edi-grid-'.$dependencyTabDropdownIndex:'edi-grid')),
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



$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'edi_grid', "

$('.JBoxButton').click(JBoxViewFileButton);


function JBoxViewFileButton(event){
    var id = $(this).parent().parent().find(\"td:nth-child(1)\");
    alert(id);
    event.preventDefault();
    myModal.open();
}


");


$cs->registerScript(__CLASS__ . 'order_header-grid', '

    $("#edi-resend-checked-btn").click(function(){
        $("#edi-resend-checked-btn").addClass("disabled");
        var checked = getSelectedIds();
        notifyUser("Creating the labels...");

        $.ajax({
            type: "GET",
            contentType: "application/json",
            cache: false,
            url: "'.Yii::app()->createUrl('/edi/resend').'",
            dataType: "JSON",
            data: {
                YII_CSRF_TOKEN: "' . Yii::app()->request->csrfToken . '",
                checked: checked,
                ajax: true,
            }
        }).success(function(data) {
            notifyUser("Transactions Resent!.");

        }).error(function(xhr, status, error) {
            notifyUser("Could not resend every transaction. Try again later.");
        });

        $("#resend-checked-btn-click").removeClass("disabled");

    });

    //If a checkbox is checked, then enable the Print Labels button
    $(".edi-grid-checkboxes input").change(function(){

        //Check if the "All" checkbox is checked, if so, handle appropriately
        if($(this).is("#edi-grid-checkboxes_c0_all")){
            alert("All checkboxes checkbox is checked");
            if($("#edi-grid-checkboxes_c0_all").attr("checked")){
                $("#order-header-print-labels-btn").removeClass("disabled");
            }else{
                $("#order-header-print-labels-btn").addClass("disabled");
            }
        }
        //Handle all the other checkboxes
        else{
            var checked = getSelectedIds();

            if(checked != ""){
                $("#edi-resend-checked-btn").removeClass("disabled");
            }else{
                $("#edi-resend-checked-btn").addClass("disabled");
            }
        }

    });

    // Selected Requests
    function getSelectedIds(){
        //regular grid selections
        return $("#'.(isset($relation)?'edi-grid-'.$relationIndex:(isset($dependency)?'edi-grid-'.$dependencyTabDropdownIndex:'edi-grid')).' tbody input[type=checkbox]:checked").map(function() {
            return $(this).val();
        }).get();
    }
');