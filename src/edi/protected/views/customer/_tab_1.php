<?php
/* @var $this CustomerController
 * @var $model Customer
 * @var $form TbActiveForm
 */

echo $form->textFieldGroup($model, 'cu1_phone', array(
    'maxlength' => 25,
    'prepend' => '<i class="fa fa-phone"></i>',
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6'),
));
echo $form->textFieldGroup($model, 'cu1_fax', array(
    'maxlength' => 25,
    'prepend' => '<i class="fa fa-fax"></i>',
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6'),
));
echo $form->textFieldGroup($model, 'cu1_url', array(
    'maxlength' => 250,
    'prepend' => '<i class="fa fa-link"></i>',
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8'),
));
echo $form->fileFieldGroup($model, 'cu1_logo', array(
    'maxlength' => 250,
    'maxFileSize' => 2000000,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
    'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i', 'style' => 'margin-bottom: 10px;',
));
echo $form->textFieldGroup($model, 'cu1_address1', array(
    'maxlength' => 250,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
));
echo $form->textFieldGroup($model, 'cu1_address2', array(
    'maxlength' => 250,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-8 col-md-8 input-group-sm'),
));
echo $form->textFieldGroup($model, 'cu1_city', array(
    'maxlength' => 50,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
));
echo $form->dropDownListGroup($model, 'st1_id', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('data' => State::getListData(null, true)),
));
echo $form->textFieldGroup($model, 'cu1_postal_code', array(
    'maxlength' => 25,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
));
echo $form->textFieldGroup($model, 'cu1_country', array(
    'maxlength' => 50,
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
));
