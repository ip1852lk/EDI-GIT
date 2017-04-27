<?php
/* @var $this CustomerController
 * @var $model Customer
 */

$cs = Yii::app()->clientScript;
$customerAdmin = Yii::app()->user->checkAccess('Customer.*');
$customerDelete = Yii::app()->user->checkAccess('Customer.Delete');
// Title
$this->title = Yii::t('app', 'Customer')." <span class=\"text-warning\">".$model->cu1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Customers') => array('index'),
    $model->cu1_code => array('view', 'id' => $model->id),
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
        'htmlOptions' => array('id' => 'customer-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($customerDelete) {
    $this->menu = array_merge($this->menu, array(
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
// Tab Controls
$customer2List = 'window.getDependencyGrid(
    "' . $this->createUrl('/customer2/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'cu1_id',
        'parentId' => $model->id,
    )) . '",
    "customer-customer2-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$plantList = 'window.getDependencyGrid(
    "' . $this->createUrl('/plant/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 1,
        'parentPk' => 'cu1_id',
        'parentId' => $model->id,
    )) . '",
    "customer-plant-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$rackList = 'window.getDependencyGrid(
    "' . $this->createUrl('/rack/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 2,
        'parentPk' => 'cu1_id',
        'parentId' => $model->id,
    )) . '",
    "customer-rack-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$masterDataList = 'window.getDependencyGrid(
    "' . $this->createUrl('/masterData/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 2,
        'parentPk' => 'cu1_id',
        'parentId' => $model->id,
    )) . '",
    "customer-master-data-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$userList = 'window.getDependencyGrid(
    "' . $this->createUrl('/user/user/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 3,
        'parentPk' => 'cu1_id',
        'parentId' => $model->id,
    )) . '",
    "customer-user-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$tableLogList = 'window.getDependencyGrid(
    "' . $this->createUrl('/tableLog/dependency', array(
        'dependency' => '/customer/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 4,
        'parentPk' => 'Customer',
        'parentId' => $model->id,
    )) . '",
    "customer-table-log-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'customer_form_tab_menu', 'class' => 'dependency-dropdown'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex == 0 ? true : false,
                'id' => 'customer-form-tab',
                'label' => Yii::t('app', 'Customer'),
                'content' => $this->renderPartial('//customer/_form', array(
                    'model' => $model,
                    'dependency' => (isset($dependency) ? $dependency : null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                    'parentPk' => (isset($parentPk) ? $parentPk : null),
                    'parentId' => (isset($parentId) ? $parentId : null),
                ), true),
            ),
            array(
                'active' => isset($tabIndex) && $tabIndex == 1 ? true : false,
                'label' => Yii::t('app', 'Dependency Lists'),
                'items' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 0 ? true : false,
                        'id' => 'customer-customer2-tab',
                        'label' => Yii::t('app', 'Sub-Customers'),
                        'icon' => 'fa fa-users',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-customer2-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 1 ? true : false,
                        'id' => 'customer-plant-tab',
                        'label' => Yii::t('app', Yii::app()->params['plantDisplayLabel2']),
                        'icon' => 'fa fa-code-fork',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-plant-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 2 ? true : false,
                        'id' => 'customer-rack-tab',
                        'label' => Yii::t('app', 'Racks'),
                        'icon' => 'fa fa-inbox',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-rack-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 3 ? true : false,
                        'id' => 'customer-master-data-tab',
                        'label' => Yii::t('app', 'Master Data'),
                        'icon' => 'fa fa-gift',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-master-data-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 4 ? true : false,
                        'id' => 'customer-user-tab',
                        'label' => Yii::t('app', 'Users'),
                        'icon' => 'fa fa-user',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-user-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 5 ? true : false,
                        'id' => 'customer-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="customer-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//customer/_form', array(
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
        <div id="customer-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'customer_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 0 ? true : false,
                                'id' => 'customer-customer2-tab',
                                'label' => Yii::t('app', 'Sub-Customers'),
                                'icon' => 'fa fa-users',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-customer2-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 1 ? true : false,
                                'id' => 'customer-plant-tab',
                                'label' => Yii::t('app', Yii::app()->params['plantDisplayLabel2']),
                                'icon' => 'fa fa-code-fork',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-plant-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 2 ? true : false,
                                'id' => 'customer-rack-tab',
                                'label' => Yii::t('app', 'Racks'),
                                'icon' => 'fa fa-inbox',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-rack-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 3 ? true : false,
                                'id' => 'customer-master-data-tab',
                                'label' => Yii::t('app', 'Master Data'),
                                'icon' => 'fa fa-gift',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-master-data-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 4 ? true : false,
                                'id' => 'customer-user-tab',
                                'label' => Yii::t('app', 'Users'),
                                'icon' => 'fa fa-user',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-user-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 5 ? true : false,
                                'id' => 'customer-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer-table-log-tab-btn'),
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
    $cs->registerScript(__CLASS__ . 'customer_customer2_control', $customer2List);
elseif ($tabIndex == 1 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'customer_plant_control', $plantList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 2)
    $cs->registerScript(__CLASS__ . 'customer_rack_control', $rackList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 3)
    $cs->registerScript(__CLASS__ . 'customer_master_data_control', $masterDataList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 4)
    $cs->registerScript(__CLASS__ . 'customer_user_control', $userList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 5)
    $cs->registerScript(__CLASS__ . 'customer_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'customer_dependency_control', '
    $("#customer-customer2-tab-btn").click(function(){' . $customer2List . '});
    $("#customer-plant-tab-btn").click(function(){' . $plantList . '});
    $("#customer-rack-tab-btn").click(function(){' . $rackList . '});
    $("#customer-master-data-tab-btn").click(function(){' . $masterDataList . '});
    $("#customer-user-tab-btn").click(function(){' . $userList . '});
    $("#customer-table-log-tab-btn").click(function(){' . $tableLogList . '});
');
// Save Control
$cs->registerScript(__CLASS__ . 'customer_form_save', '
    $("#customer-update-save-btn").click(function(){
        $("#customer-form-save-btn").trigger("click")
    });
');