<?php

/**
 * This is the model class for table 'no1_numbers'.
 *
 * The followings are the available columns in table 'no1_numbers':
 * @property string $NO1_TYPE
 * @property string $NO1_NUMBER
 * @property integer $CU1_ID
 * @property integer $VD1_ID
* @property integer $NO1_TEST_MODE

 * The followings are the available model relations:
 */
class Numbers extends JActiveRecord
{

    CONST MODE_TEST_FALSE = 0;
    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Numbers the static model class
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
        return 'no1_numbers';
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
            array('CU1_ID, VD1_ID', 'numerical', 'integerOnly'=>true),
            array('NO1_TYPE, NO1_NUMBER', 'length', 'max'=>45),
            array('NO1_TEST_MODE', 'length', 'max'=>1),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('NO1_TYPE, NO1_NUMBER, CU1_ID, VD1_ID', 'safe', 'on' => 'search'),

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
            'NO1_TYPE' => 'No1 Type',
            'NO1_NUMBER' => 'No1 Number',
            'CU1_ID' => 'Cu1',
            'VD1_ID' => 'Vd1',
            'NO1_TEST_MODE' => 'Test Mode',
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Numbers::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.NO1_TYPE';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Numbers::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.NO1_TYPE, ' . $alias . '.NO1_NUMBER',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.NO1_TYPE',
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
        $models = Numbers::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->NO1_TYPE)) {
                $rtv[$model->NO1_TYPE] = $model->NO1_NUMBER;
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
        $alias = Numbers::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array();
        $criteria->compare($alias . '.NO1_TYPE', $this->NO1_TYPE, true);
        $criteria->compare($alias . '.NO1_NUMBER', $this->NO1_NUMBER, true);
        $criteria->compare($alias . '.CU1_ID', $this->CU1_ID);
        $criteria->compare($alias . '.VD1_ID', $this->VD1_ID);
        $criteria->compare($alias . '.NO1_TEST_MODE', $this->NO1_TEST_MODE);
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
            'fileName' => Yii::t('app', 'Numbers').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'NO1_TYPE',
                    'label' => $this->getAttributeLabel('NO1_TYPE'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 60,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'NO1_NUMBER',
                    'label' => $this->getAttributeLabel('NO1_NUMBER'),
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
            ),
        ));
    }

    public function afterSave()
    {
        //parent::afterSave(); // TODO: Change the autogenerated stub
        return true;
    }

}

