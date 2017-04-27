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

$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Master Data') : $model->contract_bin_id,
    'headerIcon' => 'fa fa-gift fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'master-data-form',
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
    if (!$model->isNewRecord && $masterDataAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary(array($model, $company, $customer2, $rack));
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($model, 'contract_bin_id', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
    ));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($model, 'customer_bin_id', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
    ));
    echo '</div>';
    echo '</div>';
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($model, 'item_id', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
    ));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($model, 'customer_part_no', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
    ));
    echo '</div>';
    echo '</div>';

    echo $form->textFieldGroup($model, 'item_desc', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-2 col-lg-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-10 col-md-10 col-lg-10 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
    ));
    echo $form->textFieldGroup($model, 'extended_desc', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-2 col-lg-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-10 col-md-10 col-lg-10 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
    ));

    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->dropDownListGroup($model, 'bt1_id', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array('data' => BinType::getListData(null, true)),
        'prepend' => '<i class="fa fa-sitemap fa-fw"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($model, 'preferred_location_id', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    ));
    echo '</div>';
    echo '</div>';

    echo $form->hiddenField($model, 'pf1_id');
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($productFamily, 'pf1_family', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('disabled' => true)
        ),
        'prepend' => '<i class="fa fa-tags fa-fw"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $form->textFieldGroup($productFamily, 'pf1_commodity', array(
        'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
        'widgetOptions' => array(
            'htmlOptions' => array('readonly' => true)
        ),
        'append' =>
            '<span class="input-group-btn">'.
            '<button id="product-family-select-btn" class="btn btn-info" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Select').'"><i class="fa fa-check "></i></button> '.
            '<button id="product-family-clear-btn" class="btn btn-danger" type="button" data-toggle="tooltip" title="'.Yii::t('app', 'Clear').'"><i class="fa fa-times "></i></button> '.
            '</span>',
        'appendOptions' => array('isRaw' => true),
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo '</div>';
    echo '</div>';

    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'master-data-internal-form-tab-menu'),
        'tabs' => array(
            array(
                'active' => true,
                'id' => 'master-data-internal-form-tab-1',
                'label' => Yii::t('app', 'General Info.'),
                'content' => $this->renderPartial('//masterData/_tab_1', array(
                    'model' => $model,
                    'productFamily' => $productFamily,
                    'company' => $company,
                    'customer2' => $customer2,
                    'rack' => $rack,
                    'form' => $form,
                    'dependency' => (isset($dependency) ? $dependency : null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                    'parentPk' => (isset($parentPk) ? $parentPk : null),
                    'parentId' => (isset($parentId) ? $parentId : null),
                ), true),
            ),
            array(
                'active' => false,
                'id' => 'master-data-internal-form-tab-2',
                'label' => Yii::t('app', 'References'),
                'content' => $this->renderPartial('//masterData/_tab_2', array(
                    'model' => $model,
                    'productFamily' => $productFamily,
                    'company' => $company,
                    'customer2' => $customer2,
                    'rack' => $rack,
                    'form' => $form,
                    'dependency' => (isset($dependency) ? $dependency : null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                    'parentPk' => (isset($parentPk) ? $parentPk : null),
                    'parentId' => (isset($parentId) ? $parentId : null),
                ), true),
            ),
        ),
    ));
    echo '<div class="form-actions btn-toolbar">';
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => 'master-data-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
$this->endWidget();
$this->endWidget();

// Relations
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'master_data_relation', '
    // Relations in MasterData: ProductFamily
    $("#master-data-form").on("click", "#product-family-select-btn", function() {
        window.openRelationPopup(
            "'.$this->createUrl('/productFamily/relation', array(
                'parentPk' => isset($parentPk) ? $parentPk : null,
                'parentId' => isset($parentId) ? $parentId : null,
                'relationIndex' => 1,
                'relationSelectableRows' => 1,
            )).'",
            "product-family-relation-select-btn-1",
            "product-family-relation-close-btn-1",
            function() {
                var rows = $("#product-family-grid-1 tbody input[type=checkbox]:checked").map(function() {
                    return $(this).parent().next().html();
                }).get();
                $.each(rows, function(i, row) {
                    metadata = row.split("|");
                    $.each(metadata, function(k, column) {
                        value = column.split("==");
                        if (value[0] == "id")
                            $("#MasterData_pf1_id").val(value[1]);
                        if (value[0] == "pf1_family")
                            $("#ProductFamily_pf1_family").val(value[1]);
                        if (value[0] == "pf1_commodity")
                            $("#ProductFamily_pf1_commodity").val(value[1]);
                    });
                });
                window.relationBootbox.modal("hide");
            },
            "'.Yii::t('app', 'Please select a Family-Commodity in the list.').'",
            "'.Yii::t('app', 'Loading...').'",
            "'.Yii::t('app', 'Server Error').'",
            "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
        );
        return false;
    });
    $("#product-family-clear-btn").click(function() {
        $("#MasterData_pf1_id").val("");
        $("#ProductFamily_pf1_family").val("");
        $("#ProductFamily_pf1_commodity").val("");
        return false;
    });
');

?><!-- master-data-form -->
