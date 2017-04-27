
<?php
/* @var $this LogController
 * @var $model Log
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$logAdmin = Yii::app()->user->checkAccess('Log.*');
$logView = Yii::app()->user->checkAccess('Log.View');
$logUpdate = Yii::app()->user->checkAccess('Log.Update');
$logDelete = Yii::app()->user->checkAccess('Log.Delete');

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
    echo $this->renderPartial('//log/_grid_menu', array(
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
    echo '<div class="log-grid-status-msg">';
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
                '"LOG_ID==".$data->LOG_ID'
                .'."|LOG_DESCRIPTION==".$data->LOG_DESCRIPTION'
                .'."|LOG_UPDATED_BY==".$data->LOG_UPDATED_BY'
                .'."|LOG_UPDATED_ON==".$data->LOG_UPDATED_ON'
                .'."|LOG_SHOW_DEFAULT==".$data->LOG_SHOW_DEFAULT'
                .'."|CU1_ID==".$data->CU1_ID'
                .'."|VD1_ID==".$data->VD1_ID'
                .'."|ED1_ID==".$data->ED1_ID'
                .'."|US1_ID==".$data->US1_ID'
                .'."|LOG_FILENAME==".$data->LOG_FILENAME'
                .'."|LOG_P21==".$data->LOG_P21'
                .'."|LOG_CHECKED==".$data->LOG_CHECKED'
                .'."|LOG_FILE_TYPE==".$data->LOG_FILE_TYPE',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        'LOG_DESCRIPTION',
        'LOG_UPDATED_BY',
        'LOG_UPDATED_ON',
        'LOG_SHOW_DEFAULT',
        'CU1_ID',
        'VD1_ID',
        'ED1_ID',
        'US1_ID',
        'LOG_FILENAME',
        'LOG_P21',
        'LOG_CHECKED',
        'LOG_FILE_TYPE',

    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/log/update", '.
            '"id" => $data->LOG_ID, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/log/update", '.
            '"id" => $data->LOG_ID, ';
    $columns = array(
        array(
            'name' => 'LOG_ID',
            'type' => 'raw',
            'value' => $logUpdate ? 'TbHtml::link(UHtml::markSearch($data, "LOG_ID"), array('.$updateLink.'))' : '$data->LOG_ID',
        ),
        'LOG_DESCRIPTION',
        'LOG_UPDATED_BY',
        'LOG_UPDATED_ON',
        'LOG_SHOW_DEFAULT',
        'CU1_ID',
        'VD1_ID',
        'ED1_ID',
        'US1_ID',
        'LOG_FILENAME',
        'LOG_P21',
        'LOG_CHECKED',
        'LOG_FILE_TYPE',

        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'log-grid-'.$dependencyTabDropdownIndex:'log-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $logDelete?'{delete}':'', //($logView?'{view} ':'').($logUpdate?'{update} ':'').($logDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $logDelete, //$logView || $logUpdate || $logDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/log/view", "id" => $data->LOG_ID)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/log/update", "id" => $data->LOG_ID)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/log/delete", "id" => $data->LOG_ID)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".log-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'log-grid-'.$dependencyTabDropdownIndex:'log-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'log-grid-'.$dependencyTabDropdownIndex:'log-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'log-grid-'.$relationIndex:(isset($dependency)?'log-grid-'.$dependencyTabDropdownIndex:'log-grid')),
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
?><!-- log-grid -->

