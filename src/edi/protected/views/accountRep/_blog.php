<?php
/* @var $this AccountRepController
 * @var $data AccountRep
 */

$accountRepAdmin = Yii::app()->user->checkAccess('AccountRep.*');
$accountRepUpdate = Yii::app()->user->checkAccess('AccountRep.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-user fa-lg',
    'title' => $accountRepUpdate ? TbHtml::link($data->representative->fullname, array("update", "id" => $data->id)) : $data->representative->fullname,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'pl1_search',
            'value' => ($data->plant == null ? '' : $data->plant->pl1_name),
        ),
        array(
            'name' => 'us1_search',
            'type' => 'raw',
            'value' => $accountRepUpdate ? TbHtml::link($data->representative->fullname, array("update", "id" => $data->id)) : $data->representative->fullname,
        ),
        'ar1_desc',
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $accountRepAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $accountRepAdmin,
        ),
    ),
));
$this->endWidget();

