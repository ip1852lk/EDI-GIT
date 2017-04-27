<?php

class MasterDataController extends RController
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
        $this->render('//masterData/view', array(
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
        $model = new MasterData();
        $productFamily = new ProductFamily('relation');
        $company = new Company('relation');
        $customer2 = new Customer2('relation');
        $rack = new Rack('relation');
        $this->performAjaxValidation(array($model, $company, $customer2, $rack));
        if (isset($_POST['MasterData']) && isset($_POST['Company']) && isset($_POST['Customer2']) && isset($_POST['Rack'])) {
            $model->attributes = $_POST['MasterData'];
            $company->attributes = $_POST['Company'];
            $customer2->attributes = $_POST['Customer2'];
            $rack->attributes = $_POST['Rack'];
            if ($model->validate() && $company->validate() && $customer2->validate() && $rack->validate()) {
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
                    throw new CHttpException(500, Yii::t('app', 'MasterData cannot be created.'));
            }
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            if ($_GET['parentPk'] == 'co1_id') {
                $model->co1_id = (int)$_GET['parentId'];
                $company = Company::model()->findByPk((int)$_GET['parentId']);
                if (isset($company))
                    $company->setScenario('relation');
                else
                    throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
            } elseif ($_GET['parentPk'] == 'cu2_id') {
                $model->cu2_id = (int)$_GET['parentId'];
                $customer2 = Customer2::model()->findByPk((int)$_GET['parentId']);
                if (isset($customer2))
                    $customer2->setScenario('relation');
                else
                    throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
            } elseif ($_GET['parentPk'] == 'ra1_id') {
                $model->ra1_id = (int)$_GET['parentId'];
                $rack = Rack::model()->findByPk((int)$_GET['parentId']);
                if (isset($rack))
                    $rack->setScenario('relation');
                else
                    throw new CHttpException(400, Yii::t('app', 'Please provide a valid reference: ').$_GET['parentPk'].' => '.$_GET['parentId']);
            }
        }
        $this->render('//masterData/create', array(
            'model' => $model,
            'productFamily' => $productFamily,
            'company' => $company,
            'customer2' => $customer2,
            'rack' => $rack,
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
        $productFamily = isset($model->productFamily) ? $model->productFamily : new ProductFamily();
        $productFamily->setScenario('relation');
        $company = isset($model->company) ? $model->company : new Company();
        $company->setScenario('relation');
        $customer2 = isset($model->customer2) ? $model->customer2 : new Customer2();
        $customer2->setScenario('relation');
        $rack = isset($model->rack) ? $model->rack : new Rack();
        $rack->setScenario('relation');
        $this->performAjaxValidation(array($model, $company, $customer2, $rack));
        if (isset($_POST['MasterData']) && isset($_POST['Company']) && isset($_POST['Customer2']) && isset($_POST['Rack'])) {
            $model->attributes = $_POST['MasterData'];
            $company->attributes = $_POST['Company'];
            $customer2->attributes = $_POST['Customer2'];
            $rack->attributes = $_POST['Rack'];
            if ($model->validate() && $company->validate() && $customer2->validate() && $rack->validate()) {
                if ($model->save()) {
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
                    throw new CHttpException(500, Yii::t('app', 'MasterData cannot be saved.'));
            }
        }
        $this->render('//masterData/update', array(
            'model' => $model,
            'productFamily' => $productFamily,
            'company' => $company,
            'customer2' => $customer2,
            'rack' => $rack,
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
            $model = MasterData::model()->findByPk((int)$_POST['pk']);
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
        $dataProvider = new CActiveDataProvider('MasterData');
        $this->render('//masterData/blog', array(
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
        $model = new MasterData('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MasterData']))
            $model->attributes = $_GET['MasterData'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('MasterData.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'master-data-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'MasterData data cannot be exported.');
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
                        Yii::log('MasterData data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'MasterData data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export MasterData data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export MasterData data.'));
            }
        }
        $this->render('//masterData/index', array(
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
            $model = new MasterData('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['MasterData']))
                $model->attributes = $_GET['MasterData'];
            if ($_GET['parentPk'] == 'co1_id')
                $model->co1_id = (int)$_GET['parentId'];
            if ($_GET['parentPk'] == 'cu2_id')
                $model->cu2_id = (int)$_GET['parentId'];
            if ($_GET['parentPk'] == 'ra1_id')
                $model->ra1_id = (int)$_GET['parentId'];
            $criteria = $model->getDbCriteria();
            if ($_GET['parentPk'] == 'cu1_id')
                $criteria->compare('customer2.cu1_id', (int)$_GET['parentId']);
            $model->setDbCriteria($criteria);
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('MasterData.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'master-data-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'MasterData data cannot be exported.');
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
                            Yii::log('MasterData data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'MasterData data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export MasterData data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export MasterData data.'));
                }
            }
            $this->renderPartial('//masterData/_grid', array(
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
        $model = new MasterData('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MasterData']))
            $model->attributes = $_GET['MasterData'];
        if (isset($_GET['id'])) 
            $model->id = $_GET['id'];
        if (isset($_GET['co1_id']))
            $model->id = $_GET['co1_id'];
        if (isset($_GET['cu2_id']))
            $model->id = $_GET['cu2_id'];
        if (isset($_GET['ra1_id']))
            $model->id = $_GET['ra1_id'];
        $criteria = $model->getDbCriteria();
        if ($_GET['parentPk'] == 'cu1_id')
            $criteria->compare('customer2.cu1_id', (int)$_GET['parentId']);
        $model->setDbCriteria($criteria);
        $this->renderPartial('//masterData/_grid', array(
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
        if (Yii::app()->user->checkAccess('MasterData.AjaxGet')) {
            $alias = MasterData::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            $criteria->params = array();
            if (isset($_GET['id']))
                $criteria->compare($alias.'.id', $_GET['id']);
            if (isset($_GET['co1_id']))
                $criteria->compare($alias.'.co1_id', $_GET['co1_id']);
            if (isset($_GET['cu2_id']))
                $criteria->compare($alias.'.cu2_id', $_GET['cu2_id']);
            if (isset($_GET['ra1_id']))
                $criteria->compare($alias.'.ra1_id', $_GET['ra1_id']);
            if (isset($_GET['cu1_id']))
                $criteria->compare('customer2.cu1_id', $_GET['cu1_id']);
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => MasterData::getListData($criteria),
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
     * @return MasterData
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = MasterData::model()->findByPk($id);
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
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'master-data-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

