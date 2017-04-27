<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

$mainConlumns = "";
$relationColumns = "";
$relationValues = "'\"{$this->tableSchema->primaryKey}==\".\$data->{$this->tableSchema->primaryKey}'";
foreach ($this->tableSchema->columns as $column) {
    if ($column->isPrimaryKey) continue;
    if (!array_key_exists($column->name, $this->excludedColumns)) {
        $mainConlumns .= "        '{$column->name}',\n";
        $relationColumns .= "        '{$column->name}',\n";
        $relationValues .= "\n                .'.\"|{$column->name}==\".\$data->{$column->name}'";
    }
}
echo "
<?php
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 */

// Debugging code
//\$relation = true;
//\$relationIndex = 1;
//\$relationSelectableRows = 2;

\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
\${$this->class2var($this->modelClass)}View = Yii::app()->user->checkAccess('{$this->modelClass}.View');
\${$this->class2var($this->modelClass)}Update = Yii::app()->user->checkAccess('{$this->modelClass}.Update');
\${$this->class2var($this->modelClass)}Delete = Yii::app()->user->checkAccess('{$this->modelClass}.Delete');

\$cs = Yii::app()->getClientScript();
// Menu
if (isset(\$dependency) || isset(\$relation)) {
    \$cs->scriptMap = array(
        'font-awesome.min.css' => false,
        'bootstrap-yii.css' => false,
        'jquery-ui-bootstrap.css' => false,
        'bootstrap-notify.css' => false,
        'bootstrap.no-icons.min.css' => false,
        'datepicker3.css' => false,
        'jquery.js' => false,
        'jquery.min.js' => false,
        'bootstrap.js' => false,
        'bootstrap.min.js' => false,
        'bootstrap.bootbox.js' => false,
        'bootstrap.bootbox.min.js' => false,
        'bootstrap.notify.js' => false,
        'bootstrap.notify.min.js' => false,
        'jquery.yiigridview.js' => false,
        'jquery.saveselection.gridview.js' => false,
        'jquery.ba-bbq.js' => false,
        'bootstrap-datepicker.js' => false,
        'bootstrap-datepicker.min.js' => false,
        'bootstrap-datepicker-noconflict.js' => false,
        'jquery.stickytableheaders.js' => false,
        'jquery.stickytableheaders.min.js' => false,
    );
    echo \$this->renderPartial('//{$this->class2var($this->modelClass)}/_grid_menu', array(
        'model' => \$model,
        'dependency' => (isset(\$dependency)?\$dependency:null),
        'dependencyTabIndex' => (isset(\$dependencyTabIndex)?\$dependencyTabIndex:null),
        'dependencyTabDropdownIndex' => (isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:null),
        'parentId' => (isset(\$parentId)?\$parentId:null),
        'parentPk' => (isset(\$parentPk)?\$parentPk:null),
        'relation' => (isset(\$relation)?\$relation:null),
        'relationIndex' => (isset(\$relationIndex)?\$relationIndex:null),
    ));
}
// Status Message
if (!isset(\$relation)) {
    echo '<div class=\"{$this->class2id($this->modelClass)}-grid-status-msg\">';
        if (Yii::app()->user->hasFlash('success')) 
            \$this->widget('booster.widgets.TbAlert', array(
                'alerts' => array(
                    'success' => array('fade' => true, 'closeText' => '×'), 
                ),
            ));
        elseif (Yii::app()->user->hasFlash('error')) 
            \$this->widget('booster.widgets.TbAlert', array(
                'alerts' => array(
                    'error' => array('fade' => true, 'closeText' => '×'), 
                ),
            ));
    echo '</div>';
}
// Grid Columns
if (isset(\$relation)) {
    \$columns = array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => isset(\$relationSelectableRows)?\$relationSelectableRows:1,
        ),
        array(
            'type' => 'raw',
            'value' => 
                {$relationValues},
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm hidden-md hidden-lg'),
        ),
{$relationColumns}
    );
} else {
    if (isset(\$dependency)) 
        \$updateLink = 
            '\"/{$this->class2var($this->modelClass)}/update\", '.
            '\"id\" => \$data->{$this->tableSchema->primaryKey}, '.
            '\"dependency\" => \"'.(isset(\$dependency)?\$dependency:null).'\", '.
            '\"dependencyTabIndex\" => '.(isset(\$dependencyTabIndex)?\$dependencyTabIndex:null).', '.
            '\"dependencyTabDropdownIndex\" => '.(isset(\$dependencyTabDropdownIndex)?\$dependencyTabDropdownIndex:null).', '.
            '\"parentPk\" => \"'.(isset(\$parentPk)?\$parentPk:null).'\", '.
            '\"parentId\" => '.(isset(\$parentId)?\$parentId:null).', ';
    else 
        \$updateLink = 
            '\"/{$this->class2var($this->modelClass)}/update\", '.
            '\"id\" => \$data->{$this->tableSchema->primaryKey}, ';
    \$columns = array(
        array(
            'name' => '{$this->tableSchema->primaryKey}',
            'type' => 'raw',
            'value' => \${$this->class2var($this->modelClass)}Update ? 'TbHtml::link(UHtml::markSearch(\$data, \"{$this->tableSchema->primaryKey}\"), array('.\$updateLink.'))' : '\$data->{$this->tableSchema->primaryKey}',
        ),
{$mainConlumns}
";
if ($this->useDefaultColumns == 1) {
echo 
"        array(
            'name' => 'mprofile_search',
            'value' => '(\$data->mprofile==null || \$data->mprofile->first_name==null ? \"\" : \$data->mprofile->first_name.(\$data->mprofile->last_name==null?\"\":\" \".\$data->mprofile->last_name))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => TbHtml::activeTextField(\$model, 'mprofile_search', array(
                'maxlength' => 100,
                'class' => 'form-control', 
            )),
            'visible' => !isset(\$dependency) && \${$this->class2var($this->modelClass)}Admin,
        ),
        array(
            'name' => 'modified_on',
            'value' => '(\$data->modified_on==\"\" || \$data->modified_on==\"0000-00-00 00:00:00\" ? \"\" : Yii::app()->dateFormatter->formatDateTime(\$data->modified_on,\"medium\",\"short\"))',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filter' => \$this->widget('booster.widgets.TbDatePicker', array(
                'model' => \$model,
                'attribute' => 'modified_on',
                'name' => '{$this->modelClass}[modified_on]',
                'htmlOptions' => array(
                    'id' => '{$this->modelClass}_modified_on'.(isset(\$dependency)?'_'.\$dependencyTabDropdownIndex:''),
                    'class' => 'form-control',
                    'language' => Yii::app()->language,
                    'placeholder' => '',
                ),
            ), true),
            'visible' => !isset(\$dependency) && \${$this->class2var($this->modelClass)}Admin,
        ),
";
}
echo 
"        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => \"$.fn.yiiGridView.update('\".(isset(\$dependency)?'{$this->class2id($this->modelClass)}-grid-'.\$dependencyTabDropdownIndex:'{$this->class2id($this->modelClass)}-grid').\"', {data:{pageSize:$(this).val()}})\",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => \${$this->class2var($this->modelClass)}Delete?'{delete}':'', //(\${$this->class2var($this->modelClass)}View?'{view} ':'').(\${$this->class2var($this->modelClass)}Update?'{update} ':'').(\${$this->class2var($this->modelClass)}Delete?'{delete}':''),
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'visible' => \${$this->class2var($this->modelClass)}Delete, //\${$this->class2var($this->modelClass)}View || \${$this->class2var($this->modelClass)}Update || \${$this->class2var($this->modelClass)}Delete,
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array(\"/{$this->class2var($this->modelClass)}/view\", \"id\" => \$data->{$this->tableSchema->primaryKey})',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array(\"/{$this->class2var($this->modelClass)}/update\", \"id\" => \$data->{$this->tableSchema->primaryKey})',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array(\"/{$this->class2var($this->modelClass)}/delete\", \"id\" => \$data->{$this->tableSchema->primaryKey})',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(\".{$this->class2id($this->modelClass)}-grid-status-msg\").html(data); };
                        bootbox.dialog({
                            title: \"' . Yii::t('app', 'Delete Record?') . '\",
                            message: \"' . Yii::t('app', 'Are you sure you want to delete this record?') . '\",
                            buttons: {
                                \"delete\":{label:\"' . Yii::t('app', 'Delete') . '\", className:\"btn-danger\", callback:function(){ 
                                    $(\"#'.(isset(\$dependency)?'{$this->class2id($this->modelClass)}-grid-'.\$dependencyTabDropdownIndex:'{$this->class2id($this->modelClass)}-grid').'\").yiiGridView(\"update\", {
                                        type: \"POST\",
                                        url: $(th).attr(\"href\"),
                                        data: { \"YII_CSRF_TOKEN\":\"' . Yii::app()->request->csrfToken . '\" },
                                        success: function(data) {
                                            $(\"#'.(isset(\$dependency)?'{$this->class2id($this->modelClass)}-grid-'.\$dependencyTabDropdownIndex:'{$this->class2id($this->modelClass)}-grid').'\").yiiGridView(\"update\");
                                            afterDelete(th, true, data);
                                        },
                                        error: function(XHR) {
                                            return afterDelete(th, false, XHR);
                                        }
                                    });
                                }},
                                \"cancel\":{label:\"' . Yii::t('app', 'Cancel') . '\", className:\"btn\", },
                            }
                        });
                        return false;
                    }',
                ),
            ),
        ),
    );
}
// Grid
\$this->widget('ext.jgridview.JGridView', array(
    'id' => (isset(\$relation)?'{$this->class2id($this->modelClass)}-grid-'.\$relationIndex:(isset(\$dependency)?'{$this->class2id($this->modelClass)}-grid-'.\$dependencyTabDropdownIndex:'{$this->class2id($this->modelClass)}-grid')),
    'dataProvider' => \$model->search(),
    'filter' => \$model,
    'ajaxUpdate' => isset(\$dependency)||isset(\$relation)?true:false,
    'enablePagination' => true,
    'template' => '{items} {pager}',    // '{summary} {items} {pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'columns' => \$columns,
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
        'alignment' => TbPager::ALIGNMENT_CENTER,
        'maxButtonCount' => Yii::app()->params['pagerMaxButtonCount'],
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
     ),
    'selectableRows' => null,
));
?><!-- {$this->class2id($this->modelClass)}-grid -->

";