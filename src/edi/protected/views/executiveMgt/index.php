<?php
/* @var $this ExecutiveMgtController
 * @var $model ExecutiveMgt
 */

$cs = Yii::app()->clientScript;
$executiveMgtAdmin = Yii::app()->user->checkAccess('ExecutiveMgt.*');
$executiveMgtCreate = Yii::app()->user->checkAccess('ExecutiveMgt.Create');
$executiveMgtExport = Yii::app()->user->checkAccess('ExecutiveMgt.Export');
// Title
$this->title = Yii::t('app', 'Executive Management');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Executive Management'),
);
// Menus
if ($executiveMgtCreate || $executiveMgtExport) {
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
            'visible' => $executiveMgtCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'executive-mgt-export-btn navbar-btn btn-sm'),
            'visible' => $executiveMgtExport,
        ),
    ));
}
if ($executiveMgtAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'executive-mgt-search-btn navbar-btn btn-sm'),
            'visible' => $executiveMgtAdmin,
        ),
    ));
}
if ($executiveMgtExport) {
    $cs->registerScript(__CLASS__ . 'executive_mgt_export', "
        $('.executive-mgt-export-btn').click(function(event) {
            $.fn.yiiGridView.update('executive-mgt-grid', {
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
if ($executiveMgtAdmin) {
    $cs->registerScript(__CLASS__ . 'executive_mgt_search', "
        $('.executive-mgt-search-btn, .executive-mgt-search-close-btn').click(function(event) {
            if ($('.executive-mgt-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.executive-mgt-search-container').slideUp('slow');
            } else {
                $('.executive-mgt-search-container').slideDown('slow');
            }
            return false;
        });
        $('.executive-mgt-search-form').submit(function(){
            $('#executive-mgt-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//executiveMgt/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//executiveMgt/_grid', array(
    'model' => $model,
));

