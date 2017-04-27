<?php
/* @var $this RackController
 * @var $model Rack
 */

$cs = Yii::app()->clientScript;
$rackAdmin = Yii::app()->user->checkAccess('Rack.*');
$rackCreate = Yii::app()->user->checkAccess('Rack.Create');
$rackExport = Yii::app()->user->checkAccess('Rack.Export');
// Title
$this->title = Yii::t('app', 'Racks');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Racks'),
);
// Menus
if ($rackCreate || $rackExport) {
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
            'visible' => $rackCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'rack-export-btn navbar-btn btn-sm'),
            'visible' => $rackExport,
        ),
    ));
}
if ($rackAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'rack-search-btn navbar-btn btn-sm'),
            'visible' => $rackAdmin,
        ),
    ));
}
if ($rackExport) {
    $cs->registerScript(__CLASS__ . 'rack_export', "
        $('.rack-export-btn').click(function(event) {
            $.fn.yiiGridView.update('rack-grid', {
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
if ($rackAdmin) {
    $cs->registerScript(__CLASS__ . 'rack_search', "
        $('.rack-search-btn, .rack-search-close-btn').click(function(event) {
            if ($('.rack-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.rack-search-container').slideUp('slow');
            } else {
                $('.rack-search-container').slideDown('slow');
            }
            return false;
        });
        $('.rack-search-form').submit(function(){
            $('#rack-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//rack/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//rack/_grid', array(
    'model' => $model,
));

