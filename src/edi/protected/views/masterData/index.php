<?php
/* @var $this MasterDataController
 * @var $model MasterData
 */

$cs = Yii::app()->clientScript;
$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
$masterDataCreate = Yii::app()->user->checkAccess('MasterData.Create');
$masterDataExport = Yii::app()->user->checkAccess('MasterData.Export');
// Title
$this->title = Yii::t('app', 'Master Data');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Master Data'),
);
// Menus
if ($masterDataCreate || $masterDataExport) {
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
            'visible' => $masterDataCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'master-data-export-btn navbar-btn btn-sm'),
            'visible' => $masterDataExport,
        ),
    ));
}
if ($masterDataAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'master-data-search-btn navbar-btn btn-sm'),
            'visible' => $masterDataAdmin,
        ),
    ));
}
if ($masterDataExport) {
    $cs->registerScript(__CLASS__ . 'master_data_export', "
        $('.master-data-export-btn').click(function(event) {
            $.fn.yiiGridView.update('master-data-grid', {
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
if ($masterDataAdmin) {
    $cs->registerScript(__CLASS__ . 'master_data_search', "
        $('.master-data-search-btn, .master-data-search-close-btn').click(function(event) {
            if ($('.master-data-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.master-data-search-container').slideUp('slow');
            } else {
                $('.master-data-search-container').slideDown('slow');
            }
            return false;
        });
        $('.master-data-search-form').submit(function(){
            $('#master-data-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//masterData/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//masterData/_grid', array(
    'model' => $model,
));

