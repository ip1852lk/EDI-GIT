<?php
/* @var $this BarcodeScannerController
 * @var $model BarcodeScanner
 */

$cs = Yii::app()->clientScript;
$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
$barcodeScannerCreate = Yii::app()->user->checkAccess('BarcodeScanner.Create');
$barcodeScannerExport = Yii::app()->user->checkAccess('BarcodeScanner.Export');
// Title
$this->title = Yii::t('app', 'Barcode Scanners');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Barcode Scanners'),
);
// Menus
if ($barcodeScannerCreate || $barcodeScannerExport) {
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
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'barcode-scanner-export-btn navbar-btn btn-sm'),
            'visible' => $barcodeScannerExport,
        ),
    ));
}
if ($barcodeScannerAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'barcode-scanner-search-btn navbar-btn btn-sm'),
            'visible' => $barcodeScannerAdmin,
        ),
    ));
}
if ($barcodeScannerExport) {
    $cs->registerScript(__CLASS__ . 'barcode_scanner_export', "
        $('.barcode-scanner-export-btn').click(function(event) {
            $.fn.yiiGridView.update('barcode-scanner-grid', {
                data: $(this).serialize()+'&export=true',
                success: function(data) {
                if (data.status === '200') {
                    window.location.href = data.body;
                } else {
                    bootbox.dialog({
                            title: '".Yii::t('app', 'EXPORT ERROR')."',
                            message: '<span class=\"label label-danger\">ERROR '+data.status+'</span> '+data.body,
                            buttons: {
                        'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                            }
                        });
                    }
                },
                error: function(XHR) {
                bootbox.dialog({
                        title: '".Yii::t('app', 'EXPORT ERROR')."',
                        message: '<span class=\"label label-danger\">".Yii::t('app', 'NETWORK ERROR')."</span> ".Yii::t('app', 'Please refresh this page and try again shortly.')."',
                        buttons: {
                    'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                        }
                    });
                }
            });
            return false;
        });
    ");
}
if ($barcodeScannerAdmin) {
    $cs->registerScript(__CLASS__ . 'barcode_scanner_search', "
        $('.barcode-scanner-search-btn, .barcode-scanner-search-close-btn').click(function(event) {
            if ($('.barcode-scanner-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.barcode-scanner-search-container').slideUp('slow');
            } else {
                $('.barcode-scanner-search-container').slideDown('slow');
            }
            return false;
        });
        $('.barcode-scanner-search-form').submit(function(){
            $('#barcode-scanner-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//barcodeScanner/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//barcodeScanner/_grid', array(
    'model' => $model,
));

