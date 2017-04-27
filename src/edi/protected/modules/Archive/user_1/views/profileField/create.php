<?php
/* @var $this ProfileFieldController
 * @var $model ProfileField
 */

$cs = Yii::app()->clientScript;
// Title
$this->title = Yii::t('app', 'Profile Field');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    UserModule::t('Profile Fields') => array('index'),
    UserModule::t('Create'),
);
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'profile-field-create-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
echo $this->renderPartial('_form', array('model' => $model));
// Save Control
$cs->registerScript(__CLASS__ . 'profile_field_form_save', '
    $("#profile-field-create-save-btn").click(function(){
        $("#profile-field-form-save-btn").trigger("click")
    });
');
