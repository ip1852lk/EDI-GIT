<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Location $location
 */
class Profile extends UActiveRecord
{

    /**
     * The followings are the available columns in table 'profiles':
     * @var integer $user_id
     * @var boolean $regMode
     */
    public $regMode = false;
    private $_model;
    private $_modelReg;
    private $_rules = array();

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return Yii::app()->getModule('user')->tableProfiles;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        if (!$this->_rules) {
            $required = array();
            $numerical = array();
            $float = array();
            $decimal = array();
            $rules = array();
            $search = array();
            $safe = array();
            $models = $this->getFields();
            foreach ($models as $field) {
                $field_rule = array();
                if ($field->required == ProfileField::REQUIRED_YES_NOT_SHOW_REG || $field->required == ProfileField::REQUIRED_YES_SHOW_REG)
                    array_push($required, $field->varname);
                if ($field->field_type == 'FLOAT')
                    array_push($float, $field->varname);
                if ($field->field_type == 'DECIMAL')
                    array_push($decimal, $field->varname);
                if ($field->field_type == 'INTEGER')
                    array_push($numerical, $field->varname);
                if ($field->field_type == 'VARCHAR' || $field->field_type == 'TEXT') {
                    $field_rule = array($field->varname, 'length', 'max' => $field->field_size, 'min' => $field->field_size_min, 'on' => 'insert, update');
                    if ($field->error_message)
                        $field_rule['message'] = Yii::t('app', $field->error_message);
                    array_push($rules, $field_rule);
                }
                if ($field->other_validator) {
                    if (strpos($field->other_validator, '{') === 0) {
                        $validator = (array) CJavaScript::jsonDecode($field->other_validator);
                        foreach ($validator as $name => $val) {
                            $field_rule = array($field->varname, $name);
                            $field_rule = array_merge($field_rule, (array) $validator[$name]);
                            if ($field->error_message)
                                $field_rule['message'] = Yii::t('app', $field->error_message);
                            $field_rule['on'] = 'insert, update';
                            array_push($rules, $field_rule);
                        }
                    } else {
                        $field_rule = array($field->varname, $field->other_validator);
                        if ($field->error_message)
                            $field_rule['message'] = Yii::t('app', $field->error_message);
                        $field_rule['on'] = 'insert, update';
                        array_push($rules, $field_rule);
                    }
                }
//                elseif ($field->field_type == 'DATE') {
//                    $field_rule = array($field->varname, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty' => true, 'on' => 'insert, update');
//                    if ($field->error_message)
//                        $field_rule['message'] = Yii::t('app', $field->error_message);
//                    array_push($rules, $field_rule);
//                }
                if ($field->match) {
                    $field_rule = array($field->varname, 'match', 'pattern' => $field->match, 'on' => 'insert, update');
                    if ($field->error_message)
                        $field_rule['message'] = Yii::t('app', $field->error_message);
                    array_push($rules, $field_rule);
                }
                if ($field->range) {
                    $field_rule = array($field->varname, 'in', 'range' => self::rangeRules($field->range), 'on' => 'insert, update');
                    if ($field->error_message)
                        $field_rule['message'] = Yii::t('app', $field->error_message);
                    array_push($rules, $field_rule);
                }
                if (isset($field->widget) && strlen($field->widget) > 0)
                    array_push($safe, $field->varname);
                array_push($search, $field->varname);
            }
            array_push($rules, array(implode(',', $required), 'required', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $numerical), 'numerical', 'integerOnly' => true, 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $float), 'type', 'type' => 'float', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $decimal), 'match', 'pattern' => '/^\s*[\-\+]?[0-9]*\.?[0-9]+([eE][\-\+]?[0-9]+)?\s*$/', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $safe), 'safe', 'on' => 'insert, update'));
            array_push($rules, array(implode(',', $search), 'safe', 'on' => 'search', 'on' => 'insert, update'));
            // The following rules are used by relations where this model is used
            // as a reference in another model
            array_push($rules, array('first_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'User cannot be blank.')));
            $this->_rules = $rules;
        }
        return $this->_rules;
    }

    /**
     * REQUIRED
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relations = array(
            'user' => array(self::HAS_ONE, 'User', 'user_id',),
        );
        if (isset(Yii::app()->getModule('user')->profileRelations))
            $relations = array_merge($relations, Yii::app()->getModule('user')->profileRelations);
        return $relations;
    }

    public function getFullname()
    {
        $fullname = '';
        if (isset($this->first_name) && $this->first_name !== null)
            $fullname .= $this->first_name;
        if (isset($this->last_name) && $this->last_name !== null)
            $fullname .= (strlen($fullname) > 0 ? ' ' : '') . $this->last_name;
        return $fullname;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $labels = array(
            'user_id' => Yii::t('app', 'User ID'),
        );
        $model = $this->getFields();
        foreach ($model as $field)
            $labels[$field->varname] = ((Yii::app()->getModule('user')->fieldsMessage) ? Yii::t('app', $field->title, array(), Yii::app()->getModule('user')->fieldsMessage) : Yii::t('app', $field->title));
        return $labels;
    }

    public static function logAlias($attribute, $value)
    {
        $result = $value;
        $itemAliasKeys = array(
            'user_type' => 'userTypes',
        );
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = User::itemAlias($itemAliasKeys[$attribute], $value);
            if (!$result)
                $result = $value;
        }
        return $result;
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Profile::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    private function rangeRules($str)
    {
        $rules = explode(';', $str);
        for ($i = 0; $i < count($rules); $i++)
            $rules[$i] = current(explode("==", $rules[$i]));
        return $rules;
    }

    public static function range($str, $fieldValue = NULL)
    {
        $rules = explode(';', $str);
        $array = array();
        for ($i = 0; $i < count($rules); $i++) {
            $item = explode("==", $rules[$i]);
            if (isset($item[0]))
                $array[$item[0]] = ((isset($item[1])) ? $item[1] : $item[0]);
        }
        if (isset($fieldValue)) {
            if (isset($array[$fieldValue]))
                return $array[$fieldValue];
            else
                return '';
        } else
            return $array;
    }

    public function widgetAttributes()
    {
        $data = array();
        $model = $this->getFields();
        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widget;
        }
        return $data;
    }

    public function widgetParams($fieldName)
    {
        $data = array();
        $model = $this->getFields();
        foreach ($model as $field) {
            if ($field->widget)
                $data[$field->varname] = $field->widgetparams;
        }
        return $data[$fieldName];
    }

    public function getFields()
    {
        if ($this->regMode) {
            if (!$this->_modelReg)
                $this->_modelReg = ProfileField::model()->forRegistration()->findAll();
            return $this->_modelReg;
        } else {
            if (!$this->_model) {
                if (Yii::app()->user->checkAccess('Admin')) {
                    $this->_model = ProfileField::model()->forAdmin()->sort()->findAll();
                } else {
                    $this->_model = ProfileField::model()->forUser()->sort()->findAll();
                }
            }
            return $this->_model;
        }
    }

}
