<?php 
/* @var $this ExecutiveMgtController
 * @var $model ExecutiveMgt
 * @var $location Location
 * @var $executive Profile
 * @var $form TbActiveForm
 */

$executiveMgtAdmin = Yii::app()->user->checkAccess('ExecutiveMgt.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Executive Management') : $executive->fullname,
    'headerIcon' => 'fa fa-user fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'executive-mgt-form',
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
    if (!$model->isNewRecord && $executiveMgtAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $location, $executive));
    echo $form->hiddenField($model, 'lo1_id');
    echo $form->textFieldGroup($location, 'lo1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Location'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-7 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'placeholder' => Yii::t('app', 'Location'),
                'readonly' => true,
            ),
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="location-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="location-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->hiddenField($model, 'us1_id');
    echo $form->textFieldGroup($executive, 'first_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Executive'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-7 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value' => isset($executive) ? $executive->fullname : '',
                'placeholder' => Yii::t('app', 'Executive'),
                'readonly' => true,
            ),
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="executive-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="executive-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'em1_desc', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-7 col-md-7 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'executive-mgt-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'executive_mgt_relation', '
    // Relations in ExecutiveMgt: Location
    $("#executive-mgt-form").on("click", "#location-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/location/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "location-relation-select-btn-1",
            "location-relation-close-btn-1",
            function() {
                var rows = $("#location-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#ExecutiveMgt_lo1_id").val(value[1]);
                        if (value[0] == "lo1_name")
                            $("#Location_lo1_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Location in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#location-clear-btn").click(function() {
        $("#ExecutiveMgt_lo1_id").val("");
        $("#Location_lo1_name").val("");
        return false;
    });
    // Relations in ExecutiveMgt: Executive
    $("#executive-mgt-form").on("click", "#executive-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/user/user/relation?user_type='.User::TYPE_INTERNAL, array(
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
                            $("#ExecutiveMgt_us1_id").val(value[1]);
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
    $("#executive-clear-btn").click(function() {
        $("#ExecutiveMgt_us1_id").val("");
        $("#Profile_first_name").val("");
        return false;
    });
');



?><!-- executive-mgt-form -->
