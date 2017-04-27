<?php
/* @var $this VendorController
 * @var $model Vendor
 */

$cs = Yii::app()->clientScript;
$vendorAdmin = Yii::app()->user->checkAccess('Vendor.*');
$vendorCreate = Yii::app()->user->checkAccess('Vendor.Create');
$vendorExport = Yii::app()->user->checkAccess('Vendor.Export');
// Title
$this->title = Yii::t('app', 'Vendors');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Vendors'),
);
// Menus
if ($vendorCreate || $vendorExport) {
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
            'visible' => $vendorCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'vendor-export-btn navbar-btn btn-sm'),
            'visible' => $vendorExport,
        ),
    ));
}
if ($vendorAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'vendor-search-btn navbar-btn btn-sm'),
            'visible' => $vendorAdmin,
        ),
    ));
}
if ($vendorExport) {
    $cs->registerScript(__CLASS__ . 'vendor_export', "
        $('.vendor-export-btn').click(function(event) {
            $.fn.yiiGridView.update('vendor-grid', {
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
if ($vendorAdmin) {
    $cs->registerScript(__CLASS__ . 'vendor_search', "
        $('.vendor-search-btn, .vendor-search-close-btn').click(function(event) {
            if ($('.vendor-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.vendor-search-container').slideUp('slow');
            } else {
                $('.vendor-search-container').slideDown('slow');
            }
            return false;
        });
        $('.vendor-search-form').submit(function(){
            $('#vendor-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//vendor/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//vendor/_grid', array(
    'model' => $model,
));

