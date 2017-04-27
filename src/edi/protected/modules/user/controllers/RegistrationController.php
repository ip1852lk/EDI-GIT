<?php

class RegistrationController extends JController
{

    public $defaultAction = 'registration';
    public $layout = '//layouts/column4';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Registration user
     */
    public function actionRegistration()
    {
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {
            $model = new RegistrationForm();
            $profile = new Profile();
            $profile->excludeTableFromLogging('Profile');
            $profile->regMode = true;
            if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'registration-form') {
                echo UActiveForm::validate(array($model, $profile));
                Yii::app()->end();
            }
            if (isset($_POST['RegistrationForm'])) {
                $model->attributes = $_POST['RegistrationForm'];
                $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                if ($model->validate() && $profile->validate()) {
                    $soucePassword = $model->password;
                    $model->activkey = UserModule::encrypting(microtime() . $model->password);
                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->superuser = 0;
                    $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
                    if ($model->save()) {
                        // FIXME - Captcha Bug
                        $session = Yii::app()->session;
                        $prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
                        foreach ($session->keys as $key) {
                            if (strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
                                $session->remove($key);
                        }
                        // Assigns a defualt role.
                        Rights::getAuthorizer()->authManager->assign('Inactive', $model->id);
                        // Sends an activation email.
                        $profile->user_id = $model->id;
                        $profile->save();
                        if (Yii::app()->controller->module->sendActivationMail) {
                            $activation_url = $this->createAbsoluteUrl('/user/registration/activation', array(
                                "activkey" => $model->activkey,
                                "email" => $model->email
                            ));
                            UserModule::sendMail(
                                    $model->email, UserModule::t("Account Activation for :site_name", array(':site_name' => Yii::app()->name)), UserModule::t("Your account has been registered successfully on :site_name. Please check your eamil to activate your account.<br><br>:activation_url", array(
                                        ':site_name' => Yii::app()->name, ':activation_url' => $activation_url))
                            );
                        }
                        if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) &&
                                Yii::app()->controller->module->autoLogin) {
                            $identity = new UserIdentity($model->username, $soucePassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity, 0);
                            $this->redirect(Yii::app()->controller->module->returnUrl);
                        } else {
                            if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                Yii::app()->user->setFlash(
                                        'registration', UserModule::t('<span class="label label-info">REGISTERED</span> Thank you for your registration. Contact your administrator to activate your account.'));
                            } elseif (Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                Yii::app()->user->setFlash(
                                        'registration', UserModule::t('<span class="label label-success">REGISTERED</span> Thank you for your registration. Please :login now.', array(':login' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
                            } elseif (Yii::app()->controller->module->loginNotActiv) {
                                Yii::app()->user->setFlash(
                                        'registration', UserModule::t('<span class="label label-success">REGISTERED</span> Thank you for your registration. Please check your email or :login.', array(':login' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
                            } else {
                                Yii::app()->user->setFlash(
                                        'registration', UserModule::t('<span class="label label-success">REGISTERED</span> Thank you for your registration. Please check your email to activate your account.'));
                            }
                            $this->refresh();
                        }
                    }
                } else
                    $profile->validate();
            }
            $this->render('/registration/registration', array(
                'model' => $model,
                'profile' => $profile
            ));
        }
    }

    /**
     * Activation user account
     */
    public function actionActivation()
    {
        $email = $_GET['email'];
        $activkey = $_GET['activkey'];
        if ($email && $activkey) {
            $find = User::model()->notsafe()->findByAttributes(array('email' => $email));
            if (isset($find) && $find->status) {
                $this->render('/registration/activation', array(
                    'title' => UserModule::t("Account Activation"),
                    'content' => UserModule::t('<span class="label label-info">ACTIVATED</span> You account has been activated already. Please :login  to :site_name now.', array(':site_name' => Yii::app()->name, ':login' => CHtml::link(UserModule::t('Log On'), Yii::app()->controller->module->loginUrl) ))
                ));
            } elseif (isset($find) && isset($find->activkey) && ($find->activkey == $activkey)) {
                $find->activkey = UserModule::encrypting(microtime());
                $find->status = 1;
                $find->save();
                $this->render('/registration/activation', array(
                    'title' => UserModule::t("Account Activation"),
                    'content' => UserModule::t('<span class="label label-success">ACTIVATED</span> You account has been activated successfully. Please :login  to :site_name now.', array(':site_name' => Yii::app()->name, ':login' => CHtml::link(UserModule::t('Log On'), Yii::app()->controller->module->loginUrl) ))
                ));
            } else {
                $this->render('/registration/activation', array(
                    'title' => UserModule::t("Account Activation"),
                    'content' => UserModule::t('<span class="label label-danger">ERROR</span> Incorrect activation URL.')
                ));
            }
        } else {
            $this->render('/registration/activation', array(
                'title' => UserModule::t("Account Activation"),
                'content' => UserModule::t('<span class="label label-danger">ERROR</span> Incorrect activation URL.')
            ));
        }
    }

}
