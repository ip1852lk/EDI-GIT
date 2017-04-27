<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name => CDbColumnSchema)
 * - $labels: list of attribute labels (name => label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */

// 
$count = 0;
$firstColumn = "";
$secondColumn = "";
foreach($columns as $column) {
    if ($count == 0) $firstColumn = $column->name;
    if ($count == 1) $secondColumn = $column->name;
    if ($count == 2) break;
    $count++;
}
// Annotations
$attributeAnnotations = "";
foreach($columns as $column) {
    $attributeAnnotations .= " * @property {$column->type} \${$column->name}\n";
}
$relationAnnotation = "";
foreach($relations as $name => $relation) {
    if (preg_match("~^array\\(self::([^,]+), '([^']+)', '([^']+)'\\)$~", $relation, $matches)) {
        $relationType = $matches[1];
        $relationModel = $matches[2];
        switch($relationType){
            case 'HAS_ONE':
            case 'BELONGS_TO':
                $relationAnnotation .= " * @property {$relationModel} \${$name}\n";
                break;
            case 'HAS_MANY':
            case 'MANY_MANY':
                $relationAnnotation .= " * @property {$relationModel}[] \${$name}\n";
                break;
            default:
                $relationAnnotation .= " * @property mixed \${$name}\n";
        }
    }
}
//
$ruleDefinitions = "";
foreach ($rules as $rule) {
    $ruleDefinitions .= "            {$rule},\n";
}
$searchRuleDefinition1 = implode(', ', array_keys($columns));
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    $searchRuleDefinition = "            array('{$searchRuleDefinition1}, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),\n";
} else {
    $searchRuleDefinition = "            array('{$searchRuleDefinition1}', 'safe', 'on' => 'search'),\n";
}
//
$relationDefinitions = "";
foreach ($relations as $name => $relation) {
    $relationDefinitions .= "            '{$name}' => {$relation},\n";
}
//
$attributeLabels = "";
foreach ($labels as $name => $label) {
    $attributeLabels .= "            '{$name}' => '{$label}',\n";
}
//
$withRelations = "";
foreach ($relations as $name => $relation) {
    if (preg_match("~^array\\(self::([^,]+), '([^']+)', '([^']+)'\\)$~", $relation, $matches)) {
        $relationType = $matches[1];
        $relationModel = $matches[2];
        if ($relationType === 'HAS_ONE' || $relationType === 'BELONGS_TO')
            $withRelations .= "'{$name}', ";
    }
}
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    $withRelations .= "'cprofile', 'mprofile',";
}
$filters = "";
foreach ($columns as $name => $column) {
    if (!array_key_exists($name, $this->excludedColumns)) {
        if ($column->type === 'string')
            $filters .= "        \$criteria->compare(\$alias . '.{$name}', \$this->{$name}, true);\n";
        else
            $filters .= "        \$criteria->compare(\$alias . '.{$name}', \$this->{$name});\n";
    }
}
//
$exportColumns = "";
foreach ($columns as $name => $column) {
    if (!array_key_exists($name, $this->excludedColumns)) {
        if ($column->type === 'integer' || $column->type === 'double') {
            $columnType = "TYPE_NUMERIC";
            $columnSize = 25;
        } elseif ($column->type === 'boolean') {
            $columnType = "TYPE_BOOL";
            $columnSize = 25;
        } else {
            $columnType = "TYPE_STRING";
            $columnSize = 60;
        }
        $exportColumns .= "                array(
                    'field' => '{$name}',
                    'label' => \$this->getAttributeLabel('{$name}'),
                    'type' => PHPExcel_Cell_DataType::{$columnType},
                    'value' => null,
                    'width' => {$columnSize},
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),\n";
    }
}
//
echo
"<?php

/**
 * This is the model class for table '{$tableName}'.
 *
 * The followings are the available columns in table '{$tableName}':
{$attributeAnnotations}
 * The followings are the available model relations:
{$relationAnnotation}";
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    " * @property Profile \$cprofile
 * @property Profile \$mprofile\n";
}
echo
" */
class {$modelClass} extends {$this->baseClass}
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string \$className active record class name.
     * @return {$modelClass} the static model class
     */
    public static function model(\$className = __CLASS__)
    {
        return parent::model(\$className);
    }\n";
if ($connectionId != 'db') {
    echo
    "
    /**
     * REQUIRED
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->{$connectionId};
    }\n";
}
echo
"
    /**
     * REQUIRED
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{$tableName}';
    }

    /**
     * REQUIRED
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
{$ruleDefinitions}
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
{$searchRuleDefinition}
            // Rules for relations
            //array('REQUIRED_COLUMNS_ONLY_FOR_RELATION_SEPARATED_BY_COMMA', 'required', 'on' => 'relation'),
        );
    }

    /**
     * REQUIRED
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
{$relationDefinitions}";
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),\n";
}
echo
"        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
{$attributeLabels}";
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),\n";
}
echo
"        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        \$alias = {$modelClass}::model()->getTableAlias(false, false);
        \$scope = parent::defaultScope();
        \$scope->order = \$alias . '.{$firstColumn}';\n";
if ($this->useDefaultColumns == 1) {
    echo
    "        \$scope->condition = \$alias . '.delete_flag=0';\n";
}
echo
"        return \$scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        \$alias = {$modelClass}::model()->getTableAlias(false, false);
        return array(\n";
if ($this->useDefaultColumns == 1) {
    echo
    "            'deleted' => array(
                'condition' => \$alias . '.delete_flag=1',
            ),\n";
}
echo
"            'relation' => array(
                'select' => \$alias . '.{$firstColumn}, ' . \$alias . '.{$secondColumn}',
                'together' => true,
                'with' => array({$withRelations}),
                'order' => \$alias . '.{$firstColumn}',
            ),
        );
    }

    /**
     * REQUIRED
     * Returns a set of list data.
     * @param CDbCriteria \$criteria Search criteria
     * @param boolean \$addEmptyItem Add an empty entry if it is true
     * @return array
     */
    public static function getListData(\$criteria = null, \$addEmptyItem = true)
    {
        if (\$criteria === null) {
            \$criteria = new CDbCriteria();
            \$criteria->params = array();
        }
        \$models = {$modelClass}::model()->relation()->cache(10 * 60)->findAll(\$criteria);
        \$rtv = array();
        if (\$addEmptyItem) \$rtv['0'] = '';
        foreach (\$models as \$model) {
            if (isset(\$model->{$firstColumn})) {
                \$rtv[\$model->{$firstColumn}] = \$model->{$secondColumn};
            }
        }
        return \$rtv;
    }\n";
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "
    public \$cprofile_search;
    public \$mprofile_search;\n";
}
echo
"
    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        \$alias = {$modelClass}::model()->getTableAlias(false, false);
        \$criteria = new CDbCriteria();
        \$criteria->params = array();
        \$criteria->together = true;
        \$criteria->with = array({$withRelations});
{$filters}";
if ($this->useDefaultColumns == 1) {
    echo
    "        if (isset(\$this->created_on) && strlen(\$this->created_on) > 0) {
            \$criteria->addCondition(\"\$alias.created_on BETWEEN :created_on_1 AND :created_on_2\");
            \$criteria->params = array_merge(\$criteria->params, array(
                ':created_on_1' => date('Y-m-d', strtotime(\$this->created_on)).' 00:00:00',
                ':created_on_2' => date('Y-m-d', strtotime(\$this->created_on)).' 23:59:59',
            ));
        }
        if (isset(\$this->modified_on) && strlen(\$this->modified_on) > 0) {
            \$criteria->addCondition(\"\$alias.modified_on BETWEEN :modified_on_1 AND :modified_on_2\");
            \$criteria->params = array_merge(\$criteria->params, array(
                ':modified_on_1' => date('Y-m-d', strtotime(\$this->modified_on)).' 00:00:00',
                ':modified_on_2' => date('Y-m-d', strtotime(\$this->modified_on)).' 23:59:59',
            ));
        }\n";
}
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "        if (isset(\$this->cprofile_search) && strlen(\$this->cprofile_search) > 0) {
            \$criteria->addCondition('CONCAT(cprofile.first_name, \" \", cprofile.last_name) LIKE :cprofile_search');
            \$criteria->params = array_merge(\$criteria->params, array(':cprofile_search' => '%' . \$this->cprofile_search . '%'));
        }
        if (isset(\$this->mprofile_search) && strlen(\$this->mprofile_search) > 0) {
            \$criteria->addCondition(\"CONCAT(mprofile.first_name, ' ', mprofile.last_name) LIKE :mprofile_search\");
            \$criteria->params = array_merge(\$criteria->params, array(':mprofile_search' => '%' . \$this->mprofile_search . '%'));
        }\n";
}
echo
"       \$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider(\$this, array(
            'criteria' => \$criteria,
            'sort' => array(
                'attributes' => array(\n";
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "                    'cprofile_search' => array(
                        'asc' => 'cprofile.first_name, cprofile.last_name',
                        'desc' => 'cprofile.first_name DESC, cprofile.last_name DESC',
                    ),
                    'mprofile_search' => array(
                        'asc' => 'mprofile.first_name, mprofile.last_name',
                        'desc' => 'mprofile.first_name DESC, mprofile.last_name DESC',
                    ),\n";
}
echo
"                    '*',
                ),
            ),
            'pagination' => \$pageSize<1000 ? array('pageSize' => \$pageSize) : false,
        ));
    }

    /**
     * Export data into Excel, CVS or PDF
     * @param boolean \$stream true - export without footprint, false - export with footprint
     */
    public function export(\$stream)
    {
        return Yii::app()->export->exportData(\$this, array(
            'dataProvider' => null, 
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => \$stream,
            'fileName' => Yii::t('app', '{$modelClass}').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
{$exportColumns}";
if ($this->useDefaultColumns == 1) {
    echo
    "                array(
                    'field' => 'created_on',
                    'label' => \$this->getAttributeLabel('created_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime(\$value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_on',
                    'label' => \$this->getAttributeLabel('modified_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime(\$value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),\n";
}
if ($this->useDefaultColumns == 1 && $this->buildRelations == 1) {
    echo
    "                array(
                    'field' => 'created_by',
                    'label' => \$this->getAttributeLabel('cprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('cprofile->first_name', 'cprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_by',
                    'label' => \$this->getAttributeLabel('mprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('mprofile->first_name', 'mprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),\n";
}
echo
"            ),
        ));
    }

}

";