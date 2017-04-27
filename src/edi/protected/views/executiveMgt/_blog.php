<?php
/* @var $this ExecutiveMgtController
 * @var $data ExecutiveMgt
 */

$executiveMgtAdmin = Yii::app()->user->checkAccess('ExecutiveMgt.*');
$executiveMgtUpdate = Yii::app()->user->checkAccess('ExecutiveMgt.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-user fa-lg',
    'title' => $executiveMgtUpdate ? TbHtml::link($data->executive->fullname, array("update", "id" => $data->id)) : $data->executive->fullname,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'lo1_search',
            'value' => $data->location->lo1_name,
        ),
        array(
            'name' => 'us1_search',
            'type' => 'raw',
            'value' => $executiveMgtUpdate ? TbHtml::link($data->executive->fullname, array("update", "id" => $data->id)) : $data->executive->fullname,
        ),
        array(
            'name' => 'em1_desc',
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null ? "" : $data->mprofile->fullname),
            'visible' => $executiveMgtAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $executiveMgtAdmin,
        ),
    ),
));
$this->endWidget();

