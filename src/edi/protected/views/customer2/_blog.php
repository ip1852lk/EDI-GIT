<?php
/* @var $this Customer2Controller
 * @var $data Customer2
 */

$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
$customer2Update = Yii::app()->user->checkAccess('Customer2.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-users fa-lg',
    'title' => $customer2Update ? TbHtml::link(UHtml::markSearch($data, "corp_address_id"), array("update", "id" => $data->id)) : $data->corp_address_id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'corp_address_id',
            'type' => 'raw',
            'value' => $customer2Update ? TbHtml::link(UHtml::markSearch($data, "corp_address_id"), array("update", "id" => $data->id)) : $data->corp_address_id,
        ),
        'customer_name',
        array(
            'name' => 'cu2_type',
            'value' => Customer2::itemAlias("customerTypes", $data->cu2_type),
        ),
        'cu2_consignment_location_id',
        array(
            'name' => 'cu1_search',
            'value' => ($data->customer == null ? '' : $data->customer->cu1_name),
        ),
        array(
            'name' => 'lo1_search',
            'value' => ($data->location == null ? '' : $data->location->lo1_name),
        ),
        array(
            'name' => 'rg1_search',
            'value' => ($data->location == null && $data->location->region == null ? '' : $data->location->region->rg1_name),
        ),
        array(
            'name' => 'co1_search',
            'value' => ($data->location == null && $data->location->region == null && $data->location->region->company == null ? '' : $data->location->region->company->co1_name),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $customer2Admin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $customer2Admin,
        ),
    ),
));
$this->endWidget();

