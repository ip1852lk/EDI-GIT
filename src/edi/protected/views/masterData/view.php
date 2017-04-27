<?php
/* @var $this MasterDataController
 * @var $model MasterData
 */

$cs = Yii::app()->clientScript;
$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
$masterDataCreate = Yii::app()->user->checkAccess('MasterData.Create');
$masterDataUpdate = Yii::app()->user->checkAccess('MasterData.Update');
$masterDataDelete = Yii::app()->user->checkAccess('MasterData.Delete');
// Title
$this->title = Yii::t('app', 'Master Data').' <span class="text-warning">'.$model->contract_bin_id.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Master Data') => array('index'),
    $model->contract_bin_id,
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'warning',
            'icon' => 'fa fa-lg fa-angle-double-left',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Back') . '</span>',
            'url' => array(
                $dependency,
                'id' => (int)$parentId,
                'tabIndex' => isset($dependencyTabIndex)?$dependencyTabIndex:1,
                'tabDropdownIndex' => isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:0,
            ),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        ),
    ));
}
if ($masterDataUpdate || $masterDataDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $masterDataCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => $model->id),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $masterDataUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'master-data-delete-btn navbar-btn btn-sm',),
            'visible' => $masterDataDelete,
        ),
    ));
    if ($masterDataDelete) {
        if (isset($dependency))
            $deleteUrl = array(
                'id' => $model->id,
                'dependency' => $dependency,
                'dependencyTabIndex' => $dependencyTabIndex,
                'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
                'parentPk' => $parentPk,
                'parentId' => $parentId,
            );
        else
            $deleteUrl = array('id' => $model->id);
        $cs->registerCoreScript('yii');
        $cs->registerScript(__CLASS__ . 'master_data_delete', '
            $(".master-data-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this MasterData?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".master-data-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                        }},
                        cancel:{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
                    }
                });
                return false;
            });
        ');
    }
}
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->contract_bin_id,
    'headerIcon' => 'fa fa-gift fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'co1_search',
            'value' => ($model->company == null ? '' : $model->company->co1_name),
        ),
        array(
            'name' => 'cu2_search',
            'value' => ($model->customer2 == null ? '' : $model->customer2->customer_name),
        ),
        array(
            'name' => 'ra1_search',
            'value' => ($model->rack == null ? '' : $model->rack->ship_to_name),
        ),
        'contract_bin_id',
        'customer_bin_id',
        'item_id',
        'customer_part_no',
        'item_desc',
        'extended_desc',
        array(
            'name' => 'bt1_search',
            'value' => ($model->binType == null ? '' : $model->binType->bt1_code),
        ),
        'preferred_location_id',
        array(
            'name' => 'pf1_search',
            'value' => ($model->productFamily == null ? '' : $model->productFamily->pf1_family.' - '.$model->productFamily->pf1_commodity),
        ),
        array(
            'name' => 'reorder_qty',
            'value' => number_format($model->reorder_qty, 1),
        ),
        array(
            'name' => 'capacity',
            'value' => number_format($model->capacity, 1),
        ),
        array(
            'name' => 'min_qty',
            'value' => number_format($model->min_qty, 1),
        ),
        array(
            'name' => 'max_qty',
            'value' => number_format($model->max_qty, 1),
        ),
        array(
            'name' => 'p21_on_hand_qty',
            'value' => number_format($model->p21_on_hand_qty, 1),
        ),
        array(
            'name' => 'frequency',
            'value' => number_format($model->frequency, 0),
        ),
        array(
            'name' => 'unit_size',
            'value' => number_format($model->unit_size, 2),
        ),
        'unit_of_measure',
        array(
            'name' => 'price',
            'value' => Yii::app()->numberFormatter->formatCurrency($model->price, Yii::app()->params["supportedLanguages"][Yii::app()->language]["currency"]),
        ),
        array(
            'name' => 'total_value',
            'value' => Yii::app()->numberFormatter->formatCurrency($model->capacity*$model->price/$model->unit_size, Yii::app()->params["supportedLanguages"][Yii::app()->language]["currency"]),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null? '' : $model->cprofile->fullname),
            'visible' => $masterDataAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $masterDataAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null ? '' : $model->mprofile->fullname),
            'visible' => $masterDataAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $masterDataAdmin,
        ),
    ),
));
$this->endWidget();

