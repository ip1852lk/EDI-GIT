<?php
/* @var $this UserController
 * @var $model User
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

$isAdmin = Yii::app()->user->checkAccess('Admin');
$userView = Yii::app()->user->checkAccess('User.User.View');
$userUpdate = Yii::app()->user->checkAccess('User.User.Update');
$userDelete = Yii::app()->user->checkAccess('User.User.Delete');

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
    echo $this->renderPartial('application.modules.user.views.user._grid_menu', array(
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
    echo '<div class="user-grid-status-msg">';
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
                'username==".$data->username."|'.
                'fullname==".($data->profile==null ? "" : $data->profile->fullname)."|'.
                'first_name==".($data->profile==null || $data->profile->first_name==null ? "" : $data->profile->first_name)."|'.
                'last_name==".($data->profile==null || $data->profile->last_name==null ? "" : $data->profile->last_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'profile_user_type_search',
            'value' => '($data->profile==null || $data->profile->user_type>User::TYPE_SUPPLIER ? "" : User::itemAlias("userTypes",$data->profile->user_type))',
            'htmlOptions' => array('style' => 'width: 80px;'),
            'filterHtmlOptions' => array('style' => 'width: 80px;'),
            'headerHtmlOptions' => array('style' => 'width: 80px;'),
            'filter' => User::itemAlias("userTypes"),
            'visible' => $isAdmin,
        ),
        array(
            'name' => 'username',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'email',
            'type' => 'raw',
            'value' => 'TbHtml::link(UHtml::markSearch($data, "email"), "mailto:".$data->email)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'profile_full_name_search',
            'value' => '($data->profile==null || $data->profile->first_name==null ? "" : $data->profile->first_name." ".$data->profile->last_name)',
            'filter' => TbHtml::activeTextField($model, 'profile_full_name_search', array('class' => 'form-control', 'maxlength' => 100)),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->profile==null || $data->profile->location==null || $data->profile->location->region==null || $data->profile->location->region->company==null || $data->profile->location->region->company->co1_code==null ? "" : $data->profile->location->region->company->co1_code." - ".$data->profile->location->region->company->co1_name)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'lo1_search',
            'value' => '($data->profile==null || $data->profile->location==null || $data->profile->location->lo1_code==null ? "" : $data->profile->location->lo1_code." - ".$data->profile->location->lo1_name)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'lo1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'cu1_search',
            'value' => '($data->profile==null || $data->profile->customer==null || $data->profile->customer->cu1_code==null ? "" : $data->profile->customer->cu1_code." - ".$data->profile->customer->cu1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'cu1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'su1_search',
            'value' => '($data->profile==null || $data->profile->supplier==null || $data->profile->supplier->su1_code==null ? "" : $data->profile->supplier->su1_code." - ".$data->profile->supplier->su1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'su1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => false,//!isset($dependency),
        ),
    );
} else {
    if (isset($dependency)) 
        $updateLink = 
            '"/user/user/update", '.
            '"id" => $data->id, '.
            '"dependency" => "'.(isset($dependency)?$dependency:null).'", '.
            '"dependencyTabIndex" => '.(isset($dependencyTabIndex)?$dependencyTabIndex:null).', '.
            '"dependencyTabDropdownIndex" => '.(isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null).', '.
            '"parentPk" => "'.(isset($parentPk)?$parentPk:null).'", '.
            '"parentId" => '.(isset($parentId)?$parentId:null).', ';
    else 
        $updateLink = 
            '"/user/user/update", '.
            '"id" => $data->id, ';
    $columns = array(
        array(
            'name' => 'profile_user_type_search',
            'value' => '($data->profile==null || $data->profile->user_type>User::TYPE_SUPPLIER ? "" : User::itemAlias("userTypes",$data->profile->user_type))',
            'htmlOptions' => array('style' => 'width: 80px;'),
            'filterHtmlOptions' => array('style' => 'width: 80px;'),
            'headerHtmlOptions' => array('style' => 'width: 80px;'),
            'filter' => User::itemAlias("userTypes"),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => $userUpdate ? 'TbHtml::link(UHtml::markSearch($data, "username"), array('.$updateLink.'))' : '$data->username',
        ),
        array(
            'name' => 'email',
            'type' => 'raw',
            'value' => 'TbHtml::link(UHtml::markSearch($data, "email"), "mailto:".$data->email)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'superuser',
            'value' => 'User::itemAlias("adminStatus", $data->superuser)',
            'filter' => User::itemAlias("adminStatus"),
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'visible' => !isset($dependency) && $isAdmin,
        ),
        array(
            'name' => 'status',
            'value' => 'User::itemAlias("userStatus",$data->status)',
            'filter' => User::itemAlias("userStatus"),
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'visible' => $isAdmin,
        ),
        array(
            'name' => 'profile_full_name_search',
            'value' => '($data->profile==null || $data->profile->first_name==null ? "" : $data->profile->first_name." ".$data->profile->last_name)',
            //'htmlOptions' => array('class' => 'hidden-xs'),
            //'filterHtmlOptions' => array('class' => 'hidden-xs'),
            //'headerHtmlOptions' => array('class' => 'hidden-xs'),
            'filter' => TbHtml::activeTextField($model, 'profile_full_name_search', array('class' => 'form-control', 'maxlength' => 100)),
        ),
        array(
            'name' => 'co1_search',
            'value' => '($data->profile==null || $data->profile->location==null || $data->profile->location->region==null || $data->profile->location->region->company==null || $data->profile->location->region->company->co1_code==null ? "" : $data->profile->location->region->company->co1_code." - ".$data->profile->location->region->company->co1_name)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'co1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'lo1_search',
            'value' => '($data->profile==null || $data->profile->location==null || $data->profile->location->lo1_code==null ? "" : $data->profile->location->lo1_code." - ".$data->profile->location->lo1_name)',
            'htmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => isset($dependency)?'':'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'lo1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'cu1_search',
            'value' => '($data->profile==null || $data->profile->customer==null || $data->profile->customer->cu1_code==null ? "" : $data->profile->customer->cu1_code." - ".$data->profile->customer->cu1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'cu1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'su1_search',
            'value' => '($data->profile==null || $data->profile->supplier==null || $data->profile->supplier->su1_code==null ? "" : $data->profile->supplier->su1_code." - ".$data->profile->supplier->su1_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => TbHtml::activeTextField($model, 'su1_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => false,//!isset($dependency),
        ),
        array(
            'name' => 'create_at',
            'value' => '($data->create_at=="" || $data->create_at=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->create_at,"medium","short"))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'create_at',
                'name' => 'User[create_at]',
                'htmlOptions' => array(
                    'id' => 'User_create_at'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => false,
        ),
        array(
            'name' => 'lastvisit_at',
            'value' => '($data->lastvisit_at=="" || $data->lastvisit_at=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->lastvisit_at,"medium","short"))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'lastvisit_at',
                'name' => 'User[lastvisit_at]',
                'htmlOptions' => array(
                    'id' => 'User_lastvisit_at'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('".(isset($dependency)?'user-grid-'.$dependencyTabDropdownIndex:'user-grid')."', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => $userDelete?'{delete}':'', //($userView?'{view} ':'').($userUpdate?'{update} ':'').($userDelete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => $userDelete, //$userView || $userUpdate || $userDelete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/user/user/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/user/user/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/user/user/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".user-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#'.(isset($dependency)?'user-grid-'.$dependencyTabDropdownIndex:'user-grid').'").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#'.(isset($dependency)?'user-grid-'.$dependencyTabDropdownIndex:'user-grid').'").yiiGridView("update");
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
    'id' => (isset($relation)?'user-grid-'.$relationIndex:(isset($dependency)?'user-grid-'.$dependencyTabDropdownIndex:'user-grid')),
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
?><!-- user-grid -->
