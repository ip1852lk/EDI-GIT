<?php

/**
 * This is the model class for table 'ct1_contract'.
 *
 * The followings are the available columns in table 'ct1_contract':
 * @property string $id
 * @property string $co1_id
 * @property string $cu2_id
 * @property integer $job_price_hdr_uid
 * @property string $contract_no
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Company $company
 * @property Customer2 $customer2
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class Contract extends JActiveRecord
{

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Contract the static model class
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
        return 'ct1_contract';
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
            array('job_price_hdr_uid', 'uniqueContract', 'on' => 'insert, update'),
            array('co1_id, cu2_id, job_price_hdr_uid', 'required', 'on' => 'insert, update'),
            array('job_price_hdr_uid, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('co1_id, cu2_id, created_by, modified_by', 'length', 'max' => 20),
            array('contract_no', 'length', 'max' => 255),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, co1_id, co1_search, cu2_id, cu2_search, cu1_search, job_price_hdr_uid, contract_no, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search', 'safe', 'on' => 'search'),
            // Rules for relations
            array('job_price_hdr_uid', 'required', 'on' => 'relation', 'message' => Yii::t('app', '"Contract" is required.')),
        );
    }

    public function uniqueContract($attribute)
    {
        if (isset($this->{$attribute}) &&
            isset($this->co1_id) && $this->co1_id > 0  &&
            isset($this->cu2_id) && $this->cu2_id > 0)
        {
            if ($this->isNewRecord)
                $count = Contract::model()->count('t.co1_id=:co1_id AND t.cu2_id=:cu2_id AND t.job_price_hdr_uid=:job_price_hdr_uid', array(
                    ':co1_id' => $this->co1_id,
                    ':cu2_id' => $this->cu2_id,
                    ':job_price_hdr_uid' => $this->job_price_hdr_uid,
                ));
            else
                $count = Contract::model()->count('t.id<>:id AND t.co1_id=:co1_id AND t.cu2_id=:cu2_id AND t.job_price_hdr_uid=:job_price_hdr_uid', array(
                    ':id' => $this->id,
                    ':co1_id' => $this->co1_id,
                    ':cu2_id' => $this->cu2_id,
                    ':job_price_hdr_uid' => $this->job_price_hdr_uid,
                ));
            if ($count > 0)
                $this->addError($attribute, Yii::t('app', 'The contract, ":contract_no", has already been registered on ":cu2_id" and ":co1_id".', array(
                    ':contract_no' => $this->contract_no,
                    ':cu2_id' => $this->customer2->customer_name,
                    ':co1_id' => $this->company->co1_name,
                )));
        }
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
            'company' => array(self::BELONGS_TO, 'Company', 'co1_id'),
            'customer2' => array(self::BELONGS_TO, 'Customer2', 'cu2_id'),
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
            'co1_id' => Yii::t('app', 'Company'),
            'co1_search' => Yii::t('app', 'Company'),
            'cu2_id' => Yii::t('app', 'Sbu-Customer'),
            'cu2_search' => Yii::t('app', 'Sub-Customer'),
            'cu1_search' => Yii::t('app', 'Customer'),
            'job_price_hdr_uid' => Yii::t('app', 'Contract'),
            'contract_no' => Yii::t('app', 'Contract No.'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_on' => Yii::t('app', 'Created On'),
            'modified_by' => Yii::t('app', 'Modified By'),
            'modified_on' => Yii::t('app', 'Modified On'),
            'delete_flag' => Yii::t('app', 'Delete Flag'),
            'update_flag' => Yii::t('app', 'Update Flag'),
            'cprofile_search' => Yii::t('app', 'Created By'),
            'mprofile_search' => Yii::t('app', 'Modified By'),
        );
    }

    /**
     * REQUIRED
     * @return array default scopes
     */
    public function defaultScope()
    {
        $alias = Contract::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.co1_id, ' . $alias . '.cu2_id, ' . $alias . '.contract_no';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Contract::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.contract_no',
                'together' => true,
                'with' => array('company', 'customer2', 'customer2.customer', 'cprofile', 'mprofile',),
                'order' => $alias . '.co1_id, ' . $alias . '.cu2_id, ' . $alias . '.contract_no',
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
        $models = Contract::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->id) && isset($model->company) && isset($model->customer2))
                $rtv[$model->id] = '['.$model->company->co1_name.', '.$model->customer2->customer_name.'] '.$model->contract_no;
        }
        return $rtv;
    }

    public $co1_search;
    public $cu2_search;
    public $cu1_search;
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
        $alias = Contract::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('company', 'customer2', 'customer2.customer', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id);
        $criteria->compare($alias . '.co1_id', $this->co1_id);
        if (isset($this->co1_search) && strlen($this->co1_search)) {
            $criteria->compare('company.co1_name', $this->co1_search, true);
        }
        $criteria->compare($alias . '.cu2_id', $this->cu2_id);
        if (isset($this->cu2_search) && strlen($this->cu2_search)) {
            $criteria->compare('customer2.customer_name', $this->cu2_search, true);
        }
        if (isset($this->cu1_search) && strlen($this->cu1_search)) {
            $criteria->compare('customer.cu1_name', $this->cu1_search, true);
        }
        $criteria->compare($alias . '.job_price_hdr_uid', $this->job_price_hdr_uid);
        $criteria->compare($alias . '.contract_no', $this->contract_nol, true);
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
                    'co1_search' => array(
                        'asc' => 'company.co1_name',
                        'desc' => 'company.co1_name DESC',
                    ),
                    'cu2_search' => array(
                        'asc' => 'customer2.customer_name',
                        'desc' => 'customer2.customer_name DESC',
                    ),
                    'cu1_search' => array(
                        'asc' => 'customer.cu1_name',
                        'desc' => 'customer.cu1_name DESC',
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
            'fileName' => Yii::t('app', 'Contract').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'co1_search',
                    'label' => $this->getAttributeLabel('co1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'company->co1_name',
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu2_search',
                    'label' => $this->getAttributeLabel('cu2_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => 'customer2->customer_name',
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'contract_no',
                    'label' => $this->getAttributeLabel('contract_no'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
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

