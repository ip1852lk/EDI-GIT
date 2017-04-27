<?php
/* @var $this Customer_EDIController
 * @var $model Customer_EDI
 */

$cs = Yii::app()->clientScript;
$customer_EDIAdmin = Yii::app()->user->checkAccess('Customer_EDI.*');
$customer_EDICreate = Yii::app()->user->checkAccess('Customer_EDI.Create');
$customer_EDIUpdate = Yii::app()->user->checkAccess('Customer_EDI.Update');
$customer_EDIDelete = Yii::app()->user->checkAccess('Customer_EDI.Delete');
// Title
$this->title = Yii::t('app', 'Customer  Edis').' <span class="text-warning">'.$model->CU1_ID.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Customer  Edis') => array('index'),
    $model->CU1_ID,
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'warning',
            'icon' => 'fa fa-lg fa-angle-double-left',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Back') . '</span>',
            'url' => array(
                $dependency,
                'id' => (int)$parentId,
                'tabIndex' => isset($dependencyTabIndex)?$dependencyTabIndex:1,
                'tabDropdownIndex' => isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:0,
            ),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
        ),
    ));
}
if ($customer_EDIUpdate || $customer_EDIDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'success',
            'icon' => 'fa fa-plus-square fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
            'url' => array('create'),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $customer_EDICreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => $model->CU1_ID),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $customer_EDIUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer--edi-delete-btn navbar-btn btn-sm',),
            'visible' => $customer_EDIDelete,
        ),
    ));
    if ($customer_EDIDelete) {
        if (isset($dependency))
            $deleteUrl = array(
                'id' => $model->CU1_ID,
                'dependency' => $dependency,
                'dependencyTabIndex' => $dependencyTabIndex,
                'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
                'parentPk' => $parentPk,
                'parentId' => $parentId,
            );
        else
            $deleteUrl = array('id' => $model->CU1_ID);
        $cs->registerCoreScript('yii');
        $cs->registerScript(__CLASS__ . 'customer__edi_delete', '
            $(".customer--edi-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this Customer_EDI?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".customer--edi-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                        }},
                        cancel:{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
                    }
                });
                return false;
            });
        ');
    }
}
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->CU1_ID,
    'headerIcon' => 'fa fa-users fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'CORP_ADDRESS_ID',
        'CU1_NAME',
        'CU1_CREATED_BY',
        'CU1_CREATED_ON',
        'CU1_MODIFIED_BY',
        'CU1_MODIFIED_ON',
        'CU1_SHOW_DEFAULT',
        'CU1_RECEIVE_EDI',
        'CU1_SEND_EDI_INVOICES',
        'CU1_SEND_EDI_ASN',
        'CU1_SEND_EDI_ORDERS',
        'CU1_SEND_EDI_ORDER_CONFIRMATIONS',
        'CU1_SEND_ACKNOWLEDGEMENT',
        'CU1_ORDER_TYPE',
        'CU1_ORDER_FORMAT',
        'CU1_INVOICE_FORMAT',
        'CU1_ASN_FORMAT',
        'CU1_TXT_APPROVED',
        'CU1_SEND_FTP',
        'CU1_SEND_SFTP',
        'CU1_POST_HTTP',
        'CU1_RECEIVE_FTP',
        'CU1_PICKUP_FTP',
        'CU1_RECEIVE_HTTP',
        'CU1_PICKUP_SFTP',
        'CU1_REMOTE_FTP_SERVER',
        'CU1_REMOTE_FTP_USERNAME',
        'CU1_REMOTE_FTP_PASSWORD',
        'CU1_REMOTE_FTP_DIRECTORY_SEND',
        'CU1_REMOTE_FTP_DIRECTORY_PICKUP',
        'CU1_FTP_USER',
        'CU1_FTP_PASSWORD',
        'CU1_FTP_DIRECTORY',
        'CU1_REMOTE_HTTP_SERVER',
        'CU1_SUPPLIER_CODE',
        'CU1_RECEIVER_QUALIFIER',
        'CU1_RECEIVER_ID',
        'CU1_FACILITY',
        'CU1_TRADING_PARTNER_QUALIFIER',
        'CU1_TRADING_PARTNER_ID',
        'CU1_ASN_TRADING_PARTNER_ID',
        'CU1_CONSOLIDATE_ASN',
        'CU1_FLAG',
        'CU1_X12_STANDARD',
        'CU1_EDI_VERSION',
        'CU1_DUNS',
        'CU1_SHARED_SECRET',
        'CU1_REJECT_INVALID_ITEM_ORDERS',
        'CU1_INVALID_ITEM_SUBSTITUTE',
        'CU1_USE_CONTRACT',
        'CU1_SEND_CUSTOMERS_AND_ITEMS',
        'CU1_STOP_IMPORT_WITH_ERRORS',
        'CU1_USE_CLASS_ID',
        'CU1_CLASS_ID',
        'CU1_MAP',
        'CU1_ORDER_PRICE_OVERRIDE',
        'CU1_SEND_CREDIT_INVOICES',
        'CU1_852_IMPORT_FOLDER',
        'CU1_ALWAYS_SEND_ORDER_CONFIRMATIONS',
        'CU1_COMPLETE_SHIP_TO_NAME',
        'CU1_ALWAYS_SEND_ASNS',
        'CU1_IMPORT_FREIGHT_CODES',
        'CU1_POST_AS2',
        'CU1_RECEIVE_AS2',
        'CU1_CXML_PAYLOAD_ID',
        'CU1_AS2_CERTIFICATE_FILENAME',
        'CU1_AS2_RECEIVER_ID',
        'CU1_AS2_TRADING_PARTNER_ID',
        'CU1_CUSTOMER_SENDS_P21_SHIP_TO_ID',
        'CU1_USE_P21_SHIP_TO_DATA',
        'CU1_ALLOW_DUPLICATE_PO_NUMBERS',

        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $customer_EDIAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $customer_EDIAdmin,
        ),
    ),
));
$this->endWidget();

