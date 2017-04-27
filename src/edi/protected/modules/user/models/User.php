<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'users':
 * @var integer $id
 * @var string $username
 * @var string $password
 * @var string $email
 * @var string $activkey
 * @var integer $createtime
 * @var integer $lastvisit
 * @var integer $superuser
 * @var integer $status
 * @var timestamp $create_at
 * @var timestamp $lastvisit_at
 * @var integer $delete_flag
 *
 * @var integer $us1_id
 * The followings are the available model relations:
 * @property Profile $profile
 */
class User extends JActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    const STATUS_BANED = -1;    //TODO: Delete for next version (backward compatibility)

    const TYPE_UNKNOWN = 0;
    const TYPE_INTERNAL = 1;
    const TYPE_CUSTOMER = 2;
    const TYPE_SUPPLIER = 3;
    const TYPE_INTERNAL_SUPERVISOR = 4;
    const TYPE_INTERNAL_USER = 5;



    public function init()
    {
        parent::init();
        $this->excludeAttributeFromLogging(['password', 'superuser', 'activkey']);
    }

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
        return Yii::app()->getModule('user')->tableUsers;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.CConsoleApplication
        return
        //get_class(Yii::app()) == 'CConsoleApplication' ?
        array(
            array('username', 'length', 'max' => 60, 'min' => 3, 'message' => Yii::t('app', "Incorrect username (length between 3 and 20 characters).")),
            array('password', 'length', 'max' => 128, 'min' => 6, 'message' => Yii::t('app', "Incorrect password (minimal length 4 symbols).")),
            array('email', 'email'),
            array('username', 'unique', 'message' => Yii::t('app', "This user's name already exists.")),
            //array('email', 'unique', 'message' => Yii::t('app', "This user's email address already exists.")),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_.]+$/u', 'message' => Yii::t('app', "Incorrect symbols (A-z0-9).")),
            array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
            array('superuser', 'in', 'range' => array(0, 1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
            array('username, password, email, superuser, status', 'required', 'on' => 'insert, update'),
            array('superuser, status', 'numerical', 'integerOnly' => true),
            array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, delete_flag, profile_full_name_search, profile_user_type_search, lo1_search, rg1_search, co1_search, cu1_search, su1_search, profile_address1_search, profile_address2_search, profile_city_search, st1_search, profile_postal_code_search, profile_country_search, name, us1_id', 'safe', 'on' => 'search'),
            // The following rules are used by relations where this model is used
            // as a reference in another model
            array('username, email', 'required', 'on' => 'relation', 'message' => Yii::t('app', 'User cannot be blank.')),
        ); //:
//            (
//                Yii::app()->user->id == $this->id ?
//                array(
//                    array('username, password, email', 'required'),
//                    array('username', 'length', 'max' => 20, 'min' => 4, 'message' => Yii::t('app', "Incorrect username (length between 3 and 20 characters).")),
//                    array('password', 'length', 'max' => 128, 'min' => 4, 'message' => Yii::t('app', "Incorrect password (minimal length 4 symbols).")),
//                    array('email', 'email'),
//                    array('username', 'unique', 'message' => Yii::t('app', "This user's name already exists.")),
//                    array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('app', "Incorrect symbols (A-z0-9).")),
//                    array('email', 'unique', 'message' => Yii::t('app', "This user's email address already exists.")),
//                ) :
//                array()
//            );
    }

    /**
     * REQUIRED
     * @return array default behaviors for model.
     */
    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'RUserBehavior' => array('class' => 'RUserBehavior', 'idColumn' => 'id', 'nameColumn' => 'username',),
        ));
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
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id', 'with' => array(
                'location', 'customer', 'supplier', 'state'
            )),
        );
        if (isset(Yii::app()->getModule('user')->relations))
            $relations = array_merge($relations, Yii::app()->getModule('user')->relations);
        return $relations;
    }

    /**
     * Returns the full user name.
     * @return mixed|string
     */
    public function getFullname()
    {
        if (isset($this->profile))
            return $this->profile->fullname;
        else
            return '';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', "Id"),
            'username' => Yii::t('app', "Username"),
            'password' => Yii::t('app', "Password"),
            'verifyPassword' => Yii::t('app', "Retype Password"),
            'email' => Yii::t('app', "Email"),
            'verifyCode' => Yii::t('app', "Verification Code"),
            'activkey' => Yii::t('app', "Activation Key"),
            'createtime' => Yii::t('app', "Registration Date"),
            'create_at' => Yii::t('app', "Registration Date"),
            'lastvisit_at' => Yii::t('app', "Last Visit"),
            'superuser' => Yii::t('app', "Superuser"),
            'status' => Yii::t('app', "Status"),
            'delete_flag' => Yii::t('app', "Delete Flag"),
            'profile_full_name_search' => Yii::t('app', 'Full Name'),
            'profile_user_type_search' => Yii::t('app', 'User Type'),
            'lo1_search' => Yii::t('app', 'Location'),
            'rg1_search' => Yii::t('app', 'Region'),
            'co1_search' => Yii::t('app', 'Company'),
            'cu1_search' => Yii::t('app', 'Customer'),
            'su1_search' => Yii::t('app', 'Supplier'),
            'profile_address1_search' => Yii::t('app', 'Address 1'),
            'profile_address2_search' => Yii::t('app', 'Address 2'),
            'profile_city_search' => Yii::t('app', 'City'),
            'st1_search' => Yii::t('app', 'State'),
            'profile_postal_code_search' => Yii::t('app', 'Postal Code'),
            'profile_country_search' => Yii::t('app', 'Country'),
            'name' => Yii::t('app', 'Username'),

            'us1_id'=>Yii::t('app', 'User ID'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'userTypes' => array(
                self::TYPE_INTERNAL => Yii::t('app', 'Internal'),
                self::TYPE_CUSTOMER => Yii::t('app', 'User'),
                //self::TYPE_SUPPLIER => Yii::t('app', 'Supplier'),
            ),
            'userTypesForSearch' => array(
                '' => '',
                self::TYPE_INTERNAL => Yii::t('app', 'Internal'),
                self::TYPE_CUSTOMER => Yii::t('app', 'User'),
                //self::TYPE_SUPPLIER => Yii::t('app', 'Supplier'),
            ),
            'userStatus' => array(
                self::STATUS_NOACTIVE => Yii::t('app', 'Not active'),
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_BANNED => Yii::t('app', 'Banned'),
            ),
            'userStatusForSearch' => array(
                '' => '',
                self::STATUS_NOACTIVE => Yii::t('app', 'Not active'),
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_BANNED => Yii::t('app', 'Banned'),
            ),
            'adminStatus' => array(
                '0' => Yii::t('app', 'No'),
                '1' => Yii::t('app', 'Yes'),
            ),
            'adminStatusForSearch' => array(
                '' => '',
                '0' => Yii::t('app', 'No'),
                '1' => Yii::t('app', 'Yes'),
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
            'user_type' => 'userTypes',
            'status' => 'userStatus',
            'superuser' => 'adminStatus',
        );
        if (array_key_exists($attribute, $itemAliasKeys)) {
            $result = self::itemAlias($itemAliasKeys[$attribute], $value);
            if (!$result)
                $result = $value;
        }
        return $result;
    }

    public function defaultScope()
    {
        $alias = User::model()->getTableAlias(false, false);
        $scope = Yii::app()->getModule('user')->defaultScope;
        $scope['select'] = $alias . '.id, ' . $alias . '.username, ' . $alias . '.password, ' . $alias . '.email, ' . $alias . '.activkey, ' . $alias . '.create_at, ' . $alias . '.lastvisit_at, ' . $alias . '.superuser, ' . $alias . '.status, ' . $alias . '.delete_flag';
        $scope['condition'] = $alias . '.delete_flag=0';
        $scope['order'] = 'profile.user_type, ' . $alias . '.username';
        return $scope;
    }

    public function scopes()
    {
        $alias = User::model()->getTableAlias(false, false);
        return array(
            'active' => array(
                'condition' => $alias . '.status=' . self::STATUS_ACTIVE,
            ),
            'notactive' => array(
                'condition' => $alias . '.status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => $alias . '.status=' . self::STATUS_BANNED,
            ),
            'superuser' => array(
                'condition' => $alias . '.superuser=1',
            ),
            'internal' => array(
                'condition' => 'profile.user_type=' . self::TYPE_INTERNAL,
            ),
            'customer' => array(
                'condition' => 'profile.user_type=' . self::TYPE_CUSTOMER,
            ),
            'supplier' => array(
                'condition' => 'profile.user_type=' . self::TYPE_SUPPLIER,
            ),
            'notsafe' => array(
                'select' => $alias . '.id, ' . $alias . '.username, ' . $alias . '.password, ' . $alias . '.email, ' . $alias . '.activkey, ' . $alias . '.create_at, ' . $alias . '.lastvisit_at, ' . $alias . '.superuser, ' . $alias . '.status, ' . $alias . '.delete_flag',
                'order' => $alias . '.create_at DESC',
            ),
            'relation' => array(
                'select' => $alias . '.id, ' . $alias . '.username, profile.first_name, profile.last_name',
                'together' => true,
                'with' => array('profile', 'profile.location', 'profile.location.region', 'profile.location.region.company', 'profile.customer', 'profile.supplier', 'profile.state',),
                'order' => 'profile.first_name, profile.last_name',
            ),
        );
    }

    /**
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry
     * @return array States
     */
//    public static function getListData($criteria = null, $addEmptyItem = true)
//    {
//        if ($criteria === null) {
//            $criteria = new CDbCriteria();
//            $criteria->params = array();
//        }
//        $models = User::model()->relation()->findAll($criteria);
//        $rtv = array();
//        if ($addEmptyItem) $rtv['0'] = '';
//        foreach ($models as $model) {
//            if (isset($model->profile)) {
//                $rtv[$model->id] = $model->profile->fullname;
//            }
//        }
//        return $rtv;
//    }
    /**
     * Returns a set of list data.
     * @param CDbCriteria $criteria Search criteria
     * @param boolean $addEmptyItem Add an empty entry
     * @return array States
     */
    public static function getListData($criteria = null, $addEmptyItem = true)
    {
        if ($criteria === null) {
            $criteria = new CDbCriteria();
            $criteria->params = array();
        }
        $criteria->together = true;
        $criteria->with = array('profile', 'profile.location', 'profile.location.region', 'profile.location.region.company', 'profile.customer', 'profile.supplier', 'profile.state',);
        //$criteria->compare('t.superuser', 0);
        //$criteria->addInCondition('profile.user_type', [self::TYPE_INTERNAL_SUPERVISOR, self::TYPE_INTERNAL_OFFICE, self::TYPE_INTERNAL_FOREMAN, self::TYPE_INTERNAL_LABORER, self::TYPE_INTERNAL_OPERATOR, self::TYPE_INTERNAL_TRUCKER, User::TYPE_SUPPLIER]);
        //$criteria->compare('t.status', '>'.User::STATUS_BANNED);
        //$criteria->compare('profile.show_in_scheduler', 1);
        $criteria->order = 'profile.user_type, profile.first_name, profile.last_name';
        $models = User::model()->findAll($criteria);
        $rtv = array();
        if ($addEmptyItem) $rtv['0'] = '';
        foreach ($models as $model) {
            if (isset($model->profile)) {
                $rtv[$model->id] = $model->profile->first_name.' '.$model->profile->last_name;
            }
        }
        return $rtv;
    }
    public $name;
    public $profile_full_name_search;
    public $profile_user_type_search;
    public $lo1_search;
    public $rg1_search;
    public $co1_search;
    public $cu1_search;
    public $su1_search;
    public $profile_address1_search;
    public $profile_address2_search;
    public $profile_city_search;
    public $st1_search;
    public $profile_postal_code_search;
    public $profile_country_search;

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = User::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria;
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('profile', 'profile.location', 'profile.location.region', 'profile.location.region.company', 'profile.customer', 'profile.supplier', 'profile.state',);
        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activkey', $this->activkey);
        $criteria->compare('us1_id', $this->us1_id);
        if (isset($this->create_at) && strlen($this->create_at) > 0) {
            $criteria->addCondition("$alias.create_at BETWEEN :created_at_1 AND :created_at_2");
            $criteria->params = array_merge($criteria->params, array(
                ':created_at_1' => date('Y-m-d', strtotime($this->create_at)).' 00:00:00',
                ':created_at_2' => date('Y-m-d', strtotime($this->create_at)).' 23:59:59',
            ));
        }
        if (isset($this->lastvisit_at) && strlen($this->lastvisit_at) > 0) {
            $criteria->addCondition("$alias.lastvisit_at BETWEEN :lastvisit_at_1 AND :lastvisit_at_2");
            $criteria->params = array_merge($criteria->params, array(
                ':lastvisit_at_1' => date('Y-m-d', strtotime($this->lastvisit_at)).' 00:00:00',
                ':lastvisit_at_2' => date('Y-m-d', strtotime($this->lastvisit_at)).' 23:59:59',
            ));
        }
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        if (isset($this->profile_full_name_search) && strlen($this->profile_full_name_search) > 0) {
            $criteria->addCondition('CONCAT(profile.first_name, " ", profile.last_name) LIKE :profile_full_name_search');
            $criteria->params = array_merge($criteria->params, array(':profile_full_name_search' => '%' . $this->profile_full_name_search . '%'));
        }
        $criteria->compare('profile.user_type', $this->profile_user_type_search);
        if (isset($this->lo1_search) && strlen($this->lo1_search) > 0) {
            $criteria->addCondition('CONCAT(location.lo1_code, " ", location.lo1_name) LIKE :lo1_search');
            $criteria->params = array_merge($criteria->params, array(':lo1_search' => '%' . $this->lo1_search . '%'));
        }
        if (isset($this->rg1_search) && strlen($this->rg1_search) > 0) {
            $criteria->addCondition('CONCAT(region.rg1_code, " ", region.rg1_name) LIKE :rg1_search');
            $criteria->params = array_merge($criteria->params, array(':rg1_search' => '%' . $this->rg1_search . '%'));
        }
        if (isset($this->co1_search) && strlen($this->co1_search) > 0) {
            $criteria->addCondition('CONCAT(company.co1_code, " ", company.co1_name) LIKE :co1_search');
            $criteria->params = array_merge($criteria->params, array(':co1_search' => '%' . $this->co1_search . '%'));
        }
        if (isset($this->cu1_search) && strlen($this->cu1_search) > 0) {
            $criteria->addCondition('CONCAT(customer.cu1_code, " ", customer.cu1_name) LIKE :cu1_search');
            $criteria->params = array_merge($criteria->params, array(':cu1_search' => '%' . $this->cu1_search . '%'));
        }
        if (isset($this->su1_search) && strlen($this->su1_search) > 0) {
            $criteria->addCondition('CONCAT(supplier.su1_code, " ", supplier.su1_name) LIKE :su1_search');
            $criteria->params = array_merge($criteria->params, array(':su1_search' => '%' . $this->su1_search . '%'));
        }

        $criteria->compare('profile.user_address1', $this->profile_address1_search, true);
        $criteria->compare('profile.user_address2', $this->profile_address2_search, true);
        $criteria->compare('profile.user_city', $this->profile_city_search, true);
        if (isset($this->st1_search) && $this->st1_search > 0) {
            $criteria->compare('profile.st1_id', $this->st1_search);
        }
        $criteria->compare('profile.user_postal_code', $this->profile_postal_code_search, true);
        $criteria->compare('profile.user_country', $this->profile_country_search, true);
        $criteria->compare('username', $this->name, true);
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->getModule('user')->user_page_size,
            ),
            'sort' => array(
                'attributes' => array(
                    'profile_full_name_search' => array(
                        'asc' => 'profile.first_name, profile.last_name',
                        'desc' => 'profile.first_name DESC, profile.last_name DESC',
                    ),
                    'profile_user_type_search' => array(
                        'asc' => 'profile.user_type',
                        'desc' => 'profile.user_type DESC',
                    ),
                    'lo1_search' => array(
                        'asc' => 'location.lo1_code, location.lo1_name',
                        'desc' => 'location.lo1_code DESC, location.lo1_name DESC',
                    ),
                    'rg1_search' => array(
                        'asc' => 'region.rg1_code, region.rg1_name',
                        'desc' => 'region.rg1_code DESC, region.rg1_name DESC',
                    ),
                    'co1_search' => array(
                        'asc' => 'company.co1_code, company.co1_name',
                        'desc' => 'company.co1_code DESC, company.co1_name DESC',
                    ),
                    'cu1_search' => array(
                        'asc' => 'customer.cu1_code, customer.cu1_name',
                        'desc' => 'customer.cu1_code DESC, customer.cu1_name DESC',
                    ),
                    'su1_search' => array(
                        'asc' => 'supplier.su1_code, supplier.su1_name',
                        'desc' => 'supplier.su1_code DESC, supplier.su1_name DESC',
                    ),
                    'profile_address1_search' => array(
                        'asc' => 'profile.user_address1',
                        'desc' => 'profile.user_address1 DESC',
                    ),
                    'profile_address2_search' => array(
                        'asc' => 'profile.user_address2',
                        'desc' => 'profile.user_address2 DESC',
                    ),
                    'profile_city_search' => array(
                        'asc' => 'profile.user_city',
                        'desc' => 'profile.user_city DESC',
                    ),
                    'st1_search' => array(
                        'asc' => 'state.st1_code, state.st1_name',
                        'desc' => 'state.st1_code DESC, state.st1_name DESC',
                    ),
                    'profile_postal_code_search' => array(
                        'asc' => 'profile.user_postal_code',
                        'desc' => 'profile.user_postal_code DESC',
                    ),
                    'profile_country_search' => array(
                        'asc' => 'profile.user_country',
                        'desc' => 'profile.user_country DESC',
                    ),
                    'name' => array(
                        'asc' => $alias . '.username',
                        'desc' => $alias . '.username DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => $pageSize<1000 ? array('pageSize' => $pageSize) : false,
        ));
    }

    public function getCreatetime()
    {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value)
    {
        $this->create_at = date('Y-m-d H:i:s', $value);
    }

    public function getLastvisit()
    {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value)
    {
        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
    }

    public static function getIdFromTeamworkId($teamworkID){

        $alias = User::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria;
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('profile');
        $criteria->compare('profile.teamwork_id',$teamworkID);

        $result = User::model()->find($criteria);
        if(isset($result->id)){
            return $result->id;
        }else{
            return false;
        }
    }

    public static function importTeamworkUsers(){
        Yii::log('Importing Teamwork Users', CLogger::LEVEL_INFO);
        $result = ImportTeamwork::runTeamworkRequest("companies/66336/people.json");

        if($result != false && $result['STATUS'] == "OK") {
            $users = $result['people'];
            $updated = 0;
            $processed = 0;

            foreach ($users as $user) {
                $processed++;
                $model = User::getIdFromTeamworkId($user['id']);
                //Check if the User has already been imported
                if($model == false){
                    //If there is no user, attempt to match based on email address, then name

                    $criteria = new CDbCriteria;
                    $criteria->params = array();
                    $criteria->together = true;
                    $criteria->with = array('profile');
                    $criteria->compare('email',$user['email-address']);
                    $model = User::model()->find($criteria);

                    if(!isset($model)){
                        //Couldn't find with email, find with first and last name
                        $criteria = new CDbCriteria;
                        $criteria->params = array();
                        $criteria->together = true;
                        $criteria->with = array('profile');
                        $criteria->compare('profile.first_name',$user['first-name']);
                        $criteria->compare('profile.last_name',$user['last-name']);
                        $model = User::model()->find($criteria);
                    }

                    if(isset($model)){
                        //If there is a match, set the Teamwork ID
                        $model->profile->teamwork_id = $user['id'];
                        if($model->validate()){
                            $model->save();
                            $model->profile->save();
                            $updated++;
                        }
                    }else{
                        //Add log error for could not match a person
                        $couldNotMatch[] = $user;
                        Yii::log('!!! Error: Could not match User! UserID: '.$user['id'].' - Name: '. $user['first-name'] . ' ' . $user['last-name'], CLogger::LEVEL_INFO);
                    }

                }

            }
//            $message = new YiiMailMessage();
//            $message->setSubject(Yii::t('app', 'Users could not import'))
//                ->setFrom(Yii::app()->params['companyEmail'])
//                ->setTo(Yii::app()->params['adminEmail'])
//                ->setBody('Could not import these users: Chad + John');
//            $value = Yii::app()->mail->send($message);

            Yii::log('User Import Results: Processed: '.$processed . ' Updated: '. $updated, CLogger::LEVEL_INFO);
            return true;
        }
        Yii::log('!!! Error: Could not retrieve Users from Teamwork', CLogger::LEVEL_INFO);
        Yii::log('!!! Error: Could not retrieve Users from Teamwork', CLogger::LEVEL_ERROR);
        return false;
    }

    /**
     * Export data into Excel, CVS or PDF
     * @param boolean $stream true - export without footprint, false - export with footprint
     * @param boolean $isAdmin
     */
    public function export($stream, $isAdmin)
    {
        return Yii::app()->export->exportData($this, array(
            'dataProvider' => null,
            'exportType' => YiiExport::EXPORT_TYPE_EXCEL,
            'stream' => $stream,
            'fileName' => Yii::t('app', 'Users').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'username',
                    'label' => $this->getAttributeLabel('username'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'email',
                    'label' => $this->getAttributeLabel('email'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 30,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'superuser',
                    'label' => $this->getAttributeLabel('superuser'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => null,
                    'itemAlias' => array('class' => 'User', 'type' => 'adminStatus'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                    'visible' => $isAdmin,
                ),
                array(
                    'field' => 'status',
                    'label' => $this->getAttributeLabel('status'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => null,
                    'itemAlias' => array('class' => 'User', 'type' => 'userStatus'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                    'visible' => $isAdmin,
                ),
                array(
                    'field' => 'user_type',
                    'label' => $this->getAttributeLabel('profile_user_type_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => 'profile->user_type',
                    'itemAlias' => array('class' => 'User', 'type' => 'userTypes'),
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'first_name',
                    'label' => $this->getAttributeLabel('profile_full_name_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->first_name', 'profile->last_name'), 'separator' => ' '),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'co1_search',
                    'label' => $this->getAttributeLabel('co1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->location->region->company->co1_code', 'profile->location->region->company->co1_name'), 'separator' => '-'),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'rg1_search',
                    'label' => $this->getAttributeLabel('rg1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->location->region->rg1_code', 'profile->location->region->rg1_name'), 'separator' => '-'),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'lo1_search',
                    'label' => $this->getAttributeLabel('lo1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->location->lo1_code', 'profile->location->lo1_name'), 'separator' => '-'),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'cu1_search',
                    'label' => $this->getAttributeLabel('cu1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->customer->cu1_code', 'profile->customer->cu1_name'), 'separator' => '-'),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'su1_search',
                    'label' => $this->getAttributeLabel('su1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => array('attributes' => array('profile->supplier->su1_code', 'profile->supplier->su1_name'), 'separator' => '-'),
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_address1',
                    'label' => $this->getAttributeLabel('profile_address1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 35,
                    'value' => 'profile->user_address1',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_address2',
                    'label' => $this->getAttributeLabel('profile_address2_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 35,
                    'value' => 'profile->user_address2',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_city',
                    'label' => $this->getAttributeLabel('profile_city_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => 'profile->user_city',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'st1_name',
                    'label' => $this->getAttributeLabel('st1_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => 'profile->state->st1_name',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_postal_code',
                    'label' => $this->getAttributeLabel('profile_postal_code_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => 'profile->user_postal_code',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_country',
                    'label' => $this->getAttributeLabel('profile_country_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 15,
                    'value' => 'profile->user_country',
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'create_at',
                    'label' => $this->getAttributeLabel('create_at'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'lastvisit_at',
                    'label' => $this->getAttributeLabel('lastvisit_at'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'width' => 25,
                    'value' => null,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
            ),
        ));
    }

}
