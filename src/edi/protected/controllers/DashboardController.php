<?php

class DashboardController extends RController
{

    public $layout = '//layouts/column4';
    public $defaultAction = 'index';

    /**
     * REQUIRED
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'rights', // perform access control for CRUD operations
            //'rights - common', // This will exclude "common" action from rights so that it becomes public.
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


    // Default
    /**
     * Displays the main dashboard page
     */
    public function actionIndex()
    {

        Yii::log('Dashboard Loaded', CLogger::LEVEL_INFO);
        //$alerts = Dashboard::getAlerts();
        //$alerts = Dashboard::getAlerts();

        $Edi = Edi::model();
        if(isset($_GET['Edi'])) {
            $Edi->attributes = $_GET['Edi'];
            $Edi->edi_status_search = $_GET['Edi']['edi_status_search'];
        }

        $data = array();
        $data['model'] = $Edi;
        $user = User::model()->findByPk(Yii::app()->user->id)->profile;
        $data['firstName'] = $user->first_name;
        $data['fullName'] = $user->getFullname();
        $data['companyName'] = isset($data['company'])? ($data['company']->CO1_NAME) : "Comparatio";
        if(isset($data['company'])){
            $data['city'] = $data['company']->CO1_CITY;
        }else{
            $data['city'] = "Minneapolis";
        }

        if(!isset(Yii::app()->session['degrees'])){
            $country="US"; //Two digit country code
            $url="http://api.openweathermap.org/data/2.5/weather?q=".$data['city'].",".$country."lang=en&APPID=e73ad88b8cee45141d4924c7c0f83287";
            $connected = @fsockopen("www.google.com", 80);
            //website, port  (try 80 or 443)
            if ($connected){
                $weatherData= json_decode(file_get_contents($url),true);
                Yii::app()->session['degrees'] = round((($weatherData['main']['temp'] - 273)*1.8) + 32);
                fclose($connected);
            }
        }
        $this->render('index', array(
            'alerts'=>[],
            'data'=>$data,
        ));

    }// Default
    /**
     * Displays the main dash page
     */
    public function actionDash()
    {
        //Render the dash page with the passed variables
        $this->render('dash', array(
            )
        );
    }

}
