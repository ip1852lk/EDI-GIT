<?php
/* @var $this SupplierController
 * @var $model Supplier
 */

$cs = Yii::app()->clientScript;
$supplierAdmin = Yii::app()->user->checkAccess('Supplier.*');
$supplierCreate = Yii::app()->user->checkAccess('Supplier.Create');
$supplierUpdate = Yii::app()->user->checkAccess('Supplier.Update');
$supplierDelete = Yii::app()->user->checkAccess('Supplier.Delete');
// Title
$this->title = Yii::t('app', 'Supplier')." <span class=\"text-warning\">".$model->su1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Suppliers') => array('index'),
    $model->su1_code,
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
if ($supplierUpdate || $supplierDelete) {
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
            'visible' => $supplierCreate,
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
            'visible' => $supplierUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'supplier-delete-btn navbar-btn btn-sm',),
            'visible' => $supplierDelete,
        ),
    ));
    if ($supplierDelete) {
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
        $cs->registerScript(__CLASS__ . 'supplier_delete', '
            $(".supplier-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                    buttons: {
                        "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".supplier-delete-btn")[0], "' . $this->createUrl('delete', array('id' => $model->id)) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
    'title' => $model->su1_code,
    'headerIcon' => 'fa fa-truck fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'su1_code',
        'su1_name',
        'su1_phone',
        'su1_fax',
        array(
            'name' => 'su1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'su1_logo',
            'type' => 'image',
            'value' => isset($model->su1_logo) && strlen($model->su1_logo) > 0 ? $model->su1_logo : Yii::app()->params['supplierDefaultLogo'],
        ),
        'su1_address1',
        'su1_address2',
        'su1_city',
        array(
            'name' => 'st1_id',
            'type' => 'raw',
            'value' => isset($model->state) ? $model->state->st1_name : '',
        ),
        'su1_postal_code',
        'su1_country',
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $supplierAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $supplierAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null || $model->mprofile->first_name == null ? '' : $model->mprofile->first_name . ' ' . $model->mprofile->last_name),
            'visible' => $supplierAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $supplierAdmin,
        ),
    ),
));
$this->endWidget();
