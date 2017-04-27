<?php
class Teamwork
{

    /**
     * @param $email - Teamwork Desk Inbox email for receiving Tickets
     * @param $subject - Ticket Subject
     * @param $message - Ticket message
     */
    public static function createTeamworkDeskTicket($email, $subject, $message){
        $mail = new Email();
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if(!$mail->send()) {
            Yii::log('Email could not be sent. Error Message: '.$mail->ErrorInfo, 'error', 'system.*');
            return false;
        } else {
            Yii::log('Email Message Sent - Subject: ' . $subject , 'info', 'system.*');
            return true;
        }

    }
    
}

