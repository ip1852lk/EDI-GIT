<?php
/* @var $this MasterDataController
 * @var $data MasterData
 */

$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
$masterDataUpdate = Yii::app()->user->checkAccess('MasterData.Update');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-gift fa-lg',
    'title' => $masterDataUpdate ? TbHtml::link(UHtml::markSearch($data, "contract_bin_id"), array("update", "id" => $data->id)) : $data->contract_bin_id,
));
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'co1_search',
            'value' => ($data->company == null ? '' : $data->company->co1_name),
        ),
        array(
            'name' => 'cu2_search',
            'value' => ($data->customer2 == null ? '' : $data->customer2->customer_name),
        ),
        array(
            'name' => 'ra1_search',
            'value' => ($data->rack == null ? '' : $data->rack->ship_to_name),
        ),
        array(
            'name' => 'contract_bin_id',
            'type' => 'raw',
            'value' => $masterDataUpdate ? TbHtml::link(UHtml::markSearch($data, "contract_bin_id"), array("update", "id" => $data->id)) : $data->contract_bin_id,
        ),
        'customer_bin_id',
        'item_id',
        'customer_part_no',
        'item_desc',
        'extended_desc',
        array(
            'name' => 'bt1_search',
            'value' => ($data->binType == null ? '' : $data->binType->bt1_code),
        ),
        'preferred_location_id',
        array(
            'name' => 'pf1_search',
            'value' => ($data->productFamily == null ? '' : $data->productFamily->pf1_family.' - '.$data->productFamily->pf1_commodity),
        ),
        array(
            'name' => 'reorder_qty',
            'value' => number_format($data->reorder_qty, 0),
        ),
        array(
            'name' => 'capacity',
            'value' => number_format($data->capacity, 0),
        ),
        array(
            'name' => 'min_qty',
            'value' => number_format($data->min_qty, 0),
        ),
        array(
            'name' => 'max_qty',
            'value' => number_format($data->max_qty, 0),
        ),
        array(
            'name' => 'p21_on_hand_qty',
            'value' => number_format($data->p21_on_hand_qty, 0),
        ),
        array(
            'name' => 'frequency',
            'value' => number_format($data->frequency, 0),
        ),
        array(
            'name' => 'unit_size',
            'value' => number_format($data->unit_size, 2),
        ),
        'unit_of_measure',
        array(
            'name' => 'price',
            'value' => Yii::app()->numberFormatter->formatCurrency($data->price, Yii::app()->params["supportedLanguages"][Yii::app()->language]["currency"]),
        ),
        array(
            'name' => 'total_value',
            'value' => Yii::app()->numberFormatter->formatCurrency($data->capacity*$data->price/$data->unit_size, Yii::app()->params["supportedLanguages"][Yii::app()->language]["currency"]),
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($data->mprofile == null || $data->mprofile->first_name == null ? "" : $data->mprofile->first_name . " " . $data->mprofile->last_name),
            'visible' => $masterDataAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($data->modified_on == "" || $data->modified_on == "0000-00-00 00:00:00" ? "" : Yii::app()->dateFormatter->formatDateTime($data->modified_on, "medium", "short")),
            'visible' => $masterDataAdmin,
        ),
    ),
));
$this->endWidget();

