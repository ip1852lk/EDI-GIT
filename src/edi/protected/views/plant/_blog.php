<?php
/* @var $this PlantController
 * @var $model Plant
 */

$plantAdmin = Yii::app()->user->checkAccess('Plant.*');
$plantUpdate = Yii::app()->user->checkAccess('Plant.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-code-fork fa-lg',
    'title' => $plantUpdate ? TbHtml::link(UHtml::markSearch($data, "pl1_code"), array("update", "id" => $data->id)) : $data->pl1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'pl1_code',
            'type' => 'raw',
            'value' => $plantUpdate ? TbHtml::link(UHtml::markSearch($data, "pl1_code"), array("update", "id" => $data->id)) : $data->pl1_code,
        ),
        array(
            'name' => 'pl1_name',
        ),
        array(
            'name' => 'cu1_id',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $plantAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $plantAdmin,
        ),
    ),
));
$this->endWidget();

