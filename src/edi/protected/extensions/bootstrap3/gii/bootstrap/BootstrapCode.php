<?php

/**
 * ## BootstrapCode class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
Yii::import('gii.generators.crud.CrudCode');

/**
 * ## Class BootstrapCode
 *
 * @package booster.gii
 */
class BootstrapCode extends CrudCode
{
    public $useDefaultColumns;
    public $icon;
    public $excludedColumns = array(
        'created_by' => 'created_by',
        'created_on' => 'created_on',
        'modified_by' => 'modified_by',
        'modified_on' => 'modified_on',
        'delete_flag' => 'delete_flag',
        'update_flag' => 'update_flag',
    );

    public function init()
    {
        parent::init();
        $this->baseControllerClass = 'RController';
        $this->useDefaultColumns = 1;
        $this->icon = "fa-twitter";
    }

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('model, controller', 'filter', 'filter'=>'trim'),
            array('model, controller, baseControllerClass, icon, useDefaultColumns', 'required'),
            array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
            array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
            array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
            array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
            array('model', 'validateModel'),
            array('baseControllerClass', 'sticky'),
            array('useDefaultColumns', 'numerical', 'integerOnly' => true),
            array('icon', 'sticky'),
            array('icon', 'match', 'pattern'=>'/^fa-[a-zA-Z0-9-]*$/', 'message'=>'{attribute} should only contain word characters and dash.'),
        ));
    }

    /**
     * Converts a class name into a db column or variable.
     * For example, 'PostTag' will be converted as 'post_tag'.
     * @param string $name the string to be converted
     * @return string the resulting ID
     */
    public function class2dbid($name)
    {
        return trim(strtolower(str_replace('-','_',preg_replace('/(?<![A-Z])[A-Z]/', '-\0', $name))),'_');
    }

    public function generateActiveGroup($modelClass, $column, $labelOptions, $wrapperHtmlOptions, $indent='')
    {
        if (!array_key_exists($column->name, $this->excludedColumns)) {
            if ($column->type === 'boolean') {
                return 
"{$indent}echo \$form->checkBoxGroup(\$model, '{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => '{$wrapperHtmlOptions} input-group-sm'),
{$indent}));\n";
            } else if (stripos($column->dbType, 'text') !== false) {
                return 
"{$indent}echo \$form->textAreaGroup(\$model, '{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-9 input-group-sm'),
    {$indent}'widgetOptions' => array('htmlOptions' => array('rows' => 10, 'cols' => 50)),
{$indent}));\n";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'passwordFieldGroup';
                } else {
                    $inputField = 'textFieldGroup';
                }
                if ($column->type !== 'string' || $column->size === null) {
                    if ($column->dbType == 'date') {
                        return 
"{$indent}echo \$form->datePickerGroup(\$model, '{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => '{$wrapperHtmlOptions} input-group-sm'),
    {$indent}'widgetOptions' => array(
        {$indent}'options' => array('language' => Yii::app()->language), 
    {$indent}),
    {$indent}'prepend' => '<i class=\"fa fa-calendar\"></i>',
    {$indent}'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
{$indent}));\n";
                    } else {
                        return 
"{$indent}echo \$form->{$inputField}(\$model, '{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => '{$wrapperHtmlOptions} input-group-sm'),
{$indent}));\n";
                    }
                } else {
                    if (strpos($column->dbType, 'enum(') !== false) {
                        $temp = $column->dbType;
                        $temp = str_replace('enum', 'array', $temp);
                        // FIXME: What. The. Seriously, parse the enum declaration from MySQL as an array definition in PHP?!
                        eval('$options = ' . $temp . ';');
                        $dropdown_options = "array(";
                        foreach ($options as $option) {
                            $dropdown_options .= "\"$option\" => \"$option\",";
                        }
                        $dropdown_options .= ")";
                        return 
"{$indent}echo \$form->dropDownListGroup(\$model,'{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => '{$wrapperHtmlOptions} input-group-sm'),
    {$indent}'widgetOptions' => array('data' => {$dropdown_options})
{$indent}));\n";
                    } else {
                        return 
"{$indent}echo \$form->{$inputField}(\$model, '{$column->name}', array(
    {$indent}'labelOptions' => array('class' => '{$labelOptions}'),
    {$indent}'wrapperHtmlOptions' => array('class' => '{$wrapperHtmlOptions} input-group-sm'),
    {$indent}'widgetOptions' => array('htmlOptions' => array('maxlength' => {$column->size})),
{$indent}));\n";
                    }
                }
            }
        }
    }

}
