<?php 
/* @var $this Customer2Controller
 * @var $model Customer2
 * @var $customer Customer
 * @var $location Location
 * @var $region Region
 * @var $company Company
 * @var $contracts array
 */

$cs = Yii::app()->clientScript;
$customer2Admin = Yii::app()->user->checkAccess('Customer2.*');
$customer2View = Yii::app()->user->checkAccess('Customer2.View');
$customer2Delete = Yii::app()->user->checkAccess('Customer2.Delete');
// Title
$this->title = Yii::t('app', 'Sub-Customer').' <span class="text-warning">'.$model->corp_address_id.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Sub-Customers') => array('index'),
    $model->corp_address_id => array('view', 'id' => $model->id),
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
        'htmlOptions' => array('id' => 'customer2-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($customer2Delete) {
    $this->menu = array_merge($this->menu, array(
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
                message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                buttons: {
                    delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                        $.yii.submitForm($(".customer2-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {YII_CSRF_TOKEN:"' . Yii::app()->request->csrfToken . '"});
                    }},
                    cancel:{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default",},
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
$masterDataList = 'window.getDependencyGrid(
    "'.$this->createUrl('/masterData/dependency', array(
        'dependency' => '/customer2/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'cu2_id',
        'parentId' => $model->id,
    )).'",
    "customer2-master-data-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
$tableLogList = 'window.getDependencyGrid(
    "'.$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/customer2/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 1,
        'parentPk' => 'Customer2',
        'parentId' => $model->id,
    )).'",
    "customer2-table-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'customer2_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex==0 ? true : false,
                'id' => 'customer2-form-tab',
                'label' => Yii::t('app', 'Customer2'),
                'content' => $this->renderPartial('//customer2/_form', array(
                    'model' => $model,
                    'customer' => $customer,
                    'location' => $location,
                    'region' => $region,
                    'company' => $company,
                    'contracts' => $contracts,
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
                        'id' => 'customer2-master-data-tab',
                        'label' => Yii::t('app', 'Master Data'),
                        'icon' => 'fa fa-gift',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer2-master-data-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                        'id' => 'customer2-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'customer2-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="customer2-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//customer2/_form', array(
                'model' => $model,
                'customer' => $customer,
                'location' => $location,
                'region' => $region,
                'company' => $company,
                'contracts' => $contracts,
                'dependency' => (isset($dependency)?$dependency:null),
                'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
                'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
                'parentPk' => (isset($parentPk)?$parentPk:null),
                'parentId' => (isset($parentId)?$parentId:null),
            ));
            ?>
            <br>
        </div>
        <div id="customer2-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'customer2_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                                'id' => 'customer2-master-data-tab',
                                'label' => Yii::t('app', 'Master Data'),
                                'icon' => 'fa fa-gift',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer2-master-data-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                                'id' => 'customer2-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'customer2-table-log-tab-btn'),
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
    $cs->registerScript(__CLASS__ . 'customer2_master_data_control', $masterDataList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'customer2_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'customer2_dependency_control', '
    $("#customer2-master-data-tab-btn").click(function(){'.$masterDataList.'});
    $("#customer2-table-log-tab-btn").click(function(){'.$tableLogList.'});
');
// Save Control
$cs->registerScript(__CLASS__ . 'customer2_form_save', '
    $("#customer2-update-save-btn").click(function(){
        $("#customer2-form-save-btn").trigger("click")
    });
');

