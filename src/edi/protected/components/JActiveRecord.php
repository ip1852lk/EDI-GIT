<?php

/**
 * Description of JActiveRecord
 *
 * @author JB
 */
class JActiveRecord extends CActiveRecord
{

    const CREATED_BY = 'created_by';
    const CREATED_ON = 'created_on';
    const MODIFIED_BY = 'modified_by';
    const MODIFIED_ON = 'modified_on';
    const DELETE_FLAG = 'delete_flag';
    const UPDATE_FLAG = 'update_flag';

    // Attributes
    public $createdByAttribute = self::CREATED_BY;
    public $createdOnAttribute = self::CREATED_ON;
    public $modifiedByAttribute = self::MODIFIED_BY;
    public $modifiedOnAttribute = self::MODIFIED_ON;
    public $deleteAttribute = self::DELETE_FLAG;
    public $deletedValue = 1;
    private $_oldAttributes = array();

    public function getOldAttributes()
    {
        return $this->_oldAttributes;
    }

    public function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }

    // Logging
    private $_excludedTablesFromLogging = array(
        'RegistrationForm',
        'TableLog',
        'UserLog',
    );

    public function getExcludedTablesFromLogging()
    {
        return $this->_excludedTablesFromLogging;
    }

    public function setExcludedTablesFromLogging($tables)
    {
        if (is_array($tables)) {
            $this->_excludedTablesFromLogging = $tables;
        }
    }

    public function excludeTableFromLogging($table)
    {
        if (is_string($table)) {
            if (!array_key_exists($table, $this->getExcludedTablesFromLogging())) {
                $this->_excludedTablesFromLogging[] = $table;
            }
        } elseif (is_array($table)) {
            foreach ($table as $t) {
                if (is_string($t)) {
                    if (!array_key_exists($t, $this->getExcludedTablesFromLogging())) {
                        $this->_excludedTablesFromLogging[] = $t;
                    }
                }
            }
        }
    }

    private $_excludedAttributesFromLogging = array(
        'delete_flag',
        'update_flag',
        'activkey',
        'lastvisit_at',
    );
 
    public function getExcludedAttributesFromLogging()
    {
        return array_merge($this->_excludedAttributesFromLogging, array(
            self::CREATED_BY,
            self::CREATED_ON,
            self::MODIFIED_BY,
            self::MODIFIED_ON,
            self::DELETE_FLAG,
            self::UPDATE_FLAG,
        ));
    }

    public function setExcludedAttributesFromLogging($attributes)
    {
        if (is_array($attributes)) {
            $this->_excludedAttributesFromLogging = $attributes;
        }
    }

    public function excludeAttributeFromLogging($attribute)
    {
        if (is_string($attribute)) {
            if (!array_key_exists($attribute, $this->getExcludedAttributesFromLogging())) {
                $this->_excludedAttributesFromLogging[] = $attribute;
            }
        } elseif (is_array($attribute)) {
            foreach ($attribute as $att) {
                if (is_string($att)) {
                    if (!array_key_exists($att, $this->getExcludedAttributesFromLogging())) {
                        $this->_excludedAttributesFromLogging[] = $att;
                    }
                }
            }
        }
    }

    // Item Alias
    /**
     * @inheritdoc
     */
    public static function itemAlias($type, $code = NULL)
    {
        $_items = array();
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    // Log Alias
    /**
     * @inheritdoc
     */
    public static function logAlias($attribute, $value)
    {
        $result = $value;
        $itemAliasKeys = array();
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = self::itemAlias($itemAliasKeys[$attribute], $value);
            if (!$result) 
                $result = $value;
        }
        return $result;
    }

    // Find
    /**
     * @inheritdoc
     */
    protected function afterFind()
    {
        parent::afterFind();
        $this->setOldAttributes($this->getAttributes());
    }

    // Save
    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        if (!defined('YII_CRON_JOB')) {
            $metaData = $this->getMetaData();
            if ($this->scenario == 'insert' &&
                $this->createdByAttribute !== null &&
                $metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->createdByAttribute, $metaData->columns)
            ) {
                $this->{$this->createdByAttribute} = Yii::app()->user->isGuest ? 1 : Yii::app()->user->getId();
            }
            if ($this->scenario == 'insert' &&
                $this->createdOnAttribute !== null &&
                $metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->createdOnAttribute, $metaData->columns)
            ) {
                $this->{$this->createdOnAttribute} = new CDbExpression('NOW()');
            }
            if ($this->modifiedByAttribute !== null &&
                $metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->modifiedByAttribute, $metaData->columns)
            ) {
                $this->{$this->modifiedByAttribute} = Yii::app()->user->isGuest ? 1 : Yii::app()->user->getId();
            }
            if ($this->modifiedOnAttribute !== null &&
                $metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->modifiedOnAttribute, $metaData->columns)
            ) {
                $this->{$this->modifiedOnAttribute} = new CDbExpression('NOW()');
            }
        }
        return parent::beforeSave();
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        // Logging changes
        $id = $this->getPrimaryKey();
        $class = get_class($this);
        if (!in_array($class, $this->getExcludedTablesFromLogging()) && isset($id) && !defined('YII_CRON_JOB')) {
            $log = new TableLog('insert');
            if ($this->isNewRecord) {
                $log->description = 
                    Yii::app()->user->Name . ' created <span class="label label-primary">' . $class . '</span> <span class="badge alert-success">' . $id . '</span>';
                $log->log_action = TableLog::LOG_ACTION_CREATE;
                $log->model_id = $id;
                $log->model = $class;
                $log->save();
            } else {
                $newAttributes = $this->getAttributes();
                $oldAttributes = $this->getOldAttributes();
                $log->description = '';
                foreach ($newAttributes as $attribute => $value) {
                    if (!in_array($attribute, $this->getExcludedAttributesFromLogging())) {
                        if (!empty($oldAttributes)) {
                            $old = $oldAttributes[$attribute];
                        } else {
                            $old = '';
                        }
                        if ((string)$value !== (string)$old) {
                            if (strlen($log->description) > 0) $log->description .= '<br>';
                            $log->description .= 
                                '<span class="label label-primary">'.$this->getAttributeLabel($attribute) . ' | ' . $attribute . '</span> ' . 
                                '<span class="badge alert-danger">' . $class::logAlias($attribute, $old) . '</span> >> <span class="badge alert-success">' . $class::logAlias($attribute, $value) . '</span>';
                        }
                    }
                }
                if (strlen($log->description) > 0) {
                    $log->log_action = TableLog::LOG_ACTION_UPDATE;
                    $log->model_id = $id;
                    $log->model = $class;
                    $log->save();
                }
            }
        }
        parent::afterSave();
    }

    // Delete
    /**
     * @inheritdoc
     */
    protected function beforeDelete()
    {
        $metaData = $this->getMetaData();
        if ($metaData !== null &&
            $metaData->columns !== null &&
            array_key_exists($this->deleteAttribute, $metaData->columns))
        {
            // Logging changes
            $id = $this->getPrimaryKey();
            $class = get_class($this);
            if (!in_array($class, $this->getExcludedTablesFromLogging()) && isset($id)) {
                $log = new TableLog('insert');
                $log->description = Yii::app()->user->Name . ' deleted <span class="label label-primary">' . $class . '</span> <span class="badge alert-danger">' . $id . '</span>';
                $log->log_action = TableLog::LOG_ACTION_DELETE;
                $log->model_id = $id;
                $log->model = $class;
                $log->save();
            }
            // Vertually delete this reacord
            $attributes = array();
            if ($metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->deleteAttribute, $metaData->columns))
            {
                $this->{$this->deleteAttribute} = $this->deletedValue;
                $attributes[] = $this->deleteAttribute;
            }
            if ($metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->modifiedByAttribute, $metaData->columns))
            {
                $this->{$this->modifiedByAttribute} = Yii::app()->user->isGuest ? 1 : Yii::app()->user->getId();
                $attributes[] = $this->modifiedByAttribute;
            }
            if ($metaData !== null &&
                $metaData->columns !== null &&
                array_key_exists($this->modifiedOnAttribute, $metaData->columns))
            {
                $this->{$this->modifiedOnAttribute} = new CDbExpression('NOW()');
                $attributes[] = $this->modifiedOnAttribute;
            }
            $this->update($attributes);
            return false;   // Prevent the user deleting this model from database
        } else {
            return parent::beforeDelete();
        }
    }

    // Scope
    /**
     * @inheritdoc
     */
    public function defaultScope()
    {
        $scope = new CDbCriteria();
        $keys = array_keys($this->behaviors());
        foreach ($keys as $key) {
            $behavior = $this->asa($key);
            if ($behavior && $behavior->enabled && method_exists($behavior, 'defaultScope')) {
                $scope->mergeWith($behavior->defaultScope());
            }
        }
        return $scope;
    }

    /**
     * Insert multiple models using a single query.
     * @param array $rows [{'column1' => 'value1', 'column2' => 'value2' ...}]
     * @return int
     */
    public function insertMultipleModels($rows)
    {
        //$columns = $this->getMetaData()->columns;
        $sql = '';
        $params = array();
        $rowCount = 0;
        foreach ($rows as $row) {
            $columns = array();
            $values = array();
            foreach ($row as $column => $value) {
                if (!$rowCount) {
                    $columns[] = $this->dbConnection->quoteColumnName($column);
                }
                if ($value instanceof CDbExpression) {
                    $values[] = $value->expression;
                    foreach ($value->params as $n => $v) {
                        $params[$n] = $v;
                    }
                } else {
                    $values[] = ':'.$column.$rowCount;
                    $params[':'.$column.$rowCount] = $value;
                }
            }
            if (!$rowCount) {
                $sql = 'INSERT INTO '.$this->tableName().' ('.
                    implode(', ', $columns).
                    ') VALUES ('.
                    implode(', ', $values) . ')';
            } else {
                $sql .= ',('.implode(', ', $values).')';
            }
            $rowCount++;
        }
        return !empty($sql) ? $this->dbConnection->createCommand($sql)->execute($params) : 0;
    }

}

?>
