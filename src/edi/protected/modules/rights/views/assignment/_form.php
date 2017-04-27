<?php
$form = $this->beginWidget('TbActiveForm', array(
    'id' => 'assignment-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
));
    echo $form->dropDownListGroup($model, 'itemname', array(
        'labelOptions' => array('class' => 'col-md-2'),
        'wrapperHtmlOptions' => array('class' => 'col-md-4'),
        'widgetOptions' => array('data' => $itemnameSelectOptions),
    ));
    ?>
    <div class="form-actions btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => Rights::t('core', 'Assign'),
    ));
    ?>
    </div>
<?php $this->endWidget(); ?><!-- assignment-form -->