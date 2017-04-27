<?php
/* @var $this ProfileFieldController
 * @var $model ProfileField
 */

$cs = Yii::app()->clientScript;
// Title
$this->title = Yii::t('app', 'Profile Field')." <span class=\"text-warning\">".CHtml::encode($model->varname)."</span>";;
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    UserModule::t('Profile Fields') => array('index'),
    UserModule::t($model->varname),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'success',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
        'url' => array('/user/profileField/create'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'primary',
        'icon' => 'fa fa-pencil fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
        'url' => array('/user/profileField/update', 'id' => $model->id),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'danger',
        'icon' => 'fa fa-trash-o fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'profile-field-delete-btn navbar-btn btn-sm',),
    ),
));
Yii::app()->booster->registerPackage('bootbox');
$cs->registerCoreScript('yii');
$cs->registerScript(__CLASS__ . 'profile_field_record_delete', '
    $(".profile-field-delete-btn").click(function(){
        bootbox.dialog({
            title: "' . Yii::t('app', 'Delete Record?') . '",
            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
            buttons: {
                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                    $.yii.submitForm($(".profile-field-delete-btn")[0], "' . $this->createUrl('/user/profileField/delete', array('id' => $model->id)) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                }},
                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
            }
        });
        return false;
    });
');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Profile Field') : $model->varname,
    'headerIcon' => 'fa fa-user-plus fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'varname',
        'title',
        'field_type',
        'field_size',
        'field_size_min',
        array(
            'name' => 'required',
            'type' => 'raw',
            'value' => isset($model->required) ? ProfileField::itemAlias('required', $model->required) : '',
        ),
        'match',
        'range',
        'error_message',
        'other_validator',
        'widget',
        'widgetparams',
        'default',
        'position',
        array(
            'name' => 'visible',
            'type' => 'raw',
            'value' => isset($model->visible) ? ProfileField::itemAlias('required', $model->visible) : '',
        ),
    ),
));
$this->endWidget();
