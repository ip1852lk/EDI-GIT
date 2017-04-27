<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Rights::t('core', Rights::getAuthItemTypeName(isset($_GET['type']) ? $_GET['type'] : $model->type))." <span class=\"text-warning\">" . CHtml::encode($model->name) . "</span>",
    'headerIcon' => Rights::getAuthItemIcon(isset($_GET['type']) ? $_GET['type'] : $model->type),
));
$form = $this->beginWidget('TbActiveForm', array(
    'id' => 'auth-item-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError) { 
                if (!hasError) { 
                    bootbox.dialog({
                        title: \'' . Yii::t('app', 'Saving...') . '\',
                        message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\',
                    });
                    return true;
                }
            }',
    ),
        ));
echo $form->errorSummary(array($model));
echo $form->textFieldGroup($model, 'name', array(
    'maxlength' => 255,
    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'hint' => Rights::t('core', '<span class="label label-info">Hint</span> Do not change the name unless you know what you are doing.'),
));
echo $form->textFieldGroup($model, 'description', array(
    'maxlength' => 255,
    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'hint' => Rights::t('core', '<span class="label label-info">Hint</span> A descriptive name for this item.'),
));
if (Rights::module()->enableBizRule === true)
    echo $form->textFieldGroup($model, 'bizRule', array(
        'maxlength' => 255,
        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'hint' => Rights::t('core', '<span class="label label-info">Hint</span> Code that will be executed when performing access checking.'),
    ));
if (Rights::module()->enableBizRule === true && Rights::module()->enableBizRuleData)
    echo $form->textFieldGroup($model, 'data', array(
        'class' => 'input-large', 
        'maxlength' => 255,
        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'hint' => Rights::t('core', '<span class="label label-info">Hint</span> Additional data available when executing the business rule.'),
    ));
?>
<div class="form-actions btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => (!isset($model->name) ? Rights::t('core', 'Create') : Rights::t('core', 'Save')),
        'htmlOptions' => array('id' => 'auth-item-form-save-btn', 'style' => 'display: none;'),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?><!-- auth-item-form -->