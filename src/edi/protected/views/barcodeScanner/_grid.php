
<?php
/* @var $this BarcodeScannerController
 * @var $model BarcodeScanner
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
$barcodeScannerView = Yii::app()->user->checkAccess('BarcodeScanner.View');
$barcodeScannerUpdate = Yii::app()->user->checkAccess('BarcodeScanner.Update');
$barcodeScannerDelete = Yii::app()->user->checkAccess('BarcodeScanner.Delete');

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
    echo $this->renderPartial('//barcodeScanner/_grid_menu', array(
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
    echo '<div class="barcode-scanner-grid-status-msg">';
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
                '"id==".$data->id'
                .'."|us1_id==".$data->us1_id'
                .'."|us1_fullname==".(isset($data->user)?$data->user->fullname:"")'
                .'."|bs1_mac_address==".$data->bs1_mac_address'
                .'."|bs1_model==".$data->bs1_model'
                .'."|bs1_com_port==".$data->bs1_com_port'
                .'."|bs1_speed==".$data->bs1_speed'
                .'."|bs1_data_bit==".$data->bs1_data_bit'
                .'."|bs1_parity==".$data->bs1_parity'
                .'."|bs1_stop_bit==".$data->bs1_stop_bit'
                .'."|bs1_flow_control==".$data->bs1_flow_control',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'us1_search',
            'value' => '($data->user==null ? "" : $data->user->fullname)',
            'htmlOptions' => array('style' => 'width: 150px;'),
            'filterHtmlOptions' => array('style' => 'width: 150px;'),
            'headerHtmlOptions' => array('style' => 'width: 150px;'),
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'bs1_mac_address',
        ),
        array(
            'name' => 'bs1_model',
            'value' => 'BarcodeScanner::itemAlias("model", $data->bs1_model)',
            'htmlOptions' => array('style' => 'width: 120px;'),
            'filterHtmlOptions' => array('style' => 'width: 120px;'),
            'headerHtmlOptions' => array('style' => 'width: 120px;'),
            'filter' => BarcodeScanner::itemAlias("model"),
        ),
        array(
            'name' => 'bs1_com_port',
            'value' => 'BarcodeScanner::itemAlias("comPort", $data->bs1_com_port)',
            'htmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => BarcodeScanner::itemAlias("comPort"),
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/barcodeScanner/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/barcodeScanner/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'us1_search',
            'value' => '($data->user==null ? "" : $data->user->fullname)',
            'htmlOptions' => array('style' => 'width: 150px;'),
            'filterHtmlOptions' => array('style' => 'width: 150px;'),
            'headerHtmlOptions' => array('style' => 'width: 150px;'),
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'bs1_mac_address',
            'type' => 'raw',
            'value' => $barcodeScannerUpdate ? 'TbHtml::link(UHtml::markSearch($data, "bs1_mac_address"), array('.$updateLink.'))' : '$data->bs1_mac_address',
        ),
        array(
            'name' => 'bs1_model',
            'value' => 'BarcodeScanner::itemAlias("model", $data->bs1_model)',
            'htmlOptions' => array('style' => 'width: 120px;'),
            'filterHtmlOptions' => array('style' => 'width: 120px;'),
            'headerHtmlOptions' => array('style' => 'width: 120px;'),
            'filter' => BarcodeScanner::itemAlias("model"),
        ),
        array(
            'name' => 'bs1_com_port',
            'value' => 'BarcodeScanner::itemAlias("comPort", $data->bs1_com_port)',
            'htmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs hidden-sm'),
            'filter' => BarcodeScanner::itemAlias("comPort"),
        ),
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
            'visible' => !isset($dependency) && $barcodeScannerAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => '($data->modified_on=="" || $data->modified_on=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on,"medium","short"))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'modified_on',
                'name' => 'BarcodeScanner[modified_on]',
                'htmlOptions' => array(
                    'id' => 'BarcodeScanner_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset($dependency) && $barcodeScannerAdmin,
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'barcode-scanner-grid-'.$dependencyTabDropdownIndex:'barcode-scanner-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $barcodeScannerDelete?'{delete}':'', //($barcodeScannerView?'{view} ':'').($barcodeScannerUpdate?'{update} ':'').($barcodeScannerDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $barcodeScannerDelete, //$barcodeScannerView || $barcodeScannerUpdate || $barcodeScannerDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/barcodeScanner/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/barcodeScanner/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/barcodeScanner/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".barcode-scanner-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'barcode-scanner-grid-'.$dependencyTabDropdownIndex:'barcode-scanner-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'barcode-scanner-grid-'.$dependencyTabDropdownIndex:'barcode-scanner-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'barcode-scanner-grid-'.$relationIndex:(isset($dependency)?'barcode-scanner-grid-'.$dependencyTabDropdownIndex:'barcode-scanner-grid')),
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
?><!-- barcode-scanner-grid -->

