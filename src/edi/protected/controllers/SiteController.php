<?php

class SiteController extends RController
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
     * @return string the actions that are always allowed separated by commas.
     */
    public function allowedActions()
    {
        return '*';
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //$this->render('index');
        $this->redirect(Yii::app()->user->isGuest ? Yii::app()->user->loginUrl : array(Yii::app()->params['workspaceUrl']));
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate() && !isset($_REQUEST['ajax'])) {
                // FIXME - Captcha Bug
                $session = Yii::app()->session;
                $prefixLen = strlen(CCaptchaAction::SESSION_VAR_PREFIX);
                foreach ($session->keys as $key) {
                    if (strncmp(CCaptchaAction::SESSION_VAR_PREFIX, $key, $prefixLen) == 0)
                        $session->remove($key);
                }
                // Sends an email
                $message = new YiiMailMessage();
                //$message->view = 'emailsent';
                $message->setSubject($model->subject . ' [' . $model->name . ' - ' . $model->email . ']')
                        ->setFrom($model->email)
                        ->setTo(Yii::app()->params['adminEmail'])
                        ->setBody($model->body, 'text/html');
                Yii::app()->mail->send($message);
                Yii::app()->user->setFlash('contact', '<span class="label label-success">SENT</span> Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        if (!isset($_REQUEST['ajax']))
            $this->render('contact', array('model' => $model));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if (($error = Yii::app()->errorHandler->error)) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
