<?php
/* @var $this SiteController
 * @var $error array
 */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>

<div class="error">
    <?php
    Yii::app()->user->setFlash('error', 
        '<span class="label label-danger">ERROR '.$code.'</span> ' . CHtml::encode($message)
    );
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'error' => array('fade' => true, 'closeText' => false), 
        ),
    ));
    ?>
</div>