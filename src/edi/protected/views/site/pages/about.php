<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['companyShortName']) => array('site/page', 'view' => 'about',),
    'About',
);
?>
<h3>About <span class="text-info"><?php echo Yii::app()->params['companyName']; ?></span></h3>

<p>Provide the company's description here.</p>