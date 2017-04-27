<?php
/* @var $this LocationController 
 * @var $model Location
 * @var $region Region
 * @var $company Company
 * @var $representative Profile
 */

// Title
$this->title = Yii::t('app', 'Location');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Locations') => array('index'),
    Yii::t('app', 'Create'),
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
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
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'location-create-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// JavaScript files for dependency and relation
$cs = Yii::app()->clientScript;
$assetsScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets'));
$cs->registerScriptFile($assetsScriptUrl .'/gridview/jquery.yiigridview.js',CClientScript::POS_END);
$cs->registerScriptFile($this->assetsBase . '/js/relation.js');
$cs->registerCoreScript('bbq');
$booster = Yii::app()->booster;
$booster->registerPackage('bootbox');
$booster->registerPackage('datepicker');
$booster->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
// UIs
echo $this->renderPartial('//location/_form', array(
    'model' => $model, 
    'region' => $region,
    'company' => $company,
    'representative' => $representative,
    'dependency' => (isset($dependency)?$dependency:null), 
    'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null), 
    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null), 
    'parentPk' => (isset($parentPk)?$parentPk:null), 
    'parentId' => (isset($parentId)?$parentId:null), 
));
// Save Control
$cs->registerScript(__CLASS__ . 'location_form_save', '
    $("#location-create-save-btn").click(function(){
        $("#location-form-save-btn").trigger("click")
    });
');
