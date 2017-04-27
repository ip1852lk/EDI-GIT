<?php
echo $form->checkboxGroup(
    $model,
    'VD1_RECEIVE_EDI',
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
    'VD1_SEND_ACKNOWLEDGEMENT',
    array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
            )
        )
    )
);

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'VD1_PICKUP_FTP',
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
    'VD1_PICKUP_SFTP',
    array(
//        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'pickup_SFTP_Button',
                'class' => 'receive_EDI_Button_Toggle',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_DIRECTORY_SEND', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_DIRECTORY_PICKUP', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_USERNAME', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_SFTP_Button_Toggle')),
));

//Put transaction field here

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'VD1_POST_HTTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'shared_Secret_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'VD1_POST_AS2',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'post_AS2_Button_Receive_Tab',
            )
        )
    )
);


echo $form->checkboxGroup(
    $model,
    'VD1_AS2_REQUEST_RECEIPT',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'post_AS2_Button_Receive_Tab_Toggle')),
    )
);

echo $form->checkboxGroup(
    $model,
    'VD1_AS2_SIGN_MESSAGES',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'post_AS2_Button_Receive_Tab_Toggle')),
    )
);

echo $form->textFieldGroup($model, 'VD1_REMOTE_HTTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => '')),
));

echo $form->textFieldGroup($model, 'VD1_SHARED_SECRET', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'shared_Secret_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_AS2_KEY_LENGTH', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'post_AS2_Button_Receive_Tab_Toggle')),
));
echo '<hr>';
echo $form->checkboxGroup(
    $model,
    'VD1_RECEIVE_FTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'receive_EDI_Button_Toggle',
                'id' => 'receive_FTP_Button_Receive_Tab',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'VD1_FTP_DIRECTORY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Receive_Tab_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_FTP_USER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Receive_Tab_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'receive_FTP_Button_Receive_Tab_Toggle')),
));

$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . '_receive_tab', '

//Check values when page loads
receive_EDI_Button_Click();
pickup_FTP_SFTP_Click();
shared_Secret_Button_Click();
post_AS2_Button_Receive_Tab_Click();
receive_FTP_Button_Receive_Tab_Click();


$("#receive_EDI_Button").click(receive_EDI_Button_Click);

$("#pickup_FTP_Button_Receive_Tab, #pickup_SFTP_Button").click(pickup_FTP_SFTP_Click);

$("#shared_Secret_Button").click(shared_Secret_Button_Click);

$("#post_AS2_Button_Receive_Tab").click(post_AS2_Button_Receive_Tab_Click);

$("#receive_FTP_Button_Receive_Tab").click(receive_FTP_Button_Receive_Tab_Click);

function receive_EDI_Button_Click() {
    if($("#receive_EDI_Button").is(\':checked\')) {
        $(".receive_EDI_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".receive_EDI_Button_Toggle").prop(\'disabled\', true);
    }
}

function pickup_FTP_SFTP_Click(){
    if($("#pickup_SFTP_Button").is(\':checked\') || $("#pickup_FTP_Button_Receive_Tab").is(\':checked\')) {
        $(".pickup_FTP_SFTP_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".pickup_FTP_SFTP_Button_Toggle").prop(\'disabled\', true);
    }
}

function shared_Secret_Button_Click() {
    if($("#shared_Secret_Button").is(\':checked\')) {
        $(".shared_Secret_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".shared_Secret_Button_Toggle").prop(\'disabled\', true);
    }
}

function post_AS2_Button_Receive_Tab_Click() {
    if($("#post_AS2_Button_Receive_Tab").is(\':checked\')) {
        $(".post_AS2_Button_Receive_Tab_Toggle").prop(\'disabled\', false);
    } else {
        $(".post_AS2_Button_Receive_Tab_Toggle").prop(\'disabled\', true);
    }
}

function receive_FTP_Button_Receive_Tab_Click() {
    if($("#receive_FTP_Button_Receive_Tab").is(\':checked\')) {
        $(".receive_FTP_Button_Receive_Tab_Toggle").prop(\'disabled\', false);
    } else {
        $(".receive_FTP_Button_Receive_Tab_Toggle").prop(\'disabled\', true);
    }
}

');