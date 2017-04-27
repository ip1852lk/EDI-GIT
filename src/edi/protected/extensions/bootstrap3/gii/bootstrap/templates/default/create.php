<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

echo 
"<?php 
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 */

// Title
\$this->title = Yii::t('app', '{$this->class2name($this->modelClass)}');
// Breadcrumbs
\$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}') => array('index'),
    Yii::t('app', 'Create'),
);
// Menus
if (isset(\$dependency) && isset(\$parentId)) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'warning',
            'icon' => 'fa fa-lg fa-angle-double-left',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Back') . '</span>',
            'url' => array(
                \$dependency,
                'id' => (int)\$parentId,
                'tabIndex' => isset(\$dependencyTabIndex)?\$dependencyTabIndex:1,
                'tabDropdownIndex' => isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:0,
            ),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        ),
    ));
}
\$this->menu = array_merge(\$this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => '{$this->class2id($this->modelClass)}-create-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// JavaScript files for dependency and relation
\$cs = Yii::app()->clientScript;
\$assetsScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets'));
\$cs->registerScriptFile(\$assetsScriptUrl .'/gridview/jquery.yiigridview.js',CClientScript::POS_END);
\$cs->registerScriptFile(\$this->assetsBase . '/js/relation.js');
\$cs->registerCoreScript('bbq');
\$booster = Yii::app()->booster;
\$booster->registerPackage('bootbox');
\$booster->registerPackage('datepicker');
\$booster->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
// UIs
echo \$this->renderPartial('//{$this->class2var($this->modelClass)}/_form', array(
    'model' => \$model, 
    'dependency' => (isset(\$dependency)?\$dependency:null), 
    'dependencyTabIndex' => (isset(\$dependencyTabIndex)?\$dependencyTabIndex:null), 
    'dependencyTabDropdownIndex' => (isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:null), 
    'parentPk' => (isset(\$parentPk)?\$parentPk:null), 
    'parentId' => (isset(\$parentId)?\$parentId:null), 
));
// Save Control
\$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_form_save', '
    $(\"#{$this->class2id($this->modelClass)}-create-save-btn\").click(function(){
        $(\"#{$this->class2id($this->modelClass)}-form-save-btn\").trigger(\"click\")
    });
');

";