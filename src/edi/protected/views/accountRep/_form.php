<?php 
/* @var $this AccountRepController
 * @var $model AccountRep
 * @var $plant Plant
 * @var $representative Profile
 * @var $form TbActiveForm
 */

$accountRepAdmin = Yii::app()->user->checkAccess('AccountRep.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Account Representative') : $representative->fullname,
    'headerIcon' => 'fa fa-user fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'account-rep-form',
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
    if (!$model->isNewRecord && $accountRepAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $plant, $representative));
    echo $form->hiddenField($model, 'pl1_id');
    echo $form->textFieldGroup($plant, 'pl1_name', array(
        'labelOptions' => array('label' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-7 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'placeholder' => Yii::t('app', Yii::app()->params['plantDisplayLabel1']),
                'readonly' => true,
            ),
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="plant-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="plant-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->hiddenField($model, 'us1_id');
    echo $form->textFieldGroup($representative, 'first_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Executive'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-7 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value' => isset($representative) ? $representative->fullname : '',
                'placeholder' => Yii::t('app', 'Executive'),
                'readonly' => true,
            ),
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="representative-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="representative-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'ar1_desc', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'account-rep-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'account_rep_relation', '
    // Relations in AccountRep: Plant
    $("#account-rep-form").on("click", "#plant-select-btn", function() {
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
                            $("#AccountRep_pl1_id").val(value[1]);
                        if (value[0] == "pl1_name")
                            $("#Plant_pl1_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a '.Yii::app()->params['plantDisplayLabel1'].' in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#plant-clear-btn").click(function() {
        $("#AccountRep_pl1_id").val("");
        $("#Plant_pl1_name").val("");
        return false;
    });
    // Relations in AccountRep: Executive
    $("#account-rep-form").on("click", "#representative-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/user/user/relation?user_type='.User::TYPE_CUSTOMER, array(
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
                            $("#AccountRep_us1_id").val(value[1]);
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
    $("#representative-clear-btn").click(function() {
        $("#AccountRep_us1_id").val("");
        $("#Profile_first_name").val("");
        return false;
    });
');

?><!-- account-rep-form -->
