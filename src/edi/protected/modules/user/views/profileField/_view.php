<?php
/* @var $this ProfileFieldController
 * @var $model ProfileField
 */

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => TbHtml::link(TbHtml::encode($data->varname), array('view', 'id' => $data->id)),
    'headerIcon' => 'fa fa-link',
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'varname',
            'type' => 'raw',
            'value' => TbHtml::link(UHtml::markSearch($data, "varname"), array("view", "id" => $data->id)),
        ),
        'title',
        'field_type',
        'field_size',
        //'field_size_min',
        array(
            'name' => 'required',
            'type' => 'raw',
            'value' => isset($data->required) ? ProfileField::itemAlias('required', $data->required) : '',
        ),
        //'match',
        //'range',
        //'error_message',
        //'other_validator',
        //'widget',
        //'widgetparams',
        //'default',
        'position',
        array(
            'name' => 'visible',
            'type' => 'raw',
            'value' => isset($data->visible) ? ProfileField::itemAlias('required', $data->visible) : '',
        ),
    ),
));
$this->endWidget();
