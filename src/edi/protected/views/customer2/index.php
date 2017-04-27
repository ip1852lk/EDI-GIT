<?php
/* @var $this Customer2Controller
 * @var $model Customer2
 */

$cs = Yii::app()->clientScript;
$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
$customer2Create = Yii::app()->user->checkAccess('Customer2.Create');
$customer2Export = Yii::app()->user->checkAccess('Customer2.Export');
// Title
$this->title = Yii::t('app', 'Sub-Customers');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Sub-Customers'),
);
// Menus
if ($customer2Create || $customer2Export) {
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
            'visible' => $customer2Create,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer2-export-btn navbar-btn btn-sm'),
            'visible' => $customer2Export,
        ),
    ));
}
if ($customer2Admin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer2-search-btn navbar-btn btn-sm'),
            'visible' => $customer2Admin,
        ),
    ));
}
if ($customer2Export) {
    $cs->registerScript(__CLASS__ . 'customer2_export', "
        $('.customer2-export-btn').click(function(event) {
            $.fn.yiiGridView.update('customer2-grid', {
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
if ($customer2Admin) {
    $cs->registerScript(__CLASS__ . 'customer2_search', "
        $('.customer2-search-btn, .customer2-search-close-btn').click(function(event) {
            if ($('.customer2-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.customer2-search-container').slideUp('slow');
            } else {
                $('.customer2-search-container').slideDown('slow');
            }
            return false;
        });
        $('.customer2-search-form').submit(function(){
            $('#customer2-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//customer2/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//customer2/_grid', array(
    'model' => $model,
));

