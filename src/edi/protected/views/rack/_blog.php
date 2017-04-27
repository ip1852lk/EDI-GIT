<?php
/* @var $this RackController
 * @var $data Rack
 */

$rackAdmin = Yii::app()->user->checkAccess('Rack.*');
$rackUpdate = Yii::app()->user->checkAccess('Rack.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-inbox fa-lg',
    'title' => $rackUpdate ? TbHtml::link(UHtml::markSearch($data, "ship_to_id"), array("update", "id" => $data->id)) : $data->ship_to_id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'ship_to_id',
            'type' => 'raw',
            'value' => $rackUpdate ? TbHtml::link(UHtml::markSearch($data, "ship_to_id"), array("update", "id" => $data->id)) : $data->ship_to_id,
        ),
        array(
            'name' => 'ship_to_name',
        ),
        array(
            'name' => 'ra1_po_number',
        ),
        array(
            'name' => 'pl1_search',
            'value' => ($data->plant == null ? '' : $data->plant->pl1_name),
        ),
        array(
            'name' => 'cu1_search',
            'value' => ($data->plant == null || $data->plant->customer == null ? '' : $data->plant->customer->cu1_name),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $rackAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $rackAdmin,
        ),
    ),
));
$this->endWidget();

