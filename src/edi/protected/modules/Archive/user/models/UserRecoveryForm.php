<?php

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class UserRecoveryForm extends CFormModel
{

    public $login_or_email, $verifyCode, $user_id;

    public function rules()
    {
        $rules = array(
            array('login_or_email, verifyCode', 'required'),
            array('login_or_email', 'match', 'pattern' => '/^[A-Za-z0-9@.\-\s,]+$/u', 'message' => Yii::t('app', "Incorrect symbols (A-z0-9).")),
        );
        if (!(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'password-restore-form')) {
            array_push($rules, array('verifyCode', 'captcha', 'allowEmpty' => !UserModule::doCaptcha('recovery')));
        }
        array_push($rules, array('login_or_email', 'accountExists'));
        return $rules;
    }

    public function attributeLabels()
    {
        return array(
            'login_or_email' => Yii::t('app', "Username or Email"),
        );
    }

    /**
     * Checks whether the givie username or email exists or not.
     * @param type $attribute
     * @param type $params
     */
    public function accountExists($attribute, $params)
    {
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            if (strpos($this->login_or_email, "@")) {
                $user = User::model()->findByAttributes(array('email' => $this->$attribute));
                if ($user)
                    $this->user_id = $user->id;
            } else {
                $user = User::model()->findByAttributes(array('username' => $this->$attribute));
                if ($user)
                    $this->user_id = $user->id;
            }
            if ($user === null) {
                if (strpos($this->login_or_email, "@")) {
                    $this->addError($attribute, Yii::t('app', "Email is incorrect."));
                } else {
                    $this->addError($attribute, Yii::t('app', "Username is incorrect."));
                }
            }
        }
    }

}
