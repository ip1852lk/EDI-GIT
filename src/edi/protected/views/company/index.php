<?php
/* @var $this CompanyController
 * @var $model Company
 */

$cs = Yii::app()->clientScript;
$companyAdmin = Yii::app()->user->checkAccess('Company.*');
$companyCreate = Yii::app()->user->checkAccess('Company.Create');
$companyExport = Yii::app()->user->checkAccess('Company.Export');
// Title
$this->title = Yii::t('app', 'Companies');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Companies'),
);
// Menus
if ($companyCreate || $companyExport) {
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
            'visible' => $companyCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'company-export-btn navbar-btn btn-sm'),
            'visible' => $companyExport,
        ),
    ));
}
if ($companyAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'company-search-btn navbar-btn btn-sm'),
            'visible' => $companyAdmin,
        ),
    ));
}
if ($companyExport) {
    $cs->registerScript(__CLASS__ . 'company_export', "
        $('.company-export-btn').click(function(event) {
            $.fn.yiiGridView.update('company-grid', {
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
if ($companyAdmin) {
    $cs->registerScript(__CLASS__ . 'company_search', "
        $('.company-search-btn, .company-search-close-btn').click(function(event) {
            if ($('.company-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.company-search-container').slideUp('slow');
            } else {
                $('.company-search-container').slideDown('slow');
            }
            return false;
        });
        $('.company-search-form').submit(function(){
            $('#company-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//company/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//company/_grid', array(
    'model' => $model,
));
