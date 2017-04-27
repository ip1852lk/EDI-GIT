<?php
/* @var $this BinTypeController
 * @var $model BinType
 */

$binTypeAdmin = Yii::app()->user->checkAccess('BinType.*');
$binTypeUpdate = Yii::app()->user->checkAccess('BinType.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-sitemap fa-lg',
    'title' => $binTypeUpdate ? TbHtml::link(UHtml::markSearch($data, "id"), array("update", "id" => $data->id)) : $data->id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'bt1_code',
            'type' => 'raw',
            'value' => $binTypeUpdate ? TbHtml::link(UHtml::markSearch($data, "bt1_code"), array("update", "id" => $data->id)) : $data->bt1_code,
        ),
        array(
            'name' => 'bt1_desc',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $binTypeAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $binTypeAdmin,
        ),
    ),
));
$this->endWidget();

