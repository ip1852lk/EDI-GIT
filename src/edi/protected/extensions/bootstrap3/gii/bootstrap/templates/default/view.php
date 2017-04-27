<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

$mainConlumns = "";
foreach ($this->tableSchema->columns as $column) {
    if ($column->isPrimaryKey) continue;
    if (!array_key_exists($column->name, $this->excludedColumns)) {
        $mainConlumns .= "        '{$column->name}',\n";
    }
}
echo 
"<?php
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 */

\$cs = Yii::app()->clientScript;
\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
\${$this->class2var($this->modelClass)}Create = Yii::app()->user->checkAccess('{$this->modelClass}.Create');
\${$this->class2var($this->modelClass)}Update = Yii::app()->user->checkAccess('{$this->modelClass}.Update');
\${$this->class2var($this->modelClass)}Delete = Yii::app()->user->checkAccess('{$this->modelClass}.Delete');
// Title
\$this->title = Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}').' <span class=\"text-warning\">'.\$model->{$this->tableSchema->primaryKey}.'</span>';
// Breadcrumbs
\$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}') => array('index'),
    \$model->{$this->tableSchema->primaryKey},
);
// Menus
if (isset(\$dependency) && isset(\$parentId)) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
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
if (\${$this->class2var($this->modelClass)}Update || \${$this->class2var($this->modelClass)}Delete) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => \${$this->class2var($this->modelClass)}Create,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => \$model->{$this->tableSchema->primaryKey}),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => \${$this->class2var($this->modelClass)}Update,
        ),
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
    if (\${$this->class2var($this->modelClass)}Delete) {
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
                    message: \"' . Yii::t('app', 'Are you sure you want to delete this {$this->modelClass}?') . '\",
                    buttons: {
                        delete:{label:\"' . Yii::t('app', 'Delete') . '\", className:\"btn-danger\", callback:function(){
                            $.yii.submitForm($(\".{$this->class2id($this->modelClass)}-delete-btn\")[0], \"' . \$this->createUrl('delete', \$deleteUrl) . '\", {\"YII_CSRF_TOKEN\":\"' . Yii::app()->request->csrfToken . '\"});
                        }},
                        cancel:{label:\"' . Yii::t('app', 'Cancel') . '\", className:\"btn-default\",},
                    }
                });
                return false;
            });
        ');
    }
}
// UIs
\$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => \$model->{$this->tableSchema->primaryKey},
    'headerIcon' => 'fa {$this->icon} fa-lg',
));
\$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => \$model,
    'attributes' => array(
{$mainConlumns}
        array(
            'name' => 'cprofile_search',
            'value' => (\$model->cprofile == null || \$model->cprofile->first_name == null ? '' : \$model->cprofile->first_name . ' ' . \$model->cprofile->last_name),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
        array(
            'name' => 'created_on',
            'value' => (\$model->created_on == '' || \$model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime(\$model->created_on, \"medium\", \"short\")),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
";
if ($this->useDefaultColumns == 1) {
echo 
"        array(
            'name' => 'mprofile_search',
            'value' => (\$model->mprofile == null || \$model->mprofile->first_name == null ? '' : \$model->mprofile->first_name . ' ' . \$model->mprofile->last_name),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
        array(
            'name' => 'modified_on',
            'value' => (\$model->modified_on == '' || \$model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime(\$model->modified_on, \"medium\", \"short\")),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
";
}
echo 
"    ),
));
\$this->endWidget();

";