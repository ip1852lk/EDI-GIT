<?php
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 */

if (isset($dependency)) {
    $customer_EDICreate = Yii::app()->user->checkAccess('Customer_EDI.Create');
    $customer_EDIExport = Yii::app()->user->checkAccess('Customer_EDI.Export');
}
?>

<div class="row">
    <div class="top-menu pull-left col-md-4" style="padding-right: 0;">
        <div class="btn-toolbar">
            <?php 
            if (isset($dependency)) {
                if ($customer_EDICreate || $customer_EDIExport) {
                    $this->widget('booster.widgets.TbButtonGroup', array(
                        'context' => 'primary',
                        'htmlOptions' => array('class' => 'operations btn-group-sm'),
                        'buttons' => array(
                            array(
                                'label' => Yii::t('app', 'Actions'),
                                'url' => '#',
                                'htmlOptions' => array('class' => 'visible-xs  visible-sm first-child last-child',),
                                'items' => array(
                                    array(
                                        'label' => Yii::t('app', 'Create'), 
                                        'url' => array(
                                            '/customer_EDI/create',
                                            'dependency' => $dependency, 
                                            'dependencyTabIndex' => $dependencyTabIndex, 
                                            'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex, 
                                            'parentId' => $parentId, 
                                            'parentPk' => $parentPk, 
                                        ),
                                        'icon' => 'fa fa-plus-square',
                                        'visible' => $customer_EDICreate,
                                    ),
                                    array(
                                        'label' => Yii::t('app', 'Export'),
                                        'url' => '#',
                                        'icon' => 'fa fa-file-excel-o',
                                        'linkOptions' => array('class' => 'customer--edi-export-btn-'.$dependencyTabDropdownIndex),
                                        'visible' => $customer_EDIExport,
                                    ),
                                ),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'context' => 'success',
                                'icon' => 'fa fa-plus-square',
                                'label' => Yii::t('app', 'Create'),
                                'url' => array(
                                    '/customer_EDI/create',
                                    'dependency' => $dependency, 
                                    'dependencyTabIndex' => $dependencyTabIndex, 
                                    'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex, 
                                    'parentId' => $parentId, 
                                    'parentPk' => $parentPk, 
                                ),
                                'htmlOptions' => array('class' => 'visible-md visible-lg first-child',),
                                'visible' => $customer_EDICreate,
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_BUTTON,
                                'context' => 'info',
                                'icon' => 'fa fa-file-excel-o',
                                'label' => Yii::t('app', 'Export'),
                                'url' => '#',
                                'htmlOptions' => array('class' => 'customer--edi-export-btn-'.$dependencyTabDropdownIndex.' visible-md visible-lg last-child'),
                                'visible' => $customer_EDIExport,
                            ),
                        ),
                    ));
                }
            } elseif (isset($relation)) {
                $this->widget('booster.widgets.TbButtonGroup', array(
                    'context' => 'primary',
                    'htmlOptions' => array('class' => 'operations btn-group-sm'),
                    'buttons' => array(
                        array(
                            'buttonType' => TbButton::BUTTON_BUTTON,
                            'context' => 'info',
                            'icon' => 'fa fa-check-square',
                            'label' => Yii::t('app', 'Assign'),
                            'url' => '#',
                            'htmlOptions' => array(
                                'class' => 'first-child',
                                'id' => 'customer--edi-relation-select-btn-'.$relationIndex,
                            ),
                        ),
                        array(
                            'buttonType' => TbButton::BUTTON_BUTTON,
                            'context' => 'danger',
                            'icon' => 'fa fa-times',
                            'label' => Yii::t('app', 'Cancel'),
                            'url' => '#',
                            'htmlOptions' => array(
                                'class' => 'last-child',
                                'id' => 'customer--edi-relation-close-btn-'.$relationIndex,
                            ),
                        ),
                    ),
                ));
            }
            ?>
        </div>
    </div>
    <h4 class="content-header"><?php echo Yii::t('app', 'Customer  Edis'); ?></h4>
</div>

<?php 
$cs = Yii::app()->clientScript;
if (isset($dependency)) {
    if ($customer_EDIExport) {
        $cs->registerScript(__CLASS__ . 'customer__edi_export', "
            $('.customer--edi-export-btn-".$dependencyTabDropdownIndex."').click(function(event) {
                $.fn.yiiGridView.update('customer--edi-grid-".$dependencyTabDropdownIndex."', {
                    data: $(this).serialize()+'&export=true&dependencyTabIndex=$dependencyTabIndex&dependencyTabDropdownIndex=$dependencyTabDropdownIndex',
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
}

