<?php
/* @var $this UserLogController
 * @var $model UserLog
 */

$cs = Yii::app()->clientScript;
$userLogAdmin = Yii::app()->user->checkAccess('User.UserLog.*');
$userLogExport = Yii::app()->user->checkAccess('User.UserLog.Export');
// Title
$this->title = Yii::t('app', 'User Logs');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    Yii::t('app', 'User Logs'),
);
// Menus
if ($userLogExport) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'user-log-export-btn navbar-btn btn-sm'),
            'visible' => $userLogExport,
        ),
    ));
}
//if ($userLogAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'user-log-search-btn navbar-btn btn-sm'),
//            'visible' => $userLogAdmin,
        ),
    ));
//}
if ($userLogExport) {
    $cs->registerScript(__CLASS__ . 'user_log_export', "
        $('.user-log-export-btn').click(function(event) {
            event.preventDefault();
            $.fn.yiiGridView.update('user-log-grid', {
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
        });
    ");
}
//if ($userLogAdmin) {
    $cs->registerScript(__CLASS__ . 'user_log_search', "
        $('.user-log-search-btn, .user-log-search-close-btn').click(function(event) {
            event.preventDefault();
            if ($('.user-log-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.user-log-search-container').slideUp('slow');
            } else {
                $('.user-log-search-container').slideDown('slow');
            }
        });
        $('.user-log-search-form').submit(function() {
            $('#user-log-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('application.modules.user.views.userLog._search', array(
        'model' => $model,
    ));
//}
// UIs
echo $this->renderPartial('application.modules.user.views.userLog._grid', array(
    'model' => $model,
));
