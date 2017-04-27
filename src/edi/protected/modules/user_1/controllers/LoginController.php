<?php

class LoginController extends JController
{

    public $defaultAction = 'login';
    public $layout = '//layouts/column1';

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin();
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    $returnUrl = Yii::app()->user->returnUrl;
                    if ($returnUrl == '/index.php')
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    else
                        $this->redirect($returnUrl);
                }
            }
            // display the login form
            $this->render('/login/login', array(
                'model' => $model,
            ));
        } else
            $this->redirect(Yii::app()->controller->module->returnUrl);
    }

    private function lastViset()
    {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}
