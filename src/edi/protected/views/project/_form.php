<?php 
/* @var $this ProjectController
 * @var $model Project
 * @var $form TbActiveForm
 */

$projectAdmin = Yii::app()->user->checkAccess('Project.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Project') : $model->PR1_NAME,
    'headerIcon' => 'fa fa-folder fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'project-form',
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
    if (!$model->isNewRecord && $projectAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model));
//    echo $form->textFieldGroup($model, 'PR1_ID', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
//    ));
    echo $form->textFieldGroup($model, 'PR1_NAME', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
    ));
//    echo $form->textFieldGroup($model, 'RE1_INVOICE_TYPE', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
//    echo $form->textFieldGroup($model, 'RE1_INVOICE_BILLED', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));

    echo $form->radioButtonListGroup(
        $model,
        'RE1_INVOICE_TYPE',
        array(
//            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
            'widgetOptions' => array(
                'data' => array(
                    'Not to be invoiced',
                    'By time and effort',
                    'Contract',
                )
            )
        )
    );
    echo $form->checkboxGroup(
        $model,
        'RE1_INVOICE_BILLED',
        array(
            //            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
           // 'label'=>'Invoice Billed',
            //'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
           // 'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
            'widgetOptions' => array(

            ),
            //'inline' =>true,
        )
    );
    echo $form->checkboxGroup(
        $model,
        'pr1_import_from_teamwork_desk',
        array(
            //            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
           // 'label'=>'Invoice Billed',
            //'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
           // 'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
            'widgetOptions' => array(

            ),
            //'inline' =>true,
        )
    );
    echo $form->textFieldGroup($model, 'pr1_teamwork_id', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
        'hint'=>'You can find this by going to your Teamwork Project and checking the URL for the six digit number that appears directly after "projects/"',
    ));
    echo $form->textFieldGroup($model, 'pr1_teamwork_desk_name', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
        'hint'=>'This is the name in TeamWork Desk (not Project). Ensure that it is exactly the same as what appears in Desk.',
    ));
//    echo $form->textFieldGroup($model, 'PR1_APP_NAME', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
//    ));
//    echo $form->textFieldGroup($model, 'PR1_DELETE_FLAG', array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'project-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//$cs = Yii::app()->clientScript;
//$cs->registerScript(__CLASS__ . 'project_relation', '
//    // Relations in Project: Customer
//    $("#project-form").on("click", "#customer-select-btn", function() {
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
//                            $("#Project_cu1_id").val(value[1]);
//                        if (value[0] == "cu1_name") 
//                            $("#Customer_cu1_name").val(value[1]);
//                    });
//                });
//                window.relationBootbox.modal("hide");
//            },
//            "'.Yii::t('app', 'Please select a Customer in the list.').'",
//            "'.Yii::t('app', 'Loading...').'", 
//            "'.Yii::t('app', 'Server Error').'", 
//            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
//        );
//        return false;
//    });
//    $("#customer-clear-btn").click(function() {
//        $("#Project_cu1_id").val("");
//        $("#Customer_cu1_name").val("");
//        return false;
//    });
//');

?><!-- project-form -->
