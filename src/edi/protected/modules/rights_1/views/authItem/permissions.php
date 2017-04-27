<?php
// Title
$this->title = Yii::t('app', 'Permissions');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Permissions'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'primary',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Generate') . '</span>',
        'url' => array('authItem/generate'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
?>
<div id="permissions">
    <?php
    Yii::app()->user->setFlash('info', '
        <ul>
            <li>Here you can manage the permissions assigned to each <span class="label label-warning">Role</span>.</li>
            <li>Authorization items can be managed under <span class="label label-warning">Roles</span>, <span class="label label-warning">Tasks</span>, and <span class="label label-warning">Operations</span>.</li>
            <li>Hover to see from which the permission is inherited.</li>
        </ul>
    ');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
    $this->widget('booster.widgets.TbGridView', array(
        'id' => 'permissioin-grid',
        'dataProvider' => $dataProvider,
        'ajaxUpdate' => true,
        'enablePagination' => true,
        'template' => '{summary}{items}{pager}',
        'type' => 'striped bordered condensed',
        'summaryText' => true,
        'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
        'emptyText' => Rights::t('core', 'No authorization items found.'),
        'rowCssClassExpression' => '$data["type"]===CAuthItem::TYPE_TASK ? "success" : ""',
        'columns' => $columns,
    ));
    Yii::app()->clientScript->registerScript(__CLASS__ . 'permissions_tooltip', '
        $(".inherited-item").rightsTooltip({
            title: "' . Rights::t('core', 'Source') . '"
        });
        $("#rights tbody tr").hover(function() {
            $(this).addClass("hover"); // On mouse over
        }, function() {
            $(this).removeClass("hover"); // On mouse out
        });
    ');
    ?>
</div>