<?php

class EmailController extends RController
{
    /**
     * REQUIRED
     * @var string the default layout for the views. Defaults to '//layouts/column4', 
     * meaning using four-column layout. See 'protected/views/layouts/column4.php'.
     */
    public $layout = '//layouts/column4';

    /**
     * REQUIRED
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
     * REQUIRED
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('processEmails'),
                'ips' => array('*'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * REQUIRED
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('//email/view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * REQUIRED
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws CHttpException
     */
    public function actionCreate()
    {
        $model = new Email();
        $this->performAjaxValidation(array($model));
        if (isset($_POST['Email'])) {
            $model->attributes = $_POST['Email'];
            if ($model->validate()) {
                if ($model->save()) {
                    if (isset($_GET['dependency']) && isset($_GET['parentId'])) 
                        $this->redirect(array(
                            $_GET['dependency'], 
                            'id' => (int)$_GET['parentId'], 
                            'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                            'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0), 
                        ));
                    else 
                        $this->redirect(array('view', 'id' => $model->id));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'Email cannot be created.'));
            }
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            $model->{$_GET['parentPk']} = (int)$_GET['parentId'];
            // TODO: Implement your code here regarding dependency control
        }
        $this->render('//email/create', array(
            'model' => $model,
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation(array($model));
        if (isset($_POST['Email'])) {
            $model->attributes = $_POST['Email'];
            if ($model->validate()) {
                if ($model->save()) {
                    if (isset($_GET['dependency']) && isset($_GET['parentId'])) 
                        $this->redirect(array(
                            $_GET['dependency'], 
                            'id' => $model->{$_GET['parentPk']}, 
                            'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                            'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0), 
                        ));
                    else 
                        $this->redirect(array('view', 'id' => $model->id));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'Email cannot be saved.'));
            }
        }
        $this->render('//email/update', array(
            'model' => $model,
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->delete();
            if (!isset($_REQUEST['ajax']))
                Yii::app()->user->setFlash('success', Yii::t('app', '<span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.', array(':record' => $model->id)));
            else
                echo Yii::t('app', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.</div>', array(':record' => $model->id));
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
     * REQUIRED
     * Lists all models.
     */
    public function actionBlog()
    {
        $dataProvider = new CActiveDataProvider('Email');
        $this->render('//email/blog', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * REQUIRED
     * Lists all models.
     * @throws CHttpException
     */
    public function actionIndex()
    {
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
            unset($_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
        }
        $model = new Email('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Email']))
            $model->attributes = $_GET['Email'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('Email.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'email-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Email data cannot be exported.');
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
                    if (!$model->export(true)) {
                        Yii::log('Email data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Email data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Email data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Email data.'));
            }
        }
        $this->render('//email/index', array(
            'model' => $model,
        ));
    }

//    /**
//     * REQUIRED
//     * Lists all models.
//     * @throws CHttpException
//     */
//    public function actionIndexErrors()
//    {
//        if (isset($_GET['pageSize'])) {
//            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
//            unset($_GET['pageSize']);
//        } else {
//            Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
//        }
//        $model = new Email('search');
//        $model->unsetAttributes();  // clear any default values
//
//        $criteria = $model->getDbCriteria();
//        $criteria->addCondition("MATCH (t.em1_subject, t.em1_content) AGAINST ('\"File Not Found\"' IN BOOLEAN MODE)");
//        $model->setDbCriteria($criteria);
//
//        if (isset($_GET['Email']))
//            $model->attributes = $_GET['Email'];
//        if (isset($_GET['export'])) {
//            if (Yii::app()->user->checkAccess('Email.Export')) {
//                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'email-grid') {
//                    header('Content-type: application/json');
//                    $file = $model->export(false);
//                    if ($file === false) {
//                        $status = '500';
//                        $statusText = 'fail';
//                        $body = Yii::t('app', 'Email data cannot be exported.');
//                    } else {
//                        $status = '200';
//                        $statusText = 'success';
//                        $body = $file;
//                    }
//                    echo CJSON::encode(array(
//                        'status' => $status,
//                        'statusText' => $statusText,
//                        'body' => $body,
//                    ));
//                    Yii::app()->end();
//                } else {
//                    if (!$model->export(true)) {
//                        Yii::log('Email data cannot be exported.', CLogger::LEVEL_ERROR);
//                        throw new CHttpException(500, Yii::t('app', 'Email data cannot be exported.'));
//                    }
//                }
//            } else {
//                Yii::log('This user is not permitted to export Email data.', CLogger::LEVEL_ERROR);
//                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Email data.'));
//            }
//        }
//        $this->render('//email/index', array(
//            'model' => $model,
//        ));
//    }

    /**
     * REQUIRED
     * Lists all Error models.
     * @throws CHttpException
     */
    /*public function actionIndexErrors()
    {
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
            unset($_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
        }
        //$model = new Email('search');
        //$modelErrors = new Email('search');
        //$model->unsetAttributes();  // clear any default values
        $model = new Email();
        if (isset($_GET['Email'])) {
            if(isset($_GET['Email'])) {
                $model->attributes = $_GET['Email'];
            }
        }
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('Email.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'email-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Email data cannot be exported.');
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
                    if (!$model->export(true)) {
                        Yii::log('Email data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Email data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Email data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Email data.'));
            }
        }
        $data = $model->errorSearch()->getData();
        Yii::log('$data.count = '.count($data), CLogger::LEVEL_ERROR);
        $this->render('//email/index', array(
            'model' => $model,
            'errorEmailsOnly'=>true,
        ));
    }*/

    /**
     * Used for dynamic scrolling updates of Email Grid
     */
    public function actionSelectMore()
    {
        $models = Email::model()->findAllBySql("SELECT * FROM em1_email LIMIT ".$_GET['offset'].",5");
        $tab = array();
        foreach($models as $model){
            $tab[] = $model->getAttributes();
        }
        print(json_encode($tab));
    }

    public function actionDownloadAttachment()
    {
        if(isset($_GET['id'])){
            $fileHelper = new CFileHelper();
            if(file_exists(Yii::app()->basePath.'/../uploads/'. $_GET['id'])) {
                $fileNames = $fileHelper->findFiles(Yii::app()->basePath.'/../uploads/'. $_GET['id']);
                foreach($fileNames as $fileName){
                    Yii::app()->getRequest()->sendFile($fileName,file_get_contents($fileName));
                }
            } else{
                throw new CHttpException(404, Yii::t('app', 'File not found.'));
            }
            $this->redirect(Yii::app()->createUrl('//email/index'));
        }
    }


    /**
     * Exports records to Excel.
     * @deprecated since version 2.0.0
     * @throws CHttpException
     */
    public function actionExport()
    {
        throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * REQUIRED
     * Returns a grid in JSON.
     * @throws CHttpException
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
            $model = new Email('search');
            $model->unsetAttributes();  // clear any default values
            $model->em1_seen = 0;
            if (isset($_GET['Email']))
                $model->attributes = $_GET['Email'];
            // TODO: Add additional filters here!
//            if ($_GET['parentPk'] == 'em1_address') {
//                $model->em1_address = $_GET['parentId'];
            if ($_GET['parentPk'] == 'cl1_id') {
                $model->cl1_id = $_GET['parentId'];
            }
            
            if (isset($_GET['reset']) && isset($model->em1_address)) {
//                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] ==='email-grid-'.$_GET['dependencyTabDropdownIndex'])
//                    header('Content-type: application/json');
                $sql='UPDATE em1_email SET em1_seen = \'1\' WHERE em1_address = \''.$model->em1_address.'\' AND delete_flag <> \'1\' ';
                $command = Yii::app()->db->createCommand($sql);
                try {
                    $sqlResult = $command->execute();
                } catch (Exception $ex){
                    $sqlResult=false;
                }
            }
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('Email.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'email-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'Email data cannot be exported.');
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
                        if (!$model->export(true)) {
                            Yii::log('Email data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'Email data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export Email data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Email data.'));
                }
            }
            if(isset($_GET['iasPagerLink'])){
                //Using the Yii-based infinite pager extension requires a render instead of a renderPartial due to grab the content
                $this->render('//email/_grid', array(
                    'model' => $model,
                    'dependency' => $_GET['dependency'],
                    'dependencyTabIndex' => $_GET['dependencyTabIndex'],
                    'dependencyTabDropdownIndex' => $_GET['dependencyTabDropdownIndex'],
                    'parentPk' => $_GET['parentPk'],
                    'parentId' => $_GET['parentId'],
                    )
                );
            } else {
                $this->renderPartial('//email/_grid', array(
                    'model' => $model,
                    'dependency' => $_GET['dependency'],
                    'dependencyTabIndex' => $_GET['dependencyTabIndex'],
                    'dependencyTabDropdownIndex' => $_GET['dependencyTabDropdownIndex'],
                    'parentPk' => $_GET['parentPk'],
                    'parentId' => $_GET['parentId'],
                ), false, true);
            }
        } else 
            throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
    }

    /**
     * REQUIRED
     * Returns a grid in JSON.
     */
    public function actionRelation()
    {
        Yii::app()->user->setState('pageSize',5);
        if (isset($_GET['pageSize'])) 
            unset($_GET['pageSize']);
        $model = new Email('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Email']))
            $model->attributes = $_GET['Email'];
        if (isset($_GET['id'])) 
            $model->id = $_GET['id'];
        // TODO: Add additional filters here! 
        $this->renderPartial('//email/_grid', array(
            'model' => $model,
            'relation' => true,
            'relationIndex' => isset($_GET['relationIndex'])?(int)$_GET['relationIndex']:1,
            'relationSelectableRows' => isset($_GET['relationSelectableRows'])?(int)$_GET['relationSelectableRows']:1,
        ), false, true);
    }

    /**
     * REQUIRED
     * Returns all models in JSON.
     */
    public function actionAjaxGet()
    {
        header('Content-type: application/json');
        if (Yii::app()->user->checkAccess('Email.AjaxGet')) {
            $alias = Email::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            $criteria->params = array();
            $criteria->together = true;
            // TODO: Add more relations here!
            $criteria->with = array('cprofile', 'mprofile',);
            if (isset($_GET['id'])) 
                $criteria->compare($alias.'.id', $_GET['id']);
            // TODO: Add additional filters here!
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => Email::getListData($criteria),
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
     * Returns DataProvider for unassigned email addresses
     */
    public function actionUnassigned(){
        $clients = Client::model()->findAll();
        $notInList = array();
        foreach($clients as $client){
            if(isset($client->cl1_email_address) && strlen($client->cl1_email_address)>0){
                $notInList[]=$client->cl1_email_address;
            }
        }
        $model = new Email('search');
        $model->unsetAttributes();
        $criteria = $model->getDbCriteria();
        $criteria->group = 't.em1_address';
        $criteria->addNotInCondition('t.em1_address',$notInList);
        $model->setDbCriteria($criteria);
        //$model->dbCriteria = $criteria;
        $this->render('//email/index',array(
            'model'=>$model,
            'unassigned'=>true,
        ));

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Email
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Email::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'email-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Marks the given email as seen
     * @param integer $id the email's id
     */
    public static function markAsSeen($id){
        $model = new Email();
        $model = $model->findByPk($id);
        $model->em1_seen = 1;
        if($model->validate())
            $model->save();
    }

}

