
<?php

echo $form->checkboxGroup(
    $model,
    'VD1_SEND_EDI_PO',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'send_EDI_PO_Button',
                'inline' => true,
            ),
            'inline' => true,
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'VD1_ITEM_USAGE_FORMAT',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'item_Usage_Format_Button'
            )
        )
    )
);
echo $form->checkboxGroup(
    $model,
    'VD1_SEND_EDI_PO_CHANGE',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                //'id' => 'send_EDI_PO_Button'
            )
        )
    )
);
echo $form->checkboxGroup(
    $model,
    'VD1_CHECK_P21_EDI_FLAG',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                //'id' => 'send_EDI_PO_Button'
            )
        )
    )
);
echo $form->checkboxGroup($model,
    'VD1_PAYMENT_ADVICE_FORMAT',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'send_Payment_Advice_Button'
            )
        )
    )
);

echo $form->radioButtonListGroup(
    $model,
    'VD1_PAYMENT_ADVICE_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'class' => 'send_Payment_Advice_Button_Toggle'
            ),
            'data' => Vendor::itemAlias('PAYMENT_ADVICE_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->radioButtonListGroup(
    $model,
    'VD1_PO_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'class' => 'EDI_PO_Button_Toggle'
            ),
            'data' => Vendor::itemAlias('PO_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->radioButtonListGroup(
    $model,
    'VD1_ITEM_USAGE_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'class' => 'item_Usage_Format_Button_Toggle',
            ),
            'data' => Vendor::itemAlias('ITEM_USAGE_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->textFieldGroup($model, 'VD1_ITEM_USAGE_SOURCE', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array(
        'htmlOptions' => array(
            'maxlength' => 255,
            'class' => 'item_Usage_Format_Button_Toggle',
            )
        ),
    )
);

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'VD1_SEND_FTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'EDI_PO_Button_Toggle',
                'id' => 'send_FTP_Button',
            )
        )
    )
);

    echo $form->checkboxGroup(
        $model,
        'VD1_SEND_SFTP',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class' => 'EDI_PO_Button_Toggle',
                    'id' => 'send_SFTP_Button',
                )
            )
        )
    );

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_DIRECTORY_SEND', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_DIRECTORY_PICKUP', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_USERNAME', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'send_FTP_SFTP_Toggle')),
));

echo '<hr>';

echo $form->checkboxGroup(
    $model,
        'VD1_POST_HTTP',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class' => 'EDI_PO_Button_Toggle',
                    'id' => 'post_HTTP_Button'
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
                    'class' => 'EDI_PO_Button_Toggle',
                    'id' => 'post_AS2_Button',
                )
            )
        )
    );


echo $form->checkboxGroup(
    $model,
    'VD1_AS2_REQUEST_RECEIPT',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'post_AS2_Button_Toggle')),
    )
);

echo $form->checkboxGroup(
    $model,
    'VD1_AS2_SIGN_MESSAGES',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'post_AS2_Button_Toggle')),
    )
);

echo $form->textFieldGroup($model, 'VD1_REMOTE_HTTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'post_HTTP_Button_Toggle post_AS2_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_AS2_KEY_LENGTH', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'post_AS2_Button_Toggle')),
));

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'VD1_PICKUP_FTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'class' => 'EDI_PO_Button_Toggle',
                'id' => 'pickup_FTP_Button',
            )
        )
    )
);


echo $form->textFieldGroup($model, 'VD1_FTP_DIRECTORY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_FTP_USER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'VD1_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'pickup_FTP_Button_Toggle')),
));

$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . '_send_tab', '

$("hr").css({"border-color": "lightgrey"});

EDI_PO_Button_Click();
item_Usage_Format_Button_Click();
send_Payment_Advice_Button_Click();
send_FTP_SFTP_Click();
post_HTTP_Button_Click();
post_AS2_Button_Click();
pickup_FTP_Button_Click();

$("#send_EDI_PO_Button").click(EDI_PO_Button_Click);

$("#item_Usage_Format_Button").click(item_Usage_Format_Button_Click);

$("#send_Payment_Advice_Button").click(send_Payment_Advice_Button_Click);

$("#send_FTP_Button, #send_SFTP_Button").click(send_FTP_SFTP_Click);

$("#post_HTTP_Button").click(post_HTTP_Button_Click);

$("#post_AS2_Button").click(post_AS2_Button_Click);

$("#pickup_FTP_Button").click(pickup_FTP_Button_Click);

function EDI_PO_Button_Click() {
    if($("#send_EDI_PO_Button").is(\':checked\')) {
        $(".EDI_PO_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".EDI_PO_Button_Toggle").prop(\'disabled\', true);
    }
}

function item_Usage_Format_Button_Click() {
    if($("#item_Usage_Format_Button").is(\':checked\')) {
        $(".item_Usage_Format_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".item_Usage_Format_Button_Toggle").prop(\'disabled\', true);
    }
}

function send_Payment_Advice_Button_Click() {
    if($("#send_Payment_Advice_Button").is(\':checked\')) {
        $(".send_Payment_Advice_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_Payment_Advice_Button_Toggle").prop(\'disabled\', true);
    }
}

function send_FTP_SFTP_Click(){
    if($("#send_FTP_Button").is(\':checked\') || $("#send_SFTP_Button").is(\':checked\')) {
        $(".send_FTP_SFTP_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_FTP_SFTP_Toggle").prop(\'disabled\', true);
    }
}

function post_HTTP_Button_Click(){
    if($("#post_HTTP_Button").is(\':checked\') || $("#post_AS2_Button").is(\':checked\')) {
        $(".post_HTTP_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".post_HTTP_Button_Toggle").prop(\'disabled\', true);
    }
}

function post_AS2_Button_Click(){
    if($("#post_AS2_Button").is(\':checked\') || $("#post_AS2_Button").is(\':checked\')) {
        $(".post_AS2_Button_Toggle").prop(\'disabled\', false);
    } else {
        if($("#post_AS2_Button").is(\':unchecked\') && $("#post_HTTP_Button").is(\':checked\'))
        {
            $(".post_AS2_Button_Toggle").prop(\'disabled\', true);
            $(".post_HTTP_Button_Toggle").prop(\'disabled\', false);
        }
        else{
            $(".post_AS2_Button_Toggle").prop(\'disabled\', true);
        }
    }
}

function pickup_FTP_Button_Click(){
    if($("#pickup_FTP_Button").is(\':checked\')) {
        $(".pickup_FTP_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".pickup_FTP_Button_Toggle").prop(\'disabled\', true);
    }
}

');
//$("#Vendor_VD1_PAYMENT_ADVICE_FORMAT").attr('disabled', true);
//send_Payment_Advice_Button