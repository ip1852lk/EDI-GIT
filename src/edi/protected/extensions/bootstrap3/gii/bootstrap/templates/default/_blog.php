<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

echo 
"<?php
/* @var \$this {$this->getControllerClass()}
 * @var \$data {$this->modelClass}
 */

\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
\${$this->class2var($this->modelClass)}Update = Yii::app()->user->checkAccess('{$this->modelClass}.Update');

\$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa {$this->icon} fa-lg',
    'title' => \${$this->class2var($this->modelClass)}Update ? TbHtml::link(UHtml::markSearch(\$data, \"{$this->tableSchema->primaryKey}\"), array(\"update\", \"id\" => \$data->{$this->tableSchema->primaryKey})) : \$data->{$this->tableSchema->primaryKey},
));
\$this->widget('booster.widgets.TbDetailView', array(
    'data' => \$data,
    'attributes' => array(
        array(
            'name' => '{$this->tableSchema->primaryKey}',
            'type' => 'raw',
            'value' => \${$this->class2var($this->modelClass)}Update ? TbHtml::link(UHtml::markSearch(\$data, \"{$this->tableSchema->primaryKey}\"), array(\"update\", \"id\" => \$data->{$this->tableSchema->primaryKey})) : \$data->{$this->tableSchema->primaryKey},
        ),\n";
foreach ($this->tableSchema->columns as $column) {
    if ($column->isPrimaryKey) continue;
    if (!array_key_exists($column->name, $this->excludedColumns)) {
        echo "        array(
            'name' => '{$column->name}',
        ),\n";
    }
}
if ($this->useDefaultColumns == 1) {
echo 
"        array(
            'name' => 'mprofile_search',
            'value' => (\$data->mprofile == null || \$data->mprofile->first_name == null ? \"\" : \$data->mprofile->first_name . \" \" . \$data->mprofile->last_name),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
        array(
            'name' => 'modified_on',
            'value' => (\$data->modified_on == \"\" || \$data->modified_on == \"0000-00-00 00:00:00\" ? \"\" : Yii::app()->dateFormatter->formatDateTime(\$data->modified_on, \"medium\", \"short\")),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
";
}
echo 
"    ),
));
\$this->endWidget();

";