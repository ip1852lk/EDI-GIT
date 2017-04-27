<?php
/* @var $this ProjectController
 * @var $data Project
 */

$projectAdmin = Yii::app()->user->checkAccess('Project.*');
$projectUpdate = Yii::app()->user->checkAccess('Project.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-folder fa-lg',
    'title' => $projectUpdate ? TbHtml::link(UHtml::markSearch($data, "id"), array("update", "id" => $data->id)) : $data->id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => $projectUpdate ? TbHtml::link(UHtml::markSearch($data, "id"), array("update", "id" => $data->id)) : $data->id,
        ),
        array(
            'name' => 'PR1_ID',
        ),
        array(
            'name' => 'PR1_NAME',
        ),
        array(
            'name' => 'RE1_INVOICE_TYPE',
        ),
        array(
            'name' => 'RE1_INVOICE_BILLED',
        ),
        array(
            'name' => 'PR1_APP_NAME',
        ),
        array(
            'name' => 'PR1_DELETE_FLAG',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $projectAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $projectAdmin,
        ),
    ),
));
$this->endWidget();

