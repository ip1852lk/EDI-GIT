<?php
/* @var $this LogController
 * @var $data Log
 */

$logAdmin = Yii::app()->user->checkAccess('Log.*');
$logUpdate = Yii::app()->user->checkAccess('Log.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-sticky-note-o fa-lg',
    'title' => $logUpdate ? TbHtml::link(UHtml::markSearch($data, "LOG_ID"), array("update", "id" => $data->LOG_ID)) : $data->LOG_ID,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'LOG_ID',
            'type' => 'raw',
            'value' => $logUpdate ? TbHtml::link(UHtml::markSearch($data, "LOG_ID"), array("update", "id" => $data->LOG_ID)) : $data->LOG_ID,
        ),
        array(
            'name' => 'LOG_DESCRIPTION',
        ),
        array(
            'name' => 'LOG_UPDATED_BY',
        ),
        array(
            'name' => 'LOG_UPDATED_ON',
        ),
        array(
            'name' => 'LOG_SHOW_DEFAULT',
        ),
        array(
            'name' => 'CU1_ID',
        ),
        array(
            'name' => 'VD1_ID',
        ),
        array(
            'name' => 'ED1_ID',
        ),
        array(
            'name' => 'US1_ID',
        ),
        array(
            'name' => 'LOG_FILENAME',
        ),
        array(
            'name' => 'LOG_P21',
        ),
        array(
            'name' => 'LOG_CHECKED',
        ),
        array(
            'name' => 'LOG_FILE_TYPE',
        ),
    ),
));
$this->endWidget();

