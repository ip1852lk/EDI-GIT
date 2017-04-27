<?php
/* @var $this SupplierController
 * @var $model Supplier
 * @var $form TbActiveForm
 */

$supplierAdmin = Yii::app()->user->checkAccess('Supplier.*');
?>
<div class="supplier-search-container" style="display:none">
    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'warning',
        'title' => Yii::t('app', 'Advanced Search'),
        'headerIcon' => 'fa fa-filter fa-lg',
    ));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'showErrors' => false,
        'showRequiredSymbol' => false,
        'htmlOptions' => array('class' => 'supplier-search-form'),
    ));
        echo $form->textFieldGroup($model, 'su1_code', array(
            'maxlength' => 10,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_name', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_phone', array(
            'maxlength' => 25,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_fax', array(
            'maxlength' => 25,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_address1', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-6 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_address2', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-6 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_city', array(
            'maxlength' => 50,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->dropDownListGroup($model, 'st1_id', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => State::getListData(null, true)),
        ));
        echo $form->textFieldGroup($model, 'su1_postal_code', array(
            'maxlength' => 25,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'su1_country', array(
            'maxlength' => 50,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        if ($supplierAdmin) {
            echo $form->textFieldGroup($model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'Supplier_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'htmlOptions' => array('id' => 'Supplier_mprofile_search_2'),
                ),
                'prepend' => '<i class="fa fa-user"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo $form->datePickerGroup($model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'Supplier_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language),
                    'htmlOptions' => array('id' => 'Supplier_modified_on_2'),
                ),
                'prepend' => '<i class="fa fa-calendar"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
        }
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-search',
                'label' => Yii::t('app', 'Search'),
                'htmlOptions' => array('class' => 'btn-sm'),
            ));
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_BUTTON,
                'context' => 'default',
                'icon' => 'fa fa-times',
                'label' => Yii::t('app', 'Close'),
                'htmlOptions' => array('class' => 'supplier-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
</div><!-- supplier-search-form -->
