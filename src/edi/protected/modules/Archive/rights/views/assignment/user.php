<?php

// Title
$this->title = Yii::t('app', 'Assignments for')."<span class=\"text-info\">".CHtml::encode($model->getName());
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments') => array('assignment/view'),
    $model->getName(),
);
// Menus
$this->menu = array();
// Notes
Yii::app()->user->setFlash('info', 'Please assign <span class="label label-warning">Roles</span> <span class="label label-warning">Tasks</span> or <span class="label label-warning">Operations</span> to this user.');
$this->widget('booster.widgets.TbAlert', array(
    'alerts' => array(
        'info' => array('fade' => true, 'closeText' => false,), 
    ),
));
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Rights::t('core', 'Assignment Form'),
    'headerIcon' => 'fa fa-link',
));
if ($formModel !== null) {
    $this->renderPartial('_form', array(
        'model' => $formModel,
        'itemnameSelectOptions' => $assignSelectOptions,
    ));
} else {
    Yii::app()->user->setFlash('warning', '<span class="text text-important">No assignment</span> available to be assigned to this user.');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'warning' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
}
?> <br/><h5><?php echo Rights::t('core', 'Assigned Authorization Items'); ?></h5> <?php
if (Yii::app()->user->hasFlash('RightsSuccess')) {
    Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('RightsSuccess'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'success' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
}
if (Yii::app()->user->hasFlash('RightsError')) {
    Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('RightsError'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'error' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
}
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'assignment-grid',
    'dataProvider' => $dataProvider,
    'template' => '{items}',
    'emptyText' => Rights::t('core', 'This user has not been assigned to any item.'),
    'columns' => array(
        array(
            'name' => 'name',
            'header' => Rights::t('core', 'Name'),
            'type' => 'raw',
            'value' => '$data->getNameText()',
        ),
        array(
            'name' => 'type',
            'header' => Rights::t('core', 'Type'),
            'type' => 'raw',
            'value' => '$data->getTypeText()',
        ),
        array(
            'header' => 'Actions',
            'header' => Rights::t('core', 'Actions'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'actions-column'),
            'value' => '$data->getRevokeAssignmentLink()',
        ),
    )
));
$this->endWidget();
?><!-- assignment-form -->