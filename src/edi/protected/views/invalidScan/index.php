<?php
/* @var $this InvalidScanController
 * @var $model InvalidScan
 */

$cs = Yii::app()->clientScript;
$invalidScanAdmin = Yii::app()->user->checkAccess('InvalidScan.*');
$invalidScanCreate = Yii::app()->user->checkAccess('InvalidScan.Create');
$invalidScanExport = Yii::app()->user->checkAccess('InvalidScan.Export');
// Title
$this->title = Yii::t('app', 'Invalid Scans');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Invalid Scans'),
);
// Menus
if ($invalidScanCreate || $invalidScanExport) {
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
            'visible' => $invalidScanCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'invalid-scan-export-btn navbar-btn btn-sm'),
            'visible' => $invalidScanExport,
        ),
    ));
}
if ($invalidScanAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'invalid-scan-search-btn navbar-btn btn-sm'),
            'visible' => $invalidScanAdmin,
        ),
    ));
}
if ($invalidScanExport) {
    $cs->registerScript(__CLASS__ . 'invalid_scan_export', "
        $('.invalid-scan-export-btn').click(function(event) {
            $.fn.yiiGridView.update('invalid-scan-grid', {
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
if ($invalidScanAdmin) {
    $cs->registerScript(__CLASS__ . 'invalid_scan_search', "
        $('.invalid-scan-search-btn, .invalid-scan-search-close-btn').click(function(event) {
            if ($('.invalid-scan-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.invalid-scan-search-container').slideUp('slow');
            } else {
                $('.invalid-scan-search-container').slideDown('slow');
            }
            return false;
        });
        $('.invalid-scan-search-form').submit(function(){
            $('#invalid-scan-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//invalidScan/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//invalidScan/_grid', array(
    'model' => $model,
));

