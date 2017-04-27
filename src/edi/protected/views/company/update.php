<?php
/* @var $this CompanyController
 * @var $model Company
 */

$cs = Yii::app()->clientScript;
$companyAdmin = Yii::app()->user->checkAccess('Company.*');
$companyDelete = Yii::app()->user->checkAccess('Company.Delete');
// Title
$this->title = Yii::t('app', 'Company')." <span class=\"text-warning\">".$model->co1_code."</span>";
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Companies') => array('index'),
    $model->co1_code => array('view', 'id' => $model->id),
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
        'htmlOptions' => array('id' => 'company-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($companyDelete) {
    $this->menu = array_merge($this->menu, array(
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
$regionList = 'window.getDependencyGrid(
    "' . $this->createUrl('/region/dependency', array(
        'dependency' => '/company/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'co1_id',
        'parentId' => $model->id,
    )) . '",
    "company-region-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$locationList = 'window.getDependencyGrid(
    "' . $this->createUrl('/location/dependency', array(
        'dependency' => '/company/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 1,
        'parentPk' => 'co1_id',
        'parentId' => $model->id,
    )) . '",
    "company-location-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$userList = 'window.getDependencyGrid(
    "' . $this->createUrl('/user/user/dependency', array(
        'dependency' => '/company/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 2,
        'parentPk' => 'co1_id',
        'parentId' => $model->id,
    )) . '",
    "company-user-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
$tableLogList = 'window.getDependencyGrid(
    "' . $this->createUrl('/tableLog/dependency', array(
        'dependency' => '/company/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 3,
        'parentPk' => 'Company',
        'parentId' => $model->id,
    )) . '",
    "company-table-log-tab",
    "' . Yii::t('app', 'Loading...') . '",
    "' . Yii::t('app', 'Server Error') . '",
    "' . Yii::t('app', 'Please refresh this page and try again shortly.') . '"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'company_form_tab_menu', 'class' => 'dependency-dropdown'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex == 0 ? true : false,
                'id' => 'company-form-tab',
                'label' => Yii::t('app', 'Company'),
                'content' => $this->renderPartial('//company/_form', array(
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
                        'active' => isset($tabIndex) && $tabIndex == 1 && isset($tabDropdownIndex) && $tabDropdownIndex == 0 ? true : false,
                        'id' => 'company-region-tab',
                        'label' => Yii::t('app', 'Regions'),
                        'icon' => 'fa fa-map-marker',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'company-region-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex == 1 && isset($tabDropdownIndex) && $tabDropdownIndex == 1 ? true : false,
                        'id' => 'company-location-tab',
                        'label' => Yii::t('app', 'Locations'),
                        'icon' => 'fa fa-thumb-tack',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'company-location-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex == 1 && isset($tabDropdownIndex) && $tabDropdownIndex == 2 ? true : false,
                        'id' => 'company-user-tab',
                        'label' => Yii::t('app', 'Users'),
                        'icon' => 'fa fa-user',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'company-user-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex == 1 && isset($tabDropdownIndex) && $tabDropdownIndex == 3 ? true : false,
                        'id' => 'company-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'company-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="company-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//company/_form', array(
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
        <div id="company-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'company_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 0 ? true : false,
                                'id' => 'company-region-tab',
                                'label' => Yii::t('app', 'Regions'),
                                'icon' => 'fa fa-map-marker',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'company-region-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 1 ? true : false,
                                'id' => 'company-location-tab',
                                'label' => Yii::t('app', 'Locations'),
                                'icon' => 'fa fa-thumb-tack',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'company-location-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 2 ? true : false,
                                'id' => 'company-user-tab',
                                'label' => Yii::t('app', 'Users'),
                                'icon' => 'fa fa-user',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'company-user-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex ==1 && isset($tabDropdownIndex) && $tabDropdownIndex == 3 ? true : false,
                                'id' => 'company-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> ' . Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'company-table-log-tab-btn'),
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
    $cs->registerScript(__CLASS__ . 'company_region_control', $regionList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'company_location_control', $locationList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 2)
    $cs->registerScript(__CLASS__ . 'company_user_control', $userList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 3)
    $cs->registerScript(__CLASS__ . 'company_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'company_dependency_control', '
    $("#company-region-tab-btn").click(function(){' . $regionList . '});
    $("#company-location-tab-btn").click(function(){' . $locationList . '});
    $("#company-user-tab-btn").click(function(){' . $userList . '});
    $("#company-table-log-tab-btn").click(function(){' . $tableLogList . '});
');
// Save Control
$cs->registerScript(__CLASS__ . 'company_form_save', '
    $("#company-update-save-btn").click(function(){
        $("#company-form-save-btn").trigger("click")
    });
');