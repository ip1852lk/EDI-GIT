
<?php
/* @var $this ProjectController
 * @var $model Project
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$projectAdmin = Yii::app()->user->checkAccess('Project.*');
$projectView = Yii::app()->user->checkAccess('Project.View');
$projectUpdate = Yii::app()->user->checkAccess('Project.Update');
$projectDelete = Yii::app()->user->checkAccess('Project.Delete');

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
    echo $this->renderPartial('//project/_grid_menu', array(
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
    echo '<div class="project-grid-status-msg">';
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
                .'."|PR1_ID==".$data->PR1_ID'
                .'."|PR1_NAME==".$data->PR1_NAME'
                .'."|RE1_INVOICE_TYPE==".$data->RE1_INVOICE_TYPE'
                .'."|RE1_INVOICE_BILLED==".$data->RE1_INVOICE_BILLED'
                .'."|PR1_APP_NAME==".$data->PR1_APP_NAME'
                .'."|PR1_DELETE_FLAG==".$data->PR1_DELETE_FLAG',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        'PR1_ID',
        'PR1_NAME',
        'RE1_INVOICE_TYPE',
        'RE1_INVOICE_BILLED',
        'PR1_APP_NAME',
        'PR1_DELETE_FLAG',

    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/project/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/project/update", '.
            '"id" => $data->id, ';
    $columns = array(
//        array(
//            'name' => 'id',
//            'type' => 'raw',
//            'value' => $projectUpdate ? 'TbHtml::link(UHtml::markSearch($data, "id"), array('.$updateLink.'))' : '$data->id',
//        ),
        array(
            'name' => 'PR1_NAME',
            'type' => 'raw',
            'value' => $projectUpdate ? 'TbHtml::link(UHtml::markSearch($data, "PR1_NAME"), array('.$updateLink.'))' : '$data->id',
        ),
        'pr1_teamwork_id',
        array(
            'name' => 'RE1_INVOICE_TYPE',
//            'value' => 'Project::itemAlias("invoiceTypes", $data->RE1_INVOICE_TYPE)',
            'filter' => Project::itemAlias("invoiceTypes"),
            'htmlOptions' => array('class' => 'hidden'),
            'filterHtmlOptions' => array('class' => 'hidden'),
            'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'name' => 'RE1_INVOICE_BILLED',
//            'value' => 'Project::itemAlias("invoiceBilled", $data->RE1_INVOICE_BILLED)',
            'filter' => Project::itemAlias("invoiceBilled"),
            'htmlOptions' => array('class' => 'hidden'),
            'filterHtmlOptions' => array('class' => 'hidden'),
            'headerHtmlOptions' => array('class' => 'hidden'),
        ),
        array(
            'name' => 'total_hours_search',
            'value' => '$data->recordsSum',
            'filter' => TbHtml::activeTextField($model, 'total_hours_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),

        ),
//        array(
//            'name' => 'total_hours_search',
//            'value' => '$data->getUserHours()',
//            'filter' => TbHtml::activeTextField($model, 'total_hours_search', array(
//                'maxlength' => 100,
//                'class' => 'form-control',
//            )),
//
//        ),
//        array(
//            'name' => 'hours_spent',
//            'value' => 'Project::getTotalHoursSpentOnProject($data->id)',
//            //'value' => '$data->recordsSum',
//
//        ),

//        'PR1_APP_NAME',
//        'PR1_DELETE_FLAG',

//        array(
//            'name' => 'mprofile_search',
//            'value' => '($data->mprofile==null || $data->mprofile->first_name==null ? "" : $data->mprofile->first_name.($data->mprofile->last_name==null?"":" ".$data->mprofile->last_name))',
//            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filter' => TbHtml::activeTextField($model, 'mprofile_search', array(
//                'maxlength' => 100,
//                'class' => 'form-control',
//            )),
//            'visible' => !isset($dependency) && $projectAdmin,
//        ),
//        array(
//            'name' => 'modified_on',
//            'value' => '($data->modified_on=="" || $data->modified_on=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on,"medium","short"))',
//            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
//            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
//                'model' => $model,
//                'attribute' => 'modified_on',
//                'name' => 'Project[modified_on]',
//                'htmlOptions' => array(
//                    'id' => 'Project_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
//                    'class' => 'form-control',
//                    'language' => Yii::app()->language,
//                    'placeholder' => '',
//                ),
//            ), true),
//            'visible' => !isset($dependency) && $projectAdmin,
//        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'project-grid-'.$dependencyTabDropdownIndex:'project-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $projectDelete?'{delete}':'', //($projectView?'{view} ':'').($projectUpdate?'{update} ':'').($projectDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $projectDelete, //$projectView || $projectUpdate || $projectDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/project/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/project/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/project/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".project-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'project-grid-'.$dependencyTabDropdownIndex:'project-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'project-grid-'.$dependencyTabDropdownIndex:'project-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'project-grid-'.$relationIndex:(isset($dependency)?'project-grid-'.$dependencyTabDropdownIndex:'project-grid')),
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
?><!-- project-grid -->

