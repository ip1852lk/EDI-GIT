<?php

/**
 * Class PostTaskToMonitoratio
 *
 * This class will POST to Monitoratio in order to log tasks, most commonly CRON jobs
 *
 */
class PostTaskToMonitoratio
{

    //For a Task, you must send in the array: cl1_id, task_id, result, and result_text
    //The cl1_id is set in the app Params
    public static function send($dataArray){
        //MUST SET UP PARAM FOR COMPANY ID IN OUR SYSTEM BEFORE IT WILL PROPERLY BE RECEIVED!
        $url = 'http://office.comparatio.com:8081/monitoringsystem/receiveYiiAppLogs/receiveLogs';
        $dataArray['validToken'] = "510651afds56f46a0f56ad0f45as6ef4065aes0dv1sz201f560as7fr32174455632045246";
        $dataArray['type'] = "Task";
        $data = array(
            'data'=> DServerMonitoringLogRoute::encrypt(
                json_encode($dataArray)
            ));
        DServerMonitoringLogRoute::sendPostData($data, $url);
    }
}