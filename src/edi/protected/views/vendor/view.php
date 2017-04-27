<?php
/* @var $this VendorController
 * @var $model Vendor
 */

$cs = Yii::app()->clientScript;
$vendorAdmin = Yii::app()->user->checkAccess('Vendor.*');
$vendorCreate = Yii::app()->user->checkAccess('Vendor.Create');
$vendorUpdate = Yii::app()->user->checkAccess('Vendor.Update');
$vendorDelete = Yii::app()->user->checkAccess('Vendor.Delete');
// Title
$this->title = Yii::t('app', 'Vendors').' <span class="text-warning">'.$model->VD1_ID.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Vendors') => array('index'),
    $model->VD1_ID,
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
if ($vendorUpdate || $vendorDelete) {
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
            'visible' => $vendorCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => $model->VD1_ID),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $vendorUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'vendor-delete-btn navbar-btn btn-sm',),
            'visible' => $vendorDelete,
        ),
    ));
    if ($vendorDelete) {
        if (isset($dependency))
            $deleteUrl = array(
                'id' => $model->VD1_ID,
                'dependency' => $dependency,
                'dependencyTabIndex' => $dependencyTabIndex,
                'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
                'parentPk' => $parentPk,
                'parentId' => $parentId,
            );
        else
            $deleteUrl = array('id' => $model->VD1_ID);
        $cs->registerCoreScript('yii');
        $cs->registerScript(__CLASS__ . 'vendor_delete', '
            $(".vendor-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this Vendor?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".vendor-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
    'title' => $model->VD1_ID,
    'headerIcon' => 'fa fa-users fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'VENDOR_ID',
        'VD1_NAME',
        'VD1_CREATED_BY',
        'VD1_CREATED_ON',
        'VD1_MODIFIED_BY',
        'VD1_MODIFIED_ON',
        'VD1_SHOW_DEFAULT',
        'VD1_RECEIVE_EDI',
        'VD1_SEND_EDI_PO',
        'VD1_SEND_ACKNOWLEDGEMENT',
        'VD1_PO_FORMAT',
        'VD1_SEND_FTP',
        'VD1_SEND_SFTP',
        'VD1_POST_HTTP',
        'VD1_RECEIVE_FTP',
        'VD1_PICKUP_FTP',
        'VD1_PICKUP_SFTP',
        'VD1_RECEIVE_HTTP',
        'VD1_REMOTE_FTP_SERVER',
        'VD1_REMOTE_FTP_USERNAME',
        'VD1_REMOTE_FTP_PASSWORD',
        'VD1_REMOTE_FTP_DIRECTORY_SEND',
        'VD1_REMOTE_FTP_DIRECTORY_PICKUP',
        'VD1_FTP_USER',
        'VD1_FTP_PASSWORD',
        'VD1_FTP_DIRECTORY',
        'VD1_REMOTE_HTTP_SERVER',
        'VD1_SUPPLIER_CODE',
        'VD1_RECEIVER_QUALIFIER',
        'VD1_RECEIVER_ID',
        'VD1_FACILITY',
        'VD1_TRADING_PARTNER_QUALIFIER',
        'VD1_TRADING_PARTNER_ID',
        'VD1_TRADING_PARTNER_GS_ID',
        'VD1_FLAG',
        'VD1_X12_STANDARD',
        'VD1_EDI_VERSION',
        'VD1_DUNS',
        'VD1_SHARED_SECRET',
        'VD1_SEND_EDI_PO_CHANGE',
        'VD1_SEND_ITEM_USAGE',
        'VD1_ITEM_USAGE_FORMAT',
        'VD1_ITEM_USAGE_SOURCE',
        'VD1_POST_AS2',
        'VD1_RECEIVE_AS2',
        'VD1_CHECK_P21_EDI_FLAG',
        'VD1_CXML_PAYLOAD_ID',
        'VD1_SEND_EDI_PAYMENT_ADVICE',
        'VD1_PAYMENT_ADVICE_FORMAT',
        'VD1_BANK_ROUTING_NUMBER',
        'VD1_BANK_ACCOUNT_NUMBER',
        'VD1_AS2_CERTIFICATE_FILENAME',
        'VD1_AS2_RECEIVER_ID',
        'VD1_AS2_TRADING_PARTNER_ID',

        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $vendorAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $vendorAdmin,
        ),
    ),
));
$this->endWidget();

