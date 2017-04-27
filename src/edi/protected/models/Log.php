<?php

/**
 * This is the model class for table 'lg1_log'.
 *
 * The followings are the available columns in table 'lg1_log':
 * @property string $LOG_ID
 * @property string $LOG_DESCRIPTION
 * @property integer $LOG_UPDATED_BY
 * @property string $LOG_UPDATED_ON
 * @property string $LOG_SHOW_DEFAULT
 * @property integer $CU1_ID
 * @property integer $VD1_ID
 * @property integer $ED1_ID
 * @property integer $US1_ID
 * @property string $LOG_FILENAME
 * @property integer $LOG_P21
 * @property integer $LOG_CHECKED
 * @property string $LOG_FILE_TYPE

 * The followings are the available model relations:
 */
class Log extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Log the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * REQUIRED
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lg1_log';
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
            array('CU1_ID, VD1_ID, ED1_ID, US1_ID', 'required'),
            array('LOG_UPDATED_BY, CU1_ID, VD1_ID, ED1_ID, US1_ID, LOG_P21, LOG_CHECKED', 'numerical', 'integerOnly'=>true),
            array('LOG_SHOW_DEFAULT', 'length', 'max'=>1),
            array('LOG_FILENAME', 'length', 'max'=>255),
            array('LOG_FILE_TYPE', 'length', 'max'=>20),
            array('LOG_DESCRIPTION, LOG_UPDATED_ON', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('LOG_ID, LOG_DESCRIPTION, LOG_UPDATED_BY, LOG_UPDATED_ON, LOG_SHOW_DEFAULT, CU1_ID, VD1_ID, ED1_ID, US1_ID, LOG_FILENAME, LOG_P21, LOG_CHECKED, LOG_FILE_TYPE', 'safe', 'on' => 'search'),

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
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'LOG_ID' => 'Log ID',
            'LOG_DESCRIPTION' => 'Log Description',
            'LOG_UPDATED_BY' => 'Log Updated By',
            'LOG_UPDATED_ON' => 'Log Updated On',
            'LOG_SHOW_DEFAULT' => 'Show Default',
            'CU1_ID' => 'Customer ID',
            'VD1_ID' => 'Vendor ID',
            'ED1_ID' => 'Edi ID',
            'US1_ID' => 'User ID',
            'LOG_FILENAME' => 'Filename',
            'LOG_P21' => 'P21',
            'LOG_CHECKED' => 'Log Checked',
            'LOG_FILE_TYPE' => 'Log File Type',
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Log::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.LOG_ID';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Log::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.LOG_ID, ' . $alias . '.LOG_DESCRIPTION',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.LOG_ID',
            ),
        );
    }

    /**
     * REQUIRED
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry if it is true
     * @return array
     */
    public static function getListData($criteria = null, $addEmptyItem = true)
    {
        if ($criteria === null) {
            $criteria = new CDbCriteria();
            $criteria->params = array();
        }
        $models = Log::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->LOG_ID)) {
                $rtv[$model->LOG_ID] = $model->LOG_DESCRIPTION;
            }
        }
        return $rtv;
    }

    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = Log::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array();
        $criteria->compare($alias . '.LOG_ID', $this->LOG_ID, true);
        $criteria->compare($alias . '.LOG_DESCRIPTION', $this->LOG_DESCRIPTION, true);
        $criteria->compare($alias . '.LOG_UPDATED_BY', $this->LOG_UPDATED_BY);
        $criteria->compare($alias . '.LOG_UPDATED_ON', $this->LOG_UPDATED_ON, true);
        $criteria->compare($alias . '.LOG_SHOW_DEFAULT', $this->LOG_SHOW_DEFAULT, true);
        $criteria->compare($alias . '.CU1_ID', $this->CU1_ID);
        $criteria->compare($alias . '.VD1_ID', $this->VD1_ID);
        $criteria->compare($alias . '.ED1_ID', $this->ED1_ID);
        $criteria->compare($alias . '.US1_ID', $this->US1_ID);
        $criteria->compare($alias . '.LOG_FILENAME', $this->LOG_FILENAME, true);
        $criteria->compare($alias . '.LOG_P21', $this->LOG_P21);
        $criteria->compare($alias . '.LOG_CHECKED', $this->LOG_CHECKED);
        $criteria->compare($alias . '.LOG_FILE_TYPE', $this->LOG_FILE_TYPE, true);
       $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    '*',
                ),
            ),
            'pagination' => $pageSize<1000 ? array('pageSize' => $pageSize) : false,
        ));
    }

    /**
     * Export data into Excel, CVS or PDF
     * @param boolean $stream true - export without footprint, false - export with footprint
     */
    public function export($stream)
    {
        return Yii::app()->export->exportData($this, array(
            'dataProvider' => null, 
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => $stream,
            'fileName' => Yii::t('app', 'Log').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'LOG_ID',
                    'label' => $this->getAttributeLabel('LOG_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_DESCRIPTION',
                    'label' => $this->getAttributeLabel('LOG_DESCRIPTION'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_UPDATED_BY',
                    'label' => $this->getAttributeLabel('LOG_UPDATED_BY'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_UPDATED_ON',
                    'label' => $this->getAttributeLabel('LOG_UPDATED_ON'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_SHOW_DEFAULT',
                    'label' => $this->getAttributeLabel('LOG_SHOW_DEFAULT'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'CU1_ID',
                    'label' => $this->getAttributeLabel('CU1_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'VD1_ID',
                    'label' => $this->getAttributeLabel('VD1_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED1_ID',
                    'label' => $this->getAttributeLabel('ED1_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'US1_ID',
                    'label' => $this->getAttributeLabel('US1_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_FILENAME',
                    'label' => $this->getAttributeLabel('LOG_FILENAME'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_P21',
                    'label' => $this->getAttributeLabel('LOG_P21'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_CHECKED',
                    'label' => $this->getAttributeLabel('LOG_CHECKED'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'LOG_FILE_TYPE',
                    'label' => $this->getAttributeLabel('LOG_FILE_TYPE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }

}

