<?php

class AutoTaskController extends RController
{

    public $layout = '//layouts/column4';

    const TC1_TIMER_TASK = 8;

    /**
     * REQUIRED
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
			//'accessControl',
            'rights', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
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
                'allow',
                'actions' => array('run'),
                'ips' => array('127.0.0.1'),
            ),
			array(
                'deny', // deny all users
                'actions' => array('run'),
				'ips'=>array('*'),
            ),
        );
    }

    /**
     * This is the default run function defined within AutoTaskController. You will call this function
	 * through triggerAutorun.php with through a command prompt or task scheduler and include a function
	 * call as a parameter for the run. Example:
	 * d:\...\php.exe -f D:\WWW\monitoringsystem\triggerAutorun.php createTeamworkTickets
	 *
	 * @author Bradley Cutshall <bradley.cutshall@comparatio.com>
     * @date 17 Jan 2017
     */
    public function actionRun() {

		$action = Yii::app()->request->getQuery('action', '');
        $action = isset($action) ? $action : 'default';
        //Yii::log('Start Automated Process : ' . $action, CLogger::LEVEL_INFO);
        
		switch ($action) {
			// case 'createTeamworkTickets' :
            //       $this->postTask(CurrentUpdate::autoTaskCreateTeamworkTickets(), AutoTaskController::TEAMWORK_TICKET_TASK);
			// 	break;
            case 'tc1TimerTask' : 
                //$this->postTask(Object::StaticFunction(), self::TC1_TIMER_TASK);
			default :
                Yii::log('Start Automated Process : default action', CLogger::LEVEL_INFO);
				break;
		}

        Yii::log('[' . $action . '] AutoTask Completed Successfully', CLogger::LEVEL_INFO);

        die();
		
    }


    /**
     * Takes text and the result of the run to post to monitoratio.  It will post with The default
     * client id defined in the configuration if the client_id is not provided.
     *
     * @param $result Array contains array['result-text'] Boolean if the run was successful and array['result-text'] String text to post as a result summary.
     * @param $taskId Integer task id to be created on.
     */
    public function postTask($result, $taskId) {
		
		$clientId = isset(Yii::app()->params['comparatioServerMonitoringClientId']) ? Yii::app()->params['comparatioServerMonitoringClientId'] : -1;

        PostTaskToMonitoratio::send(
            array(
                'taskId' => isset($taskId) ? $taskId : -1, //Task ID in Monitoratio that this "Task" was assigned
                'result' => isset($result['result']) ? $result['result'] : ' Error: Result Not Set. ',
                'resultSummary'=> isset($result['result-text']) ? $result['result-text'] : ' Error: Result Text Not Set. ',
                'cl1_id'=> $clientId,
            )
        );
    }


}
