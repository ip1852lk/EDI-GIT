<?php

/**
 * This is the model class for table 'ed2_edi_types'.
 *
 * The followings are the available columns in table 'ed2_edi_types':
 * @property integer $ED2_ID
 * @property integer $ED2_NUMBER
 * @property string $ED2_NAME

 * The followings are the available model relations:
 */
class EdiTypes extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EdiTypes the static model class
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
        return 'ed2_edi_types';
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
            array('ED2_NUMBER', 'required'),
            array('ED2_NUMBER', 'numerical', 'integerOnly'=>true),
            array('ED2_NAME', 'length', 'max'=>255),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('ED2_ID, ED2_NUMBER, ED2_NAME', 'safe', 'on' => 'search'),

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
            'ED2_ID' => 'Ed2',
            'ED2_NUMBER' => 'Ed2 Number',
            'ED2_NAME' => 'Ed2 Name',
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = EdiTypes::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.ED2_ID';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = EdiTypes::model()->getTableAlias(false, false);
        return array(
            'relation' => array(
                'select' => $alias . '.ED2_ID, ' . $alias . '.ED2_NUMBER',
                'together' => true,
                'with' => array(),
                'order' => $alias . '.ED2_ID',
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
        $models = EdiTypes::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->ED2_ID)) {
                $rtv[$model->ED2_ID] = $model->ED2_NUMBER;
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
        $alias = EdiTypes::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array();
        $criteria->compare($alias . '.ED2_ID', $this->ED2_ID);
        $criteria->compare($alias . '.ED2_NUMBER', $this->ED2_NUMBER);
        $criteria->compare($alias . '.ED2_NAME', $this->ED2_NAME, true);
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
            'fileName' => Yii::t('app', 'EdiTypes').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'ED2_ID',
                    'label' => $this->getAttributeLabel('ED2_ID'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED2_NUMBER',
                    'label' => $this->getAttributeLabel('ED2_NUMBER'),
                    'type' => PHPExcel_Cell_DataType::TYPE_NUMERIC,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ED2_NAME',
                    'label' => $this->getAttributeLabel('ED2_NAME'),
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

