<?php
/* @var $this EdiController
 * @var $data Edi
 */

$ediAdmin = Yii::app()->user->checkAccess('Edi.*');
$ediUpdate = Yii::app()->user->checkAccess('Edi.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-exchange fa-lg',
    'title' => $ediUpdate ? TbHtml::link(UHtml::markSearch($data, "ED1_ID"), array("update", "id" => $data->ED1_ID)) : $data->ED1_ID,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'ED1_ID',
            'type' => 'raw',
            'value' => $ediUpdate ? TbHtml::link(UHtml::markSearch($data, "ED1_ID"), array("update", "id" => $data->ED1_ID)) : $data->ED1_ID,
        ),
        array(
            'name' => 'ED1_TYPE',
        ),
        array(
            'name' => 'ED1_DOCUMENT_NO',
        ),
        array(
            'name' => 'ED1_FILENAME',
        ),
        array(
            'name' => 'ED1_STATUS',
        ),
        array(
            'name' => 'CU1_ID',
        ),
        array(
            'name' => 'VD1_ID',
        ),
        array(
            'name' => 'ED1_MODIFIED_ON',
        ),
        array(
            'name' => 'ED1_MODIFIED_BY',
        ),
        array(
            'name' => 'ED1_CREATED_ON',
        ),
        array(
            'name' => 'ED1_CREATED_BY',
        ),
        array(
            'name' => 'ED1_SHOW_DEFAULT',
        ),
        array(
            'name' => 'ED1_IN_OUT',
        ),
        array(
            'name' => 'ED1_RESEND',
        ),
        array(
            'name' => 'ED1_ACKNOWLEDGED',
        ),
    ),
));
$this->endWidget();

