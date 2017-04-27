<?php 
/* @var $this RackController
 * @var $model Rack
 * @var $plant Plant
 * @var $customer Customer
 * @var $form TbActiveForm
 */

$rackAdmin = Yii::app()->user->checkAccess('Rack.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Rack') : $model->ship_to_name,
    'headerIcon' => 'fa fa-inbox fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'rack-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => !isset($dependency) ? 'js:function(form, data, hasError) { 
            if (!hasError) { 
                bootbox.dialog({
                    title: \'' . Yii::t('app', 'Saving...') . '\',
                    message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\',
                });
                return true;
            }
        }' : 'js:function(form, data, hasError) {return true;}',
    ),
));
    if (!$model->isNewRecord && $rackAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $plant));
    echo $form->textFieldGroup($model, 'ship_to_id', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
    ));
    echo $form->textFieldGroup($model, 'ship_to_name', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
    ));
    echo $form->textFieldGroup($model, 'ra1_po_number', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
    ));
    echo $form->hiddenField($model, 'pl1_id');
    echo $form->textFieldGroup($plant, 'pl1_name', array(
        'labelOptions' => array('label' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']), 'readonly' => true)
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="plant-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="plant-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($customer, 'cu1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Customer'), 'required' => false, 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('disabled' => true)
        ),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'rack-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'rack_relation', '
    // Relations in Rack: Plant
    $("#rack-form").on("click", "#plant-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/plant/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "plant-relation-select-btn-1",
            "plant-relation-close-btn-1",
            function() {
                var rows = $("#plant-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#Rack_pl1_id").val(value[1]);
                        if (value[0] == "pl1_name")
                            $("#Plant_pl1_name").val(value[1]);
                        if (value[0] == "cu1_name")
                            $("#Customer_cu1_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a '.strtoupper(Yii::t('app', Yii::app()->params['plantDisplayLabel1'])).' in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#plant-clear-btn").click(function() {
        $("#Rack_pl1_id").val("");
        $("#Plant_pl1_name").val("");
        $("#Customer_cu1_name").val("");
        return false;
    });
');

?><!-- rack-form -->
