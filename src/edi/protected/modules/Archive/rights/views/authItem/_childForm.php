<?php
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('cookie');
$cs->registerScriptFile($this->assetsBase . '/js/scroller.js');
$cs->registerScript(__CLASS__ . '_authItem_child_getLastScrollerPosistion', "
    if ($.cookie('scrollLeft')) {
        $(document).scrollLeft($.cookie('scrollLeft'));
        $.cookie('scrollLeft', null);
    }
    if ($.cookie('scrollTop')) {
        $(document).scrollTop($.cookie('scrollTop'));
        $.cookie('scrollTop', null);
    }
");
$cs->registerScript(__CLASS__ . '_authItem_child_setCurrentScrollerPosition', "
    $('#auth-item-child-form-add-btn').click(setCurrentScrollerPosition);
");
$form = $this->beginWidget('TbActiveForm', array(
    'id' => 'child-item-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
));
echo $form->dropDownListGroup($model, 'itemname', array(
    'labelOptions' => array('class' => 'col-md-2'),
    'widgetOptions' => array('data' => $itemnameSelectOptions),
    'wrapperHtmlOptions' => array('class' => 'col-md-10'),
));
?>

<div class="form-actions btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-plus-square',
        'label' => Rights::t('core', 'Add'),
        'htmlOptions' => array('id' => 'auth-item-child-form-add-btn'),
    ));
    ?>
</div>
<?php
$this->endWidget();
?><!-- child-item-form -->