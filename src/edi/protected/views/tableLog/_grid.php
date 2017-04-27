<?php
/* @var $this TableLogController
 * @var $model TableLog
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$tableLogAdmin = Yii::app()->user->checkAccess('TableLog.*');
$tableLogView = Yii::app()->user->checkAccess('TableLog.View');
$tableLogUpdate = Yii::app()->user->checkAccess('TableLog.Update');
$tableLogDelete = Yii::app()->user->checkAccess('TableLog.Delete');

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
    echo $this->renderPartial('//tableLog/_grid_menu', array(
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
    echo '<div class="table-log-grid-status-msg">';
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
                'log_action==".$data->log_action."|'.
                'model==".$data->model."|'.
                'model_id==".$data->model_id."|'.
                'created_by==".$data->created_by."|'.
                'created_on==".$data->created_on',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'created_on',
            'type' => 'raw',
            'value' => '($data->created_on=="" || $data->created_on=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->created_on,"medium","short"))',
            'htmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'created_on',
                'name' => 'TableLog[created_on]',
                'htmlOptions' => array(
                    'id' => 'TableLog_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => '($data->cprofile==null ? "" : $data->cprofile->fullname)',
            'htmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control', 
            )),
        ),
        array(
            'name' => 'log_action',
            'value' => 'TableLog::itemAlias("logActions", $data->log_action)',
            'filter' => TableLog::itemAlias("logActions"),
        ),
        array(
            'name' => 'description',
            'type' => 'html',
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/tableLog/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/tableLog/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'created_on',
            'type' => 'raw',
            'value' => $tableLogUpdate ? 'TbHtml::link(Yii::app()->dateFormatter->formatDateTime($data->created_on,"medium","short"), array('.$updateLink.'))' : 'Yii::app()->dateFormatter->formatDateTime($data->created_on,"medium","short")',
            'htmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'created_on',
                'name' => 'TableLog[created_on]',
                'htmlOptions' => array(
                    'id' => 'TableLog_created_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => '($data->cprofile==null ? "" : $data->cprofile->fullname)',
            'htmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 120px;', 'class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'cprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control', 
            )),
        ),
        array(
            'name' => 'model',
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'model_id',
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'log_action',
            'value' => 'TableLog::itemAlias("logActions", $data->log_action)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => TableLog::itemAlias("logActions"),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'description',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 350px;'),
            'filterHtmlOptions' => array('style' => 'width: 350px;'),
            'headerHtmlOptions' => array('style' => 'width: 350px;'),
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'table-log-grid-'.$dependencyTabDropdownIndex:'table-log-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $tableLogDelete?'{delete}':'', //($tableLogView?'{view} ':'').($tableLogUpdate?'{update} ':'').($tableLogDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $tableLogDelete, //$tableLogView || $tableLogUpdate || $tableLogDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/tableLog/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/tableLog/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/tableLog/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".table-log-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'table-log-grid-'.$dependencyTabDropdownIndex:'table-log-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'table-log-grid-'.$dependencyTabDropdownIndex:'table-log-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'table-log-grid-'.$relationIndex:(isset($dependency)?'table-log-grid-'.$dependencyTabDropdownIndex:'table-log-grid')),
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
?><!-- table-log-grid -->
