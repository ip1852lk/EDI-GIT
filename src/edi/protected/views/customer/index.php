<?php
/* @var $this CustomerController
 * @var $model Customer
 */

$cs = Yii::app()->clientScript;
$customerAdmin = Yii::app()->user->checkAccess('Customer.*');
$customerCreate = Yii::app()->user->checkAccess('Customer.Create');
$customerExport = Yii::app()->user->checkAccess('Customer.Export');
// Title
$this->title = Yii::t('app', 'Customers');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Customers'),
);
// Menus
if ($customerCreate || $customerExport) {
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
            'visible' => $customerCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer-export-btn navbar-btn btn-sm'),
            'visible' => $customerExport,
        ),
    ));
}
if ($customerAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer-search-btn navbar-btn btn-sm'),
            'visible' => $customerAdmin,
        ),
    ));
}
if ($customerExport) {
    $cs->registerScript(__CLASS__ . 'customer_export', "
        $('.customer-export-btn').click(function(event) {
            $.fn.yiiGridView.update('customer-grid', {
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
if ($customerAdmin) {
    $cs->registerScript(__CLASS__ . 'customer_search', "
        $('.customer-search-btn, .customer-search-close-btn').click(function(event) {
            if ($('.customer-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.customer-search-container').slideUp('slow');
            } else {
                $('.customer-search-container').slideDown('slow');
            }
            return false;
        });
        $('.customer-search-form').submit(function(){
            $('#customer-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//customer/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//customer/_grid', array(
    'model' => $model,
));
