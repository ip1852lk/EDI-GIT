<?php
/* @var $this BarcodeScannerController
 * @var $data BarcodeScanner
 */

$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
$barcodeScannerUpdate = Yii::app()->user->checkAccess('BarcodeScanner.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-barcode fa-lg',
    'title' => $barcodeScannerUpdate ? TbHtml::link($data->itemAlias('model', $data->bs1_model), array("update", "id" => $data->id)) : $data->itemAlias('model', $data->bs1_model),
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'us1_search',
            'value' => ($data->user == null ? '' : $data->user->fullname),
        ),
        array(
            'name' => 'bs1_mac_address',
            'type' => 'raw',
            'value' => $barcodeScannerUpdate ? TbHtml::link(UHtml::markSearch($data, "bs1_mac_address"), array("update", "id" => $data->id)) : $data->bs1_mac_address,
        ),
        array(
            'name' => 'bs1_model',
            'value' => $data->itemAlias('model', $data->bs1_model),
        ),
        array(
            'name' => 'bs1_com_port',
            'value' => $data->itemAlias('comPort', $data->bs1_com_port),
        ),
        array(
            'name' => 'bs1_speed',
            'value' => $data->itemAlias('speed', $data->bs1_speed),
        ),
        array(
            'name' => 'bs1_data_bit',
            'value' => $data->itemAlias('dataBit', $data->bs1_data_bit),
        ),
        array(
            'name' => 'bs1_parity',
            'value' => $data->itemAlias('parity', $data->bs1_parity),
        ),
        array(
            'name' => 'bs1_stop_bit',
            'value' => $data->itemAlias('stopBit', $data->bs1_stop_bit),
        ),
        array(
            'name' => 'bs1_flow_control',
            'value' => $data->itemAlias('flowControl', $data->bs1_flow_control),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null ? "" : $data->mprofile->fullname),
            'visible' => $barcodeScannerAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $barcodeScannerAdmin,
        ),
    ),
));
$this->endWidget();

