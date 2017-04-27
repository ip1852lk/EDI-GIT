
<?php
/* @var $this Customer2Controller
 * @var $model Customer2
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
$customer2View = Yii::app()->user->checkAccess('Customer2.View');
$customer2Update = Yii::app()->user->checkAccess('Customer2.Update');
$customer2Delete = Yii::app()->user->checkAccess('Customer2.Delete');

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
    echo $this->renderPartial('//customer2/_grid_menu', array(
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
    echo '<div class="customer2-grid-status-msg">';
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
                .'."|cu2_type==".$data->cu2_type'
                .'."|cu2_consignment_location_id==".$data->cu2_consignment_location_id'
                .'."|cu1_id==".$data->cu1_id'
                .'."|cu1_name==".(isset($data->customer)?$data->customer->cu1_name:"")'
                .'."|lo1_id==".$data->lo1_id'
                .'."|lo1_name==".(isset($data->location)?$data->location->lo1_name:"")'
                .'."|rg1_id==".(isset($data->location)?$data->location->rg1_id:"")'
                .'."|rg1_name==".(isset($data->location)&&isset($data->location->region)?$data->location->region->rg1_name:"")'
                .'."|co1_id==".(isset($data->location)&&isset($data->location->region)?$data->location->region->co1_id:"")'
                .'."|co1_name==".(isset($data->location)&&isset($data->location->region)&&isset($data->location->region->company)?$data->location->region->company->co1_name:"")'
                .'."|corp_address_id==".$data->corp_address_id'
                .'."|customer_name==".$data->customer_name',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'cu2_type',
            'value' => 'Customer2::itemAlias("customerTypes", $data->cu2_type)',
            'filter' => Customer2::itemAlias("customerTypes"),
        ),
        array(
            'name' => 'corp_address_id',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        'customer_name',
        array(
            'name' => 'cu2_consignment_location_id',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
        ),
        array(
            'name' => 'cu1_search',
            'value' => '($data->customer==null ? "" : $data->customer->cu1_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cu1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'lo1_search',
            'value' => '($data->location==null ? "" : $data->location->lo1_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'lo1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'rg1_search',
            'value' => '($data->location==null || $data->location->region==null ? "" : $data->location->region->rg1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'rg1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->location==null || $data->location->region==null || $data->location->region->company==null ? "" : $data->location->region->company->co1_name)',
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/customer2/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/customer2/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'cu2_type',
            'value' => 'Customer2::itemAlias("customerTypes", $data->cu2_type)',
            'filter' => Customer2::itemAlias("customerTypes"),
        ),
        array(
            'name' => 'corp_address_id',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'customer_name',
            'type' => 'raw',
            'value' => $customer2Update ? 'TbHtml::link(UHtml::markSearch($data, "customer_name"), array('.$updateLink.'))' : '$data->customer_name',
        ),
        array(
            'name' => 'cu2_consignment_location_id',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
        ),
        array(
            'name' => 'cu1_search',
            'value' => '($data->customer==null ? "" : $data->customer->cu1_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cu1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'lo1_search',
            'value' => '($data->location==null ? "" : $data->location->lo1_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'lo1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'rg1_search',
            'value' => '($data->location==null || $data->location->region==null ? "" : $data->location->region->rg1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'rg1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->location==null || $data->location->region==null || $data->location->region->company==null ? "" : $data->location->region->company->co1_name)',
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => '($data->mprofile==null || $data->mprofile->first_name==null ? "" : $data->mprofile->first_name.($data->mprofile->last_name==null?"":" ".$data->mprofile->last_name))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => TbHtml::activeTextField($model, 'mprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control', 
            )),
            'visible' => !isset($dependency) && $customer2Admin,
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
                'name' => 'Customer2[modified_on]',
                'htmlOptions' => array(
                    'id' => 'Customer2_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset($dependency) && $customer2Admin,
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'customer2-grid-'.$dependencyTabDropdownIndex:'customer2-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $customer2Delete?'{delete}':'', //($customer2View?'{view} ':'').($customer2Update?'{update} ':'').($customer2Delete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $customer2Delete, //$customer2View || $customer2Update || $customer2Delete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/customer2/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/customer2/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/customer2/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".customer2-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'customer2-grid-'.$dependencyTabDropdownIndex:'customer2-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'customer2-grid-'.$dependencyTabDropdownIndex:'customer2-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'customer2-grid-'.$relationIndex:(isset($dependency)?'customer2-grid-'.$dependencyTabDropdownIndex:'customer2-grid')),
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
?><!-- customer2-grid -->

