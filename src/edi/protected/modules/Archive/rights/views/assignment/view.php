<?php

// Title
$this->title = Yii::t('app', 'Assignments');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Assignments'),
);
// Menus
$this->menu = array();
// Notes
Yii::app()->user->setFlash('info', 'Here you can see which <span class="label label-warning">Permissions</span> has been assigned to each user.');
$this->widget('booster.widgets.TbAlert', array(
    'alerts' => array(
        'info' => array('fade' => true, 'closeText' => false,), 
    ),
));
// UIs
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'assignment-grid',
    'dataProvider' => $dataProvider,
    'enablePagination' => true,
    'template' => '{summary}{items}{pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'emptyText' => Rights::t('core', 'No users found.'),
    'columns' => array(
        array(
            'name' => 'name',
            'header' => Rights::t('core', 'Name'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'name-column'),
            'value' => '$data->getAssignmentNameLink()',
        ),
        array(
            'name' => 'assignments',
            'header' => Rights::t('core', 'Roles'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'role-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
            'filter' => false,
        ),
        array(
            'name' => 'assignments',
            'header' => Rights::t('core', 'Tasks'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'task-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
            'filter' => false,
        ),
        array(
            'name' => 'assignments',
            'header' => Rights::t('core', 'Operations'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'operation-column'),
            'value' => '$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
            'filter' => false,
        ),
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'label' => 'Assign',
                    'url' => 'Yii::app()->createUrl("/rights/assignment/user", array("id" => $data->id))',
                ),
            ),
        ),
    ),
));
?><!-- assignment-grid -->
