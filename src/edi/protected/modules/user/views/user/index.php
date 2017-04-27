<?php
/* @var $this UserController
 * @var $model User
 */

$cs = Yii::app()->clientScript;
$userAdmin = Yii::app()->user->checkAccess('User.User.*');
$userCreate = Yii::app()->user->checkAccess('User.User.Create');
$userExport = Yii::app()->user->checkAccess('User.User.Export');
// Title
$this->title = Yii::t('app', 'Users');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    Yii::t('app', 'Users'),
);
// Menus
if ($userCreate || $userExport) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('/user/user/create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $userCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'user-export-btn navbar-btn btn-sm'),
            'visible' => $userExport,
        ),
    ));
}
//if ($userAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'user-search-btn navbar-btn btn-sm'),
            'visible' => true, //$userAdmin,
        ),
    ));
//}
if ($userExport) {
    $cs->registerScript(__CLASS__ . 'user_export', "
        $('.user-export-btn').click(function(event) {
            event.preventDefault();
            $.fn.yiiGridView.update('user-grid', {
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
//if ($userAdmin) {
    $cs->registerScript(__CLASS__ . 'user_search', "
        $('.user-search-btn, .user-search-close-btn').click(function(event) {
            event.preventDefault();
            if ($('.user-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.user-search-container').slideUp('slow');
            } else {
                $('.user-search-container').slideDown('slow');
            }
        });
        $('.user-search-form').submit(function() {
            $('#user-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('application.modules.user.views.user._search', array(
        'model' => $model,
    ));
//}
// UIs
echo $this->renderPartial('application.modules.user.views.user._grid', array(
    'model' => $model,
));
