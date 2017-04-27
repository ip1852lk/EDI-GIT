<?php
/* @var $this TableLogController
 * @var $model TableLog
 */

$cs = Yii::app()->clientScript;
$tableLogAdmin = Yii::app()->user->checkAccess('TableLog.*');
$tableLogCreate = Yii::app()->user->checkAccess('TableLog.Create');
$tableLogUpdate = Yii::app()->user->checkAccess('TableLog.Update');
$tableLogDelete = Yii::app()->user->checkAccess('TableLog.Delete');
// Title
$this->title = TableLog::itemAlias('logActions', $model->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short").')';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Change Logs') => array('index'),
    TableLog::itemAlias('logActions', $model->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", null).')',
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'warning',
            'icon' => 'fa fa-lg fa-angle-double-left',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Back') . '</span>',
            'url' => array(
                $dependency,
                'id' => (int)$parentId,
                'tabIndex' => isset($dependencyTabIndex)?$dependencyTabIndex:1,
                'tabDropdownIndex' => isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:0,
            ),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        ),
    ));
}
if ($tableLogUpdate || $tableLogDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $tableLogCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => $model->id),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $tableLogUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'table-log-delete-btn navbar-btn btn-sm',),
            'visible' => $tableLogDelete,
        ),
    ));
    if ($tableLogDelete) {
        if (isset($dependency))
            $deleteUrl = array(
                'id' => $model->id,
                'dependency' => $dependency,
                'dependencyTabIndex' => $dependencyTabIndex,
                'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
                'parentPk' => $parentPk,
                'parentId' => $parentId,
            );
        else
            $deleteUrl = array('id' => $model->id);
        $cs->registerCoreScript('yii');
        $cs->registerScript(__CLASS__ . 'table_log_delete', '
            $(".table-log-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                    buttons: {
                        "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".table-log-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                        }},
                        "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
                    }
                });
                return false;
            });
        ');
    }
}
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => TableLog::itemAlias('logActions', $model->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short").')',
    'headerIcon' => 'fa fa-map-marker fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'created_on',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short"),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? "" : $model->cprofile->first_name . " " . $model->cprofile->last_name),
        ),
        array(
            'name' => 'action',
            'value' => TableLog::itemAlias('logActions', $model->log_action),
        ),
        array(
            'name' => 'description',
            'type' => 'html',
        ),
    ),
));
$this->endWidget();
