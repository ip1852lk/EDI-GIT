<?php
/* @var $this SupplierController
 * @var $model Supplier
 */

$cs = Yii::app()->clientScript;
$supplierAdmin = Yii::app()->user->checkAccess('Supplier.*');
$supplierCreate = Yii::app()->user->checkAccess('Supplier.Create');
$supplierExport = Yii::app()->user->checkAccess('Supplier.Export');
// Title
$this->title = Yii::t('app', 'Suppliers');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Suppliers'),
);
// Menus
if ($supplierCreate || $supplierExport) {
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
            'visible' => $supplierCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'supplier-export-btn navbar-btn btn-sm'),
            'visible' => $supplierExport,
        ),
    ));
}
if ($supplierAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'supplier-search-btn navbar-btn btn-sm'),
            'visible' => $supplierAdmin,
        ),
    ));
}
if ($supplierExport) {
    $cs->registerScript(__CLASS__ . 'supplier_export', "
        $('.supplier-export-btn').click(function(event) {
            $.fn.yiiGridView.update('supplier-grid', {
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
if ($supplierAdmin) {
    $cs->registerScript(__CLASS__ . 'supplier_search', "
        $('.supplier-search-btn, .supplier-search-close-btn').click(function(event) {
            if ($('.supplier-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.supplier-search-container').slideUp('slow');
            } else {
                $('.supplier-search-container').slideDown('slow');
            }
            return false;
        });
        $('.supplier-search-form').submit(function(){
            $('#supplier-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//supplier/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//supplier/_grid', array(
    'model' => $model,
));
