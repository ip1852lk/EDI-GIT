<?php

class ProfileField extends CActiveRecord
{

    const VISIBLE_NO = 0;
    const VISIBLE_ADMIN = 1;
    const VISIBLE_REGISTER_USER = 2;
    const VISIBLE_ONLY_OWNER = 3;
    const VISIBLE_ALL = 4;
    const REQUIRED_NO = 0;
    const REQUIRED_YES_SHOW_REG = 1;
    const REQUIRED_NO_SHOW_REG = 2;
    const REQUIRED_YES_NOT_SHOW_REG = 3;

    /**
     * The followings are the available columns in table 'profiles_fields':
     * @var integer $id
     * @var string $varname
     * @var string $title
     * @var string $field_type
     * @var integer $field_size
     * @var integer $field_size_mix
     * @var integer $required
     * @var integer $match
     * @var string $range
     * @var string $error_message
     * @var string $other_validator
     * @var string $default
     * @var integer $position
     * @var integer $visible
     */

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
        return Yii::app()->getModule('user')->tableProfileFields;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('varname, title, field_type', 'required'),
            array('varname', 'match', 'pattern' => '/^[A-Za-z_0-9]+$/u', 'message' => Yii::t('app', "Variable name may consist of A-z, 0-9, underscores, begin with a letter.")),
            array('varname', 'unique', 'message' => Yii::t('app', "This field already exists.")),
            array('varname, field_type', 'length', 'max' => 50),
            array('field_size_min, required, position, visible', 'numerical', 'integerOnly' => true),
            array('field_size', 'match', 'pattern' => '/^\s*[\-\+]?[0-9]*\,*\.?[0-9]+([eE][\-\+]?[0-9]+)?\s*$/'),
            array('title, match, error_message, other_validator, default, widget', 'length', 'max' => 255),
            array('range, widgetparams', 'length', 'max' => 5000),
            array('id, varname, title, field_type, field_size, field_size_min, required, match, range, error_message, other_validator, default, widget, widgetparams, position, visible', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'Id'),
            'varname' => Yii::t('app', 'Variable Name'),
            'title' => Yii::t('app', 'Title'),
            'field_type' => Yii::t('app', 'Field Type'),
            'field_size' => Yii::t('app', 'Field Size'),
            'field_size_min' => Yii::t('app', 'Field Size Min'),
            'required' => Yii::t('app', 'Required'),
            'match' => Yii::t('app', 'Match'),
            'range' => Yii::t('app', 'Range'),
            'error_message' => Yii::t('app', 'Error Message'),
            'other_validator' => Yii::t('app', 'Other Validator'),
            'default' => Yii::t('app', 'Default'),
            'widget' => Yii::t('app', 'Widget'),
            'widgetparams' => Yii::t('app', 'Widget Parametrs'),
            'position' => Yii::t('app', 'Position'),
            'visible' => Yii::t('app', 'Visible'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'field_type' => array(
                'INTEGER' => Yii::t('app', 'INTEGER'),
                'VARCHAR' => Yii::t('app', 'VARCHAR'),
                'TEXT' => Yii::t('app', 'TEXT'),
                'DATE' => Yii::t('app', 'DATE'),
                'FLOAT' => Yii::t('app', 'FLOAT'),
                'DECIMAL' => Yii::t('app', 'DECIMAL'),
                'BOOL' => Yii::t('app', 'BOOL'),
                'BLOB' => Yii::t('app', 'BLOB'),
                'BINARY' => Yii::t('app', 'BINARY'),
            ),
            'field_type_search' => array(
                '' => '',
                'INTEGER' => Yii::t('app', 'INTEGER'),
                'VARCHAR' => Yii::t('app', 'VARCHAR'),
                'TEXT' => Yii::t('app', 'TEXT'),
                'DATE' => Yii::t('app', 'DATE'),
                'FLOAT' => Yii::t('app', 'FLOAT'),
                'DECIMAL' => Yii::t('app', 'DECIMAL'),
                'BOOL' => Yii::t('app', 'BOOL'),
                'BLOB' => Yii::t('app', 'BLOB'),
                'BINARY' => Yii::t('app', 'BINARY'),
            ),
            'required' => array(
                self::REQUIRED_NO => Yii::t('app', 'No'),
                self::REQUIRED_NO_SHOW_REG => Yii::t('app', 'No, but show on registration form'),
                self::REQUIRED_YES_SHOW_REG => Yii::t('app', 'Yes and show on registration form'),
                self::REQUIRED_YES_NOT_SHOW_REG => Yii::t('app', 'Yes'),
            ),
            'required_search' => array(
                '' => '',
                self::REQUIRED_NO => Yii::t('app', 'No'),
                self::REQUIRED_NO_SHOW_REG => Yii::t('app', 'No, but show on registration form'),
                self::REQUIRED_YES_SHOW_REG => Yii::t('app', 'Yes and show on registration form'),
                self::REQUIRED_YES_NOT_SHOW_REG => Yii::t('app', 'Yes'),
            ),
            'visible' => array(
                self::VISIBLE_ALL => Yii::t('app', 'For All'),
                self::VISIBLE_ONLY_OWNER => Yii::t('app', 'Only Owner'),
                self::VISIBLE_REGISTER_USER => Yii::t('app', 'Registered Users'),
                self::VISIBLE_ADMIN => Yii::t('app', 'Administrators'),
                self::VISIBLE_NO => Yii::t('app', 'Hidden'),
            ),
            'visible_search' => array(
                '' => '',
                self::VISIBLE_ALL => Yii::t('app', 'For All'),
                self::VISIBLE_ONLY_OWNER => Yii::t('app', 'Only Owner'),
                self::VISIBLE_REGISTER_USER => Yii::t('app', 'Registered Users'),
                self::VISIBLE_ADMIN => Yii::t('app', 'Administrators'),
                self::VISIBLE_NO => Yii::t('app', 'Hidden'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function logAlias($attribute, $value)
    {
        $result = $value;
        $itemAliasKeys = array(
            'field_type' => 'field_type',
            'required' => 'required',
            'visible' => 'visible',
        );
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = self::itemAlias($itemAliasKeys[$attribute], $value);
            if (!$result) 
                $result = $value;
        }
        return $result;
    }

    public function scopes()
    {
        return array(
            'forAll' => array(
                'condition' => 'visible=' . self::VISIBLE_ALL,
                'order' => 'position',
            ),
            'forOwner' => array(
                'condition' => 'visible>=' . self::VISIBLE_ONLY_OWNER,
                'order' => 'position',
            ),
            'forUser' => array(
                'condition' => 'visible>=' . self::VISIBLE_REGISTER_USER,
                'order' => 'position',
            ),
            'forAdmin' => array(
                'condition' => 'visible>=' . self::VISIBLE_ADMIN,
                'order' => 'position',
            ),
            'forRegistration' => array(
                'condition' => 'required=' . self::REQUIRED_NO_SHOW_REG . ' OR required=' . self::REQUIRED_YES_SHOW_REG,
                'order' => 'position',
            ),
            'sort' => array(
                'order' => 'position',
            ),
        );
    }

    /**
     * @param $model
     * @return formated value (string)
     */
    public function widgetView($model)
    {
        if ($this->widget && class_exists($this->widget)) {
            $widgetClass = new $this->widget;

            $arr = $this->widgetparams;
            if ($arr) {
                $newParams = $widgetClass->params;
                $arr = (array) CJavaScript::jsonDecode($arr);
                foreach ($arr as $p => $v) {
                    if (isset($newParams[$p]))
                        $newParams[$p] = $v;
                }
                $widgetClass->params = $newParams;
            }
            if (method_exists($widgetClass, 'viewAttribute')) {
                return $widgetClass->viewAttribute($model, $this);
            }
        }
        return false;
    }

    public function widgetEdit($model, $htmlOptions = array(), $form = null)
    {
        if ($this->widget && class_exists($this->widget)) {
            $widgetClass = new $this->widget;
            $arr = $this->widgetparams;
            if ($arr) {
                $newParams = $widgetClass->params;
                $arr = (array) CJavaScript::jsonDecode($arr);
                foreach ($arr as $p => $v) {
                    if (isset($newParams[$p]))
                        $newParams[$p] = $v;
                }
                $widgetClass->params = $newParams;
            }
            if (method_exists($widgetClass, 'editAttribute')) {
                return $widgetClass->editAttribute($model, $this, $htmlOptions, $form);
            }
        }
        return false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('varname', $this->varname, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('field_type', $this->field_type, true);
        $criteria->compare('field_size', $this->field_size);
        $criteria->compare('field_size_min', $this->field_size_min);
        $criteria->compare('required', $this->required);
        $criteria->compare('match', $this->match, true);
        $criteria->compare('range', $this->range, true);
        $criteria->compare('error_message', $this->error_message, true);
        $criteria->compare('other_validator', $this->other_validator, true);
        $criteria->compare('default', $this->default, true);
        $criteria->compare('widget', $this->widget, true);
        $criteria->compare('widgetparams', $this->widgetparams, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('visible', $this->visible);
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'position',
            ),
            'pagination' => $pageSize<1000 ? array('pageSize' => $pageSize) : false,
        ));
    }

    /**
     * Export data into Excel, CVS or PHP
     * @param boolean $stream true - export without footprint, false - export with footprint
     */
    public function export($stream)
    {
        return Yii::app()->export->exportData($this, array(
            'dataProvider' => null, 
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => $stream,
            'fileName' => Yii::t('app', 'Profile-Fields').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'varname',
                    'label' => $this->getAttributeLabel('varname'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 20,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'title',
                    'label' => $this->getAttributeLabel('title'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'field_type',
                    'label' => $this->getAttributeLabel('field_type'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => null,
                    'itemAlias' => array('class' => 'ProfileField', 'type' => 'field_type'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'field_size',
                    'label' => $this->getAttributeLabel('field_size'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'required',
                    'label' => $this->getAttributeLabel('required'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 40,
                    'value' => null,
                    'itemAlias' => array('class' => 'ProfileField', 'type' => 'required'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'position',
                    'label' => $this->getAttributeLabel('position'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'visible',
                    'label' => $this->getAttributeLabel('visible'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 40,
                    'value' => null,
                    'itemAlias' => array('class' => 'ProfileField', 'type' => 'visible'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }
    
}
