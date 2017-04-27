<?php
/* @var $this SupplierController
 * @var $model Supplier
 */

$supplierAdmin = Yii::app()->user->checkAccess('Supplier.*');
$supplierUpdate = Yii::app()->user->checkAccess('Supplier.Update');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-lg fa-users',
    'title' => $supplierUpdate ? TbHtml::link(UHtml::markSearch($data, "su1_code"), array("update", "id" => $data->id)) : $data->su1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'su1_logo',
            'type' => 'image',
            'value' => isset($data->su1_logo) && strlen($data->su1_logo) > 0 ? $data->su1_logo : Yii::app()->params['supplierDefaultLogo'],
        ),
        array(
            'name' => 'su1_code',
            'type' => 'raw',
            'value' => $supplierUpdate ? TbHtml::link(UHtml::markSearch($data, "su1_code"), array("update", "id" => $data->id)) : $data->su1_code,
        ),
        'su1_name',
        'su1_phone',
        'su1_fax',
        array(
            'name' => 'su1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $supplierAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $supplierAdmin,
        ),
    ),
));
$this->endWidget();
