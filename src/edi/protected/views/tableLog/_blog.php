<?php
/* @var $this TableLogController
 * @var $model TableLog
 */

$tableLogAdmin = Yii::app()->user->checkAccess('TableLog.*');
$tableLogUpdate = Yii::app()->user->checkAccess('TableLog.Update');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-history fa-lg',
    'title' => $tableLogUpdate ? TbHtml::link(TableLog::itemAlias('logActions', $data->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($data->created_on, "medium", "short").')', array('view', 'id' => $data->id)) : TableLog::itemAlias('logActions', $data->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($data->created_on, "medium", "short").')',
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'created_on',
            'type' => 'raw',
            'value' => Yii::app()->dateFormatter->formatDateTime($data->created_on, "medium", "short"),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => ($data->cprofile == null || $data->cprofile->first_name == null ? "" : $data->cprofile->first_name . " " . $data->cprofile->last_name),
        ),
        array(
            'name' => 'action',
            'value' => TableLog::itemAlias('logActions', $data->log_action),
        ),
        array(
            'name' => 'description',
            'type' => 'html',
        ),
    ),
));
$this->endWidget();
