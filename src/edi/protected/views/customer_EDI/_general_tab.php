<style>
    .radioGroup{display: inline !important; width: auto !important;}
</style>

<div class = "radioGroup">
    <?php
    echo $form->radioButtonListGroup(
        $model,
        'CU1_FLAG',
        array(
            'widgetOptions' => array(
                'data' => array(
                    'P'=>'Production',
                    'T'=>'Test',
                ),
            ),
        )
    );
    ?>
</div>
<?php

echo $form->textFieldGroup($model, 'CU1_EDI_VERSION', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_X12_STANDARD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo '<hr>';
echo $form->textFieldGroup($model, 'CU1_ASN_TRADING_PARTNER_ID', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_SUPPLIER_CODE', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_FACILITY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_DUNS', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_MAP', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'CU1_852_IMPORT_FOLDER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
?>