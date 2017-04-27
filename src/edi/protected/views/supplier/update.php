<?php
/* @var $this SupplierController
 * @var $model Supplier
 */

$cs = Yii::app()->clientScript;
$supplierAdmin = Yii::app()->user->checkAccess('Supplier.*');
$supplierDelete = Yii::app()->user->checkAccess('Supplier.Delete');
// Title
$this->title = Yii::t('app', 'Supplier')." <span class=\"text-warning\">".$model->su1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Suppliers') => array('index'),
    $model->su1_code => array('view', 'id' => $model->id),
    Yii::t('app', 'Update'),
);
// Menus
if (isset($dependency) && isset($parentId)) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
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
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'supplier-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($supplierDelete) {
    $this->menu = array_merge($this->menu, array(
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
                        $.yii.submitForm($(".supplier-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {"YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '"});
                    }},
                    "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
                }
            });
            return false;
        });
    ');
}
// JavaScript files for dependency and relation
$assetsScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets'));
$cs->registerScriptFile($assetsScriptUrl .'/gridview/jquery.yiigridview.js',CClientScript::POS_END);
$cs->registerScriptFile($this->assetsBase . '/js/dependency.js');
$cs->registerScriptFile($this->assetsBase . '/js/relation.js');
$cs->registerCoreScript('bbq');
$booster = Yii::app()->booster;
$booster->registerPackage('bootbox');
$booster->registerPackage('datepicker');
$booster->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
// Tab Control
$userList = 'window.getDependencyGrid(
    "'.$this->createUrl('/user/user/dependency', array(
        'dependency' => '/supplier/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'su1_id',
        'parentId' => $model->id,
    )).'",
    "supplier-user-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
$tableLogList = 'window.getDependencyGrid(
    "'.$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/supplier/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 1,
        'parentPk' => 'Supplier',
        'parentId' => $model->id,
    )).'",
    "supplier-table-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'supplier_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex==0 ? true : false,
                'id' => 'supplier-form-tab',
                'label' => Yii::t('app', 'Supplier'),
                'content' => $this->renderPartial('//supplier/_form', array(
                    'model' => $model,
                    'dependency' => (isset($dependency)?$dependency:null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
                    'parentPk' => (isset($parentPk)?$parentPk:null),
                    'parentId' => (isset($parentId)?$parentId:null),
                ), true),
            ),
            array(
                'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                'label' => Yii::t('app', 'Dependency Lists'),
                'items' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                        'id' => 'supplier-user-tab',
                        'label' => Yii::t('app', 'Users'),
                        'icon' => 'fa fa-user',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'supplier-user-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                        'id' => 'supplier-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'supplier-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="supplier-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//supplier/_form', array(
                'model' => $model,
                'dependency' => (isset($dependency) ? $dependency : null),
                'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                'parentPk' => (isset($parentPk) ? $parentPk : null),
                'parentId' => (isset($parentId) ? $parentId : null),
            ));
            ?>
            <br>
        </div>
        <div id="supplier-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'supplier_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                                'id' => 'supplier-user-tab',
                                'label' => Yii::t('app', 'Users'),
                                'icon' => 'fa fa-user',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'supplier-user-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                                'id' => 'supplier-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'supplier-table-log-tab-btn'),
                            ),
                        )
                    ),
                ),
            ));
            ?>
        </div>
    </div>
<?php
}
// Tab Initialization
if ($tabIndex == 1 && $tabDropdownIndex == 0)
    $cs->registerScript(__CLASS__ . 'supplier_user_control', $userList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'supplier_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'supplier_dependency_control', '
    $("#supplier-user-tab-btn").click(function(){'.$userList.'});
    $("#supplier-table-log-tab-btn").click(function(){'.$tableLogList.'});
');
// Save Control
$cs->registerScript(__CLASS__ . 'supplier_form_save', '
    $("#supplier-update-save-btn").click(function(){
        $("#supplier-form-save-btn").trigger("click")
    });
');
