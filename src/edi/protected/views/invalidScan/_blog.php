<?php
/* @var $this InvalidScanController
 * @var $model InvalidScan
 */

$invalidScanAdmin = Yii::app()->user->checkAccess('InvalidScan.*');
$invalidScanUpdate = Yii::app()->user->checkAccess('InvalidScan.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-barcode fa-lg',
    'title' => $invalidScanUpdate ? TbHtml::link(UHtml::markSearch($data, "id"), array("update", "id" => $data->id)) : $data->id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => $invalidScanUpdate ? TbHtml::link(UHtml::markSearch($data, "id"), array("update", "id" => $data->id)) : $data->id,
        ),
        array(
            'name' => 'is1_error_code',
        ),
        array(
            'name' => 'us1_id',
        ),
        array(
            'name' => 'cu1_id',
        ),
        array(
            'name' => 'or1_type',
        ),
        array(
            'name' => 'contract_bin_id',
        ),
        array(
            'name' => 'or2_scanned_qty',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $invalidScanAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $invalidScanAdmin,
        ),
    ),
));
$this->endWidget();

