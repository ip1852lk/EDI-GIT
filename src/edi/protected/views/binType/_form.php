<?php 
/* @var $this BinTypeController
 * @var $model BinType
 * @var $form TbActiveForm
 */

$binTypeAdmin = Yii::app()->user->checkAccess('BinType.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Bin Type') : $model->bt1_code,
    'headerIcon' => 'fa fa-sitemap fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'bin-type-form',
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
    if (!$model->isNewRecord && $binTypeAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model));
    echo $form->textFieldGroup($model, 'bt1_code', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
    ));
    echo $form->textFieldGroup($model, 'bt1_desc', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'bin-type-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//$cs = Yii::app()->clientScript;
//$cs->registerScript(__CLASS__ . 'bin_type_relation', '
//    // Relations in BinType: Customer
//    $("#bin-type-form").on("click", "#customer-select-btn", function() {
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
//                            $("#BinType_cu1_id").val(value[1]);
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
//        $("#BinType_cu1_id").val("");
//        $("#Customer_cu1_name").val("");
//        return false;
//    });
//');

?><!-- bin-type-form -->
