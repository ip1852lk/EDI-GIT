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

echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'reorder_qty', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'p21_on_hand_qty', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array(
            //'disabled' => true,
        )
    ),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'capacity', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'frequency', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'min_qty', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'max_qty', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '</div>';


echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'unit_size', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'unit_of_measure', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
));
echo '</div>';
echo '</div>';

echo '<div class="row">';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'price', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
));
echo '</div>';
echo '<div class="col-sm-6 col-md-6 col-lg-6">';
echo $form->textFieldGroup($model, 'total_value', array(
    'labelOptions' => array('class' => 'col-sm-4 col-md-4 col-lg-4'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 col-lg-8 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array(
            'disabled' => true,
            'value' => $model->capacity*$model->price/$model->unit_size,
        ),
    ),
));
echo '</div>';
echo '</div>';
