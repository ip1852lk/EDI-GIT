<?php
// Title
$this->title = Yii::t('app', 'Tasks');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Tasks'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'primary',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
        'url' => array('authItem/create', 'type' => CAuthItem::TYPE_TASK),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
));
// Notes
Yii::app()->user->setFlash('info', '
    <ul>
        <li>A <span class="label label-warning">Task</span> is a permission to perform multiple <span class="label label-warning">Operations</span>, for example accessing a group of controller actions.</li>
        <li><span class="label label-warning">Tasks</span> exist below <span class="label label-warning">Roles</span> in the authorization hierarchy and can therefore only inherit from other <span class="label label-warning">Tasks</span> and/or <span class="label label-warning">Operations</span>.</li>
        <li><span class="text-warning">Values within square brackets tell how many children each item has.</span></li>
    </ul>
');
$this->widget('booster.widgets.TbAlert', array(
    'alerts' => array(
        'info' => array('fade' => true, 'closeText' => false,), 
    ),
));
// UIs
?>
<p></p>
<div class="task-grid-status-msg">
    <?php
    if (Yii::app()->user->hasFlash('success')) 
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'success' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    elseif (Yii::app()->user->hasFlash('error')) 
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'error' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    ?>
</div>

<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'task-grid',
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => true,
    'enablePagination' => true,
    'template' => '{summary}{items}{pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'emptyText' => Rights::t('core', 'No task found.'),
    'columns' => array(
        array(
            'name' => 'name',
            'header' => Rights::t('core', 'Name'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'name-column'),
            'value' => '$data->getGridNameLink()',
        ),
        array(
            'name' => 'description',
            'header' => Rights::t('core', 'Description'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'description-column'),
        ),
        array(
            'name' => 'bizRule',
            'header' => Rights::t('core', 'Business rule'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'bizrule-column'),
            'visible' => Rights::module()->enableBizRule === true,
        ),
        array(
            'name' => 'data',
            'header' => Rights::t('core', 'Data'),
            'type' => 'raw',
            'htmlOptions' => array('class' => 'data-column'),
            'visible' => Rights::module()->enableBizRuleData === true,
        ),
        array(
            'header' => Yii::t('app', 'Actions'),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'label' => '',
                    'url' => 'array("/rights/authItem/delete", "name" => $data->name)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".task-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    jQuery("#task-grid").yiiGridView("update", {
                                        type: "POST",
                                        url: jQuery(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            jQuery("#task-grid").yiiGridView("update");
                                            afterDelete(th, true, data);
                                        },
                                        error: function(XHR) {
                                            return afterDelete(th, false, XHR);
                                        }
                                    });
                                }},
                                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default", },
                            }
                        });
                        return false;
                    }',
                ),
            ),
        ),
    )
));
?>