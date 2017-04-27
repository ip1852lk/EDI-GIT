<?php
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 */

$cs = Yii::app()->clientScript;
$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
$customer_EDICreate = Yii::app()->user->checkAccess('Customer_EDI.Create');
$customer_EDIExport = Yii::app()->user->checkAccess('Customer_EDI.Export');
// Title
$this->title = Yii::t('app', 'Customer  Edis');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Customer  Edis'),
);
// Menus
if ($customer_EDICreate || $customer_EDIExport) {
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
            'visible' => $customer_EDICreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer--edi-export-btn navbar-btn btn-sm'),
            'visible' => $customer_EDIExport,
        ),
    ));
}
if ($customer_EDIAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer--edi-search-btn navbar-btn btn-sm'),
            'visible' => $customer_EDIAdmin,
        ),
    ));
}
if ($customer_EDIExport) {
    $cs->registerScript(__CLASS__ . 'customer__edi_export', "
        $('.customer--edi-export-btn').click(function(event) {
            $.fn.yiiGridView.update('customer--edi-grid', {
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
if ($customer_EDIAdmin) {
    $cs->registerScript(__CLASS__ . 'customer__edi_search', "
        $('.customer--edi-search-btn, .customer--edi-search-close-btn').click(function(event) {
            if ($('.customer--edi-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.customer--edi-search-container').slideUp('slow');
            } else {
                $('.customer--edi-search-container').slideDown('slow');
            }
            return false;
        });
        $('.customer--edi-search-form').submit(function(){
            $('#customer--edi-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//customer_EDI/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//customer_EDI/_grid', array(
    'model' => $model,
));

