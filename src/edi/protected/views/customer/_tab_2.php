<?php
/* @var $this CustomerController
 * @var $model Customer
 * @var $form TbActiveForm
 */

echo '<div class="row">';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_duplicate_barcodes', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_split_up_orders', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_txt_approved', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_inventory_management', array(
    'labelOptions' => array('label' => false, 'class' => 'col-sm-10 col-md-10'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_import_external_xml_usage', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_new_contract_number', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_convert_reorder_qty_into_each', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_upto_order_mode', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_show_on_hand_qty_from_p21', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-12 col-md-6 col-lg-6">';
echo $form->checkboxGroup($model, 'cu1_multiply_reorder_qty', array(
    'labelOptions' => array('label' => false, 'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12'),
    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo $form->textFieldGroup($model, 'cu1_missing_order_emails', array(
    'maxlength' => 250,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
