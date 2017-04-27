<?php
echo $form->checkboxGroup(
    $model,
    'CU1_RECEIVE_EDI',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'receive_EDI_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_ACKNOWLEDGEMENT',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
            )
        )
    )
);

//echo $form->checkboxGroup(
//    $model,
//    'UPLOAD???',
//    array(
////        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
//        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
//        'widgetOptions'=>array(
//            'htmlOptions'=>array(
//                'class' => 'receive_EDI_Button_Toggle',
//            )
//        )
//    )
//);

echo $form->checkboxGroup(
    $model,
    'CU1_REJECT_INVALID_ITEM_ORDERS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_REJECT_INVALID_ITEM_ORDERS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_INVALID_ITEM_SUBSTITUTE', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => '')),
));

echo $form->checkboxGroup(
    $model,
    'CU1_USE_CONTRACT',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_STOP_IMPORT_WITH_ERRORS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_USE_P21_SHIP_TO_DATA',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_ORDER_PRICE_OVERRIDE',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_COMPLETE_SHIP_TO_NAME',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_ALLOW_DUPLICATE_PO_NUMBERS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_IMPORT_FREIGHT_CODES',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => '',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_ASN_IMPORT_FOLDER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
));

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'CU1_PICKUP_FTP',
    array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'pickup_FTP_Button_Receive_Tab',
                'class' => 'receive_EDI_Button_Toggle',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_PICKUP_SFTP',
    array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'pickup_SFTP_Button_Receive_Tab',
                'class' => 'receive_EDI_Button_Toggle',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_SEND', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_PICKUP', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_USERNAME', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle_Receive_Tab')),
));

//Put transaction field here

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'CU1_POST_HTTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'HTTP_Server_Receive_Tab_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_POST_AS2',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'AS2_Toggle_Receive_Tab_Button',
            )
        )
    )
);


echo $form->checkboxGroup(
    $model,
    'CU1_AS2_REQUEST_RECEIPT',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'receive_EDI_Button_Toggle AS2_Toggle_Receive_Tab_Button_Toggle')),
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_AS2_SIGN_MESSAGES',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'receive_EDI_Button_Toggle AS2_Toggle_Receive_Tab_Button_Toggle')),
    )
);

echo $form->textFieldGroup($model, 'CU1_REMOTE_HTTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'AS2_Toggle_Receive_Tab_Button_Toggle HTTP_Server_Receive_Tab_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_SHARED_SECRET', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'HTTP_Server_Receive_Tab_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_AS2_KEY_LENGTH', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'AS2_Toggle_Receive_Tab_Button_Toggle')),
));
echo '<hr>';
echo $form->checkboxGroup(
    $model,
    'CU1_RECEIVE_FTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'receive_FTP_Button_Customer_Receive_Tab',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_FTP_DIRECTORY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Customer_Receive_Tab_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_FTP_USER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Customer_Receive_Tab_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Customer_Receive_Tab_Toggle')),
));

$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . '_receive_tab', '

receive_EDI_Button_Click();
pickup_FTP_SFTP_Receive_Tab_Click();
HTTP_Server_Receive_Tab_Click();
AS2_Toggle_Receive_Tab_Click();
receive_FTP_Button_Customer_Receive_Tab_Click();

$("#receive_EDI_Button").click(receive_EDI_Button_Click);
$("#pickup_FTP_Button_Receive_Tab, #pickup_SFTP_Button_Receive_Tab").click(pickup_FTP_SFTP_Receive_Tab_Click);
$("#HTTP_Server_Receive_Tab_Button").click(HTTP_Server_Receive_Tab_Click);
$("#AS2_Toggle_Receive_Tab_Button").click(AS2_Toggle_Receive_Tab_Click);
$("#receive_FTP_Button_Customer_Receive_Tab").click(receive_FTP_Button_Customer_Receive_Tab_Click);

function receive_EDI_Button_Click() {
    if($("#receive_EDI_Button").is(\':checked\')) {
        $(".receive_EDI_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".receive_EDI_Button_Toggle").prop(\'disabled\', true);
    }
}

function pickup_FTP_SFTP_Receive_Tab_Click(){
    if($("#pickup_FTP_Button_Receive_Tab").is(\':checked\') || $("#pickup_SFTP_Button_Receive_Tab").is(\':checked\')) {
        $(".pickup_FTP_SFTP_Button_Toggle_Receive_Tab").prop(\'disabled\', false);
    } else {
        $(".pickup_FTP_SFTP_Button_Toggle_Receive_Tab").prop(\'disabled\', true);
    }
}

function HTTP_Server_Receive_Tab_Click() {
    if($("#HTTP_Server_Receive_Tab_Button").is(\':checked\')) {
        $(".HTTP_Server_Receive_Tab_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".HTTP_Server_Receive_Tab_Button_Toggle").prop(\'disabled\', true);
        if($("#AS2_Toggle_Receive_Tab_Button").is(\':checked\')){
            $(".AS2_Toggle_Receive_Tab_Button_Toggle").prop(\'disabled\', false);
        }
    }
}

function AS2_Toggle_Receive_Tab_Click() {
    if($("#AS2_Toggle_Receive_Tab_Button").is(\':checked\')) {
        $(".AS2_Toggle_Receive_Tab_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".AS2_Toggle_Receive_Tab_Button_Toggle").prop(\'disabled\', true);
    }
}

function receive_FTP_Button_Customer_Receive_Tab_Click() {
    if($("#receive_FTP_Button_Customer_Receive_Tab").is(\':checked\')) {
        $(".receive_FTP_Button_Customer_Receive_Tab_Toggle").prop(\'disabled\', false);
    } else {
        $(".receive_FTP_Button_Customer_Receive_Tab_Toggle").prop(\'disabled\', true);
    }
}

');