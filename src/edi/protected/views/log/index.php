<?php
/* @var $this LogController
 * @var $model Log
 */

$cs = Yii::app()->clientScript;
$logAdmin = Yii::app()->user->checkAccess('Log.*');
$logCreate = Yii::app()->user->checkAccess('Log.Create');
$logExport = Yii::app()->user->checkAccess('Log.Export');
// Title
$this->title = Yii::t('app', 'Logs');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Logs'),
);
// Menus
if ($logCreate || $logExport) {
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
            'visible' => $logCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'log-export-btn navbar-btn btn-sm'),
            'visible' => $logExport,
        ),
    ));
}
if ($logAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'log-search-btn navbar-btn btn-sm'),
            'visible' => $logAdmin,
        ),
    ));
}
if ($logExport) {
    $cs->registerScript(__CLASS__ . 'log_export', "
        $('.log-export-btn').click(function(event) {
            $.fn.yiiGridView.update('log-grid', {
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
if ($logAdmin) {
    $cs->registerScript(__CLASS__ . 'log_search', "
        $('.log-search-btn, .log-search-close-btn').click(function(event) {
            if ($('.log-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.log-search-container').slideUp('slow');
            } else {
                $('.log-search-container').slideDown('slow');
            }
            return false;
        });
        $('.log-search-form').submit(function(){
            $('#log-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//log/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//log/_grid', array(
    'model' => $model,
));

