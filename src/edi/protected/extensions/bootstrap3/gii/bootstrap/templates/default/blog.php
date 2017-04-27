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

\${$this->class2var($this->modelClass)}Create = Yii::app()->user->checkAccess('{$this->modelClass}.Create');
// Title
\$this->title = Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}');
// Breadcrumbs
\$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', '{$this->pluralize($this->class2name($this->modelClass))}'),
);
// Menus
\$this->menu = array(
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
);
// UIs
\$this->widget('booster.widgets.TbListView', array(
    'dataProvider' => \$dataProvider,
    'itemView' => '//{$this->class2var($this->modelClass)}/_blog',
    'template' => '{pager} {summary} {sorter} {items} {pager}',
    'emptyText' => Yii::t('app', 'There are no active items to display.'),
    'ajaxUpdate' => false,
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
        'alignment' => TbPager::ALIGNMENT_CENTER,
        'maxButtonCount' => Yii::app()->params['pagerMaxButtonCount'],
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
     ),
));

";