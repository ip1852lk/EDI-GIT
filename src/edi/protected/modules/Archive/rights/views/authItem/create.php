<?php

// Title
$this->title = Yii::t('app', ':type', array(':type' => Rights::getAuthItemTypeName($_GET['type'])));
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::getAuthItemTypeNamePlural($_GET['type']) => Rights::getAuthItemRoute($_GET['type']),
    Rights::t('core', 'Create'),
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
        'htmlOptions' => array('id' => 'auth-item-create-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
$this->renderPartial('_form', array('model' => $formModel));
// Save Control
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'auth_item_form_save', '
    $("#auth-item-create-save-btn").click(function(){
        $("#auth-item-form-save-btn").trigger("click")
    });
');