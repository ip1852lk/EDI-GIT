<?php 
/* @var $this MasterDataController
 * @var $model MasterData
 * @var $productFamily ProductFamily
 * @var $company Company
 * @var $customer2 Customer2
 * @var $rack Rack
 */

$cs = Yii::app()->clientScript;
$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
$masterDataView = Yii::app()->user->checkAccess('MasterData.View');
$masterDataDelete = Yii::app()->user->checkAccess('MasterData.Delete');
// Title
$this->title = Yii::t('app', 'Master Data').' <span class="text-warning">'.$model->contract_bin_id.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Master Data') => array('index'),
    $model->contract_bin_id => array('view', 'id' => $model->id),
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
        'htmlOptions' => array('id' => 'master-data-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($masterDataDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'master-data-delete-btn navbar-btn btn-sm',),
            'visible' => $masterDataDelete,
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
    $cs->registerScript(__CLASS__ . 'master_data_delete', '
        $(".master-data-delete-btn").click(function(){
            bootbox.dialog({
                title: "' . Yii::t('app', 'Delete Record?') . '",
                message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                buttons: {
                    delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                        $.yii.submitForm($(".master-data-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {YII_CSRF_TOKEN:"' . Yii::app()->request->csrfToken . '"});
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
$orderLineList = 'window.getDependencyGrid(
    "'.$this->createUrl('/orderLine/dependency', array(
        'dependency' => '/masterData/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'md1_id',
        'parentId' => $model->id,
    )).'",
    "order-header-order-line-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
$tableLogList = 'window.getDependencyGrid(
    "'.$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/masterData/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 1,
        'parentPk' => 'MasterData',
        'parentId' => $model->id,
    )).'",
    "master-data-table-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'master-data_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex==0 ? true : false,
                'id' => 'master-data-form-tab',
                'label' => Yii::t('app', 'MasterData'),
                'content' => $this->renderPartial('//masterData/_form', array(
                    'model' => $model,
                    'productFamily' => $productFamily,
                    'company' => $company,
                    'customer2' => $customer2,
                    'rack' => $rack,
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
                        'id' => 'order-header-order-line-tab',
                        'label' => Yii::t('app', 'Order Lines'),
                        'icon' => 'fa fa-shopping-cart',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'order-header-order-line-tab-btn'),
                    ),
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                        'id' => 'master-data-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'master-data-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="master-data-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//masterData/_form', array(
                'model' => $model,
                'productFamily' => $productFamily,
                'company' => $company,
                'customer2' => $customer2,
                'rack' => $rack,
                'dependency' => (isset($dependency)?$dependency:null),
                'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
                'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
                'parentPk' => (isset($parentPk)?$parentPk:null),
                'parentId' => (isset($parentId)?$parentId:null),
            ));
            ?>
            <br>
        </div>
        <div id="master-data-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'master-data_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                                'id' => 'order-header-order-line-tab',
                                'label' => Yii::t('app', 'Order Lines'),
                                'icon' => 'fa fa-shopping-cart',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'order-header-order-line-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                                'id' => 'master-data-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'master-data-table-log-tab-btn'),
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
    $cs->registerScript(__CLASS__ . 'order_header_order_line_control', $orderLineList);
elseif ($tabIndex == 1 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'master_data_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'master_data_dependency_control', '
    $("#order-header-order-line-tab-btn").click(function(){'.$orderLineList.'});
    $("#master-data-table-log-tab-btn").click(function(){'.$tableLogList.'});
');
// Save Control
$cs->registerScript(__CLASS__ . 'master_data_form_save', '
    $("#master-data-update-save-btn").click(function(){
        $("#master-data-form-save-btn").trigger("click")
    });
');

