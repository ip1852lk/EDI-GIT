<?php

/**
 * This is the model class for table 'co1_company'.
 *
 * The followings are the available columns in table 'co1_company':
 * @property string $id
 * @property integer $co1_type
 * @property string $co1_code
 * @property string $co1_name
 * @property string $co1_phone
 * @property string $co1_fax
 * @property string $co1_url
 * @property string $co1_logo
 * @property string $co1_address1
 * @property string $co1_address2
 * @property string $co1_city
 * @property string $st1_id
 * @property string $co1_postal_code
 * @property string $co1_country
 * @property string $co1_p21_database
 * @property string $co1_teamwork_id
 * @property string $co1_teamwork_desk_id
 * @property string $created_by
 * @property string $created_on
 * @property string $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag

 * The followings are the available model relations:
 * @property Contract[] $contracts
 * @property MasterData[] $masterDataRecords
 * @property Profile[] $users
 * @property Region[] $regions
 * @property State $state
 * @property Profile $cprofile
 * @property Profile $mprofile
 */
class Company extends JActiveRecord
{

    const TYPE_INTERNAL = 1;
    const TYPE_EXTERNAL = 2;

    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Company the static model class
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
        return 'co1_company';
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
            array('', 'unique', 'on' => 'insert, update'),
            array('co1_name, co1_type', 'required', 'on' => 'insert, update'),
            array('co1_type, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('co1_type', 'in', 'range' => array(self::TYPE_INTERNAL, self::TYPE_EXTERNAL), 'on' => 'insert, update'),
            array('co1_code', 'length', 'max' => 10),
            array('co1_name, co1_url, co1_logo, co1_address1, co1_address2', 'length', 'max' => 250),
            array('co1_url', 'url'),
            array('co1_logo', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => Yii::t('app', 'Size should be less then 2MB.'), 'allowEmpty' => true, 'safe' => true, 'on' => 'insert, update'),
            array('co1_phone, co1_fax, co1_postal_code', 'length', 'max' => 25),
            array('co1_city, co1_country', 'length', 'max' => 50),
            array('st1_id, created_by, modified_by', 'length', 'max' => 20),
            array('co1_p21_database', 'length', 'max' => 100),
            array('created_on, modified_on', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, co1_type, co1_code, co1_name, co1_phone, co1_fax, co1_url, co1_logo, co1_address1, co1_address2, co1_city, st1_id, st1_search, co1_postal_code, co1_country, co1_p21_database, created_by, created_on, modified_by, modified_on, delete_flag, update_flag, cprofile_search, mprofile_search, co1_teamwork_desk_id', 'safe', 'on' => 'search'),
            // Rules for relations
            array('co1_name', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'Company cannot be blank.')),
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
            'contracts' => array(self::HAS_MANY, 'Contract', 'co1_id'),
            'masterDataRecords' => array(self::HAS_MANY, 'MasterData', 'co1_id'),
            'users' => array(self::HAS_MANY, 'Profile', 'co1_id'),
            'regions' => array(self::HAS_MANY, 'Region', 'co1_id'),
            'state' => array(self::BELONGS_TO, 'State', 'st1_id',),
            'cprofile' => array(self::BELONGS_TO, 'Profile', 'created_by',),
            'mprofile' => array(self::BELONGS_TO, 'Profile', 'modified_by',),
        );
    }

    public static function getIDFromTeamworkId($teamworkID){
        $result = Company::model()->find('co1_teamwork_id=:teamwork_id',array(':teamwork_id'=>$teamworkID));
        if(isset($result->id)){
            return $result->id;
        }else{
            return false;
        }
    }

    public static function importTeamworkProjectCompanies(){

        Yii::log('Importing Teamwork Companies', CLogger::LEVEL_INFO);
        $result = ImportTeamwork::runTeamworkRequest("companies.json");

        if($result != false && $result['STATUS'] == "OK") {
            $companies = $result['companies'];

            $new = 0;
            $updated = 0;
            $processed = 0;

            $existingTeamworkRecords = Yii::app()->db->createCommand()
                ->select('co1_teamwork_id')
                ->from('co1_company')
                ->where('co1_teamwork_id IS NOT NULL')
                ->queryColumn();

            foreach ($companies as $company) {
                $processed++;
                //If the project can be found with re1_teamwork_id, then we don't need to do anything
                if(!in_array($company['id'],$existingTeamworkRecords)){
                    //The project was not found under re1_teamwork_id, search for the project by name
                    //If found, update with Teamwork ID
                    //Else create a new Project

                    $criteria = new CDbCriteria();
                    $criteria->params = array();
                    $criteria->together = true;
                    $criteria->compare('co1_name', $company['name']);
                    $model = Company::model()->find($criteria);

                    if (!isset($model)) {
                        $model = new Company();
                        $model->co1_name = $company['name'];
                        $model->co1_teamwork_id = $company['id'];
                        $new++;
                    }
                    if($model->validate()){
                        $model->save();
                    }else{
                        $updated++;
                    }
                }

            }

            Yii::log('Project Import Results: Processed: '.$processed. ' New: '. $new . ' Updated: '. $updated, CLogger::LEVEL_INFO);
            return true;
        }
        Yii::log('!!! Error: Could not retrieve Companies from Teamwork', CLogger::LEVEL_INFO);
        Yii::log('!!! Error: Could not retrieve Companies from Teamwork', CLogger::LEVEL_ERROR);
        return false;
    }

    public static function importTeamworkDeskCompanies($companies){

        Yii::log('Importing Teamwork Desk Companies', CLogger::LEVEL_INFO);
        try {
            $new = 0;
            $updated = 0;
            $processed = 0;

            $existingRecords = Yii::app()->db->createCommand()
                ->select('co1_teamwork_desk_id')
                ->from('co1_company')
                ->where('co1_teamwork_desk_id IS NOT NULL')
                ->queryColumn();

            foreach ($companies as $company) {
                $processed++;
                //If the project can be found with re1_teamwork_id, then we don't need to do anything
                if (!in_array($company['id'], $existingRecords)) {
                    //The Company was not found under re1_teamwork_id, search for the project by name
                    //If found, update with Teamwork ID
                    //Else create a new Project

                    $criteria = new CDbCriteria();
                    $criteria->params = array();
                    $criteria->together = true;
                    $criteria->compare('co1_name', $company['name']);
                    $model = Company::model()->find($criteria);

                    if (!isset($model)) {
                        $model = new Company();
                        $model->co1_name = $company['name'];
                        $new++;
                    } else {
                        $updated++;
                    }
                    $model->co1_teamwork_desk_id = $company['id'];

                    if ($model->validate()) {
                        $model->save();
                    }
                }

            }

            Yii::log('Teamwork Desk Company Results: Processed: ' . $processed . ' New: ' . $new . ' Updated: ' . $updated, CLogger::LEVEL_INFO);
            return true;
        }catch(Exception $e){
            Yii::log('!!!Teamwork Desk Company Import Failed!!!', CLogger::LEVEL_INFO);
            Yii::log('!!!Teamwork Desk Company Import Failed!!!', CLogger::LEVEL_ERROR);
            return false;
        }

    }


    public static function getIDFromTeamworkDeskId($teamworkID){
        $result = Company::model()->find('co1_teamwork_desk_id=:co1_teamwork_desk_id',array(':co1_teamwork_desk_id'=>$teamworkID));
        if(isset($result->id)){
            return $result->id;
        }else{
            return false;
        }
    }
    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'co1_type' => Yii::t('app', 'Type'),
            'co1_code' => Yii::t('app', 'Code'),
            'co1_name' => Yii::t('app', 'Company Name'),
            'co1_phone' => Yii::t('app', 'Phone'),
            'co1_fax' => Yii::t('app', 'Fax'),
            'co1_url' => Yii::t('app', 'URL'),
            'co1_logo' => Yii::t('app', 'Logo'),
            'co1_address1' => Yii::t('app', 'Address1'),
            'co1_address2' => Yii::t('app', 'Address2'),
            'co1_city' => Yii::t('app', 'City'),
            'st1_id' => Yii::t('app', 'State'),
            'st1_search' => Yii::t('app', 'State'),
            'co1_postal_code' => Yii::t('app', 'Postal Code'),
            'co1_country' => Yii::t('app', 'Country'),
            'co1_p21_database' => Yii::t('app', 'P21 Database'),
            'co1_teamwork_id' => Yii::t('app', 'Teamwork Project ID'),
            'co1_teamwork_desk_id' => Yii::t('app', 'Teamwork Desk ID'),
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

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'companyTypes' => array(
                self::TYPE_INTERNAL => Yii::t('app', 'Internal'),
                self::TYPE_EXTERNAL => Yii::t('app', 'External'),
            ),
            'companyTypesForSearch' => array(
                '' => '',
                self::TYPE_INTERNAL => Yii::t('app', 'Internal'),
                self::TYPE_EXTERNAL => Yii::t('app', 'External'),
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
            'co1_type' => 'companyTypes',
        );
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = self::itemAlias($itemAliasKeys[$attribute], $value);
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
        $alias = Company::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.co1_code';
        $scope->condition = $alias . '.delete_flag=0';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        $alias = Company::model()->getTableAlias(false, false);
        return array(
            'deleted' => array(
                'condition' => $alias . '.delete_flag=1',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.co1_code, ' . $alias . '.co1_name',
                'together' => true,
                'with' => array('state', 'cprofile', 'mprofile',),
                'order' => $alias . '.co1_code',
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
        $models = Company::model()->relation()->cache(10 * 60)->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->co1_code) && isset($model->co1_name))
                $rtv[$model->id] = $model->co1_code . ' - ' . $model->co1_name;
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
        $alias = Company::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('state', 'cprofile', 'mprofile',);
        $criteria->compare($alias . '.id', $this->id, true);
        $criteria->compare($alias . '.co1_type', $this->co1_type);
        $criteria->compare($alias . '.co1_code', $this->co1_code, true);
        $criteria->compare($alias . '.co1_name', $this->co1_name, true);
        $criteria->compare($alias . '.co1_phone', $this->co1_phone, true);
        $criteria->compare($alias . '.co1_fax', $this->co1_fax, true);
        $criteria->compare($alias . '.co1_url', $this->co1_url, true);
        $criteria->compare($alias . '.co1_logo', $this->co1_logo, true);
        $criteria->compare($alias . '.co1_address1', $this->co1_address1, true);
        $criteria->compare($alias . '.co1_address2', $this->co1_address2, true);
        $criteria->compare($alias . '.co1_city', $this->co1_city, true);
        $criteria->compare($alias . '.co1_teamwork_id', $this->co1_teamwork_id, true);
        $criteria->compare($alias . '.co1_teamwork_desk_id', $this->co1_teamwork_desk_id, true);
        if (isset($this->st1_id) && $this->st1_id > 0) {
            $criteria->compare($alias.'.st1_id', $this->st1_id);
        }
        $criteria->compare($alias . '.co1_postal_code', $this->co1_postal_code, true);
        $criteria->compare($alias . '.co1_country', $this->co1_country, true);
        $criteria->compare($alias . '.co1_p21_database', $this->co1_p21_database, true);
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
            'fileName' => Yii::t('app', 'Company').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'co1_code',
                    'label' => $this->getAttributeLabel('co1_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_name',
                    'label' => $this->getAttributeLabel('co1_name'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_type',
                    'label' => $this->getAttributeLabel('co1_type'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => array('class' => 'Company', 'type' => 'companyTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_teamwork_id',
                    'label' => $this->getAttributeLabel('co1_teamwork_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => array('class' => 'Company', 'type' => 'companyTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_teamwork_desk_id',
                    'label' => $this->getAttributeLabel('co1_teamwork_desk_id'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 20,
                    'itemAlias' => array('class' => 'Company', 'type' => 'companyTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_phone',
                    'label' => $this->getAttributeLabel('co1_phone'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_fax',
                    'label' => $this->getAttributeLabel('co1_fax'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_url',
                    'label' => $this->getAttributeLabel('co1_url'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_logo',
                    'label' => $this->getAttributeLabel('co1_logo'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_address1',
                    'label' => $this->getAttributeLabel('co1_address1'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_address2',
                    'label' => $this->getAttributeLabel('co1_address2'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 35,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_city',
                    'label' => $this->getAttributeLabel('co1_city'),
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
                    'field' => 'co1_postal_code',
                    'label' => $this->getAttributeLabel('co1_postal_code'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_country',
                    'label' => $this->getAttributeLabel('co1_country'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 15,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_p21_database',
                    'label' => $this->getAttributeLabel('co1_p21_database'),
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

