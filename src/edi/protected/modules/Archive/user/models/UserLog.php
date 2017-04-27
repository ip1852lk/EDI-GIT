<?php

/**
 * This is the model class for table "yii_user_log".
 *
 * The followings are the available columns in table 'yii_user_log':
 * @property integer $user_id
 * @property string $session_id
 * @property string $ip_address
 * @property string $user_agent
 * @property string $login_time
 * @property string $logout_time
 * @property integer $created_by
 * @property string $created_on
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $delete_flag
 * @property integer $update_flag
 * 
 * The followings are the available model relations:
 * @property User $user
 */
class UserLog extends JActiveRecord
{
    /**
     * REQUIRED
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserLog the static model class
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
        return 'yii_user_log';
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
            array('user_id, session_id, ip_address', 'required', 'on' => 'insert, update'),
            array('user_id, created_by, modified_by, delete_flag, update_flag', 'numerical', 'integerOnly' => true),
            array('session_id, ip_address', 'length', 'max' => 32),
            array('user_agent', 'length', 'max' => 255),
            array('login_time, logout_time', 'safe'),
            array('login_time', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'insert'),
            array('logout_time', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'update'),
            array('created_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('created_on', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'insert'),
            array('modified_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
            array('modified_on', 'default', 'value' => '0000-00-00 00:00:00', 'on' => 'insert'),
            array('modified_by', 'default', 'value' => Yii::app()->user->id, 'on' => 'update'),
            array('modified_on', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, profile_search, ip_address, user_agent, login_time, logout_time, created_on, created_by, modified_by, modified_on, delete_flag, update_flag', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id',),
        );
    }

    /**
     * REQUIRED
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => Yii::t('app', 'User'),
            'profile_search' => Yii::t('app', 'User'),
            'session_id' => Yii::t('app', 'Session'),
            'ip_address' => Yii::t('app', 'IP'),
            'user_agent' => Yii::t('app', 'User Info'),
            'login_time' => Yii::t('app', 'Login'),
            'logout_time' => Yii::t('app', 'Logout'),
            'created_by' => Yii::t('app', 'Changed By'),
            'created_on' => Yii::t('app', 'Changed On'),
            'modified_by' => Yii::t('app', 'Modified By'),
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
        $alias = UserLog::model()->getTableAlias(false, false);
        $scope = parent::defaultScope();
        $scope->order = $alias . '.login_time DESC';
        return $scope;
    }

    /**
     * REQUIRED
     * @return array scopes
     */
    public function scopes()
    {
        return array();
    }

    public $profile_search;
    /**
     * REQUIRED
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $alias = UserLog::model()->getTableAlias(false, false);
        $criteria = new CDbCriteria();
        $criteria->params = array();
        $criteria->together = true;
        $criteria->with = array('user', 'user.profile',);
        $criteria->compare($alias.'.user_id', $this->user_id);
        if (isset($this->profile_search) && strlen($this->profile_search) > 0) {
            $criteria->addCondition("CONCAT(profile.first_name, ' ', profile.last_name) LIKE :profile_search");
            $criteria->params = array_merge($criteria->params, array(':profile_search' => '%' . $this->profile_search . '%'));
        }
        //$criteria->compare($alias.'.session_id', $this->session_id);
        $criteria->compare($alias.'.ip_address', $this->ip_address, true);
        $criteria->compare($alias.'.user_agent', $this->user_agent, true);
        if (isset($this->login_time) && strlen($this->login_time) > 0) {
            $criteria->addCondition("$alias.login_time BETWEEN :login_time_1 AND :login_time_2");
            $criteria->params = array_merge($criteria->params, array(
                ':login_time_1' => date('Y-m-d', strtotime($this->login_time)).' 00:00:00',
                ':login_time_2' => date('Y-m-d', strtotime($this->login_time)).' 23:59:59',
            ));
        }
        if (isset($this->logout_time) && strlen($this->logout_time) > 0) {
            $criteria->addCondition("$alias.logout_time BETWEEN :logout_time_1 AND :logout_time_2");
            $criteria->params = array_merge($criteria->params, array(
                ':logout_time_1' => date('Y-m-d', strtotime($this->logout_time)).' 00:00:00',
                ':logout_time_2' => date('Y-m-d', strtotime($this->logout_time)).' 23:59:59',
            ));
        }
        $criteria->compare($alias.'.created_by', $this->created_by);
        if (isset($this->created_on) && strlen($this->created_on) > 0) {
            $criteria->addCondition("$alias.created_on BETWEEN :created_on_1 AND :created_on_2");
            $criteria->params = array_merge($criteria->params, array(
                ':created_on_1' => date('Y-m-d', strtotime($this->created_on)).' 00:00:00',
                ':created_on_2' => date('Y-m-d', strtotime($this->created_on)).' 23:59:59',
            ));
        }
        $criteria->compare($alias.'.modified_by', $this->modified_by);
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
                    'profile_search' => array(
                        'asc' => 'profile.first_name, profile.last_name',
                        'desc' => 'profile.first_name DESC, profile.last_name DESC',
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
            'fileName' => Yii::t('app', 'User-Logs').'-'.date('Y-m-d-H-i-s'),
            'extensionType' => 'Excel5',
            'columns' => array(
                array(
                    'field' => 'login_time',
                    'label' => $this->getAttributeLabel('login_time'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'logout_time',
                    'label' => $this->getAttributeLabel('logout_time'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => 'Yii::app()->dateFormatter->formatDateTime($value)',
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'profile_search',
                    'label' => $this->getAttributeLabel('profile_search'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => array('attributes' => array('user->profile->first_name', 'user->profile->last_name'), 'separator' => ' '),
                    'width' => 25,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'ip_address',
                    'label' => $this->getAttributeLabel('ip_address'),
                    'type' => PHPExcel_Cell_DataType::TYPE_STRING,
                    'value' => null,
                    'width' => 30,
                    'itemAlias' => null,
                    'formatter' => null,
                    'headerStyle' => null,
                    'cellStyle' => null,
                ),
                array(
                    'field' => 'user_agent',
                    'label' => $this->getAttributeLabel('user_agent'),
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
