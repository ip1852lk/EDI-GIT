<?php

class Customer2Controller extends RController
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
        $this->render('//customer2/view', array(
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
        $model = new Customer2();
        $customer = new Customer('relation');
        $location = new Location('relation');
        $region = new Region('relation');
        $company = new Company('relation');
        $contracts = array();   // Don't allow to select contracts in a new record!
        $this->performAjaxValidation(array($model, $customer, $location));
        if (isset($_POST['Customer2']) && isset($_POST['Customer']) && isset($_POST['Location'])) {
            $model->attributes = $_POST['Customer2'];
            $customer->attributes = $_POST['Customer'];
            $location->attributes = $_POST['Location'];
            if ($model->validate() && $customer->validate() && $location->validate()) {
                if ($model->save()) {
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
                    throw new CHttpException(500, Yii::t('app', 'Sub-Customer cannot be created.'));
            }
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            if ($_GET['parentPk'] == 'cu1_id') {
                $model->cu1_id = (int)$_GET['parentId'];
                $customer = Customer::model()->findByPk((int)$_GET['parentId']);
                if (isset($customer))
                    $customer->setScenario('relation');
                 else
                    throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
            }
        }
        $this->render('//customer2/create', array(
            'model' => $model,
            'customer' => $customer,
            'location' => $location,
            'region' => $region,
            'company' => $company,
            'contracts' => $contracts,
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
        $customer = isset($model->customer) ? $model->customer : new Customer();
        $customer->setScenario('relation');
        $location = isset($model->location) ? $model->location : new Location();
        $location->setScenario('relation');
        $region = isset($location->region) ? $location->region : new Region();
        $region->setScenario('relation');
        $company = isset($region->company) ? $region->company : new Company();
        $company->setScenario('relation');
        $selectedContracts = isset($model) && isset($company) ? Contract::model()->findAll('co1_id=:co1_id AND cu2_id=:cu2_id', array(
            ':co1_id' => $company->id,
            ':cu2_id' => $model->id,
        )) : array();
        if (count($selectedContracts) > 0) {
            $model->cu2_contracts = array_map(function($contract) { return $contract->job_price_hdr_uid; }, $selectedContracts);//implode(',', array_map(function($contract) { return $contract->job_price_hdr_uid; }, $selectedContracts));
        } else {
            $model->cu2_contracts = array();
        }
        if ($model->cu2_type == Customer2::TYPE_P21) {
            $jobPriceHdrs = P21JobPriceHdr::model()->findAll('corp_address_id=:corp_address_id', array(
                ':corp_address_id' => $model->corp_address_id,
            ));
            $contracts = array();
            foreach ($jobPriceHdrs as $jobPriceHdr) {
                $contracts[$jobPriceHdr->job_price_hdr_uid] = $jobPriceHdr->contract_no;
            }
        } else {
            $contracts = array();
        }
        $this->performAjaxValidation(array($model, $customer, $location));
        if (isset($_POST['Customer2']) && isset($_POST['Customer']) && isset($_POST['Location'])) {
            $model->attributes = $_POST['Customer2'];
            $customer->attributes = $_POST['Customer'];
            $location->attributes = $_POST['Location'];
            if ($model->validate() && $customer->validate() && $location->validate()) {
                if ($model->save()) {
                    Contract::model()->deleteAll('co1_id=:co1_id AND cu2_id=:cu2_id', array(
                        ':co1_id' => $company->id,
                        ':cu2_id' => $model->id,
                    ));
                    if ($model->cu2_type == Customer2::TYPE_P21 && isset($_POST['Customer2']['cu2_contracts'])) {
                        $contracts = $_POST['Customer2']['cu2_contracts'];
                        foreach ($contracts as $key => $contract) {
                            $contractModel = new Contract();
                            $contractModel->co1_id = $model->location->region->co1_id;
                            $contractModel->cu2_id = $model->id;
                            $contractModel->job_price_hdr_uid = $contract;
                            $contractModel->save();
                        }
                    }
                    if (isset($_GET['dependency']) && isset($_GET['parentId'])) 
                        $this->redirect(array(
                            $_GET['dependency'], 
                            'id' => $model->{$_GET['parentPk']}, 
                            'tabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:($this->isMobile?0:1)),
                            'tabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:0), 
                        ));
                    else 
                        $this->redirect(array('index'));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'Sub-Customer cannot be saved.'));
            }
        }
        $this->render('//customer2/update', array(
            'model' => $model,
            'customer' => $customer,
            'location' => $location,
            'region' => $region,
            'company' => $company,
            'contracts' => $contracts,
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
            $model = Customer2::model()->findByPk((int)$_POST['pk']);
            if (isset($model)) {
                if (isset($model->{$_POST['name']})) {
                    $model->{$_POST['name']} = $_POST['value'];
                    if (!$model->update([$_POST['name']]))
                        throw new CHttpException(500, Yii::t('app', 'Internal Error'));
                } else
                    throw new CHttpException(400, Yii::t('app', 'Invalid Request'));
            } else
                throw new CHttpException(404, Yii::t('app', 'The requested record does not exist.'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Invalid Request'));
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
        $dataProvider = new CActiveDataProvider('Customer2');
        $this->render('//customer2/blog', array(
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
        $model = new Customer2('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer2']))
            $model->attributes = $_GET['Customer2'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('Customer2.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'customer2-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Sub-Customer data cannot be exported.');
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
                        Yii::log('Sub-Customer data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Sub-Customer data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Sub-Customer data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Sub-Customer data.'));
            }
        }
        $this->render('//customer2/index', array(
            'model' => $model,
        ));
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
            $model = new Customer2('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Customer2']))
                $model->attributes = $_GET['Customer2'];
            if ($_GET['parentPk'] == 'cu1_id')
                $model->cu1_id = (int)$_GET['parentId'];
            if ($_GET['parentPk'] == 'lo1_id')
                $model->lo1_id = (int)$_GET['parentId'];
            $criteria = $model->getDbCriteria();
            if ($_GET['parentPk'] == 'rg1_id')
                $criteria->compare('location.rg1_id', (int)$_GET['parentId']);
            if ($_GET['parentPk'] == 'co1_id')
                $criteria->compare('region.co1_id', (int)$_GET['parentId']);
            $model->setDbCriteria($criteria);
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('Customer2.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'customer2-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'Sub-Customer data cannot be exported.');
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
                            Yii::log('Sub-Customer data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'Sub-Customer data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export Sub-Customer data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Sub-Customer data.'));
                }
            }
            $this->renderPartial('//customer2/_grid', array(
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
        $model = new Customer2('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer2']))
            $model->attributes = $_GET['Customer2'];
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'cu1_id')
            $model->cu1_id = (int)$_GET['parentId'];
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'lo1_id')
            $model->lo1_id = (int)$_GET['parentId'];
        $criteria = $model->getDbCriteria();
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'rg1_id')
            $criteria->compare('location.rg1_id', (int)$_GET['parentId']);
        if (isset($_GET['parentPk']) && $_GET['parentPk'] == 'co1_id')
            $criteria->compare('region.co1_id', (int)$_GET['parentId']);
        $model->setDbCriteria($criteria);
        $this->renderPartial('//customer2/_grid', array(
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
        if (Yii::app()->user->checkAccess('Customer2.AjaxGet')) {
            $alias = Customer2::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            $criteria->params = array();
            if (isset($_GET['id']))
                $criteria->compare($alias.'.id', $_GET['id']);
            if (isset($_GET['cu1_id']))
                $criteria->compare($alias.'.cu1_id', $_GET['cu1_id']);
            if (isset($_GET['lo1_id']))
                $criteria->compare($alias.'.lo1_id', $_GET['lo1_id']);
            if (isset($_GET['rg1_id']))
                $criteria->compare('location.rg1_id', $_GET['rg1_id']);
            if (isset($_GET['co1_id']))
                $criteria->compare('region.co1_id', $_GET['co1_id']);
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => Customer2::getListData($criteria),
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
     * @param integer $id the ID of the model to be loaded
     * @return Customer2
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Customer2::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel|array $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'customer2-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

