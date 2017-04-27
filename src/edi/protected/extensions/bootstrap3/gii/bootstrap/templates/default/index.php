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

\$cs = Yii::app()->clientScript;
\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
\${$this->class2var($this->modelClass)}Create = Yii::app()->user->checkAccess('{$this->modelClass}.Create');
\${$this->class2var($this->modelClass)}Export = Yii::app()->user->checkAccess('{$this->modelClass}.Export');
// Title
\$this->title = Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}');
// Breadcrumbs
\$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}'),
);
// Menus
if (\${$this->class2var($this->modelClass)}Create || \${$this->class2var($this->modelClass)}Export) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => \${$this->class2var($this->modelClass)}Create,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'info',
            'icon' => 'fa fa-file-excel-o fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Export') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-export-btn navbar-btn btn-sm'),
            'visible' => \${$this->class2var($this->modelClass)}Export,
        ),
    ));
}
if (\${$this->class2var($this->modelClass)}Admin) {
    \$this->menu = array_merge(\$this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'warning',
            'icon' => 'fa fa-filter fa-lg',
            'label' => '<span class=\"hidden-xs hidden-sm\">' . Yii::t('app', 'Advanced Search') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => '{$this->class2id($this->modelClass)}-search-btn navbar-btn btn-sm'),
            'visible' => \${$this->class2var($this->modelClass)}Admin,
        ),
    ));
}
if (\${$this->class2var($this->modelClass)}Export) {
    \$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_export', \"
        $('.{$this->class2id($this->modelClass)}-export-btn').click(function(event) {
            $.fn.yiiGridView.update('{$this->class2id($this->modelClass)}-grid', {
                data: $(this).serialize()+'&export=true',
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
if (\${$this->class2var($this->modelClass)}Admin) {
    \$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_search', \"
        $('.{$this->class2id($this->modelClass)}-search-btn, .{$this->class2id($this->modelClass)}-search-close-btn').click(function(event) {
            if ($('.{$this->class2id($this->modelClass)}-search-container').is(':visible')) {
                $('html, body').animate({ scrollTop: 0 }, 100);
                $('.{$this->class2id($this->modelClass)}-search-container').slideUp('slow');
            } else {
                $('.{$this->class2id($this->modelClass)}-search-container').slideDown('slow');
            }
            return false;
        });
        $('.{$this->class2id($this->modelClass)}-search-form').submit(function(){
            $('#{$this->class2id($this->modelClass)}-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    \");
    \$this->renderPartial('//{$this->class2var($this->modelClass)}/_search', array(
        'model' => \$model,
    ));
}
// UIs
echo \$this->renderPartial('//{$this->class2var($this->modelClass)}/_grid', array(
    'model' => \$model,
));

";


