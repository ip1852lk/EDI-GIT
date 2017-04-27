<?php
/* @var $this TableLogController
 * @var $model TableLog 
 */

$cs = Yii::app()->clientScript;
$tableLogAdmin = Yii::app()->user->checkAccess('TableLog.*');
$tableLogCreate = Yii::app()->user->checkAccess('TableLog.Create');
$tableLogExport = Yii::app()->user->checkAccess('TableLog.Export');
// Title
$this->title = Yii::t('app', 'Change Logs');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Change Logs'),
);
// Menus
if ($tableLogCreate || $tableLogExport) {
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
            'visible' => $tableLogCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'table-log-export-btn navbar-btn btn-sm'),
            'visible' => $tableLogExport,
        ),
    ));
}
if ($tableLogAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'table-log-search-btn navbar-btn btn-sm'),
            'visible' => $tableLogAdmin,
        ),
    ));
}
if ($tableLogExport) {
    $cs->registerScript(__CLASS__ . 'table_log_export', "
        $('.table-log-export-btn').click(function(event) {
            $.fn.yiiGridView.update('table-log-grid', {
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
if ($tableLogAdmin) {
    $cs->registerScript(__CLASS__ . 'table_log_search', "
        $('.table-log-search-btn, .table-log-search-close-btn').click(function(event) {
            if ($('.table-log-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.table-log-search-container').slideUp('slow');
            } else {
                $('.table-log-search-container').slideDown('slow');
            }
            return false;
        });
        $('.table-log-search-form').submit(function(){
            $('#table-log-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//tableLog/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//tableLog/_grid', array(
    'model' => $model,
));
