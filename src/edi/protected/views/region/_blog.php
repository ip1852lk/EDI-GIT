<?php
/* @var $this RegionController
 * @var $data Region
 */

$regionAdmin = Yii::app()->user->checkAccess('Region.*');
$regionUpdate = Yii::app()->user->checkAccess('Region.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-globe fa-lg',
    'title' => $regionUpdate ? TbHtml::link(UHtml::markSearch($data, "rg1_code"), array("update", "id" => $data->id)) : $data->rg1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'rg1_code',
            'type' => 'raw',
            'value' => $regionUpdate ? TbHtml::link(UHtml::markSearch($data, "rg1_code"), array("update", "id" => $data->id)) : $data->rg1_code,
        ),
        array(
            'name' => 'rg1_name',
        ),
        array(
            'name' => 'co1_search',
            'value' => ($data->company == null ? "" : $data->company->co1_name),
        ),
        array(
            'name' => 'us1_search',
            'value' => ($data->representative == null ? "" : $data->representative->fullname),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null ? "" : $data->mprofile->fullname),
            'visible' => $regionAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $regionAdmin,
        ),
    ),
));
$this->endWidget();

