
<?php
/* @var $this AccountRepController
 * @var $model AccountRep
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$accountRepAdmin = Yii::app()->user->checkAccess('AccountRep.*');
$accountRepView = Yii::app()->user->checkAccess('AccountRep.View');
$accountRepUpdate = Yii::app()->user->checkAccess('AccountRep.Update');
$accountRepDelete = Yii::app()->user->checkAccess('AccountRep.Delete');

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
    echo $this->renderPartial('//accountRep/_grid_menu', array(
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
    echo '<div class="account-rep-grid-status-msg">';
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
                .'."|ar1_desc==".$data->ar1_desc'
                .'."|us1_id==".$data->us1_id'
                .'."|full_name==".($data->representative==null ? "" : $data->representative->fullname)'
                .'."|pl1_id==".$data->pl1_id'
                .'."|pl1_name==".(isset($data->plant) ? $data->plant->pl1_name : "")',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'pl1_search',
            'value' => '($data->plant==null ? "" : $data->plant->pl1_name)',
            'filter' => TbHtml::activeTextField($model, 'pl1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'us1_search',
            'type' => 'raw',
            'value' => '($data->representative==null ? "" : $data->representative->fullname)',
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'ar1_desc',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/accountRep/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/accountRep/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'pl1_search',
            'value' => '($data->plant==null ? "" : $data->plant->pl1_name)',
            'filter' => TbHtml::activeTextField($model, 'pl1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'us1_search',
            'type' => 'raw',
            'value' => $accountRepUpdate ? 'TbHtml::link(($data->representative==null ? "" : $data->representative->fullname), array('.$updateLink.'))' : '($data->representative==null ? "" : $data->representative->fullname)',
            'filter' => TbHtml::activeTextField($model, 'us1_search', array(
                'maxlength' => 100,
                'class' => 'form-control',
            )),
        ),
        array(
            'name' => 'ar1_desc',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
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
            'visible' => !isset($dependency) && $accountRepAdmin,
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
                'name' => 'AccountRep[modified_on]',
                'htmlOptions' => array(
                    'id' => 'AccountRep_modified_on'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset($dependency) && $accountRepAdmin,
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'account-rep-grid-'.$dependencyTabDropdownIndex:'account-rep-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $accountRepDelete?'{delete}':'', //($accountRepView?'{view} ':'').($accountRepUpdate?'{update} ':'').($accountRepDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $accountRepDelete, //$accountRepView || $accountRepUpdate || $accountRepDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/accountRep/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/accountRep/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/accountRep/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".account-rep-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'account-rep-grid-'.$dependencyTabDropdownIndex:'account-rep-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'account-rep-grid-'.$dependencyTabDropdownIndex:'account-rep-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'account-rep-grid-'.$relationIndex:(isset($dependency)?'account-rep-grid-'.$dependencyTabDropdownIndex:'account-rep-grid')),
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
?><!-- account-rep-grid -->

