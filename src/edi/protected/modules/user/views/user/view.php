<?php
/* @var $this UserController
 * @var $model User
 */

$cs = Yii::app()->clientScript;
$isAdmin = Yii::app()->user->checkAccess('Admin');
$userCreate = Yii::app()->user->checkAccess('User.User.Create');
$userUpdate = Yii::app()->user->checkAccess('User.User.Update');
$userDelete = Yii::app()->user->checkAccess('User.User.Delete');
// Title
$this->title = Yii::t('app', 'User')." <span class=\"text-warning\">".$model->email."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    Yii::t('app', 'Users') => array('/user'),
    $model->email,
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
if ($userUpdate || $userDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('/user/user/create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $userCreate,
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
            'visible' => $userUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'user-delete-btn navbar-btn btn-sm',),
            'visible' => $userDelete,
        ),
    ));
    if ($userDelete) {
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
        $cs->registerScript(__CLASS__ . 'user_delete', '
            $(".user-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                    buttons: {
                        "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".user_delete_btn")[0], "' . $this->createUrl('delete', array('id' => $model->id)) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
$attributes = array(
    'username',
    'email',
    array(
        'name' => 'superuser',
        'value' => User::itemAlias("adminStatus", $model->superuser),
        'visible' => $isAdmin,
    ),
    array(
        'name' => 'status',
        'value' => User::itemAlias("userStatus", $model->status),
        'visible' => $isAdmin,
    ),
);
$user_type = $model->profile->user_type;
$profileFields = ProfileField::model()->forAdmin()->sort()->findAll();
if ($profileFields) {
    foreach ($profileFields as $field) {
        $addField = false;
        if ($user_type == User::TYPE_CUSTOMER && $field->varname !== 'su1_id') 
            $addField = true;
        elseif ($user_type == User::TYPE_SUPPLIER && $field->varname !== 'cu1_id') 
            $addField = true;
        elseif ($field->varname !== 'status' && !$isAdmin) 
            $addField = false;
        elseif ($field->varname !== 'cu1_id' && $field->varname !== 'su1_id')
            $addField = true;
        if ($addField)
            array_push($attributes, array(
                'label' => Yii::t('app', $field->title),
                'name' => $field->varname,
                'type' => 'raw',
                'value' => (
                    $field->widgetView($model->profile) ?
                    $field->widgetView($model->profile) : (
                    $field->range ?
                        Profile::range($field->range, $model->profile->getAttribute($field->varname)) :
                        $model->profile->getAttribute($field->varname)
                    )
                ),
            ));
    }
}
array_push($attributes, array(
    'name' => 'create_at',
    'value' => ($model->create_at == '' || $model->create_at == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->create_at,"medium","short")),
), array(
    'name' => 'lastvisit_at',
    'value' => ($model->lastvisit_at == '' || $model->lastvisit_at == '0000-00-00 00:00:00' ? Yii::t('app', 'Not visited') : Yii::app()->dateFormatter->formatDateTime($model->lastvisit_at,"medium","short")),
));
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'User') : $model->email,
    'headerIcon' => 'fa fa-user fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => $attributes,
));
$this->endWidget();
