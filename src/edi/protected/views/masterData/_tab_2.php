<?php
/**
 * @var $this MasterDataController
 * @var $model MasterData
 * @var $productFamily ProductFamily
 * @var $company Company
 * @var $customer2 Customer2
 * @var $rack Rack
 * @var $form TbActiveForm
 */

echo $form->hiddenField($model, 'co1_id');
echo $form->textFieldGroup($company, 'co1_name', array(
    'labelOptions' => array('label' => Yii::t('app', 'Company'), 'class' => 'col-sm-2 col-md-2 col-lg-2'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-10 col-md-10 col-lg-10'),
    'widgetOptions' => array(
        'htmlOptions' => array('placeholder' => Yii::t('app', 'Company'), 'readonly' => true)
    ),
    'append' =>
        '<span class="input-group-btn">'.
        '<button id="company-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
        '<button id="company-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
        '</span>',
    'appendOptions' => array('isRaw' => true),
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
));

echo $form->hiddenField($model, 'cu2_id');
echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($customer2, 'corp_address_id', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array('disabled' => true)
    ),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($customer2, 'customer_name', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array('readonly' => true)
    ),
    'append' =>
        '<span class="input-group-btn">'.
        '<button id="customer2-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
        '<button id="customer2-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
        '</span>',
    'appendOptions' => array('isRaw' => true),
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
));
echo '</div>';
echo '</div>';

echo $form->hiddenField($model, 'ra1_id');
echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($rack, 'ship_to_id', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array('disabled' => true)
    ),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($rack, 'ship_to_name', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array('readonly' => true)
    ),
    'append' =>
        '<span class="input-group-btn">'.
        '<button id="rack-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
        '<button id="rack-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
        '</span>',
    'appendOptions' => array('isRaw' => true),
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
));
echo '</div>';
echo '</div>';

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'master_data_relation_tab_2', '
    // Relations in MasterData: Company
    $("#master-data-form").on("click", "#company-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/company/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "company-relation-select-btn-1",
            "company-relation-close-btn-1",
            function() {
                var rows = $("#company-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#MasterData_co1_id").val(value[1]);
                        if (value[0] == "co1_name")
                            $("#Company_co1_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Company in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#company-clear-btn").click(function() {
        $("#MasterData_co1_id").val("");
        $("#Company_co1_name").val("");
        return false;
    });
    // Relations in MasterData: Customer2
    $("#master-data-form").on("click", "#customer2-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/customer2/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "customer2-relation-select-btn-1",
            "customer2-relation-close-btn-1",
            function() {
                var rows = $("#customer2-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#MasterData_cu2_id").val(value[1]);
                        if (value[0] == "corp_address_id")
                            $("#Customer2_corp_address_id").val(value[1]);
                        if (value[0] == "customer_name")
                            $("#Customer2_customer_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Sub-Customer in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#customer2-clear-btn").click(function() {
        $("#MasterData_cu2_id").val("");
        $("#Customer2_corp_address_id").val("");
        $("#Customer2_customer_name").val("");
        return false;
    });
    // Relations in MasterData: Rack
    $("#master-data-form").on("click", "#rack-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/rack/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "rack-relation-select-btn-1",
            "rack-relation-close-btn-1",
            function() {
                var rows = $("#rack-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#MasterData_ra1_id").val(value[1]);
                        if (value[0] == "ship_to_id")
                            $("#Rack_ship_to_id").val(value[1]);
                        if (value[0] == "ship_to_name")
                            $("#Rack_ship_to_name").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Rack in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#rack-clear-btn").click(function() {
        $("#MasterData_ra1_id").val("");
        $("#Rack_ship_to_id").val("");
        $("#Rack_ship_to_name").val("");
        return false;
    });
');


