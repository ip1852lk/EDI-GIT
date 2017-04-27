<?php

class ProfileController extends RController
{

    public $defaultAction = 'view';
    public $layout = '//layouts/column4';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Shows a particular model.
     */
    public function actionView()
    {
        $model = $this->loadUser();
        $this->render('view', array(
            'model' => $model,
            'profile' => $model->profile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadUser();
        $profile = $model->profile;
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'profile-form') {
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }
        if (isset($_POST['User']) && isset($_POST['Profile'])) {
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];
            if ($model->validate() && $profile->validate()) {
                $model->save();
                $profile->save();
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash(
                        'profileMessage', UserModule::t('<span class="label label-success">UPDATED</span> Your account is updated successfully.'));
                $this->redirect(array('view'));
            } else
                $profile->validate();
        }
        $this->render('update', array(
            'model' => $model,
            'profile' => $profile,
        ));
    }

    /**
     * Change password
     */
    public function actionChangepassword()
    {
        if (Yii::app()->user->id) {
            $model = new UserChangePassword();
            if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'password-change-form') {
                echo UActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['UserChangePassword'])) {
                $model->attributes = $_POST['UserChangePassword'];
                if ($model->validate()) {
                    $user = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                    $user->password = UserModule::encrypting($model->password);
                    $user->activkey = UserModule::encrypting(microtime() . $model->password);
                    $user->save();
                    Yii::app()->user->setFlash(
                            'profileMessage', UserModule::t('<span class="label label-success">UPDATED</span> The new password is updated successfully.'));
                    $this->redirect(array('view'));
                }
            }
            $this->render('changepassword', array(
                'model' => $model
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @return Profile|null
     */
    public function loadUser()
    {
        if ($this->_model === null) {
            if (Yii::app()->user->id)
                $this->_model = Yii::app()->controller->module->user();
            if ($this->_model === null)
                $this->redirect(Yii::app()->controller->module->loginUrl);
        }
        return $this->_model;
    }

}
