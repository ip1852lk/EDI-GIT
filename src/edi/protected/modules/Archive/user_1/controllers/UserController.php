<?php

class UserController extends RController
{
    public $defaultAction = 'index';
    public $layout = '//layouts/column4';
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'rights', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        ));
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
     * Displays a particular model.
     */
    public function actionView()
    {
        $model = $this->loadModel();
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User();
        $profile = new Profile();
        $profile->excludeTableFromLogging('Profile');
        $this->performAjaxValidation(array($model, $profile));
        if (isset($_POST['User']) && isset($_POST['Profile'])) {
            $model->attributes = $_POST['User'];
            $model->username = $_POST['User']['username'];
            $model->password = $_POST['User']['password'];
            $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
            $profile->attributes = $_POST['Profile'];
            $profile->user_id = 0;
            if ($model->validate() && $profile->validate()) {
                $model->password = Yii::app()->controller->module->encrypting($model->password);
                if ($model->save()) {
                    $profile->user_id = $model->id;
                    if ($profile->save()) {
                        if ($profile->user_type == User::TYPE_INTERNAL)
                            Rights::getAuthorizer()->authManager->assign('Internal', $model->id);
                        elseif ($profile->user_type == User::TYPE_CUSTOMER)
                            Rights::getAuthorizer()->authManager->assign('Customer', $model->id);
                        elseif ($profile->user_type == User::TYPE_SUPPLIER)
                            Rights::getAuthorizer()->authManager->assign('Supplier', $model->id);
                        if (isset($_GET['dependency']) && isset($_GET['parentId']))
                            $this->redirect(array(
                                $_GET['dependency'],
                                'id' => (int)$_GET['parentId'],
                                'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                                'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0),
                            ));
                        else
                            $this->redirect(array('index'));
                    } else {
                        $model->delete();
                        throw new CHttpException(500, Yii::t('app', 'User cannot be created.'));
                    }
                } else
                    throw new CHttpException(500, Yii::t('app', 'User cannot be created.'));
            }
        }        $model = new User();
        $profile = new Profile();
        $profile->excludeTableFromLogging('Profile');
        $this->performAjaxValidation(array($model, $profile));
        if (isset($_POST['User']) && isset($_POST['Profile'])) {
            $model->attributes = $_POST['User'];
            $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
            $profile->attributes = $_POST['Profile'];
            $profile->user_id = 0;
            if ($model->validate() && $profile->validate()) {
                $model->password = Yii::app()->controller->module->encrypting($model->password);
                if ($model->save()) {
                    $profile->user_id = $model->id;
                    if ($profile->save()) {
                        if ($profile->user_type == User::TYPE_INTERNAL)
                            Rights::getAuthorizer()->authManager->assign('Internal', $model->id);
                        elseif ($profile->user_type == User::TYPE_CUSTOMER)
                            Rights::getAuthorizer()->authManager->assign('Customer', $model->id);
                        elseif ($profile->user_type == User::TYPE_SUPPLIER)
                            Rights::getAuthorizer()->authManager->assign('Supplier', $model->id);
                        if (isset($_GET['dependency']) && isset($_GET['parentId']))
                            $this->redirect(array(
                                $_GET['dependency'],
                                'id' => (int)$_GET['parentId'],
                                'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                                'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0),
                            ));
                        else
                            $this->redirect(array('index'));
                    } else {
                        $model->delete();
                        throw new CHttpException(500, Yii::t('app', 'User cannot be created.'));
                    }
                } else
                    throw new CHttpException(500, Yii::t('app', 'User cannot be created.'));
            }
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            if ($_GET['parentPk'] == 'cu1_id') {
                $profile->user_type = User::TYPE_CUSTOMER;
                $profile->cu1_id = (int)$_GET['parentId'];
            } elseif ($_GET['parentPk'] == 'lo1_id') {
                $profile->user_type = User::TYPE_CUSTOMER;
                $profile->lo1_id = (int)$_GET['parentId'];
                $location = Location::model()->findByPk((int)$_GET['parentId']);
                if (isset($location)) {
                    $profile->cu1_id = $location->facility->cu1_id;
                }
            } elseif ($_GET['parentPk'] == 'su1_id') {
                $profile->user_type = User::TYPE_SUPPLIER;
                $profile->su1_id = (int)$_GET['parentId'];
            }
        }
        $this->render('create', array(
            'model' => $model, 
            'profile' => $profile, 
            'dependency' => (isset($_GET['dependency'])?$_GET['dependency']:null), 
            'dependencyTabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:null), 
            'dependencyTabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:null),
            'parentPk' => (isset($_GET['parentPk'])?$_GET['parentPk']:null), 
            'parentId' => (isset($_GET['parentId'])?$_GET['parentId']:null), 
            'tabIndex' => (isset($_GET['tabIndex'])?$_GET['tabIndex']:($this->isMobile?0:1)),
            'tabDropdownIndex' => (isset($_GET['tabDropdownIndex'])?$_GET['tabDropdownIndex']:0), 
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
        $profile = $model->profile;
        $this->performAjaxValidation(array($model, $profile));
        if (!Yii::app()->user->checkAccess('Admin') && $model->superuser == 1) {
            throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to access this page.'));
        } elseif (isset($_POST['User']) && isset($_POST['Profile'])) {
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];
            $model->password = $_POST['User']['password'];
            if ($model->validate() && $profile->validate()) {
                $old_user = User::model()->notsafe()->findByPk($model->id);
                if ($old_user->password != $model->password) {
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
                    $model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
                }
                if ($model->save()) {
                    $old_profile = Profile::model()->findByPk($profile->user_id);
                    if ($old_profile->user_type != $profile->user_type) {
                        $assignedItems = Rights::getAuthorizer()->authManager->getAuthItems(null, $model->id);
                        $roles = array_keys($assignedItems);
                        foreach ($roles as $role) {
                            Rights::getAuthorizer()->authManager->revoke($role, $model->id);
                        }
                        if ($profile->user_type == User::TYPE_INTERNAL)
                            Rights::getAuthorizer()->authManager->assign('Internal', $model->id);
                        elseif ($profile->user_type == User::TYPE_CUSTOMER)
                            Rights::getAuthorizer()->authManager->assign('Customer', $model->id);
                        elseif ($profile->user_type == User::TYPE_SUPPLIER)
                            Rights::getAuthorizer()->authManager->assign('Supplier', $model->id);
                    }
                    if ($profile->save()) {
                        if (isset($_GET['dependency']) && isset($_GET['parentId'])) 
                            $this->redirect(array(
                                $_GET['dependency'], 
                                'id' => (int)$_GET['parentId'], 
                                'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                                'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0), 
                            ));
                        else
                            $this->redirect(array('index'));
                    } else 
                        throw new CHttpException(500, Yii::t('app', 'User cannot be saved.'));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'User cannot be saved.'));
            }
        }
        $this->render('update', array(
            'model' => $model, 
            'profile' => $profile, 
            'dependency' => (isset($_GET['dependency'])?$_GET['dependency']:null), 
            'dependencyTabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:null), 
            'dependencyTabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:null),
            'parentPk' => (isset($_GET['parentPk'])?$_GET['parentPk']:null), 
            'parentId' => (isset($_GET['parentId'])?$_GET['parentId']:null), 
            'tabIndex' => (isset($_GET['tabIndex'])?$_GET['tabIndex']:($this->isMobile?0:1)),
            'tabDropdownIndex' => (isset($_GET['tabDropdownIndex'])?$_GET['tabDropdownIndex']:0), 
        ));
    }

    /**
     * REQUIRED
     * Updates an attribute value of this model.
     * @throws CHttpException
     */
    public function actionEdit()
    {
        if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value'])) {
            $model = User::model()->findByPk((int)$_POST['pk']);
            $profile = $model->profile;
            if (isset($model) && isset($profile)) {
                if (isset($model->{$_POST['name']}) || isset($profile->{$_POST['name']})) {
                    if (isset($model->{$_POST['name']})) {
                        $model->{$_POST['name']} = $_POST['value'];
                        if (!$model->update([$_POST['name']]))
                            throw new CHttpException(500, Yii::t('app', 'Internal Error'));
                    } elseif (isset($profile->{$_POST['name']})) {
                        $profile->{$_POST['name']} = $_POST['value'];
                        if (!$profile->update([$_POST['name']]))
                            throw new CHttpException(500, Yii::t('app', 'Internal Error'));
                    }
                } else
                    throw new CHttpException(400, Yii::t('app', 'Invalid Request'));
            } else
                throw new CHttpException(404, Yii::t('app', 'The requested record does not exist.'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Invalid Request'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel();
            $profile = $model->profile;
            $profile->delete();
            $model->delete();
            if (!isset($_REQUEST['ajax']))
                Yii::app()->user->setFlash('success', UserModule::t('<span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.', array(':record' => $model->username)));
            else
                echo UserModule::t('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.</div>', array(':record' => $model->username));
            // Redirect
            if (isset($_REQUEST['ajax']))
                Yii::app()->end();
            elseif (isset($_GET['dependency']) && isset($_GET['parentId'])) 
                $this->redirect(array(
                    $_GET['dependency'], 
                    'id' => (int)$_GET['parentId'], 
                    'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                    'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0), 
                ));
            else 
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
            unset($_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
        }
        $isAdmin = Yii::app()->user->checkAccess('Admin');
        $alias = User::model()->getTableAlias(false, false);
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];
        if (!$isAdmin) {
            $criteria = $model->getDbCriteria();
            $criteria->compare($alias.'.superuser', 0); // Hide all superusers
            $criteria->addCondition($alias.'.status > ' . User::STATUS_BANNED); // Hide banned users
            $model->setDbCriteria($criteria);
        }
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('User.User.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'user-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false, $isAdmin);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'User data cannot be exported.');
                    } else {
                        $status = '200';
                        $statusText = 'success';
                        $body = $file;
                    }
                    echo CJSON::encode(array(
                        'status' => $status,
                        'statusText' => $statusText,
                        'body' => $body,
                    ));
                    Yii::app()->end();
                } else {
                    if (!$model->export(true, $isAdmin)) {
                        Yii::log('User data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'User data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export User data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export User data.'));
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * @deprecated since version 2.0.0
     * Exports records to Excel.
     */
    public function actionExport()
    {
        throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * REQUIRED
     * Returns a grid in JSON.
     */
    public function actionDependency()
    {
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
                unset($_GET['pageSize']);
            } else {
                Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
            }
            $isAdmin = Yii::app()->user->checkAccess('Admin');
            $alias = User::model()->getTableAlias(false, false);
            $model = new User('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['User']))
                $model->attributes = $_GET['User'];
            $criteria = $model->getDbCriteria();
            if (!$isAdmin) {
                $criteria->compare($alias.'.superuser', 0); // Hide all superusers
                $criteria->addCondition($alias.'.status > ' . User::STATUS_BANNED); // Hide banned users
            }
            if ($_GET['parentPk'] == 'lo1_id') 
                $criteria->compare('profile.lo1_id', (int)$_GET['parentId']);
            elseif ($_GET['parentPk'] == 'cu1_id') 
                $criteria->compare('profile.cu1_id', (int)$_GET['parentId']);
            elseif ($_GET['parentPk'] == 'su1_id') 
                $criteria->compare('profile.su1_id', (int)$_GET['parentId']);
            $model->setDbCriteria($criteria);
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('User.User.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'user-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false, $isAdmin);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'User data cannot be exported.');
                        } else {
                            $status = '200';
                            $statusText = 'success';
                            $body = $file;
                        }
                        echo CJSON::encode(array(
                            'status' => $status,
                            'statusText' => $statusText,
                            'body' => $body,
                        ));
                        Yii::app()->end();
                    } else {
                        if (!$model->export(true, $isAdmin)) {
                            Yii::log('User data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'User data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export User data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export User data.'));
                }
            }
            $this->renderPartial('application.modules.user.views.user._grid', array(
                'model' => $model,
                'dependency' => $_GET['dependency'],
                'dependencyTabIndex' => $_GET['dependencyTabIndex'],
                'dependencyTabDropdownIndex' => $_GET['dependencyTabDropdownIndex'],
                'parentPk' => $_GET['parentPk'],
                'parentId' => (int)$_GET['parentId'],
            ), false, true);
        } else 
            throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
    }

    /**
     * REQUIRED
     * Returns a grid in JSON.
     */
    public function actionRelation()
    {
        if ($this->isMobile)
            Yii::app()->user->setState('pageSize',5);
        else
            Yii::app()->user->setState('pageSize',10);
        if (isset($_GET['pageSize'])) 
            unset($_GET['pageSize']);
        $alias = User::model()->getTableAlias(false, false);
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];
        if (isset($_GET['username'])) 
            $model->username = $_GET['username'];
        if (isset($_GET['email'])) 
            $model->email = $_GET['email'];
        if (isset($_GET['superuser'])) 
            $model->superuser = (int)$_GET['superuser'];
        if (isset($_GET['status'])) 
            $model->status = (int)$_GET['status'];
        $criteria = $model->getDbCriteria();
        if (!Yii::app()->user->checkAccess('Admin')) {
            $criteria->compare($alias.'.superuser', 0); // Hide all superusers
            $criteria->addCondition($alias.'.status > ' . User::STATUS_BANNED); // Hide banned users
        }
        if (isset($_GET['profile_full_name_search']) && strlen($_GET['profile_full_name_search']) > 0) {
            $criteria->addCondition('CONCAT(profile.first_name, " ", profile.last_name) LIKE :profile_full_name_search');
            $criteria->params = array_merge($criteria->params, array(':profile_full_name_search' => '%' . $_GET['profile_full_name_search'] . '%'));
        }
        if (isset($_GET['user_type'])) 
            $criteria->compare('profile.user_type', (int)$_GET['user_type']);
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'lo1_id') 
            $criteria->compare('profile.lo1_id', (int)$_GET['parentId']);
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'cu1_id') 
            $criteria->compare('profile.cu1_id', (int)$_GET['parentId']);
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'su1_id') 
            $criteria->compare('profile.su1_id', (int)$_GET['parentId']);
        $model->setDbCriteria($criteria);
        $this->renderPartial('application.modules.user.views.user._grid', array(
            'model' => $model,
            'relation' => true,
            'relationIndex' => isset($_GET['relationIndex'])?(int)$_GET['relationIndex']:1,
            'relationSelectableRows' => isset($_GET['relationSelectableRows'])?(int)$_GET['relationSelectableRows']:1,
        ), false, true);
    }

    /**
     * REQUIRED
     * Returns records in JSON.
     */
    public function actionAjaxGet()
    {
        header('Content-type: application/json');
        if (Yii::app()->user->checkAccess('User.User.AjaxGet')) {
            $alias = User::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            $criteria->params = array();
            if (!Yii::app()->user->checkAccess('Admin')) {
                $criteria->compare($alias.'.superuser', 0); // Hide all superusers
                $criteria->addCondition($alias.'.status > ' . User::STATUS_BANNED); // Hide banned users
            }
            if (isset($_GET['username'])) 
                $criteria->compare('username', $this->username, true);
            if (isset($_GET['email'])) 
                $criteria->compare('email', $this->email, true);
            if (isset($_GET['superuser'])) 
                $criteria->compare('superuser', $this->superuser);
            if (isset($_GET['status'])) 
                $criteria->compare('status', $this->status);
            if (isset($_GET['profile_full_name_search']) && strlen($_GET['profile_full_name_search']) > 0) {
                $criteria->addCondition('CONCAT(profile.first_name, " ", profile.last_name) LIKE :profile_full_name_search');
                $criteria->params = array_merge($criteria->params, array(':profile_full_name_search' => '%' . $_GET['profile_full_name_search'] . '%'));
            }
            if (isset($_GET['user_type'])) 
                $criteria->compare('profile.user_type', $_GET['user_type']);
            if (isset($_GET['lo1_id'])) 
                $criteria->compare('profile.lo1_id', $_GET['lo1_id']);
            if (isset($_GET['cu1_id'])) 
                $criteria->compare('profile.cu1_id', $_GET['cu1_id']);
            if (isset($_GET['su1_id'])) 
                $criteria->compare('profile.su1_id', $_GET['su1_id']);
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => User::getListData($criteria),
            );
        } else {
            $return = array(
                'status' => '401',
                'statusText' => 'fail',
                'body' => Yii::t('app', 'You are not fully authorized to access this page.'),
            );
        }
        echo CJSON::encode($return);
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @return array|User|mixed|null
     * @throws CHttpException
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                if (Yii::app()->user->checkAccess('Admin')) {
                    $this->_model = User::model()->notsafe()->findbyPk($_GET['id']);
                } else {
                    $this->_model = User::model()->findbyPk($_GET['id']);
                }
            }
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel|array $model the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'user-form') {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }

}
