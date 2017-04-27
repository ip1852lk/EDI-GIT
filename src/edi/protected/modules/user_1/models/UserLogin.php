<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{

    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            //array('username', 'length', 'max' => 60, 'min' => 4,),
            //array('password', 'length', 'max' => 128, 'min' => 6,),
            array('rememberMe', 'boolean',),
            array('password', 'authenticate',),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe' => Yii::t('app', "Stay signed in"),
            'username' => Yii::t('app', "Username"),
            'password' => Yii::t('app', "Password"),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            $identity = new UserIdentity($this->username, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    //$this->addError("username", Yii::t('app', "Email is incorrect."));
                    $this->addError("", Yii::t('app', "Username or Password is incorrect."));
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    //$this->addError("username", Yii::t('app', "Username is incorrect."));
                    $this->addError("", Yii::t('app', "Username or Password is incorrect."));
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status", Yii::t('app', "You account is not activated."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status", Yii::t('app', "You account is blocked."));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    //$this->addError("password", Yii::t('app', "Password is incorrect."));
                    $this->addError("", Yii::t('app', "Username or Password is incorrect."));
                    break;
            }
        }
    }

}
