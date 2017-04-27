<?php
/* @var $this CompanyController
 * @var $model Company
 */

$companyAdmin = Yii::app()->user->checkAccess('Company.*');
$companyUpdate = Yii::app()->user->checkAccess('Company.Update');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-lg fa-building',
    'title' => $companyUpdate ? TbHtml::link(UHtml::markSearch($data, "co1_code"), array("update", "id" => $data->id)) : $data->co1_code,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'co1_logo',
            'type' => 'image',
            'value' => isset($data->co1_logo) && strlen($data->co1_logo) > 0 ? $data->co1_logo : Yii::app()->params['companyDefaultLogo'],
        ),
        array(
            'name' => 'co1_code',
            'type' => 'raw',
            'value' => $companyUpdate ? TbHtml::link(UHtml::markSearch($data, "co1_code"), array("update", "id" => $data->id)) : $data->co1_code,
        ),
        'co1_name',
        array(
            'name' => 'co1_type',
            'value' => Company::itemAlias("companyTypes", $data->co1_type),
        ),
        'co1_phone',
        'co1_fax',
        array(
            'name' => 'co1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $companyAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $companyAdmin,
        ),
    ),
));
$this->endWidget();
