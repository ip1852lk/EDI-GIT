<?php
/* @var $this BinTypeController
 * @var $model BinType
 */

$cs = Yii::app()->clientScript;
$binTypeAdmin = Yii::app()->user->checkAccess('BinType.*');
$binTypeCreate = Yii::app()->user->checkAccess('BinType.Create');
$binTypeExport = Yii::app()->user->checkAccess('BinType.Export');
// Title
$this->title = Yii::t('app', 'Bin Types');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Bin Types'),
);
// Menus
if ($binTypeCreate || $binTypeExport) {
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
            'visible' => $binTypeCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'bin-type-export-btn navbar-btn btn-sm'),
            'visible' => $binTypeExport,
        ),
    ));
}
if ($binTypeAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'bin-type-search-btn navbar-btn btn-sm'),
            'visible' => $binTypeAdmin,
        ),
    ));
}
if ($binTypeExport) {
    $cs->registerScript(__CLASS__ . 'bin_type_export', "
        $('.bin-type-export-btn').click(function(event) {
            $.fn.yiiGridView.update('bin-type-grid', {
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
if ($binTypeAdmin) {
    $cs->registerScript(__CLASS__ . 'bin_type_search', "
        $('.bin-type-search-btn, .bin-type-search-close-btn').click(function(event) {
            if ($('.bin-type-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.bin-type-search-container').slideUp('slow');
            } else {
                $('.bin-type-search-container').slideDown('slow');
            }
            return false;
        });
        $('.bin-type-search-form').submit(function(){
            $('#bin-type-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//binType/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//binType/_grid', array(
    'model' => $model,
));

