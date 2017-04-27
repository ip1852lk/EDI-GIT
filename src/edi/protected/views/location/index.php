<?php
/* @var $this LocationController
 * @var $model Location
 */

$cs = Yii::app()->clientScript;
$locationAdmin = Yii::app()->user->checkAccess('Location.*');
$locationCreate = Yii::app()->user->checkAccess('Location.Create');
$locationExport = Yii::app()->user->checkAccess('Location.Export');
// Title
$this->title = Yii::t('app', 'Locations');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Location'),
);
// Menus
if ($locationCreate || $locationExport) {
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
            'visible' => $locationCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'location-export-btn navbar-btn btn-sm'),
            'visible' => $locationExport,
        ),
    ));
}
if ($locationAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'location-search-btn navbar-btn btn-sm'),
            'visible' => $locationAdmin,
        ),
    ));
}
if ($locationExport) {
    $cs->registerScript(__CLASS__ . 'location_export', "
        $('.location-export-btn').click(function(event) {
            $.fn.yiiGridView.update('location-grid', {
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
if ($locationAdmin) {
    $cs->registerScript(__CLASS__ . 'location_search', "
        $('.location-search-btn, .location-search-close-btn').click(function(event) {
            if ($('.location-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.location-search-container').slideUp('slow');
            } else {
                $('.location-search-container').slideDown('slow');
            }
            return false;
        });
        $('.location-search-form').submit(function(){
            $('#location-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//location/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//location/_grid', array(
    'model' => $model,
));
