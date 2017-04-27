<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'su1_supplier':
 * @property integer $id
 * @property string $su1_code
 * @property string $su1_name
 * @property string $su1_phone
 * @property string $su1_fax
 * @property string $su1_url
 * @property string $su1_logo
 * @property string $su1_address1
 * @property string $su1_address2
 * @property string $su1_city
 * @property integer $st1_id
 * @property string $su1_postal_code
 * @property string $su1_country
 * @property integer $created_by
 * @property string $created_on
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag
 *
 * The followings are the available model relations:
 * @property Profile[] $users
 * @property State $state
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class Supplier extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Supplier the static model class
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
        return 'su1_supplier';
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
            array('su1_code', 'unique', 'on' => 'insert, update'),
            array('su1_code, su1_name', 'required', 'on' => 'insert, update'),
            array('st1_id, created_by, modified_by, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('su1_code', 'length', 'max' => 10),
            array('su1_name, su1_url, su1_logo, su1_address1, su1_address2', 'length', 'max' => 250),
            array('su1_url', 'url'),
            array('su1_logo', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => Yii::t('app', 'Size should be less then 2MB.'), 'allowEmpty' => true, 'safe' => true, 'on' => 'insert, update'),
            array('su1_name, su1_url, su1_logo, su1_address1, su1_address2', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            array('su1_phone, su1_fax, su1_postal_code', 'length', 'max' => 25),
            array('su1_city, su1_country', 'length', 'max' => 50),
            array('modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, su1_code, su1_name, su1_phone, su1_fax, su1_url, su1_logo, su1_address1, su1_address2, su1_city, st1_id, st1_search, su1_postal_code, su1_country, cprofile_search, created_by, created_on, mprofile_search, modified_by, modified_on, delete_flag, update_flag', 'safe', 'on' => 'search'),
            // Rules for relations
            array('su1_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Supplier cannot be blank.')),
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
            'users' => array(self::HAS_MANY, 'Profile', 'su1_id',),
            'state' => array(self::BELONGS_TO, 'State', 'st1_id',),
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'su1_code' => Yii::t('app', 'Supplier Code'),
            'su1_name' => Yii::t('app', 'Supplier Name'),
            'su1_phone' => Yii::t('app', 'Phone'),
            'su1_fax' => Yii::t('app', 'Fax'),
            'su1_url' => Yii::t('app', 'URL'),
            'su1_logo' => Yii::t('app', 'Logo'),
            'su1_address1' => Yii::t('app', 'Address1'),
            'su1_address2' => Yii::t('app', 'Address2'),
            'su1_city' => Yii::t('app', 'City'),
            'st1_id' => Yii::t('app', 'State'),
            'st1_search' => Yii::t('app', 'State'),
            'su1_postal_code' => Yii::t('app', 'Postal Code'),
            'su1_country' => Yii::t('app', 'Country'),
            'created_by' => Yii::t('app', 'Created By'),
            'cprofile_search' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Supplier::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.su1_code';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Supplier::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.su1_code, ' . $alias . '.su1_name',
                'together' => true,
                'with' => array('state', 'cprofile', 'mprofile',),
                'order' => $alias . '.su1_code',
            ),
        );
    }

    /**
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry
     * @return array
     */
    public static function getListData($criteria = null, $addEmptyItem = true)
    {
        if ($criteria === null) {
            $criteria = new CDbCriteria();
            $criteria->params = array();
        }
        $models = Supplier::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->su1_id) && isset($model->su1_name))
                $rtv[$model->id] = $model->su1_code . ' - ' . $model->su1_name;
        }
        return $rtv;
    }

    public $st1_search;
    public $cprofile_search;
    public $mprofile_search;

    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = Supplier::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria;
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('cprofile', 'mprofile', 'state',);
        $criteria->compare($alias.'.su1_code', $this->su1_code, true);
        $criteria->compare($alias.'.su1_name', $this->su1_name, true);
        $criteria->compare($alias.'.su1_phone', $this->su1_phone, true);
        $criteria->compare($alias.'.su1_fax', $this->su1_fax, true);
        $criteria->compare($alias.'.su1_url', $this->su1_url, true);
        $criteria->compare($alias.'.su1_logo', $this->su1_logo, true);
        $criteria->compare($alias.'.su1_address1', $this->su1_address1, true);
        $criteria->compare($alias.'.su1_address2', $this->su1_address2, true);
        $criteria->compare($alias.'.su1_city', $this->su1_city, true);
        if (isset($this->st1_id) && $this->st1_id > 0) {
            $criteria->compare($alias.'.st1_id', $this->st1_id);
        }
        $criteria->compare($alias.'.su1_postal_code', $this->su1_postal_code, true);
        $criteria->compare($alias.'.su1_country', $this->su1_country, true);
        if (isset($this->cprofile_search) && strlen($this->cprofile_search) > 0) {
            $criteria->addCondition('CONCAT(cprofile.first_name, " ", cprofile.last_name) LIKE :cprofile_search');
            $criteria->params = array_merge($criteria->params, array(':cprofile_search' => '%' . $this->cprofile_search . '%'));
        }
        if (isset($this->created_on) && strlen($this->created_on) > 0) {
            $criteria->addCondition("$alias.created_on BETWEEN :created_on_1 AND :created_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':created_on_1' => date('Y-m-d', strtotime($this->created_on)).' 00:00:00',
                ':created_on_2' => date('Y-m-d', strtotime($this->created_on)).' 23:59:59',
            ));
        }
        if (isset($this->mprofile_search) && strlen($this->mprofile_search) > 0) {
            $criteria->addCondition("CONCAT(mprofile.first_name, ' ', mprofile.last_name) LIKE :mprofile_search");
            $criteria->params = array_merge($criteria->params, array(':mprofile_search' => '%' . $this->mprofile_search . '%'));
        }
        if (isset($this->modified_on) && strlen($this->modified_on) > 0) {
            $criteria->addCondition("$alias.modified_on BETWEEN :modified_on_1 AND :modified_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':modified_on_1' => date('Y-m-d', strtotime($this->modified_on)).' 00:00:00',
                ':modified_on_2' => date('Y-m-d', strtotime($this->modified_on)).' 23:59:59',
            ));
        }
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'st1_search' => array(
                        'asc' => 'state.st1_code, state.st1_name',
                        'desc' => 'state.st1_code DESC, state.st1_name DESC',
                    ),
                    'cprofile_search' => array(
                        'asc' => 'cprofile.first_name, cprofile.last_name',
                        'desc' => 'cprofile.first_name DESC, cprofile.last_name DESC',
                    ),
                    'mprofile_search' => array(
                        'asc' => 'mprofile.first_name, mprofile.last_name',
                        'desc' => 'mprofile.first_name DESC, mprofile.last_name DESC',
                    ),
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
            'fileName' => Yii::t('app', 'Suppliers').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'su1_code',
                    'label' => $this->getAttributeLabel('su1_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_name',
                    'label' => $this->getAttributeLabel('su1_name'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_phone',
                    'label' => $this->getAttributeLabel('su1_phone'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_fax',
                    'label' => $this->getAttributeLabel('su1_fax'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_url',
                    'label' => $this->getAttributeLabel('su1_url'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_logo',
                    'label' => $this->getAttributeLabel('su1_logo'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_address1',
                    'label' => $this->getAttributeLabel('su1_address1'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_address2',
                    'label' => $this->getAttributeLabel('su1_address2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_city',
                    'label' => $this->getAttributeLabel('su1_city'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'st1_id',
                    'label' => $this->getAttributeLabel('st1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'state->st1_name',
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_postal_code',
                    'label' => $this->getAttributeLabel('su1_postal_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_country',
                    'label' => $this->getAttributeLabel('su1_country'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'created_by',
                    'label' => $this->getAttributeLabel('cprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('cprofile->first_name', 'cprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'created_on',
                    'label' => $this->getAttributeLabel('created_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_by',
                    'label' => $this->getAttributeLabel('mprofile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('mprofile->first_name', 'mprofile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'modified_on',
                    'label' => $this->getAttributeLabel('modified_on'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }

}
