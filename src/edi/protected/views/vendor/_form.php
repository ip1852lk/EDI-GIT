<?php 
/* @var $this VendorController
 * @var $model Vendor
 * @var $form TbActiveForm
 */

$vendorAdmin = Yii::app()->user->checkAccess('Vendor.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Vendor') : $model->VD1_NAME,
    'headerIcon' => 'fa fa-users fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'vendor-form',
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
//        'VD1_NAME', //2
//        'VD1_TRADING_PARTNER_QUALIFIER', //3
//        'VD1_TRADING_PARTNER_ID', //4
//        'VD1_TRADING_PARTNER_GS_ID', //5
//        'VD1_RECEIVER_QUALIFIER', //6
//        'VD1_RECEIVER_ID', //7
//        'VD1_BANK_ROUTING_NUMBER', //8
//        'VD1_BANK_ACCOUNT_NUMBER', //9
//        'VD1_AS2_CERTIFICATE_FILENAME', //10
//        'VD1_AS2_RECEIVER_ID', //11
//        'VD1_AS2_TRADING_PARTNER_ID', //12
    echo $form->errorSummary(array($model));
    echo $form->textFieldGroup($model, 'VENDOR_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 10)),
        'prepend' => '<i class="fa fa-building"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_NAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        'prepend' => '<i class="fa fa-user"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_TRADING_PARTNER_QUALIFIER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        'prepend' => '<i class="fa fa-check-circle"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_TRADING_PARTNER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_TRADING_PARTNER_GS_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        'prepend' => '<i class="fa fa-circle-o"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_RECEIVER_QUALIFIER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 2)),
        'prepend' => '<i class="fa fa-check-circle"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_RECEIVER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_BANK_ROUTING_NUMBER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        'prepend' => '<i class="fa fa-balance-scale"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_BANK_ACCOUNT_NUMBER', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        'prepend' => '<i class="fa fa-credit-card"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_AS2_CERTIFICATE_FILENAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-file-o"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_AS2_RECEIVER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->textFieldGroup($model, 'VD1_AS2_TRADING_PARTNER_ID', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        'prepend' => '<i class="fa fa-tag"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));

    //This code find the columns in the database that are not included in our Yii data structure and dynamically creates them

    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'vendor-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';


    $this->widget(
        'booster.widgets.TbTabs',
        array(
            'type' => 'tabs',
            'justified' => true,
            'tabs' => array(
                array('label' => 'General',
                    'content'=>$this->renderPartial("_general_tab", array('model' => $model, 'form' => $form), true),
                    'active' => true
                ),
                array('label' => 'Send',
                    'content' => $this->renderPartial("_send_tab", array('model' => $model, 'form' => $form), true),
                ),
                array('label' => 'Receive',
                    'content' => $this->renderPartial("_receive_tab", array('model' => $model, 'form' => $form), true),
                ),
                array('label' => 'Additional',
                    'content' => $this->renderPartial("_additional_tab", array('model' => $model, 'form' => $form), true),
                ),
            ),
        )
    );
    $this->endWidget();


$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//$cs = Yii::app()->clientScript;
//$cs->registerScript(__CLASS__ . 'vendor_relation', '
//    // Relations in Vendor: Customer
//    $("#vendor-form").on("click", "#customer-select-btn", function() {
//        window.openRelationPopup(
//            "'.$this->createUrl('/customer/relation', array(
//                'parentPk' => isset($parentPk) ? $parentPk : null,
//                'parentId' => isset($parentId) ? $parentId : null,
//                'relationIndex' => 1,
//                'relationSelectableRows' => 1,
//            )).'", 
//            "customer-relation-select-btn-1", 
//            "customer-relation-close-btn-1", 
//            function() {
//                var rows = $("#customer-grid-1 tbody input[type=checkbox]:checked").map(function() {
//                    return $(this).parent().next().html();
//                }).get();
//                $.each(rows, function(i, row) {
//                    metadata = row.split("|");
//                    $.each(metadata, function(k, column) {
//                        value = column.split("==");
//                        if (value[0] == "id") 
//                            $("#Vendor_cu1_id").val(value[1]);
//                        if (value[0] == "cu1_name") 
//                            $("#Customer_cu1_name").val(value[1]);
//                    });
//                });
//                window.relationBootbox.modal("hide");
//            },
//            "'.Yii::t('app', 'Please select a CUSTOMER in the list.').'", 
//            "'.Yii::t('app', 'Loading...').'", 
//            "'.Yii::t('app', 'Server Error').'", 
//            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
//        );
//        return false;
//    });
//    $("#customer-clear-btn").click(function() {
//        $("#Vendor_cu1_id").val("");
//        $("#Customer_cu1_name").val("");
//        return false;
//    });
//');

?><!-- vendor-form -->
