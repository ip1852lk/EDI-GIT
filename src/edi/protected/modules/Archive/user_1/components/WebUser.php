<?php

class WebUser extends CWebUser
{

    public function getRole()
    {
        return $this->getState('__role');
    }

    public function getId()
    {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }

    protected function beforeLogin($id, $states, $fromCookie)
    {
        parent::beforeLogin($id, $states, $fromCookie);
        return true;
    }

    protected function afterLogin($fromCookie)
    {
        parent::afterLogin($fromCookie);
        $this->updateSession();
        if (Yii::app()->session->isStarted) {
            $userLog = new UserLog();
            $userLog->attributes = array(
                'user_id' => Yii::app()->user->id,
                'session_id' => Yii::app()->session->sessionID,
                'ip_address' => Yii::app()->request->getUserHostAddress(),
                'login_time' => new CDbExpression('NOW()'),
                'user_agent' => Yii::app()->request->getUserAgent(),
            );
            $userLog->save();
        }
    }

    public function updateSession()
    {
        $user = Yii::app()->getModule('user')->user($this->id);
        if (isset($user) && isset($user->profile)) {
            $profile = $user->profile;
            $this->setState('email', $user->email);
            $this->setState('user_type', $profile->user_type);
            $this->setState('lo1_id', $profile->lo1_id);
            $this->setState('lo1_code', isset($profile->location) ? $profile->location->lo1_code : '');
            $this->setState('lo1_name', isset($profile->location) ? $profile->location->lo1_name : '');
            $this->setState('cu1_id', $profile->cu1_id);
            $this->setState('cu1_code', isset($profile->customer) ? $profile->customer->cu1_code : '');
            $this->setState('cu1_name', isset($profile->customer) ? $profile->customer->cu1_name : '');
            $this->setState('su1_id', $profile->su1_id);
            $this->setState('su1_code', isset($profile->supplier) ? $profile->supplier->su1_code : '');
            $this->setState('su1_name', isset($profile->supplier) ? $profile->supplier->su1_name : '');
        }
    }

    public function model($id = 0)
    {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id = 0)
    {
        return $this->model($id);
    }

    public function getUserByName($username)
    {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins()
    {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin()
    {
        return Yii::app()->getModule('user')->isAdmin();
    }

}
