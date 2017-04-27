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

\$cs = Yii::app()->clientScript;
\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
\${$this->class2var($this->modelClass)}View = Yii::app()->user->checkAccess('{$this->modelClass}.View');
\${$this->class2var($this->modelClass)}Delete = Yii::app()->user->checkAccess('{$this->modelClass}.Delete');
// Title
\$this->title = Yii::t('app', '{$this->class2name($this->modelClass)}').' <span class=\"text-warning\">'.\$model->{$this->tableSchema->primaryKey}.'</span>';
// Breadcrumbs
\$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}') => array('index'),
    \$model->{$this->tableSchema->primaryKey} => array('view', 'id' => \$model->{$this->tableSchema->primaryKey}),
    Yii::t('app', 'Update'),
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
        'htmlOptions' => array('id' => '{$this->class2id($this->modelClass)}-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if (\${$this->class2var($this->modelClass)}Delete) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-delete-btn navbar-btn btn-sm',),
            'visible' => \${$this->class2var($this->modelClass)}Delete,
        ),
    ));
    if (isset(\$dependency))
        \$deleteUrl = array(
            'id' => \$model->{$this->tableSchema->primaryKey},
            'dependency' => \$dependency,
            'dependencyTabIndex' => \$dependencyTabIndex,
            'dependencyTabDropdownIndex' => \$dependencyTabDropdownIndex,
            'parentPk' => \$parentPk,
            'parentId' => \$parentId,
        );
    else
        \$deleteUrl = array('id' => \$model->{$this->tableSchema->primaryKey});
    \$cs->registerCoreScript('yii');
    \$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_delete', '
        $(\".{$this->class2id($this->modelClass)}-delete-btn\").click(function(){
            bootbox.dialog({
                title: \"' . Yii::t('app', 'Delete Record?') . '\",
                message: \"' . Yii::t('app', 'Are you sure you want to delete this record?') . '\",
                buttons: {
                    delete:{label:\"' . Yii::t('app', 'Delete') . '\", className:\"btn-danger\", callback:function(){
                        $.yii.submitForm($(\".{$this->class2id($this->modelClass)}-delete-btn\")[0], \"' . \$this->createUrl('delete', \$deleteUrl) . '\", {YII_CSRF_TOKEN:\"' . Yii::app()->request->csrfToken . '\"});
                    }},
                    cancel:{label:\"' . Yii::t('app', 'Cancel') . '\", className:\"btn-default\",},
                }
            });
            return false;
        });
    ');
}
// JavaScript files for dependency and relation
\$assetsScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets'));
\$cs->registerScriptFile(\$assetsScriptUrl .'/gridview/jquery.yiigridview.js',CClientScript::POS_END);
\$cs->registerScriptFile(\$this->assetsBase . '/js/dependency.js');
\$cs->registerScriptFile(\$this->assetsBase . '/js/relation.js');
\$cs->registerCoreScript('bbq');
\$booster = Yii::app()->booster;
\$booster->registerPackage('bootbox');
\$booster->registerPackage('datepicker');
\$booster->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
// Tab Control
\$tableLogList = 'window.getDependencyGrid(
    \"'.\$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/{$this->class2var($this->modelClass)}/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => '{$this->modelClass}',
        'parentId' => \$model->{$this->tableSchema->primaryKey},
    )).'\",
    \"{$this->class2id($this->modelClass)}-table-log-tab\",
    \"'.Yii::t('app', 'Loading...').'\",
    \"'.Yii::t('app', 'Server Error').'\",
    \"'.Yii::t('app', 'Please refresh this page and try again shortly.').'\"
);';
// Tab UIs
if (\$this->isMobile) {
    \$this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => '{$this->class2id($this->modelClass)}_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset(\$tabIndex) && \$tabIndex==0 ? true : false,
                'id' => '{$this->class2id($this->modelClass)}-form-tab',
                'label' => Yii::t('app', '{$this->modelClass}'),
                'content' => \$this->renderPartial('//{$this->class2var($this->modelClass)}/_form', array(
                    'model' => \$model,
                    'dependency' => (isset(\$dependency)?\$dependency:null),
                    'dependencyTabIndex' => (isset(\$dependencyTabIndex)?\$dependencyTabIndex:null),
                    'dependencyTabDropdownIndex' => (isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:null),
                    'parentPk' => (isset(\$parentPk)?\$parentPk:null),
                    'parentId' => (isset(\$parentId)?\$parentId:null),
                ), true),
            ),
            array(
                'active' => isset(\$tabIndex) && \$tabIndex==1 ? true : false,
                'label' => Yii::t('app', 'Dependency Lists'),
                'items' => array(
                    array(
                        'active' => isset(\$tabIndex) && \$tabIndex==1 && isset(\$tabDropdownIndex) && \$tabDropdownIndex==0 ? true : false,
                        'id' => '{$this->class2id($this->modelClass)}-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class=\"fa fa-spin fa-spinner\"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => '{$this->class2id($this->modelClass)}-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id=\"{$this->class2id($this->modelClass)}-form-content\" class=\"row\">
        <div class=\"col-sm-12 col-md-5\">
            <?php
            \$this->renderPartial('//{$this->class2var($this->modelClass)}/_form', array(
                'model' => \$model,
                'dependency' => (isset(\$dependency)?\$dependency:null),
                'dependencyTabIndex' => (isset(\$dependencyTabIndex)?\$dependencyTabIndex:null),
                'dependencyTabDropdownIndex' => (isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:null),
                'parentPk' => (isset(\$parentPk)?\$parentPk:null),
                'parentId' => (isset(\$parentId)?\$parentId:null),
            ));
            ?>
            <br>
        </div>
        <div id=\"{$this->class2id($this->modelClass)}-dependency-content\" class=\"col-sm-12 col-md-7\">
            <?php
            \$this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => '{$this->class2id($this->modelClass)}_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset(\$tabIndex) && \$tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset(\$tabIndex) && \$tabIndex==1 && isset(\$tabDropdownIndex) && \$tabDropdownIndex==0 ? true : false,
                                'id' => '{$this->class2id($this->modelClass)}-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class=\"fa fa-spin fa-spinner\"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => '{$this->class2id($this->modelClass)}-table-log-tab-btn'),
                            ),
                        )
                    ),
                ),
            ));
            ?>
        </div>
    </div>
<?php
}
// Tab Initialization
if (\$tabIndex == 1 && \$tabDropdownIndex == 0) 
    \$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_table_log_control', \$tableLogList);
// Tab Events
\$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_dependency_control', '
    $(\"#{$this->class2id($this->modelClass)}-table-log-tab-btn\").click(function(){'.\$tableLogList.'});
');
// Save Control
\$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_form_save', '
    $(\"#{$this->class2id($this->modelClass)}-update-save-btn\").click(function(){
        $(\"#{$this->class2id($this->modelClass)}-form-save-btn\").trigger(\"click\")
    });
');

";