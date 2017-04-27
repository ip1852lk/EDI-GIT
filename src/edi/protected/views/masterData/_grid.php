
<?php
/* @var $this MasterDataController
 * @var $model MasterData
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
$masterDataView = Yii::app()->user->checkAccess('MasterData.View');
$masterDataUpdate = Yii::app()->user->checkAccess('MasterData.Update');
$masterDataDelete = Yii::app()->user->checkAccess('MasterData.Delete');

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
        'jquery.stickytableheaders.js' => false,
        'jquery.stickytableheaders.min.js' => false,
    );
    echo $this->renderPartial('//masterData/_grid_menu', array(
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
    echo '<div class="master-data-grid-status-msg">';
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
                .'."|contract_bin_id==".$data->contract_bin_id'
                .'."|customer_bin_id==".$data->customer_bin_id'
                .'."|customer_part_no==".$data->customer_part_no'
                .'."|item_id==".$data->item_id'
                .'."|item_desc==".$data->item_desc'
                .'."|extended_desc==".$data->extended_desc'
                .'."|capacity==".$data->capacity'
                .'."|min_qty==".$data->min_qty'
                .'."|max_qty==".$data->max_qty'
                .'."|reorder_qty==".$data->reorder_qty'
                .'."|on_hand_qty==".$data->on_hand_qty'
                .'."|p21_on_hand_qty==".$data->p21_on_hand_qty'
                .'."|price==".$data->price'
                .'."|unit_size==".$data->unit_size'
                .'."|unit_of_measure==".$data->unit_of_measure'
                .'."|frequency==".$data->frequency'
                .'."|preferred_location_id==".$data->preferred_location_id'
                .'."|line==".$data->line'
                .'."|line_feed==".$data->line_feed'
                .'."|line_station==".$data->line_station'
                .'."|bt1_id==".$data->bt1_id'
                .'."|bt1_code==".(isset($data->binType)?$data->binType->bt1_code:"")'
                .'."|pf1_id==".$data->pf1_id'
                .'."|pf1_family==".(isset($data->productFamily)?$data->productFamily->pf1_family:"")'
                .'."|pf1_commodity==".(isset($data->productFamily)?$data->productFamily->pf1_commodity:"")'
                .'."|co1_id==".$data->co1_id'
                .'."|co1_name==".(isset($data->company)?$data->company->co1_name:"")'
                .'."|cu2_id==".$data->cu2_id'
                .'."|customer_name==".(isset($data->customer2)?$data->customer2->customer_name:"")'
                .'."|ra1_id==".$data->ra1_id'
                .'."|ship_to_name==".(isset($data->rack)?$data->rack->ship_to_name:"")',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'cu2_search',
            'value' => '($data->customer2==null ? "" : $data->customer2->customer_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cu2_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'ra1_search',
            'value' => '($data->rack==null ? "" : $data->rack->ship_to_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'ra1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'contract_bin_id',
            'type' => 'raw',
            'value' => '$data->statusIcon." ".$data->contract_bin_id',
        ),
        array(
            'name' => 'customer_bin_id',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
        ),
        array(
            'name' => 'bt1_id',
            'value' => '($data->binType==null ? "" : $data->binType->bt1_code)',
            'htmlOptions' => array('style' => 'width: 70px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => BinType::getListData(null, false),
        ),
        'item_id',
        array(
            'name' => 'customer_part_no',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
        ),
        array(
            'name' => 'item_desc',
            'htmlOptions' => array('style' => 'width: 250px;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
        ),
        array(
            'name' => 'reorder_qty',
            'value' => 'number_format($data->reorder_qty, 1)',
            'htmlOptions' => array('class' => 'hidden-xs', 'style' => 'text-align: right;'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'p21_on_hand_qty',
            'type' => 'raw',
            'value' => 'number_format($data->p21_on_hand_qty, 1)." ".$data->statusIcon',
            'htmlOptions' => array('class' => 'hidden-xs', 'style' => 'text-align: right;'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->company==null ? "" : $data->company->co1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => false,
        ),
    );
} else {
    if (isset($dependency))
        $updateLink =
            '"/masterData/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else
        $updateLink =
            '"/masterData/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'cu2_search',
            'value' => '($data->customer2==null ? "" : $data->customer2->customer_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cu2_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'ra1_search',
            'value' => '($data->rack==null ? "" : $data->rack->ship_to_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'ra1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'contract_bin_id',
            'type' => 'raw',
            'value' => $masterDataUpdate ? 'TbHtml::link($data->statusIcon." ".$data->contract_bin_id, array('.$updateLink.'))' : '$data->statusIcon." ".$data->contract_bin_id',
        ),
        array(
            'name' => 'customer_bin_id',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'bt1_id',
            'value' => '($data->binType==null ? "" : $data->binType->bt1_code)',
            'htmlOptions' => array('style' => 'width: 70px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => BinType::getListData(null, false),
        ),
        'item_id',
        array(
            'name' => 'customer_part_no',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
        ),
        array(
            'name' => 'item_desc',
            'htmlOptions' => array('style' => 'width: 250px;', 'class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
        ),
        array(
            'name' => 'reorder_qty',
            'value' => 'number_format($data->reorder_qty, 1)',
            'htmlOptions' => array('class' => 'hidden-xs', 'style' => 'text-align: right;'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'p21_on_hand_qty',
            'type' => 'raw',
            'value' => 'number_format($data->p21_on_hand_qty, 1)." ".$data->statusIcon',
            'htmlOptions' => array('class' => 'hidden-xs', 'style' => 'text-align: right;'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->company==null ? "" : $data->company->co1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => false,//!isset($dependency),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => '($data->mprofile==null ? "" : $data->mprofile->fullname)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'mprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency) && $masterDataAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => '($data->modified_on=="" || $data->modified_on=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on,"medium","short"))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'modified_on',
                'name' => 'MasterData[modified_on]',
                'htmlOptions' => array(
                    'id' => 'MasterData_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset($dependency) && $masterDataAdmin,
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize',
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                Yii::app()->params['pageSizeSet'],
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'master-data-grid-'.$dependencyTabDropdownIndex:'master-data-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $masterDataDelete?'{delete}':'', //($masterDataView?'{view} ':'').($masterDataUpdate?'{update} ':'').($masterDataDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $masterDataDelete, //$masterDataView || $masterDataUpdate || $masterDataDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/masterData/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/masterData/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/masterData/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".master-data-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'master-data-grid-'.$dependencyTabDropdownIndex:'master-data-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'master-data-grid-'.$dependencyTabDropdownIndex:'master-data-grid').'").yiiGridView("update");
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
$id = isset($relation) ? 'master-data-grid-'.$relationIndex : (isset($dependency) ? 'master-data-grid-'.$dependencyTabDropdownIndex : 'master-data-grid');
$this->widget('ext.jgridview.JGridView', array(
    'id' => $id,
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
?><!-- master-data-grid -->

