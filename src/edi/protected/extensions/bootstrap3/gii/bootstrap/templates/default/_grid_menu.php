<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

echo 
"<?php
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 */

if (isset(\$dependency)) {
    \${$this->class2var($this->modelClass)}Create = Yii::app()->user->checkAccess('{$this->modelClass}.Create');
    \${$this->class2var($this->modelClass)}Export = Yii::app()->user->checkAccess('{$this->modelClass}.Export');
}
?>

<div class=\"row\">
    <div class=\"top-menu pull-left col-md-4\" style=\"padding-right: 0;\">
        <div class=\"btn-toolbar\">
            <?php 
            if (isset(\$dependency)) {
                if (\${$this->class2var($this->modelClass)}Create || \${$this->class2var($this->modelClass)}Export) {
                    \$this->widget('booster.widgets.TbButtonGroup', array(
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
                                            '/{$this->class2var($this->modelClass)}/create',
                                            'dependency' => \$dependency, 
                                            'dependencyTabIndex' => \$dependencyTabIndex, 
                                            'dependencyTabDropdownIndex' => \$dependencyTabDropdownIndex, 
                                            'parentId' => \$parentId, 
                                            'parentPk' => \$parentPk, 
                                        ),
                                        'icon' => 'fa fa-plus-square',
                                        'visible' => \${$this->class2var($this->modelClass)}Create,
                                    ),
                                    array(
                                        'label' => Yii::t('app', 'Export'),
                                        'url' => '#',
                                        'icon' => 'fa fa-file-excel-o',
                                        'linkOptions' => array('class' => '{$this->class2id($this->modelClass)}-export-btn-'.\$dependencyTabDropdownIndex),
                                        'visible' => \${$this->class2var($this->modelClass)}Export,
                                    ),
                                ),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'context' => 'success',
                                'icon' => 'fa fa-plus-square',
                                'label' => Yii::t('app', 'Create'),
                                'url' => array(
                                    '/{$this->class2var($this->modelClass)}/create',
                                    'dependency' => \$dependency, 
                                    'dependencyTabIndex' => \$dependencyTabIndex, 
                                    'dependencyTabDropdownIndex' => \$dependencyTabDropdownIndex, 
                                    'parentId' => \$parentId, 
                                    'parentPk' => \$parentPk, 
                                ),
                                'htmlOptions' => array('class' => 'visible-md visible-lg first-child',),
                                'visible' => \${$this->class2var($this->modelClass)}Create,
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_BUTTON,
                                'context' => 'info',
                                'icon' => 'fa fa-file-excel-o',
                                'label' => Yii::t('app', 'Export'),
                                'url' => '#',
                                'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-export-btn-'.\$dependencyTabDropdownIndex.' visible-md visible-lg last-child'),
                                'visible' => \${$this->class2var($this->modelClass)}Export,
                            ),
                        ),
                    ));
                }
            } elseif (isset(\$relation)) {
                \$this->widget('booster.widgets.TbButtonGroup', array(
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
                                'id' => '{$this->class2id($this->modelClass)}-relation-select-btn-'.\$relationIndex,
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
                                'id' => '{$this->class2id($this->modelClass)}-relation-close-btn-'.\$relationIndex,
                            ),
                        ),
                    ),
                ));
            }
            ?>
        </div>
    </div>
    <h4 class=\"content-header\"><?php echo Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}'); ?></h4>
</div>

<?php 
\$cs = Yii::app()->clientScript;
if (isset(\$dependency)) {
    if (\${$this->class2var($this->modelClass)}Export) {
        \$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_export', \"
            $('.{$this->class2id($this->modelClass)}-export-btn-\".\$dependencyTabDropdownIndex.\"').click(function(event) {
                $.fn.yiiGridView.update('{$this->class2id($this->modelClass)}-grid-\".\$dependencyTabDropdownIndex.\"', {
                    data: $(this).serialize()+'&export=true&dependencyTabIndex=\$dependencyTabIndex&dependencyTabDropdownIndex=\$dependencyTabDropdownIndex',
                    success: function(data) {
                        if (data.status === '200') {
                            window.location.href = data.body;
                        } else {
                            bootbox.dialog({
                                title: '\".Yii::t('app', 'EXPORT ERROR').\"',
                                message: '<span class=\\\"label label-danger\\\">ERROR '+data.status+'</span> '+data.body,
                                buttons: {
                                    'close':{label:'\".Yii::t('app', 'Close').\"', className:'btn-default', },
                                }
                            });
                        }
                    },
                    error: function(XHR) {
                        bootbox.dialog({
                            title: '\".Yii::t('app', 'EXPORT ERROR').\"',
                            message: '<span class=\\\"label label-danger\\\">\".Yii::t('app', 'NETWORK ERROR').\"</span> \".Yii::t('app', 'Please refresh this page and try again shortly.').\"',
                            buttons: {
                                'close':{label:'\".Yii::t('app', 'Close').\"', className:'btn-default', },
                            }
                        });
                    }
                });
                return false;
            });
        \");
    }
}

";