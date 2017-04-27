<?php 
/* @var $this BarcodeScannerController
 * @var $model BarcodeScanner
 * @var $user Profile
 * @var $form TbActiveForm
 */

$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Barcode Scanner') : $model->itemAlias('model', $model->bs1_model),
    'headerIcon' => 'fa fa-barcode fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'barcode-scanner-form',
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
    if (!$model->isNewRecord && $barcodeScannerAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $user));
    echo $form->hiddenField($model, 'us1_id');
    echo $form->textFieldGroup($user, 'first_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'User'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value' => isset($user) ? $user->fullname : '',
                'placeholder' => Yii::t('app', 'User'),
                'readonly' => true,
            ),
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="user-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="user-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'bs1_mac_address', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
    ));
    echo $form->dropDownListGroup($model, 'bs1_model', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('modelForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_com_port', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('comPortForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_speed', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('speedForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_data_bit', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('dataBitForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_parity', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('parityForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_stop_bit', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('stopBitForSearch')),
    ));
    echo $form->dropDownListGroup($model, 'bs1_flow_control', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('flowControlForSearch')),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'barcode-scanner-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'barcode_scanner_relation', '
    // Relations in BarcodeScanner: User
    $("#barcode-scanner-form").on("click", "#user-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/user/user/relation'.($this->isCustomer?'?user_type='.User::TYPE_CUSTOMER.'&cu1_id='.Yii::app()->user->getState('cu1_id'):''), array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "user-relation-select-btn-1",
            "user-relation-close-btn-1",
            function() {
                var rows = $("#user-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#BarcodeScanner_us1_id").val(value[1]);
                        if (value[0] == "fullname")
                            $("#Profile_first_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a User in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#user-clear-btn").click(function() {
        $("#BarcodeScanner_us1_id").val("");
        $("#Profile_first_name").val("");
        return false;
    });
');

?><!-- barcode-scanner-form -->
