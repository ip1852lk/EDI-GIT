<?php
/* @var $this CustomerController
 * @var $model Customer
 */

$cs = Yii::app()->clientScript;
$customerAdmin = Yii::app()->user->checkAccess('Customer.*');
$customerCreate = Yii::app()->user->checkAccess('Customer.Create');
$customerUpdate = Yii::app()->user->checkAccess('Customer.Update');
$customerDelete = Yii::app()->user->checkAccess('Customer.Delete');
// Title
$this->title = Yii::t('app', 'Customer')." <span class=\"text-warning\">".$model->cu1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Customers') => array('index'),
    $model->cu1_code,
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
if ($customerUpdate || $customerDelete) {
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
            'visible' => $customerCreate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_LINK,
            'context' => 'primary',
            'icon' => 'fa fa-pencil fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
            'url' => array('update', 'id' => $model->id),
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
            'visible' => $customerUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer-delete-btn navbar-btn btn-sm',),
            'visible' => $customerDelete,
        ),
    ));
    if ($customerDelete) {
        if (isset($dependency))
            $deleteUrl = array(
                'id' => $model->id,
                'dependency' => $dependency,
                'dependencyTabIndex' => $dependencyTabIndex,
                'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
                'parentPk' => $parentPk,
                'parentId' => $parentId,
            );
        else
            $deleteUrl = array('id' => $model->id);
        $cs->registerCoreScript('yii');
        $cs->registerScript(__CLASS__ . 'customer_delete', '
            $(".customer-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                    buttons: {
                        "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".customer-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                        }},
                        "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
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
    'title' => $model->cu1_code,
    'headerIcon' => 'fa fa-users fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'cu1_code',
        'cu1_name',
        array(
            'name' => 'cu1_type',
            'value' => Customer::itemAlias("customerTypes", $model->cu1_type),
        ),
        'cu1_phone',
        'cu1_fax',
        array(
            'name' => 'cu1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'cu1_logo',
            'type' => 'image',
            'value' => isset($model->cu1_logo) && strlen($model->cu1_logo) > 0 ? $model->cu1_logo : Yii::app()->params['customerDefaultLogo'],
        ),
        'cu1_address1',
        'cu1_address2',
        'cu1_city',
        array(
            'name' => 'st1_id',
            'type' => 'raw',
            'value' => isset($model->state) ? $model->state->st1_name : '',
        ),
        'cu1_postal_code',
        'cu1_country',
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $customerAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $customerAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null || $model->mprofile->first_name == null ? '' : $model->mprofile->first_name . ' ' . $model->mprofile->last_name),
            'visible' => $customerAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $customerAdmin,
        ),
    ),
));
$this->endWidget();