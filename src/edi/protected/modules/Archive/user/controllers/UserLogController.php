<?php

class UserLogController extends RController
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
        $model = new UserLog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];
        if (!$isAdmin) {
            $criteria = $model->getDbCriteria();
            $criteria->compare('user.superuser', 0); // Hide all superusers
            $criteria->addCondition('user.status > ' . User::STATUS_BANNED); // Hide banned users
            $model->setDbCriteria($criteria);
        }
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('User.UserLog.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'user-log-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'User Log data cannot be exported.');
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
                        Yii::log('UserLog data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'User Log data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export UserLog data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export User Log data.'));
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
            $model = new UserLog('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['UserLog']))
                $model->attributes = $_GET['UserLog'];
            if ($_GET['parentPk'] == 'user_id') 
                $model->user_id = (int)$_GET['parentId'];
            if (isset($_GET['export'])) {
                if (Yii::app()->user->checkAccess('User.UserLog.Export')) {
                    if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'user-log-grid-'.$_GET['dependencyTabDropdownIndex']) {
                        header('Content-type: application/json');
                        $file = $model->export(false);
                        if ($file === false) {
                            $status = '500';
                            $statusText = 'fail';
                            $body = Yii::t('app', 'User Log data cannot be exported.');
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
                            Yii::log('UserLog data cannot be exported.', CLogger::LEVEL_ERROR);
                            throw new CHttpException(500, Yii::t('app', 'User Log data cannot be exported.'));
                        }
                    }
                } else {
                    Yii::log('This user is not permitted to export UserLog data.', CLogger::LEVEL_ERROR);
                    throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export User Log data.'));
                }
            }
            $this->renderPartial('application.modules.user.views.userLog._grid', array(
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

}
