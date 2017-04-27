<?php
/* @var $this ProjectController
 * @var $model Project
 */

$cs = Yii::app()->clientScript;
$projectAdmin = Yii::app()->user->checkAccess('Project.*');
$projectCreate = Yii::app()->user->checkAccess('Project.Create');
$projectExport = Yii::app()->user->checkAccess('Project.Export');
// Title
$this->title = Yii::t('app', 'Projects');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Projects'),
);
// Menus
if ($projectCreate || $projectExport) {
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
            'visible' => $projectCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'project-export-btn navbar-btn btn-sm'),
            'visible' => $projectExport,
        ),
    ));
}
if ($projectAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'project-search-btn navbar-btn btn-sm'),
            'visible' => $projectAdmin,
        ),
    ));
}
if ($projectExport) {
    $cs->registerScript(__CLASS__ . 'project_export', "
        $('.project-export-btn').click(function(event) {
            $.fn.yiiGridView.update('project-grid', {
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
if ($projectAdmin) {
    $cs->registerScript(__CLASS__ . 'project_search', "
        $('.project-search-btn, .project-search-close-btn').click(function(event) {
            if ($('.project-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.project-search-container').slideUp('slow');
            } else {
                $('.project-search-container').slideDown('slow');
            }
            return false;
        });
        $('.project-search-form').submit(function(){
            $('#project-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//project/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//project/_grid', array(
    'model' => $model,
));

