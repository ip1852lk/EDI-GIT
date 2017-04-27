<?php
/* @var $this ProjectController
 * @var $model Project
 */

$cs = Yii::app()->clientScript;
$projectAdmin = Yii::app()->user->checkAccess('Project.*');
$projectCreate = Yii::app()->user->checkAccess('Project.Create');
$projectUpdate = Yii::app()->user->checkAccess('Project.Update');
$projectDelete = Yii::app()->user->checkAccess('Project.Delete');
// Title
$this->title = Yii::t('app', 'Projects').' <span class="text-warning">'.$model->id.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Projects') => array('index'),
    $model->id,
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
if ($projectUpdate || $projectDelete) {
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
            'visible' => $projectCreate,
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
            'visible' => $projectUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'project-delete-btn navbar-btn btn-sm',),
            'visible' => $projectDelete,
        ),
    ));
    if ($projectDelete) {
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
        $cs->registerScript(__CLASS__ . 'project_delete', '
            $(".project-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this Project?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".project-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                        }},
                        cancel:{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
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
    'title' => $model->id,
    'headerIcon' => 'fa fa-folder fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'PR1_ID',
        'PR1_NAME',
        'RE1_INVOICE_TYPE',
        'RE1_INVOICE_BILLED',
        'PR1_APP_NAME',
        'PR1_DELETE_FLAG',

        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $projectAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $projectAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null || $model->mprofile->first_name == null ? '' : $model->mprofile->first_name . ' ' . $model->mprofile->last_name),
            'visible' => $projectAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $projectAdmin,
        ),
    ),
));
$this->endWidget();

