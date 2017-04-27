<?php
/* @var $this CompanyController
 * @var $model Company
 */

$cs = Yii::app()->clientScript;
$companyAdmin = Yii::app()->user->checkAccess('Company.*');
$companyCreate = Yii::app()->user->checkAccess('Company.Create');
$companyUpdate = Yii::app()->user->checkAccess('Company.Update');
$companyDelete = Yii::app()->user->checkAccess('Company.Delete');
// Title
$this->title = Yii::t('app', 'Company')." <span class=\"text-warning\">".$model->co1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Companies') => array('index'),
    $model->co1_code,
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
if ($companyUpdate || $companyDelete) {
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
            'visible' => $companyCreate,
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
            'visible' => $companyUpdate,
        ),
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'company-delete-btn navbar-btn btn-sm',),
            'visible' => $companyDelete,
        ),
    ));
    if ($companyDelete) {
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
        $cs->registerScript(__CLASS__ . 'company_delete', '
            $(".company-delete-btn").click(function(){
                bootbox.dialog({
                    title: "' . Yii::t('app', 'Delete Record?') . '",
                    message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                    buttons: {
                        "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                            $.yii.submitForm($(".company-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
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
    'title' => $model->co1_code,
    'headerIcon' => 'fa fa-building fa-lg',
));
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => array(
        'co1_code',
        'co1_name',
        array(
            'name' => 'co1_type',
            'value' => Company::itemAlias("companyTypes", $model->co1_type),
        ),
        'co1_phone',
        'co1_fax',
        array(
            'name' => 'co1_url',
            'type' => 'url',
        ),
        array(
            'name' => 'co1_logo',
            'type' => 'image',
            'value' => isset($model->co1_logo) && strlen($model->co1_logo) > 0 ? $model->co1_logo : Yii::app()->params['companyDefaultLogo'],
        ),
        'co1_address1',
        'co1_address2',
        'co1_city',
        array(
            'name' => 'st1_id',
            'type' => 'raw',
            'value' => isset($model->state) ? $model->state->st1_name : '',
        ),
        'co1_postal_code',
        'co1_country',
        array(
            'name' => 'cprofile_search',
            'value' => ($model->cprofile == null || $model->cprofile->first_name == null ? '' : $model->cprofile->first_name . ' ' . $model->cprofile->last_name),
            'visible' => $companyAdmin,
        ),
        array(
            'name' => 'created_on',
            'value' => ($model->created_on == '' || $model->created_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short")),
            'visible' => $companyAdmin,
        ),
        array(
            'name' => 'mprofile_search',
            'value' => ($model->mprofile == null || $model->mprofile->first_name == null ? '' : $model->mprofile->first_name . ' ' . $model->mprofile->last_name),
            'visible' => $companyAdmin,
        ),
        array(
            'name' => 'modified_on',
            'value' => ($model->modified_on == '' || $model->modified_on == '0000-00-00 00:00:00' ? '' : Yii::app()->dateFormatter->formatDateTime($model->modified_on, "medium", "short")),
            'visible' => $companyAdmin,
        ),
    ),
));
$this->endWidget();