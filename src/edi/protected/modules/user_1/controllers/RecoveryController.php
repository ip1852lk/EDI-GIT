<?php

class RecoveryController extends JController
{

    public $defaultAction = 'recovery';
    public $layout = '//layouts/column4';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        // TODO
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Recovery password
     */
    public function actionRecovery()
    {
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->returnUrl);
        } else {
            $email = isset($_GET['email']) ? $_GET['email'] : '';
            $activkey = isset($_GET['activkey']) ? $_GET['activkey'] : '';
            if ($email && $activkey) {
                $find = User::model()->notsafe()->findByAttributes(array('email' => $email));
                if (isset($find) && $find->activkey == $activkey) {
                    $model = new UserChangePassword();
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'password-change-form') {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                    }
                    if (isset($_POST['UserChangePassword'])) {
                        $model->attributes = $_POST['UserChangePassword'];
                        if ($model->validate()) {
                            $find->password = Yii::app()->controller->module->encrypting($model->password);
                            $find->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
                            if ($find->status == 0) {
                                $find->status = 1;
                            }
                            $find->save();
                            Yii::app()->user->setFlash(
                                    'recoveryMessage', UserModule::t('<span class="label label-success">UPDATED</span> The new password is updated successfully. Please :login  to :site_name now.', array(':site_name' => Yii::app()->name, ':login' => CHtml::link(UserModule::t('Log On'), Yii::app()->controller->module->loginUrl)) ));
                            $this->redirect(Yii::app()->controller->module->recoveryUrl);
                        }
                    }
                    $this->render('changepassword', array(
                        'model' => $model
                    ));
                } else {
                    Yii::app()->user->setFlash(
                            'recoveryErrorMessage', UserModule::t('<span class="label label-danger">ERROR</span> Incorrect password reset URL.'));
                    $this->redirect(Yii::app()->controller->module->recoveryUrl);
                }
            } else {
                $model = new UserRecoveryForm();
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'password-restore-form') {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }
                if (isset($_POST['UserRecoveryForm'])) {
                    $model->attributes = $_POST['UserRecoveryForm'];
                    if ($model->validate()) {
                        // FIXME - Captcha Bug
                        $session = Yii::app()->session;
                        $prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
                        foreach ($session->keys as $key) {
                            if (strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
                                $session->remove($key);
                        }
                        // Sends a password restore email.
                        $user = User::model()->notsafe()->findbyPk($model->user_id);
                        $recovery_url = $this->createAbsoluteUrl(implode(Yii::app()->controller->module->recoveryUrl), array(
                            "activkey" => $user->activkey,
                            "email" => $user->email
                        ));
                        $subject = UserModule::t(
                            "Password Recovery for :site_name", array(':site_name' => Yii::app()->name,)
                        );
                        $message = UserModule::t(
                            "Please visit the following link to reset your password for :site_name.<br>:recovery_url",
                            array(
                                ':site_name' => Yii::app()->name,
                                ':recovery_url' => $recovery_url,
                            )
                        );
                        UserModule::sendMail($user->email, $subject, $message);
                        Yii::app()->user->setFlash(
                            'recoveryMessage', UserModule::t('<span class="label label-success">EMAIL SENT</span> A password recovery instruction is sent to your email address successfully.'));
                        $this->refresh();
                    }
                }
                $this->render('recovery', array(
                    'model' => $model
                ));
            }
        }
    }

}
