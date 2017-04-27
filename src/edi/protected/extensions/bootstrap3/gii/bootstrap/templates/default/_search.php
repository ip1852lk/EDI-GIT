<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

echo 
"<?php
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 * @var \$form TbActiveForm
 */

\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
?>
<div class=\"{$this->class2id($this->modelClass)}-search-container\" style=\"display:none\">
    <?php
    \$this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'warning',
        'title' => Yii::t('app', 'Advanced Search'),
        'headerIcon' => 'fa fa-filter fa-lg',
    ));
    \$form = \$this->beginWidget('booster.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl(\$this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'showErrors' => false,
        'showRequiredSymbol' => false,
        'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-search-form'),
    ));\n";
foreach ($this->tableSchema->columns as $column) {
    if ($column->isPrimaryKey) continue;
    echo $this->generateActiveGroup($this->modelClass, $column, 'col-sm-2 col-md-2', 'col-sm-5 col-md-4', "        ");
}
if ($this->useDefaultColumns == 1) {
echo "
        if (\${$this->class2var($this->modelClass)}Admin) {
            echo \$form->textFieldGroup(\$model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => '{$this->modelClass}_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array( 
                    'htmlOptions' => array('id' => '{$this->modelClass}_mprofile_search_2'),
                ),
                'prepend' => '<i class=\"fa fa-user\"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo \$form->datePickerGroup(\$model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => '{$this->modelClass}_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language), 
                    'htmlOptions' => array('id' => '{$this->modelClass}_modified_on_2'),
                ),
                'prepend' => '<i class=\"fa fa-calendar\"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
        }
";
}
echo 
"        ?>
        <div class=\"form-actions btn-toolbar\">
            <?php
            \$this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-search',
                'label' => Yii::t('app', 'Search'),
                'htmlOptions' => array('class' => 'btn-sm'),
            ));
            \$this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_BUTTON,
                'context' => 'default',
                'icon' => 'fa fa-times',
                'label' => Yii::t('app', 'Close'),
                'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    \$this->endWidget();
    \$this->endWidget();
    ?>
</div><!-- {$this->class2id($this->modelClass)}-search-form -->

";