<?php 
/* @var $this EdiController
 * @var $model Edi
 * @var $form TbActiveForm
 */

$ediAdmin = Yii::app()->user->checkAccess('Edi.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Edi') : $model->ED1_DOCUMENT_NO,
    'headerIcon' => 'fa fa-exchange fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'edi-form',
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
    echo $form->errorSummary(array($model));
    echo $form->textFieldGroup($model, 'ED1_DOCUMENT_NO', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'prepend' => '<i class="fa fa-sticky-note-o"></i>',
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 20, 'disabled' => true)),
    ));

    echo $form->select2Group($model,'ED1_STATUS',array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'prepend' => '<i class="fa fa-bar-chart"></i>',
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array(
            'asDropDownList' => false,
            'disabled' => true,
            'options' => array(
                'escapeMarkup' => 'js: function(m) {
                       return m;
                   }',
                'language' => Yii::app()->language,
                'width' => '100%',
                'multiple' => false,
                'minimumInputLength' => 0,
                'data' => $model->getStatusDropDownListLabel(),
                ),
            ),
        )
    );
    echo $form->textFieldGroup($model, 'ED1_TYPE', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'prepend' => '<i class="fa fa-gear"></i>',
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 45, 'disabled' => true)),
    ));
    echo $form->dropDownListGroup(
        $model,
        'ED1_IN_OUT',
        array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
            'widgetOptions' => array(
                'data' => Edi::itemAlias('EDI_IN_OUT_STATUS'),
                'htmlOptions' => array('disabled' => true,),
            ),
            'prepend' => '<i class="fa fa-exchange"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        )
    );
    echo $form->textFieldGroup($model, 'ED1_FILENAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'disabled' => true)),
        'prepend' => '<i class="fa fa-file-o"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));



    echo $form->select2Group(
        $model,'cu1_search',
        array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'prepend' => '<i class="fa fa-user"></i>',
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
            'widgetOptions' => array(
                'data' => CHtml::listData(Customer_EDI::model()->findAll(array('order' => 'CORP_ADDRESS_ID')), 'CU1_ID', 'CORP_ADDRESS_ID'),

                'asDropDownList' => true,
                'htmlOptions' => array(
                    'class'=>'col-row-centered ',
                    'multiple' => false,
                    'style'=> '',
                    'disabled' => true,
                ),
                'options' => array(
                    //'placeholder' => 'type clever, or is, or just type!',
                    //'width' => '30%',
                    'tokenSeparators' => array(',', ' ')
                ),
            ),
        )
    );

    echo $form->select2Group(
        $model,'VD1_ID',
        array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'prepend' => '<i class="fa fa-building"></i>',
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
            'widgetOptions' => array(
                'data' => CHtml::listData(Vendor::model()->findAll(array('order' => 'VD1_NAME')), 'VD1_ID', 'VD1_NAME'),
                'asDropDownList' => true,
                'htmlOptions' => array(
                    'class'=>'col-row-centered',
                    'multiple' => false,
                    'style'=> '',
                    'disabled' => true,
                ),
                'options' => array(
                    //'placeholder' => 'type clever, or is, or just type!',
                    //'width' => '30%',
                    'tokenSeparators' => array(',', ' ')
                )
            )
        ));

    echo $form->select2Group(
        $model,'vd1_search',
        array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'prepend' => '<i class="fa fa-user"></i>',
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
            'widgetOptions' => array(
                'data' => CHtml::listData(Vendor::model()->findAll(array('order' => 'VENDOR_ID')), 'VD1_ID', 'VENDOR_ID'),
                'asDropDownList' => true,
                'htmlOptions' => array(
                    'class'=>'col-row-centered',
                    'multiple' => false,
                    'style'=> '',
                    'disabled' => true,
                ),
                'options' => array(
                    //'placeholder' => 'type clever, or is, or just type!',
                    //'width' => '30%',
                    'tokenSeparators' => array(',', ' ')
                )
            )
        )
    );

    //This code find the columns in the database that are not included in our Yii data structure and dynamically creates them
//    $columnsNotInYii = $model->getColumnsNotInYii();
//    if(isset($columnsNotInYii) && count($columnsNotInYii)>0){
//        echo "<hr>";
//
//        foreach($columnsNotInYii as $column){
//
//            if(strpos($column->dbType, 'datetime') !== false){
//
//                echo $form->textFieldGroup($model, $column->name, array(
//                    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//                    'prepend' => '<i class="fa fa-gear"></i>',
//                    'options' => array(
//                        'format' => 'yyyy-mm-dd hh:ii:ss',
//                    ),
//                    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//                    'widgetOptions' => array('htmlOptions' => array('disabled' => true)),
//                    'hint'=>"Note: this is a dynamically generated column"
//                ));
//            }
//            elseif(strpos($column->dbType, 'date') !== false){
//                echo $form->datePickerGroup(
//                    $model,
//                    $column->name,
//                    array(
//                        'widgetOptions' => array(
//                            'options' => array(
//                                'language' => 'en',
//                                'format' => 'yyyy-mm-dd',
//                                'disabled' => true,
//                            ),
//                        ),
//                        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//                        'hint'=>"Note: this is a dynamically generated column",
//                        'prepend' => '<i class="fa fa-calendar"></i>',
//                        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
//                    )
//                );
//
//            }else{
//                echo $form->textFieldGroup($model, $column->name, array(
//                    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//                    'prepend' => '<i class="fa fa-gear"></i>',
//                    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//                    'widgetOptions' => array('htmlOptions' => array('disabled' => true)),
//                    'hint'=>"Note: this is a dynamically generated column"
//                ));
//            }
//        }
//    }
    $this->widget(
        'booster.widgets.TbTabs',
        array(
            'type' => 'tabs',
            'justified' => true,
            'tabs' => array(
                array('label' => 'Additional',
                    'content' => $this->renderPartial("_additional_tab", array('model' => $model, 'form' => $form), true),
                    'active' => true,
                ),
            ),
        )
    );

    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'edi-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//$cs = Yii::app()->clientScript;
//$cs->registerScript(__CLASS__ . 'edi_relation', '
//    // Relations in Edi: Customer
//    $("#edi-form").on("click", "#customer-select-btn", function() {
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
//                            $("#Edi_cu1_id").val(value[1]);
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
//        $("#Edi_cu1_id").val("");
//        $("#Customer_cu1_name").val("");
//        return false;
//    });
//');

?><!-- edi-form -->
