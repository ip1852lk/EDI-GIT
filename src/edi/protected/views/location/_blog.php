<?php
/* @var $this LocationController
 * @var $data Location
 */

$locationAdmin = Yii::app()->user->checkAccess('Location.*');
$locationUpdate = Yii::app()->user->checkAccess('Location.Update');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-thumb-tack fa-lg',
    'title' => $locationUpdate ? TbHtml::link(UHtml::markSearch($data, "lo1_code"), array("update", "id" => $data->id)) : $data->lo1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'lo1_code',
            'type' => 'raw',
            'value' => $locationUpdate ? TbHtml::link(UHtml::markSearch($data, "lo1_code"), array("update", "id" => $data->id)) : $data->lo1_code,
        ),
        'lo1_name',
        array(
            'name' => 'rg1_search',
            'value' => ($data->region==null ? "" : $data->region->rg1_name),
        ),
        array(
            'name' => 'co1_search',
            'value' => ($data->region==null || $data->region->company==null ? "" : $data->region->company->co1_name),
        ),
        array(
            'name' => 'us1_search',
            'value' => ($data->representative==null ? "" : $data->representative->fullname),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null ? "" : $data->mprofile->fullname),
            'visible' => $locationAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $locationAdmin,
        ),
    ),
));
$this->endWidget();
