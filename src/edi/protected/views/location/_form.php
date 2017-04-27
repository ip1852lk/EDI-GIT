<?php
/* @var $this LocationController 
 * @var $model Location
 * @var $region Region
 * @var $company Company
 * @var $representative Profile
 * @var $form TbActiveForm
 */

$locationAdmin = Yii::app()->user->checkAccess('Location.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-thumb-tack fa-lg',
    'title' => $model->isNewRecord ? Yii::t('app', 'Location') : $model->lo1_code,
));
// Form
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'location-form',
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
    if (!$model->isNewRecord && $locationAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $region));
    echo $form->textFieldGroup($model, 'lo1_code', array(
        'maxlength' => 50,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'lo1_name', array(
        'maxlength' => 250,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->hiddenField($model, 'rg1_id');
    echo $form->textFieldGroup($region, 'rg1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Region'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', 'Region'), 'readonly' => true)
        ),
        'append' => 
            '<span class="input-group-btn">'.
                '<button id="region-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
                '<button id="region-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($company, 'co1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Company'), 'required' => false, 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('disabled' => true)
        ),
    ));
    echo $form->hiddenField($model, 'us1_id');
    echo $form->textFieldGroup($representative, 'first_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Representative'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value' => $model->isNewRecord ? '' : $representative->fullname,
                'placeholder' => Yii::t('app', 'Representative'),
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
    echo '<div class="form-actions btn-toolbar">';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-save',
            'htmlOptions' => array('id' => 'location-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
        ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'location_form', '
    // Relations in Location: Region
    $("#location-form").on("click", "#region-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/region/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'", 
            "region-relation-select-btn-1",
            "region-relation-close-btn-1",
            function() {
                var rows = $("#region-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                ;}).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id") 
                            $("#Location_rg1_id").val(value[1]);
                        if (value[0] == "rg1_name")
                            $("#Region_rg1_name").val(value[1]);
                        if (value[0] == "co1_name")
                            $("#Company_co1_name").val(value[1]);
                        if (value[0] == "us1_id")
                            $("#Location_us1_id").val(value[1]);
                        if (value[0] == "us1_search")
                            $("#Profile_first_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Region in the list.').'",
            "'.Yii::t('app', 'Loading...').'", 
            "'.Yii::t('app', 'Server Error').'", 
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#region-clear-btn").click(function() {
        $("#Location_rg1_id").val("");
        $("#Region_rg1_name").val("");
        $("#Company_co1_name").val("");
        return false;
    });
    // Relations in Location: Representative
    $("#location-form").on("click", "#representative-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/user/user/relation', array(
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
                            $("#Location_us1_id").val(value[1]);
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
        $("#Location_us1_id").val("");
        $("#Profile_first_name").val("");
        return false;
    });
');
?><!-- location-form -->
