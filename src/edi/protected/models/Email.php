<?php

/**
 * This is class for Email
 */
$realPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
$phpMailer = $realPath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR .'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php';
$swiftMailer = $realPath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR .'swiftmailer' . DIRECTORY_SEPARATOR . 'lib'. DIRECTORY_SEPARATOR . 'swift_required.php';

spl_autoload_unregister(array('YiiBase','autoload'));

require_once($phpMailer);
require_once($swiftMailer);

spl_autoload_register(array('YiiBase','autoload'));

class Email extends PHPMailer
{
    public $smtp = null;
    public $phpmailer_errors = '';
    
     public function __construct(){
        $this->exceptions = true;
        $this->SMTPDebug = 1;
        $this->Debugoutput = 'error_log';
        $this->isHTML(true);
        $this->isSMTP();
        $this->Host = Yii::app()->params['mail_host'];
        $this->SMTPAuth = true;
        $this->Username = Yii::app()->params['mail_user_name'];
        $this->Password = Yii::app()->params['mail_password'];
        $this->Port = Yii::app()->params['mail_port'];
//        $this->SMTPSecure = 'ssl';
        $this->setFrom(Yii::app()->params['mail_user_name'], Yii::app()->params['mail_display_name']);
        //TODO: Change Mail Display Name
    }

    public function send(){
        try {
            return parent::send();
        }catch (phpmailerException $e) {
            try{
                return $this->backupSend();
            }catch (Exception $e){
                Yii::log('Email could not be sent with both primary and backup methods. Error Message: '. $e->getMessage(), 'error', 'system.*');
            }
        }
        return false;
    }

    public function backupSend(){
// Create the mail transport configuration
        $transport = Swift_SmtpTransport::newInstance(Yii::app()->params['mail_host'], Yii::app()->params['mail_port'])
            ->setUsername(Yii::app()->params['mail_user_name'])
            ->setPassword(Yii::app()->params['mail_password']);

// Create the message
        $message = Swift_Message::newInstance();
        foreach($this->all_recipients as $recipient => $bool){
            $message->setTo($recipient);
        }
        $message->setContentType('text/html');
        $message->setSubject($this->Subject);
        $message->setBody($this->Body);
        $message->setFrom($this->From, $this->FromName);

// Send the email
        $mailer = Swift_Mailer::newInstance($transport);

        $failures = null;
        // Pass a variable name to the send() method
        if (!$mailer->send($message, $failures)) {
            Yii::log('Backup Mailer SwiftMailer failed.' . print_r($failures), 'error', 'system.*');
            return false;
        }else{
            return true;
        }

    }
}

