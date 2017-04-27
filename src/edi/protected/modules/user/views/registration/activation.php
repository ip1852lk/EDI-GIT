<?php
/* @var $this RegistrationController
 */

// Title
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Registration');
$this->title = Yii::t('app', 'Registration');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', "Login") => array('/user/login'),
    Yii::t('app', 'Registration'),
);
// Notes
Yii::app()->user->setFlash('info', $content);
$this->widget('booster.widgets.TbAlert', array(
    'alerts' => array(
        'info' => array('fade' => true, 'closeText' => false), 
    ),
));
