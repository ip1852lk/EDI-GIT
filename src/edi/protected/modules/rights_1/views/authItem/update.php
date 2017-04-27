<?php

// Title
$this->title = Yii::t('app', ':type', array(':type' => Rights::getAuthItemTypeName($model->type)))." <span class=\"text-warning\">" . CHtml::encode($formModel->name) . "</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    Rights::getAuthItemTypeNamePlural($model->type) => Rights::getAuthItemRoute($model->type),
    $model->name,
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'auth-item-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'danger',
        'icon' => 'fa fa-trash-o fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'auth-item-delete-btn navbar-btn btn-sm',),
    ),
));
Yii::app()->booster->registerPackage('bootbox');
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('yii');
$cs->registerScript(__CLASS__ . 'auth_item_delete_btn_control', '
    jQuery(".auth-item-delete-btn").click(function(){
        bootbox.dialog({
            title: "' . Yii::t('app', 'Delete Record?') . '",
            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
            buttons: {
                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                    $.yii.submitForm(jQuery(".auth-item-delete-btn")[0], "' . $this->createUrl('authItem/delete', array('name' => $model->name)) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                }},
                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
            }
        });
        return false;
    });
');
// AuthItemForm
$this->renderPartial('_form', array('model' => $formModel));
$cs->registerScript(__CLASS__ . 'auth_item_form_save', '
    $("#auth-item-update-save-btn").click(function(){
        $("#auth-item-form-save-btn").trigger("click")
    });
');
// Parent
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Rights::t('core', 'Parents'),
    'headerIcon' => 'fa fa-arrow-up',
));
if ($model->name !== Rights::module()->superuserName) {
    $this->widget('booster.widgets.TbGridView', array(
        'dataProvider' => $parentDataProvider,
        'template' => '{items}',
        'emptyText' => Rights::t('core', 'This item has no parent.'),
        'columns' => array(
            array(
                'name' => 'name',
                'header' => Rights::t('core', 'Name'),
                'type' => 'raw',
                'value' => '$data->getNameLink()',
            ),
            array(
                'name' => 'type',
                'header' => Rights::t('core', 'Type'),
                'type' => 'raw',
                'value' => '$data->getTypeText()',
            ),
            array(
                'header' => '&nbsp;',
                'type' => 'raw',
                'value' => '',
            ),
        )
    ));
} else {
    Yii::app()->user->setFlash('info', '
        <ul>
            <li>No parent needs to be added to <span class="label label-warning">Admins</span>.</li>
            <li><span class="label label-warning">Admins</span> are always granted all accesses implicitly.</li>
        </ul>
    ');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
}
$this->endWidget();
// Children
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Rights::t('core', 'Children'),
    'headerIcon' => 'fa fa-arrow-down',
));
if ($model->name !== Rights::module()->superuserName) {
    if ($childFormModel !== null) {
        $this->renderPartial('_childForm', array(
            'model' => $childFormModel,
            'itemnameSelectOptions' => $childSelectOptions,
        ));
    } else {
        Yii::app()->user->setFlash('warning', 'No child available to be added to this item.');
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'warning' => array('fade' => true, 'closeText' => false,), 
            ),
        ));
    }
    ?> <br/><h5><?php echo Rights::t('core', 'Assigned Children'); ?></h5> <?php
    if (Yii::app()->user->hasFlash('RightsSuccess')) {
        Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('RightsSuccess'));
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'success' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    }
    if (Yii::app()->user->hasFlash('RightsError')) {
        Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('RightsError'));
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'error' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    }
    $this->widget('booster.widgets.TbGridView', array(
        'dataProvider' => $childDataProvider,
        'template' => '{items}',
        'emptyText' => Rights::t('core', 'This item has no child.'),
        'columns' => array(
            array(
                'name' => 'name',
                'header' => Rights::t('core', 'Name'),
                'type' => 'raw',
                'value' => '$data->getNameText()',
            ),
            array(
                'name' => 'type',
                'header' => Rights::t('core', 'Type'),
                'type' => 'raw',
                'value' => '$data->getTypeText()',
            ),
            array(
                'header' => 'Actions',
                'header' => Rights::t('core', 'Actions'),
                'type' => 'raw',
                'value' => '$data->getRemoveChildLink()',
            ),
        )
    ));
} else {
    Yii::app()->user->setFlash('info', '
        <ul>
            <li>No child needs to be added to <span class="label label-warning">Admins</span>.</li>
            <li><span class="label label-warning">Admins</span> are always granted all accesses implicitly.</li>
        </ul>
    ');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
}
$this->endWidget();
?><!-- auth-item-form -->