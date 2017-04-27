<?php
/* @var $this ProductFamilyController
 * @var $model ProductFamily
 */

$cs = Yii::app()->clientScript;
$productFamilyAdmin = Yii::app()->user->checkAccess('ProductFamily.*');
$productFamilyCreate = Yii::app()->user->checkAccess('ProductFamily.Create');
$productFamilyExport = Yii::app()->user->checkAccess('ProductFamily.Export');
// Title
$this->title = Yii::t('app', 'Product Families');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Product Families'),
);
// Menus
if ($productFamilyCreate || $productFamilyExport) {
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
            'visible' => $productFamilyCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'product-family-export-btn navbar-btn btn-sm'),
            'visible' => $productFamilyExport,
        ),
    ));
}
if ($productFamilyAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'product-family-search-btn navbar-btn btn-sm'),
            'visible' => $productFamilyAdmin,
        ),
    ));
}
if ($productFamilyExport) {
    $cs->registerScript(__CLASS__ . 'product_family_export', "
        $('.product-family-export-btn').click(function(event) {
            $.fn.yiiGridView.update('product-family-grid', {
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
if ($productFamilyAdmin) {
    $cs->registerScript(__CLASS__ . 'product_family_search', "
        $('.product-family-search-btn, .product-family-search-close-btn').click(function(event) {
            if ($('.product-family-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.product-family-search-container').slideUp('slow');
            } else {
                $('.product-family-search-container').slideDown('slow');
            }
            return false;
        });
        $('.product-family-search-form').submit(function(){
            $('#product-family-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//productFamily/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//productFamily/_grid', array(
    'model' => $model,
));

