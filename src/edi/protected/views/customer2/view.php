<?php
/* @var $this Customer2Controller
 * @var $model Customer2
 */

$cs = Yii::app()->clientScript;
$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
$customer2Create = Yii::app()->user->checkAccess('Customer2.Create');
$customer2Update = Yii::app()->user->checkAccess('Customer2.Update');
$customer2Delete = Yii::app()->user->checkAccess('Customer2.Delete');
// Title
$this->title = Yii::t('app', 'Sub-Customers').' <span class="text-warning">'.$model->corp_address_id.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Sub-Customers') => array('index'),
    $model->corp_address_id,
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
if ($customer2Update || $customer2Delete) {
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
            'visible' => $customer2Create,
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
            'visible' => $customer2Update,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'customer2-delete-btn navbar-btn btn-sm',),
            'visible' => $customer2Delete,
        ),
    ));
    if ($customer2Delete) {
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
        $cs->registerScript(__CLASS__ . 'customer2_delete', '
            $(".customer2-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this Customer2?') . '",
                    buttons: {
                        delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".customer2-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
    'title' => $model->corp_address_id,
    'headerIcon' => 'fa fa-users fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'corp_address_id',
        'customer_name',
        array(
            'name' => 'cu2_type',
            'value' => Customer2::itemAlias("customerTypes", $model->cu2_type),
        ),
        'cu2_consignment_location_id',
        array(
            'name' => 'cu1_search',
            'value' => ($model->customer == null ? '' : $model->customer->cu1_name),
        ),
        array(
            'name' => 'lo1_search',
            'value' => ($model->location == null ? '' : $model->location->lo1_name),
        ),
        array(
            'name' => 'rg1_search',
            'value' => ($model->location == null && $model->location->region == null ? '' : $model->location->region->rg1_name),
        ),
        array(
            'name' => 'co1_search',
            'value' => ($model->location == null && $model->location->region == null && $model->location->region->company == null ? '' : $model->location->region->company->co1_name),
        ),
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null ? '' : $model->cprofile->fullname),
            'visible' => $customer2Admin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $customer2Admin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null ? '' : $model->mprofile->fullname),
            'visible' => $customer2Admin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $customer2Admin,
        ),
    ),
));
$this->endWidget();

