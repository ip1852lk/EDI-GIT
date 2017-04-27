<?php

class LogoutController extends JController
{

    public $defaultAction = 'logout';
    public $layout = '//layouts/column4';

    /**
     * Logout the current user and redirect to returnLogoutUrl.
     */
    public function actionLogout()
    {
        if (Yii::app()->session->isStarted) {
            $attributes = array(
                'user_id' => Yii::app()->user->id,
                'session_id' => Yii::app()->session->sessionID,
                'ip_address' => Yii::app()->request->getUserHostAddress(),
            );
            $userLog = UserLog::model()->findByAttributes($attributes);
            if (isset($userLog)) {
                $userLog->logout_time = new CDbExpression('NOW()');
                $userLog->save();
            }
        }
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->controller->module->returnLogoutUrl);
    }

}
