<?php

class EdiController extends RController
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
        $this->render('//edi/view', array(
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
        $model = new Edi();
        $this->performAjaxValidation(array($model));
        if (isset($_POST['Edi'])) {
            $model->attributes = $_POST['Edi'];
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
                        $this->redirect(array('index'));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'Edi cannot be created.'));
            }
        }
        if (isset($_GET['dependency']) && isset($_GET['parentPk']) && isset($_GET['parentId'])) {
            $model->{$_GET['parentPk']} = (int)$_GET['parentId'];
            // TODO: Implement your code here regarding dependency control
        }
        $this->render('//edi/create', array(
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
        if (isset($_POST['Edi'])) {
            $model->attributes = $_POST['Edi'];
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
                        $this->redirect(array('index'));
                } else 
                    throw new CHttpException(500, Yii::t('app', 'Edi cannot be saved.'));
            }
        }
        $this->render('//edi/update', array(
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
            $model = Edi::model()->findByPk((int)$_POST['pk']);
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
                Yii::app()->user->setFlash('success', Yii::t('app', '<span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.', array(':record' => $model->ED1_ID)));
            else
                echo Yii::t('app', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.</div>', array(':record' => $model->ED1_ID));
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
        $dataProvider = new CActiveDataProvider('Edi');



        $this->render('//edi/blog', array(
            'dataProvider' => $dataProvider,
        ));
    }
    
    /**
     * REQUIRED
     * Sets values in the Edi table to trigger a resend in Jan's system
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionResend($id = null)
    {
        if(isset($id)){
            $ids = array($id);
        }elseif(isset($_GET['ajax'], $_GET['checked']) && $_GET['ajax'] == true){
            header('Content-type: application/json');
            $ids = $_GET['checked'];
        }

        if(isset($ids)){

            //Gets all models
            $ediArray = array();
            foreach($ids as $id){
                $ediModel = Edi::model()->findByPK($id);
                if(isset($ediModel)){
                    array_push($ediArray,$ediModel);
                }
            }

            //Resends all Inbound
            $i = 0;
            while($i<sizeof($ediArray)){
                if(isset($ediArray[$i]) && $ediArray[$i]->ED1_TYPE == EDI::FUNCTIONAL_ACKNOWLEDGEMENT){
                    $ediModel->ED1_RESEND = EDI::RESEND;
                    if ($ediModel->validate()) {
                        if (!$ediModel->save()) {
                            throw new CHttpException(500, Yii::t('app', 'The data could not be saved.'));
                        }
                    } else {
                        throw new CHttpException(500, Yii::t('app', 'The data could not be validated.'));
                    }
                    array_splice($ediArray,$i,1);
                }else{
                    if(isset($ediArray[$i]) && $ediArray[$i]->ED1_IN_OUT == EDI::INBOUND_STATUS) {
                        $ediModel->ED1_RESEND = EDI::RESEND;
                        if ($ediModel->validate()) {
                            if (!$ediModel->save()) {
                                throw new CHttpException(500, Yii::t('app', 'The data could not be saved.'));
                            }
                        } else {
                            throw new CHttpException(500, Yii::t('app', 'The data could not be validated.'));
                        }
                        array_splice($ediArray,$i,1);
                    }else{
                        $i++;
                    }
                }
            }

            //Group by EDI Type
            $ediGroupedArray = array();
            $i=0;
            while($i<sizeof($ediArray)){
                $temp = array();
                $type = $ediArray[$i]->ED1_TYPE;
                $vd1_id = $ediArray[$i]->VD1_ID;
                $cu1_id = $ediArray[$i]->CU1_ID;
                $test_id = $ediArray[$i]->ED1_TEST_MODE;
                $j=0;
                while($j<sizeof($ediArray)){

                    if($type == $ediArray[$j]->ED1_TYPE && $vd1_id == $ediArray[$j]->VD1_ID && $cu1_id == $ediArray[$j]->CU1_ID && $test_id == $ediArray[$j]->ED1_TEST_MODE){
                        array_push($temp,$ediArray[$j]);
                        array_splice($ediArray,$j,1);
                    }else{
                        $j++;
                    }
                }
                array_push($ediGroupedArray,$temp);
            }

            //Take lowest of each group, -1 to doc_num, insert/update no1_numbers
            foreach($ediGroupedArray as $group){
                $lowest = $group[0];

                foreach ($group as $item) {
                    if ($lowest->ED1_DOCUMENT_NO >= $item->ED1_DOCUMENT_NO) {
                        $lowest->ED1_DOCUMENT_NO = $item->ED1_DOCUMENT_NO;
                    }
                }
                //Found lowest
                if(is_numeric($lowest->ED1_DOCUMENT_NO)) {
                    $subtractedDocumentNumber = $lowest->ED1_DOCUMENT_NO - 1;
                }else{
                    $subtractedDocumentNumber = $lowest->ED1_DOCUMENT_NO;
                }

                $cu1 = $lowest->CU1_ID;
                $vd1 = $lowest->VD1_ID;
                $testMode = $lowest->ED1_TEST_MODE;

                if (isset($lowest)) {
                    $model = Numbers::model()->findByAttributes(array('NO1_TYPE'=>$lowest->numberType[0],'CU1_ID'=>$cu1,'VD1_ID'=>$vd1,'NO1_TEST_MODE'=>$testMode));
                    if (!isset($model)) {
                        $model = new Numbers();
                        $model->NO1_NUMBER = $subtractedDocumentNumber;
                        $model->NO1_TYPE = $lowest->numberType[0];
                        $model->CU1_ID = $lowest->CU1_ID;
                        $model->VD1_ID = $lowest->VD1_ID;
                        $model->NO1_TEST_MODE = Numbers::MODE_TEST_FALSE;
                    } else {
                        $model->NO1_NUMBER = $subtractedDocumentNumber;
                        $model->NO1_TYPE = $lowest->numberType[0];
                        $model->CU1_ID = $lowest->CU1_ID;
                        $model->VD1_ID = $lowest->VD1_ID;
                        $model->NO1_TEST_MODE = Numbers::MODE_TEST_FALSE;
                    }
                } else {
                    throw new CHttpException(400, Yii::t('app', 'The Lowest EDI transaction could not be found.'));
                }

                if ($model->save()) {

                } else {
                    throw new CHttpException(400, Yii::t('app', 'The Numbers model could not be saved.'));

                }
            }

            foreach($ediGroupedArray as $group) {
                foreach($group as $model){
                    $model->ED1_SHOW_DEFAULT = "";
                    $model->save();
                }
            }
        }else{
            throw new CHttpException(500, Yii::t('app', 'ID(s) were not valid.'));
        }
        $this->redirect(array('index'));
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
        $model = new Edi('search');
        $model->unsetAttributes();  // clear any default values

        //Set the ED1_SHOW_DEFAULT Flag on so we only view the records that should be visible
        $model->ED1_SHOW_DEFAULT = Edi::SHOW_DEFAULT_FLAG;

        if (isset($_GET['Edi']))
            $model->attributes = $_GET['Edi'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('Edi.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'edi-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Edi data cannot be exported.');
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
                        Yii::log('Edi data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Edi data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Edi data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Edi data.'));
            }
        }
        $this->render('//edi/index', array(
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
            $model = new Edi('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['Edi']))
                $model->attributes = $_GET['Edi'];
            // TODO: Add additional filters here!
            //if ($_GET['parentPk'] == 'cu1_id') 
            //    $model->cu1_id = (int)$_GET['parentId'];
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('Edi.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'edi-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'Edi data cannot be exported.');
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
                            Yii::log('Edi data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'Edi data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export Edi data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Edi data.'));
                }
            }
            $this->renderPartial('//edi/_grid', array(
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
        $model = new Edi('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Edi']))
            $model->attributes = $_GET['Edi'];
        if (isset($_GET['ED1_ID'])) 
            $model->ED1_ID = $_GET['ED1_ID'];
        // TODO: Add additional filters here! 
        $this->renderPartial('//edi/_grid', array(
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
        if (Yii::app()->user->checkAccess('Edi.AjaxGet')) {
            $alias = Edi::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            // TODO: Add more relations here!
            if (isset($_GET['ED1_ID']))
                $criteria->compare($alias.'.ED1_ID', $_GET['ED1_ID']);
            // TODO: Add additional filters here!
            $return = array(
                'status' => '200',
                'statusText' => 'success',
                'body' => Edi::getListData($criteria),
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
     * @return Edi
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Edi::model()->findByPk($id);
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
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'edi-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxGetEdiFileContents()
    {
        header('Content-type: application/json');
        if (isset($_GET['ED1_ID']) && !empty($_GET['ED1_ID'])){

            $model = Edi::model()->findByPK($_GET['ED1_ID']);

            if(isset($model)){
                $result['file-name'] = $model->ED1_FILENAME;
                $urlPath = "files/" . basename($model->ED1_FILENAME);
                $fileName = Yii::app()->createAbsoluteUrl($urlPath);
                $file = fopen($fileName,"r");
                $fileContent = '';
                while(! feof($file))
                {
                    $line = fgets($file);
                    if($line != false){
//                        $line = str_replace("*","<br>",$line);
                        $fileContent .= $line . '<br>';

                    }
                }

                fclose($file);

                $result['file-content'] = $fileContent;

            }

            if($result != false){
                echo CJSON::encode(array(
                    'status' => '200',
                    'statusText' => 'success',
                    'result' => $result,
                ));
            }else{
                echo CJSON::encode(array(
                    'status' => '404',
                    'statusText' => 'Could not load file contents',
                ));
            }
        }else{
            echo CJSON::encode(array(
                'status' => '404',
                'statusText' => 'Could not load File contents. ',
            ));
        }
        Yii::app()->end();
    }


}

