<?php
/* @var $this UserLogController
 * @var $model UserLog
 */

// Debugging code
//$relation = true;
//$relationIndex = 1;
//$relationSelectableRows = 2;

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
    echo $this->renderPartial('application.modules.user.views.userLog._grid_menu', array(
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
    echo '<div class="user-log-grid-status-msg">';
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
                '"user_id==".$data->user_id."|'.
                'session_id==".$data->session_id."|'.
                'ip_address==".$data->ip_address."|'.
                'login_time==".$data->login_time."|'.
                'logout_time==".$data->logout_time."|'.
                'user_agent==".$data->user_agent."|'.
                'first_name==".($data->user==null || $data->user->profile==null || $data->user->profile->first_name==null ? "" : $data->user->profile->first_name)."|'.
                'last_name==".($data->user==null || $data->user->profile==null || $data->user->profile->last_name==null ? "" : $data->user->profile->last_name)',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
        array(
            'name' => 'login_time',
            'value' => '($data->login_time=="" || $data->login_time=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->login_time,"medium","short"))',
            'htmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'login_time',
                'name' => 'UserLog[login_time]',
                'htmlOptions' => array(
                    'id' => 'UserLog_login_time'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'name' => 'profile_search',
            'type' => 'raw',
            'value' =>
                '($data->user==null || $data->user->profile==null ? "" : $data->user->profile->fullname)'.
                '."<br><span class=\"visible-xs visible-sm\">".($data->login_time=="" || $data->login_time=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->login_time,"medium","short"))."</span>"',
            'filter' => TbHtml::activeTextField($model, 'profile_search', array('class' => 'form-control', 'maxlength' => 100)),
        ),
    );
} else {
    $columns = array(
        array(
            'name' => 'login_time',
            'value' => '($data->login_time=="" || $data->login_time=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->login_time,"medium","short"))',
            'htmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filterHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'headerHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'login_time',
                'name' => 'UserLog[login_time]',
                'htmlOptions' => array(
                    'id' => 'UserLog_login_time'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'name' => 'logout_time',
            'value' => '($data->logout_time=="" || $data->logout_time=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->logout_time,"medium","short"))',
            'htmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs hidden-sm hidden-md'),
            'filterHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs hidden-sm hidden-md'),
            'headerHtmlOptions' => array('style' => 'width: 200px;', 'class' => 'hidden-xs hidden-sm hidden-md'),
            'filter' => $this->widget('booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'logout_time',
                'name' => 'UserLog[logout_time]',
                'htmlOptions' => array(
                    'id' => 'UserLog_logout_time'.(isset($dependency)?'_'.$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
        ),
        array(
            'name' => 'profile_search',
            'type' => 'raw',
            'value' => 
                '($data->user==null || $data->user->profile==null ? "" : $data->user->profile->fullname)'.
                '."<br><span class=\"visible-xs visible-sm\">".($data->login_time=="" || $data->login_time=="0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->login_time,"medium","short"))."</span>"',
            'filter' => TbHtml::activeTextField($model, 'profile_search', array('class' => 'form-control', 'maxlength' => 100)),
            'visible' => !isset($dependency),
        ),
        array(
            'name' => 'ip_address',
            'htmlOptions' => array('class' => ''),
            'filterHtmlOptions' => array('class' => ''),
            'headerHtmlOptions' => array('class' => ''),
        ),
        array(
            'name' => 'user_agent',
            'htmlOptions' => array('class' => 'hidden-xs', 'style' => 'width: 250px;'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
    );
}
// Grid
$this->widget('ext.jgridview.JGridView', array(
    'id' => (isset($relation)?'user-log-grid-'.$relationIndex:(isset($dependency)?'user-log-grid-'.$dependencyTabDropdownIndex:'user-log-grid')),
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
?><!-- user-log-grid -->
