<?php
/**
 * Created by PhpStorm.
 * User: Alex Lappen
 * Date: 6/23/2016
 * Time: 11:37 AM
 */

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_EDI_INVOICES',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                "id" => 'send_EDI_Invoices_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_EDI_ORDERS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                "id" => 'send_EDI_Orders_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_EDI_ASN',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                "id" => 'send_EDI_ASN_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_INVENTORY',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                "id" => 'send_EDI_Inventory_Button',
            )
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_CREDIT_INVOICES',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_USE_CLASS_ID',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_CONSOLIDATE_ASN',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_ALWAYS_SEND_ASNS',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array()
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_CLASS_ID', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255))
));

echo '<hr>';

echo $form->radioButtonListGroup(
    $model,
    'CU1_INVOICE_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array("class" => 'send_EDI_Invoices_Button_Toggle'),
            'data' => Customer_EDI::itemAlias('CU1_INVOICE_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->radioButtonListGroup(
    $model,
    'CU1_ASN_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array('class' => 'send_EDI_ASN_Button_Toggle'),
            'data' => Customer_EDI::itemAlias('CU1_ASN_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->radioButtonListGroup(
    $model,
    'CU1_INVENTORY_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array('class' => 'send_EDI_Inventory_Button_Toggle'),
            'data' => Customer_EDI::itemAlias('CU1_INVENTORY_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->radioButtonListGroup(
    $model,
    'CU1_ORDER_FORMAT',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array('class' => 'send_EDI_Orders_Button_Toggle'),
            'data' => Customer_EDI::itemAlias('CU1_ORDER_FORMAT'),
        ),
        'inline' => true,
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_FTP',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array('id' =>'customer_send_FTP_Button', 'class' => 'main_Buttons_Toggle')
        )
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_SEND_SFTP',
    array(
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions'=>array(
            'htmlOptions'=>array('id' =>'customer_send_SFTP_Button', 'class' => 'main_Buttons_Toggle')
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'customer_send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_SEND', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'customer_send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_DIRECTORY_PICKUP', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'customer_send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_USERNAME', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'customer_send_FTP_SFTP_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_REMOTE_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255,'class' => 'customer_send_FTP_SFTP_Toggle')),
));

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'CU1_POST_HTTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'send_post_HTTP_Button',
                'class' => 'main_Buttons_Toggle',
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
                'id' => 'send_post_AS2_Button',
                'class' => 'main_Buttons_Toggle',
            )
        )
    )
);


echo $form->checkboxGroup(
    $model,
    'CU1_AS2_REQUEST_RECEIPT',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'send_post_AS2_Button_Toggle')),
    )
);

echo $form->checkboxGroup(
    $model,
    'CU1_AS2_SIGN_MESSAGES',
    array(
        'widgetOptions' => array('htmlOptions' => array('class' => 'send_post_AS2_Button_Toggle')),
    )
);

echo $form->textFieldGroup($model, 'CU1_REMOTE_HTTP_SERVER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'send_post_HTTP_Button_Toggle send_post_AS2_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_AS2_KEY_LENGTH', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'send_post_AS2_Button_Toggle')),
));

echo '<hr>';

echo $form->checkboxGroup(
    $model,
    'CU1_PICKUP_FTP',
    array(
        'widgetOptions'=>array(
            'htmlOptions'=>array(
                'id' => 'send_pickup_FTP_Button',
                'class' => 'main_Buttons_Toggle',
            )
        )
    )
);

echo $form->textFieldGroup($model, 'CU1_FTP_DIRECTORY', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'send_pickup_FTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_FTP_USER', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'send_pickup_FTP_Button_Toggle')),
));

echo $form->textFieldGroup($model, 'CU1_FTP_PASSWORD', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    'widgetOptions' => array('htmlOptions' => array('maxlength' => 255, 'class' => 'send_pickup_FTP_Button_Toggle')),
));

$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . '_receive_tab', '

//Check values when page loads
send_EDI_Invoices_Button_Click();
send_EDI_Orders_Button_Click();
send_EDI_ASN_Button_Click();
send_EDI_Inventory_Button_Click();
customer_send_FTP_SFTP_Click();
send_post_HTTP_Button_Click();
send_post_AS2_Button_Click();
send_pickup_FTP_Button_Click();

$("#send_EDI_Invoices_Button").click(send_EDI_Invoices_Button_Click);
$("#send_EDI_Orders_Button").click(send_EDI_Orders_Button_Click);
$("#send_EDI_ASN_Button").click(send_EDI_ASN_Button_Click);
$("#send_EDI_Inventory_Button").click(send_EDI_Inventory_Button_Click);
$("#customer_send_FTP_Button, #customer_send_SFTP_Button").click(customer_send_FTP_SFTP_Click);
$("#send_post_HTTP_Button").click(send_post_HTTP_Button_Click);
$("#send_post_AS2_Button").click(send_post_AS2_Button_Click);
$("#send_pickup_FTP_Button").click(send_pickup_FTP_Button_Click);

function send_EDI_Invoices_Button_Click() {
    if($("#send_EDI_Invoices_Button").is(\':checked\')) {
        $(".send_EDI_Invoices_Button_Toggle").prop(\'disabled\', false);
        $(".main_Buttons_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_EDI_Invoices_Button_Toggle").prop(\'disabled\', true);
        if($("#send_EDI_Orders_Button").is(\':unchecked\') && $("#send_EDI_ASN_Button").is(\':unchecked\') && $("#send_EDI_Inventory_Button").is(\':unchecked\')){
            $(".main_Buttons_Toggle").prop(\'disabled\', true);
        }
    }
}

function send_EDI_Orders_Button_Click() {
    if($("#send_EDI_Orders_Button").is(\':checked\')) {
        $(".send_EDI_Orders_Button_Toggle").prop(\'disabled\', false);
        $(".main_Buttons_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_EDI_Orders_Button_Toggle").prop(\'disabled\', true);
         if($("#send_EDI_Invoices_Button").is(\':unchecked\') && $("#send_EDI_ASN_Button").is(\':unchecked\') && $("#send_EDI_Inventory_Button").is(\':unchecked\')){
            $(".main_Buttons_Toggle").prop(\'disabled\', true);
         }
    }
}

function send_EDI_ASN_Button_Click() {
    if($("#send_EDI_ASN_Button").is(\':checked\')) {
        $(".send_EDI_ASN_Button_Toggle").prop(\'disabled\', false);
        $(".main_Buttons_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_EDI_ASN_Button_Toggle").prop(\'disabled\', true);
        if($("#send_EDI_Orders_Button").is(\':unchecked\') && $("#send_EDI_Invoices_Button").is(\':unchecked\') && $("#send_EDI_Inventory_Button").is(\':unchecked\')){
            $(".main_Buttons_Toggle").prop(\'disabled\', true);
        }
    }
}

function send_EDI_Inventory_Button_Click() {
    if($("#send_EDI_Inventory_Button").is(\':checked\')) {
        $(".send_EDI_Inventory_Button_Toggle").prop(\'disabled\', false);
        $(".main_Buttons_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_EDI_Inventory_Button_Toggle").prop(\'disabled\', true);
        if($("#send_EDI_Orders_Button").is(\':unchecked\') && $("#send_EDI_Invoices_Button").is(\':unchecked\') && $("#send_EDI_Invoices_Button").is(\':unchecked\')){
            $(".main_Buttons_Toggle").prop(\'disabled\', true);
        }
    }
}

function customer_send_FTP_SFTP_Click(){
    if($("#customer_send_FTP_Button").is(\':checked\') || $("#customer_send_SFTP_Button").is(\':checked\')) {
        $(".customer_send_FTP_SFTP_Toggle").prop(\'disabled\', false);
    } else {
        $(".customer_send_FTP_SFTP_Toggle").prop(\'disabled\', true);
    }
}

function send_post_HTTP_Button_Click(){
    if($("#send_post_HTTP_Button").is(\':checked\') || $("#send_post_AS2_Button").is(\':checked\')) {
        $(".send_post_HTTP_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_post_HTTP_Button_Toggle").prop(\'disabled\', true);
    }
}

function send_post_AS2_Button_Click(){
    if($("#send_post_AS2_Button").is(\':checked\') || $("#send_post_AS2_Button").is(\':checked\')) {
        $(".send_post_AS2_Button_Toggle").prop(\'disabled\', false);
    } else {
        if($("#send_post_AS2_Button").is(\':unchecked\') && $("#send_post_HTTP_Button").is(\':checked\'))
        {
            $(".send_post_AS2_Button_Toggle").prop(\'disabled\', true);
            $(".send_post_HTTP_Button_Toggle").prop(\'disabled\', false);
        }
        else{
            $(".send_post_AS2_Button_Toggle").prop(\'disabled\', true);
        }
    }
}

function send_pickup_FTP_Button_Click(){
    if($("#send_pickup_FTP_Button").is(\':checked\')) {
        $(".send_pickup_FTP_Button_Toggle").prop(\'disabled\', false);
    } else {
        $(".send_pickup_FTP_Button_Toggle").prop(\'disabled\', true);
    }
}

');
