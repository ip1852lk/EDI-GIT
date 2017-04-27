

<?php
/* @var $this EdiController
 * @var $model Edi
 */

$cs = Yii::app()->clientScript;
$ediAdmin = Yii::app()->user->checkAccess('Edi.*');
$ediCreate = Yii::app()->user->checkAccess('Edi.Create');
$ediExport = Yii::app()->user->checkAccess('Edi.Export');
// Title
$this->title = Yii::t('app', 'Edis');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Edis'),
);
// Menus
if ($ediCreate || $ediExport) {
    $this->menu = array_merge($this->menu, array(
//        array(
//            'class' => 'booster.widgets.TbButton',
//            'buttonType' => TbButton::BUTTON_LINK,
//            'context' => 'success',
//            'icon' => 'fa fa-plus-square fa-lg',
//            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
//            'url' => array('create'),
//            'encodeLabel' => false,
//            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
//            'visible' => $ediCreate,
//        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'edi-export-btn navbar-btn btn-sm'),
            'visible' => $ediExport,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'primary',
            'icon' => 'fa fa-repeat fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Resend Checked') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('id' => 'edi-resend-checked-btn', 'class'=>' navbar-btn btn-sm disabled'),
            'visible' => $ediExport,
        ),
    ));
}
if ($ediAdmin) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'edi-search-btn navbar-btn btn-sm'),
            'visible' => $ediAdmin,
        ),
    ));
}

if ($ediExport) {
    $cs->registerScript(__CLASS__ . 'edi_export', "
        $('.edi-export-btn').click(function(event) {
            $.fn.yiiGridView.update('edi-grid', {
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
if ($ediAdmin) {
    $cs->registerScript(__CLASS__ . 'edi_search', "
        $('.edi-search-btn, .edi-search-close-btn').click(function(event) {
            if ($('.edi-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.edi-search-container').slideUp('slow');
            } else {
                $('.edi-search-container').slideDown('slow');
            }
            return false;
        });
        $('.edi-search-form').submit(function(){
            $('#edi-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('//edi/_search', array(
        'model' => $model,
    ));
}
// UIs
echo $this->renderPartial('//edi/_grid', array(
    'model' => $model,
));
?>
    </div>

