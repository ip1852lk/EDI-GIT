
<?php
echo $form->radioButtonListGroup(
    $model,
    'VD1_FLAG',
    array(
        'widgetOptions' => array(
            'data' => array(
                'P'=>'Production',
                'T'=>'Test',
            ),
            'htmlOptions' => array(
                'class' => 'checkbox-inline',
            ),
        ),
    )
);
echo $form->textFieldGroup($model, 'VD1_EDI_VERSION', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'VD1_X12_STANDARD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'VD1_SUPPLIER_CODE', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'VD1_DUNS', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
echo $form->textFieldGroup($model, 'VD1_FACILITY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));
?>