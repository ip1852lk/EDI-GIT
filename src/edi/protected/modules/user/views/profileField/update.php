<?php
/* @var $this ProfileFieldController
 * @var $model ProfileField
 */

$cs = Yii::app()->clientScript;
// Title
$this->title = Yii::t('app', 'Profile Field')." <span class=\"text-warning\">".CHtml::encode($model->varname)."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    Yii::t('app', 'Profile Fields') => array('index'),
    $model->varname => array('view', 'id' => $model->id),
    Yii::t('app', 'Update'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'profile-field-update-save-btn', 'class' => 'navbar-btn btn-sm',),
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
echo $this->renderPartial('_form', array('model' => $model));
// Save Control
$cs->registerScript(__CLASS__ . 'profile_field_form_save', '
    $("#profile-field-update-save-btn").click(function(){
        $("#profile-field-form-save-btn").trigger("click")
    });
');


