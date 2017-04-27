<?php
/* @var $this BarcodeScannerController
 * @var $model BarcodeScanner
 */

$cs = Yii::app()->clientScript;
$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
$barcodeScannerCreate = Yii::app()->user->checkAccess('BarcodeScanner.Create');
$barcodeScannerUpdate = Yii::app()->user->checkAccess('BarcodeScanner.Update');
$barcodeScannerDelete = Yii::app()->user->checkAccess('BarcodeScanner.Delete');
// Title
$this->title = Yii::t('app', 'Barcode Scanners').' <span class="text-warning">'.$model->itemAlias('model', $model->bs1_model).'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Barcode Scanners') => array('index'),
    $model->itemAlias('model', $model->bs1_model),
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
if ($barcodeScannerUpdate || $barcodeScannerDelete) {
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
            'visible' => $barcodeScannerCreate,
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
            'visible' => $barcodeScannerUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'barcode-scanner-delete-btn navbar-btn btn-sm',),
            'visible' => $barcodeScannerDelete,
        ),
    ));
    if ($barcodeScannerDelete) {
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
        $cs->registerScript(__CLASS__ . 'barcode_scanner_delete', '
            $(".barcode-scanner-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this BarcodeScanner?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".barcode-scanner-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
    'title' => $model->itemAlias('model', $model->bs1_model),
    'headerIcon' => 'fa fa-barcode fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'us1_search',
            'value' => ($model->user == null ? '' : $model->user->fullname),
        ),
        'bs1_mac_address',
        array(
            'name' => 'bs1_model',
            'value' => $model->itemAlias('model', $model->bs1_model),
        ),
        array(
            'name' => 'bs1_com_port',
            'value' => $model->itemAlias('comPort', $model->bs1_com_port),
        ),
        array(
            'name' => 'bs1_speed',
            'value' => $model->itemAlias('speed', $model->bs1_speed),
        ),
        array(
            'name' => 'bs1_data_bit',
            'value' => $model->itemAlias('dataBit', $model->bs1_data_bit),
        ),
        array(
            'name' => 'bs1_parity',
            'value' => $model->itemAlias('parity', $model->bs1_parity),
        ),
        array(
            'name' => 'bs1_stop_bit',
            'value' => $model->itemAlias('stopBit', $model->bs1_stop_bit),
        ),
        array(
            'name' => 'bs1_flow_control',
            'value' => $model->itemAlias('flowControl', $model->bs1_flow_control),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null ? '' : $model->cprofile->fullname),
            'visible' => $barcodeScannerAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $barcodeScannerAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null ? '' : $model->mprofile->fullname),
            'visible' => $barcodeScannerAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $barcodeScannerAdmin,
        ),
    ),
));
$this->endWidget();

