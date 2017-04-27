<?php
    /**
     * Creates teamwork tickets via email if necessary.
     *
     * @author Bradley Cutshall <bradley.cutshall@comparatio.com>
     * @date January 4th 2016
     *
     * @return Array with ['result'] Boolean and ['result-text'] String
     */
    public static function autoTaskCreateTeamworkTickets() {

        $result = array();
        $result['result'] = true;
        $result['result-text'] = '';

        $autoTeamworkTicketsCreated = CurrentUpdate::checkUpdateStatusesAndCreateTickets();
        if( isset($autoTeamworkTicketsCreated) ) {
            $result['result-text'] .= ' ' . count($autoTeamworkTicketsCreated) . ' Teamwork Tickets Created. ';
            foreach($autoTeamworkTicketsCreated as $ticket) {
                $result['result-text'] .= isset($ticket) ? $ticket : '';
            }
        } else {
            $result['result'] = false;
            $result['result-text'] .= ' Property $autoTeamworkTicketsCreated is not defined! ';
        }

        return $result;
    }

    /**
     * Checks all the CurrentUpdates and triggers the creation of TeamWork Desk tickets if they are not ignore and have an issue
     *
     * @author  Bradley Cutshall <brad.cutshall@comparatio.com>
     * @date    January 19, 2017
     *
     * @return array String of each ticket created
     */
    public static function checkUpdateStatusesAndCreateTickets() {

        $ticketsCreated = array();

        foreach(Client::model()->findAll() as $client) {
            if(isset($client, $client->delete_flag) && $client->delete_flag == 0) {

                $currentIssues = array();

                foreach(CurrentUpdate::model()->findAllByAttributes( array('cl1_id'=>$client->id,'ignore_flag'=>0) ) as $currentUpdate) {

                    if(isset($currentUpdate->cl1_id)) {
                        if(isset($currentUpdate->ignore_flag) && $currentUpdate->ignore_flag == false) {
                            if(isset($client->cl1_auto_teamwork_tickets) && $client->cl1_auto_teamwork_tickets == true) {
                                if (isset($currentUpdate->auto_ticket_created)) {

                                    // Client is an error and client has not already had ticket created
                                    $status = $currentUpdate->getUpdateStatus();

                                    if(($status == self::STATUS_ERROR || $status == self::STATUS_TIMEOUT)  && $currentUpdate->auto_ticket_created == false) {

                                        $currentUpdate->auto_ticket_created = 1;

                                        if($currentUpdate->saveAttributes(array('auto_ticket_created',)) ) {

                                            $issueString = count($currentIssues) + 1;
                                            $issueString .= ': ';
                                            $issueString .= ($status == self::STATUS_TIMEOUT ? ' TIMEOUT - ' : ' ERROR - ');
                                            $issueString .= $currentUpdate->getUpdateTypeName() != NULL ? $currentUpdate->getUpdateTypeName() : '';
                                            $issueString .= ' ';
                                            $issueString .= $currentUpdate->getUpdateStatusText() != NULL ? $currentUpdate->getUpdateStatusText() : '';
                                            $issueString .= ' [';
                                            $issueString .= isset($currentUpdate->up2_name) ? $currentUpdate->up2_name : '';
                                            $issueString .= ' ';
                                            $issueString .= isset($currentUpdate->up2_size) && $currentUpdate->up2_size != 'NULL' ? $currentUpdate->up2_size : '';
                                            $issueString .= ']';
                                            $currentIssues[] = $issueString;
                                        }
                                    } elseif(($status == self::STATUS_STABLE || $status == self::STATUS_WARNING) && $currentUpdate->auto_ticket_created == true) { //
                                        $currentUpdate->auto_ticket_created = 0;
                                        $currentUpdate->saveAttributes(array('auto_ticket_created',));
                                    }
                                } elseif (!isset($currentUpdate->auto_ticket_created)) {
                                    Yii::log('There is not a auto_ticket_created set for the CurrentUpdate. Cannot proceed.', CLogger::LEVEL_ERROR);
                                }
                            } elseif(!isset($client->cl1_auto_teamwork_tickets)) {
                                Yii::log('There is not a cl1_auto_teamwork_tickets set for the CurrentUpdate. Cannot proceed.', CLogger::LEVEL_ERROR);
                            }
                        } elseif (!isset($currentUpdate->ignore_flag)) {
                            Yii::log('There is not a delete_flag set for the Update. Cannot proceed.', CLogger::LEVEL_ERROR);
                        }
                    } else {
                        $result['result'] = false;
                        Yii::log(' There is not a cl1_id set for the CurrentUpdate. ', CLogger::LEVEL_ERROR);
                    }
                }

                // Send ticket To Teamwork and update Monitoratio Tasks here
                if(count($currentIssues) > 0) {

                    // Update last teamwork ticket created date for client
                    $client->cl1_last_auto_teamwork_ticket_datetime = date('Y-m-d H:i:s');
                    $client->saveAttributes(array('cl1_last_auto_teamwork_ticket_datetime',));

                    // Build ticket subject and body
                    $ticketSubject = isset($client->cl1_name) ? $client->cl1_name : 'No cl1_name Set!';
                    $ticketSubject .= isset($client->cl1_ip_address) ? ' (' . $client->cl1_ip_address . ')' : ' No cl1_ip_address Set!';

                    // Build report for Monitoratio Task
                    $ticketsCreated[] = '[' . $ticketSubject . ' ' . count($currentIssues) . ' Issues]';

                    // Finish building subject and body
                    $ticketSubject .= ' Automatic Ticket From Monitoratio';
                    $ticketBody = '';
                    foreach($currentIssues as $issue) {
                        $ticketBody .= $issue . '<br>';
                    }
                    $emailAddress = DEPLOYMENT_MODE=='QA' ? 'bradley.cutshall@comparatio.com' : $client->getTeamworkDeskEmailAddress();
                    Teamwork::createTeamworkDeskTicket($emailAddress, $ticketSubject, $ticketBody);
                }
            } elseif(!isset($client->delete_flag)) {
                Yii::log('Client Was Found But Not Set!', CLogger::LEVEL_ERROR);
            }
        }

        return $ticketsCreated;
    }

