<?php

// Title
$this->title = Yii::t('app', 'Generate Authorization Items');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    'Rights' => Rights::getBaseUrl(),
    'Permissions' => array('authItem/permissions'),
    Rights::t('core', 'Generate'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Generate') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'generate-main-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
?>
<div id="generator">
    <?php
    Yii::app()->user->setFlash('info', 'Please select athorization items that you want to generate and then click on <span class="label label-info">Generate</span>.');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => '×'), 
        ),
    ));
    $form = $this->beginWidget('TbActiveForm', array(
        'id' => 'generate-auth-item-form',
        'method' => 'post',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
    ));
    ?>
    <div class="row">
        <div class="col-md-6">
        <?php
        echo CHtml::link(Rights::t('core', 'Select All'), '#', array(
            'onclick' => "$('.action-table').find(':checkbox').attr('checked', 'checked'); return false;",
            'class' => 'selectAllLink')) .
        ' | ' .
        CHtml::link(Rights::t('core', 'Unselect All'), '#', array(
            'onclick' => "$('.action-table').find(':checkbox').removeAttr('checked'); return false;",
            'class' => 'unselectAllLink'));
        ?>
        </div>
    </div>
    <br>
    <?php
    $this->renderPartial('_generateItems', array(
        'formTitle' => Rights::t('core', 'Application'),
        'formIcon' => 'fa fa-cloud',
        'model' => $model,
        'form' => $form,
        'items' => $items,
        'existingItems' => $existingItems,
        'basePathLength' => strlen(Yii::app()->basePath),
    ));
    ?>
    <div class="row">
        <div class="col-md-6">
        <?php
        echo CHtml::link(Rights::t('core', 'Select All'), '#', array(
            'onclick' => "$('.action-table').find(':checkbox').attr('checked', 'checked'); return false;",
            'class' => 'selectAllLink')) .
        ' | ' .
        CHtml::link(Rights::t('core', 'Unselect All'), '#', array(
            'onclick' => "$('.action-table').find(':checkbox').removeAttr('checked'); return false;",
            'class' => 'unselectAllLink'));
        ?>
        </div>
    </div>
    <br>
    <div class="form-actions btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-plus-square',
            'label' => Rights::t('core', 'Generate'),
            'htmlOptions' => array('id' => 'generate-btn', 'style' => 'display: none;'),
        ));
        ?>
    </div>
    <?php
    $this->endWidget();
    $cs = Yii::app()->clientScript;
    $cs->registerScript(__CLASS__ . 'generate_form', '
        $("#generate-main-btn").click(function(){
            $("#generate-btn").trigger("click")
        });
    ');
    ?><!-- generate-auth-item-form -->
</div>