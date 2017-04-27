<?php
/* @var $this LocationController
 * @var $model Location
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$locationAdmin = Yii::app()->user->checkAccess('Location.*');
$locationView = Yii::app()->user->checkAccess('Location.View');
$locationUpdate = Yii::app()->user->checkAccess('Location.Update');
$locationDelete = Yii::app()->user->checkAccess('Location.Delete');

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
    echo $this->renderPartial('//location/_grid_menu', array(
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
    echo '<div class="location-grid-status-msg">';
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
                '"id==".$data->id."|'.
                'lo1_code==".$data->lo1_code."|'.
                'lo1_name==".$data->lo1_name."|'.
                'rg1_name==".($data->region==null || $data->region->rg1_name==null ? "" : $data->region->rg1_name)."|'.
                'co1_name==".($data->region==null || $data->region->company==null || $data->region->company->co1_name==null ? "" : $data->region->company->co1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'lo1_code',
            'htmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
        ),
        'lo1_name',
        array(
            'name' => 'rg1_search',
            'value' => '($data->region==null || $data->region->rg1_name==null ? "" : $data->region->rg1_name)',
            'filter' => TbHtml::activeTextField($model, 'rg1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->region==null || $data->region->company==null || $data->region->company->co1_name==null ? "" : $data->region->company->co1_name)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control', 
            )),
        ),
        array(
            'name' => 'us1_search',
            'value' => '($data->representative==null ? "" : $data->representative->fullname)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/location/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/location/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'lo1_code',
            'htmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 100px;', 'class' => 'hidden-xs'),
        ),
        array(
            'name' => 'lo1_name',
            'type' => 'raw',
            'value' => $locationUpdate ? 'TbHtml::link(UHtml::markSearch($data, "lo1_name"), array('.$updateLink.'))' : '$data->lo1_name',
        ),
        array(
            'name' => 'rg1_search',
            'value' => '($data->region==null || $data->region->rg1_name==null ? "" : $data->region->rg1_name)',
            'filter' => TbHtml::activeTextField($model, 'rg1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->region==null || $data->region->company==null || $data->region->company->co1_name==null ? "" : $data->region->company->co1_name)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'us1_search',
            'value' => '($data->representative==null ? "" : $data->representative->fullname)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
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
            'visible' => !isset($dependency) && $locationAdmin,
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
                'name' => 'Location[modified_on]',
                'htmlOptions' => array(
                    'id' => 'Location_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset($dependency) && $locationAdmin,
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'location-grid-'.$dependencyTabDropdownIndex:'location-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $locationDelete?'{delete}':'', //($locationView?'{view} ':'').($locationUpdate?'{update} ':'').($locationDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $locationDelete, //$locationView || $locationUpdate || $locationDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/location/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/location/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/location/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".location-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'location-grid-'.$dependencyTabDropdownIndex:'location-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'location-grid-'.$dependencyTabDropdownIndex:'location-grid').'").yiiGridView("update");
                                            afterDelete(th, true, data);
                                        },
                                        error: function(XHR) {
                                            return afterDelete(th, false, XHR);
                                        }
                                    });
                                }},
                                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default", },
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
    'id' => (isset($relation)?'location-grid-'.$relationIndex:(isset($dependency)?'location-grid-'.$dependencyTabDropdownIndex:'location-grid')),
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
?><!-- location-grid -->
