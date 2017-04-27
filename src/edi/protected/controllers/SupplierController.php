<?php

class SupplierController extends RController
{

    /**
     * REQUIRED
     * @var string the default layout for the views. Defaults to '//layouts/column4', meaning
     * using two-column layout. See 'protected/views/layouts/column4.php'.
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
            array('deny', // deny all users
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
        $this->render('view', array(
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
        $model = new Supplier();
        $this->performAjaxValidation($model);
        if (isset($_POST['Supplier'])) {
            $model->attributes = $_POST['Supplier'];
            $logo = CUploadedFile::getInstance($model, 'su1_logo');
            if ($logo) {
                $logoPath = '/img/logo/' . $model->su1_code;
                $fullPath = Yii::app()->basePath . '/..' . $logoPath;
                if (!file_exists($fullPath))
                    mkdir($fullPath, 0755, true);
                $logoPath .= '/' . $logo->name;
                $logo->saveAs(Yii::app()->basePath . '/..' . $logoPath);
                $model->su1_logo = $this->createUrl($logoPath);
            }
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
                throw new CHttpException(500, Yii::t('app', 'Supplier cannot be created.'));
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            //$model->{$_GET['parentPk']} = (int)$_GET['parentId'];
        }
        $this->render('create', array(
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
        $this->performAjaxValidation($model);
        if (isset($_POST['Supplier'])) {
            $su1_logo = $model->su1_logo;
            $model->attributes = $_POST['Supplier'];
            $logo = CUploadedFile::getInstance($model, 'su1_logo');
            if ($logo) {
                $logoPath = '/img/logo/' . $model->su1_code;
                $fullPath = Yii::app()->basePath . '/..' . $logoPath;
                if (!file_exists($fullPath))
                    mkdir($fullPath, 0755, true);
                $logoPath .= '/' . $logo->name;
                $logo->saveAs(Yii::app()->basePath . '/..' . $logoPath);
                $model->su1_logo = $this->createUrl($logoPath);
            } else {
                $model->su1_logo = $su1_logo;
            }
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
                throw new CHttpException(500, Yii::t('app', 'Supplier cannot be saved.'));
        }
        $this->render('update', array(
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
     * Updates an attribute value of this model.
     * @throws CHttpException
     */
    public function actionEdit()
    {
        if (isset($_POST['pk']) && isset($_POST['name']) && isset($_POST['value'])) {
            $model = Location::model()->findByPk((int)$_POST['pk']);
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
                Yii::app()->user->setFlash('success', Yii::t('app', '<span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.', array(':record' => $model->su1_code)));
            else
                echo Yii::t('app', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.</div>', array(':record' => $model->su1_code));
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
        $dataProvider = new CActiveDataProvider('Supplier');
        $this->render('blog', array(
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
        $model = new Supplier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $model->attributes = $_GET['Supplier'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('Supplier.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'supplier-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Supplier data cannot be exported.');
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
                        Yii::log('Supplier data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Supplier data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Supplier data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Supplier data.'));
            }
        }
        $this->render('index', array(
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
            $model = new Supplier('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Supplier']))
                $model->attributes = $_GET['Supplier'];
            $model->{$_GET['parentPk']} = (int)$_GET['parentId'];
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('Supplier.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'supplier-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'Supplier data cannot be exported.');
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
                            Yii::log('Supplier data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'Supplier data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export Supplier data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Supplier data.'));
                }
            }
            $this->renderPartial('//supplier/_grid', array(
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
        $model = new Supplier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $model->attributes = $_GET['Supplier'];
        if (isset($_GET['su1_code'])) 
            $model->su1_code = $_GET['su1_code'];
        if (isset($_GET['su1_name'])) 
            $model->su1_name = $_GET['su1_name'];
        $this->renderPartial('//supplier/_grid', array(
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
        if (Yii::app()->user->checkAccess('Supplier.AjaxGet')) {
            $alias = Supplier::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            $criteria->params = array();
            if (isset($_GET['id'])) 
                $criteria->compare($alias.'.id', $_GET['id']);
            if (isset($_GET['su1_code'])) 
                $criteria->compare($alias.'.su1_code', $_GET['su1_code'], true);
            if (isset($_GET['su1_name'])) 
                $criteria->compare($alias.'.su1_name', $_GET['su1_name'], true);
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => Supplier::getListData($criteria),
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
     * @param integer the ID of the model to be loaded
     * @return Supplier
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Supplier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'supplier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
