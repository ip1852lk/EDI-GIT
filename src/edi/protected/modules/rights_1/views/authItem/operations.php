<?php
// Title
$this->title = Yii::t('app', 'Operations');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::t('core', 'Operations'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'primary',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
        'url' => array('authItem/create', 'type' => CAuthItem::TYPE_OPERATION),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
));
// Notes
Yii::app()->user->setFlash('info', '
    <ul>
        <li>An <span class="label label-warning">Operation</span> is a permission to perform a single action, for example accessing a certain controller action.</li>
        <li><span class="label label-warning">Operations</span> exist below <span class="label label-warning">Tasks</span> in the authorization hierarchy and can therefore only inherit from other <span class="label label-warning">Operation</span>.</li>
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
<div class="auth-item-grid-status-msg">
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
    'id' => 'operation-grid',
    'dataProvider' => $dataProvider,
    'ajaxUpdate' => true,
    'enablePagination' => true,
    'template' => '{summary}{items}{pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'emptyText' => Rights::t('core', 'No operation found.'),
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
                        var afterDelete = function(link,success,data){ $(".auth-item-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    jQuery("#operation-grid").yiiGridView("update", {
                                        type: "POST",
                                        url: jQuery(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            jQuery("#operation-grid").yiiGridView("update");
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