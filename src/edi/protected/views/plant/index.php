<?php
/* @var $this PlantController
 * @var $model Plant
 */

$cs = Yii::app()->clientScript;
$plantAdmin = Yii::app()->user->checkAccess('Plant.*');
$plantCreate = Yii::app()->user->checkAccess('Plant.Create');
$plantExport = Yii::app()->user->checkAccess('Plant.Export');
// Title
$this->title = Yii::t('app', Yii::t('app', Yii::app()->params['plantDisplayLabel2']));
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', Yii::t('app', Yii::app()->params['plantDisplayLabel2'])),
);
// Menus
if ($plantCreate || $plantExport) {
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
            'visible' => $plantCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'plant-export-btn navbar-btn btn-sm'),
            'visible' => $plantExport,
        ),
    ));
}
if ($plantAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'plant-search-btn navbar-btn btn-sm'),
            'visible' => $plantAdmin,
        ),
    ));
}
if ($plantExport) {
    $cs->registerScript(__CLASS__ . 'plant_export', "
        $('.plant-export-btn').click(function(event) {
            $.fn.yiiGridView.update('plant-grid', {
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
if ($plantAdmin) {
    $cs->registerScript(__CLASS__ . 'plant_search', "
        $('.plant-search-btn, .plant-search-close-btn').click(function(event) {
            if ($('.plant-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.plant-search-container').slideUp('slow');
            } else {
                $('.plant-search-container').slideDown('slow');
            }
            return false;
        });
        $('.plant-search-form').submit(function(){
            $('#plant-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//plant/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//plant/_grid', array(
    'model' => $model,
));

