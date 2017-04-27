<?php 
/* @var $this Customer2Controller
 * @var $model Customer2
 * @var $customer Customer
 * @var $location Location
 * @var $region Region
 * @var $company Company
 * @var $jobPriceHdrs P21JobPriceHdr[]
 * @var $contracts array
 * @var $form TbActiveForm
 */

$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Sub-Customer') : $model->corp_address_id,
    'headerIcon' => 'fa fa-users fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'customer2-form',
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
    if (!$model->isNewRecord && $customer2Admin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $customer, $location));
    echo $form->dropDownListGroup($model, 'cu2_type', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('customerTypes')),
    ));
    echo $form->textFieldGroup($model, 'corp_address_id', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8'),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="p21-address-select-btn" '.($model->cu2_type==Customer2::TYPE_NON_P21?'disabled="disabled"':'').' class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="p21-address-clear-btn" '.($model->cu2_type==Customer2::TYPE_NON_P21?'disabled="disabled"':'').' class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'customer_name', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
    ));
    if (!$model->isNewRecord) {
        echo $form->dropDownListGroup($model, 'cu2_contracts', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-8 col-md-8',
            ),
            'widgetOptions' => array(
                'data' => $contracts,
                'htmlOptions' => array(
                    'multiple' => true,
                ),
            ),
        ));
    }
    echo $form->textFieldGroup($model, 'cu2_consignment_location_id', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
    ));
    echo $form->hiddenField($model, 'cu1_id');
    echo $form->textFieldGroup($customer, 'cu1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Customer'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', 'Customer'), 'readonly' => true)
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="customer-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="customer-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->hiddenField($model, 'lo1_id');
    echo $form->textFieldGroup($location, 'lo1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Location'), 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', 'Location'), 'readonly' => true)
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="location-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="location-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($region, 'rg1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Region'), 'required' => false, 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', 'Region'), 'disabled' => true)
        ),
    ));
    echo $form->textFieldGroup($company, 'co1_name', array(
        'labelOptions' => array('label' => Yii::t('app', 'Company'), 'required' => false, 'class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('placeholder' => Yii::t('app', 'Company'), 'disabled' => true)
        ),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'customer2-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'customer2_relation', '
    // Relations in Customer2: P21Address
    $("#customer2-form").on("click", "#p21-address-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/p21address/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "p21-address-relation-select-btn-1",
            "p21-address-relation-close-btn-1",
            function() {
                var rows = $("#p21-address-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "corp_address_id")
                            $("#Customer2_corp_address_id").val(value[1]);
                        if (value[0] == "customer_name")
                            $("#Customer2_customer_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a P21 Customer in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#p21-address-clear-btn").click(function() {
        $("#Customer2_corp_address_id").val("");
        $("#Customer2_customer_name").val("");
        return false;
    });
    // Relations in Customer2: Customer
    $("#customer2-form").on("click", "#customer-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/customer/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "customer-relation-select-btn-1",
            "customer-relation-close-btn-1",
            function() {
                var rows = $("#customer-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#Customer2_cu1_id").val(value[1]);
                        if (value[0] == "cu1_name")
                            $("#Customer_cu1_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Customer in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#customer-clear-btn").click(function() {
        $("#Customer2_cu1_id").val("");
        $("#Customer_cu1_name").val("");
        return false;
    });
    // Relations in Customer2: Location
    $("#customer2-form").on("click", "#location-select-btn", function() {
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
                            $("#Customer2_lo1_id").val(value[1]);
                        if (value[0] == "lo1_name")
                            $("#Location_lo1_name").val(value[1]);
                        if (value[0] == "rg1_name")
                            $("#Region_rg1_name").val(value[1]);
                        if (value[0] == "co1_name")
                            $("#Company_co1_name").val(value[1]);
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
        $("#Customer2_lo1_id").val("");
        $("#Location_lo1_name").val("");
        $("#Region_rg1_name").val("");
        $("#Company_co1_name").val("");
        return false;
    });
    // Customer Type Control
    $("#Customer2_cu2_type").change(function() {
        if ($(this).val() == '.Customer2::TYPE_P21.') {
            $("#Customer2_corp_address_id").next().children().prop("disabled", false);
            $(\'label[for="Customer2_cu2_contracts"]\').parent().show();
        } else {
            $("#Customer2_corp_address_id").next().children().prop("disabled", true);
            $(\'label[for="Customer2_cu2_contracts"]\').parent().hide();
        }
    });
    '.($model->cu2_type==Customer2::TYPE_P21?'':'$(\'label[for="Customer2_cu2_contracts"]\').parent().hide();').'
');

?><!-- customer2-form -->
