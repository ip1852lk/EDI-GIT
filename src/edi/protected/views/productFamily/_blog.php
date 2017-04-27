<?php
/* @var $this ProductFamilyController
 * @var $model ProductFamily
 */

$productFamilyAdmin = Yii::app()->user->checkAccess('ProductFamily.*');
$productFamilyUpdate = Yii::app()->user->checkAccess('ProductFamily.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-tags fa-lg',
    'title' => $productFamilyUpdate ? TbHtml::link(UHtml::markSearch($data, "pf1_family"), array("update", "id" => $data->id)) : $data->pf1_family,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'pf1_family',
            'type' => 'raw',
            'value' => $productFamilyUpdate ? TbHtml::link(UHtml::markSearch($data, "pf1_family"), array("update", "id" => $data->id)) : $data->pf1_family,
        ),
        array(
            'name' => 'pf1_commodity',
        ),
        array(
            'name' => 'pf1_desc1',
        ),
        array(
            'name' => 'pf1_desc2',
        ),
        array(
            'name' => 'pf1_desc3',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $productFamilyAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $productFamilyAdmin,
        ),
    ),
));
$this->endWidget();

