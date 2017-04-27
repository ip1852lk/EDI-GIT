<?php
/* @var $this AccountRepController
 * @var $model AccountRep
 */

$cs = Yii::app()->clientScript;
$accountRepAdmin = Yii::app()->user->checkAccess('AccountRep.*');
$accountRepCreate = Yii::app()->user->checkAccess('AccountRep.Create');
$accountRepExport = Yii::app()->user->checkAccess('AccountRep.Export');
// Title
$this->title = Yii::t('app', 'Account Representatives');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Account Representatives'),
);
// Menus
if ($accountRepCreate || $accountRepExport) {
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
            'visible' => $accountRepCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'account-rep-export-btn navbar-btn btn-sm'),
            'visible' => $accountRepExport,
        ),
    ));
}
if ($accountRepAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'account-rep-search-btn navbar-btn btn-sm'),
            'visible' => $accountRepAdmin,
        ),
    ));
}
if ($accountRepExport) {
    $cs->registerScript(__CLASS__ . 'account_rep_export', "
        $('.account-rep-export-btn').click(function(event) {
            $.fn.yiiGridView.update('account-rep-grid', {
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
if ($accountRepAdmin) {
    $cs->registerScript(__CLASS__ . 'account_rep_search', "
        $('.account-rep-search-btn, .account-rep-search-close-btn').click(function(event) {
            if ($('.account-rep-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.account-rep-search-container').slideUp('slow');
            } else {
                $('.account-rep-search-container').slideDown('slow');
            }
            return false;
        });
        $('.account-rep-search-form').submit(function(){
            $('#account-rep-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//accountRep/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//accountRep/_grid', array(
    'model' => $model,
));

