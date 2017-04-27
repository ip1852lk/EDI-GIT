<?php 
/* @var $this ExecutiveMgtController
 * @var $model ExecutiveMgt
 * @var $location Location
 * @var $executive Profile
 */

$cs = Yii::app()->clientScript;
$executiveMgtAdmin = Yii::app()->user->checkAccess('ExecutiveMgt.*');
$executiveMgtView = Yii::app()->user->checkAccess('ExecutiveMgt.View');
$executiveMgtDelete = Yii::app()->user->checkAccess('ExecutiveMgt.Delete');
// Title
$this->title = Yii::t('app', 'Executive Management').' <span class="text-warning">'.$executive->fullname.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Executive Management') => array('index'),
    $executive->fullname => array('view', 'id' => $model->id),
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
        'htmlOptions' => array('id' => 'executive-mgt-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($executiveMgtDelete) {
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'danger',
            'icon' => 'fa fa-trash-o fa-lg',
            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'executive-mgt-delete-btn navbar-btn btn-sm',),
            'visible' => $executiveMgtDelete,
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
    $cs->registerScript(__CLASS__ . 'executive_mgt_delete', '
        $(".executive-mgt-delete-btn").click(function(){
            bootbox.dialog({
                title: "' . Yii::t('app', 'Delete Record?') . '",
                message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                buttons: {
                    delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                        $.yii.submitForm($(".executive-mgt-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {YII_CSRF_TOKEN:"' . Yii::app()->request->csrfToken . '"});
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
$tableLogList = 'window.getDependencyGrid(
    "'.$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/executiveMgt/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'ExecutiveMgt',
        'parentId' => $model->id,
    )).'",
    "executive-mgt-table-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'executive-mgt_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex==0 ? true : false,
                'id' => 'executive-mgt-form-tab',
                'label' => Yii::t('app', 'ExecutiveMgt'),
                'content' => $this->renderPartial('//executiveMgt/_form', array(
                    'model' => $model,
                    'location' => $location,
                    'executive' => $executive,
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
                        'id' => 'executive-mgt-table-log-tab',
                        'label' => Yii::t('app', 'Change Logs'),
                        'icon' => 'fa fa-history',
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'executive-mgt-table-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="executive-mgt-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//executiveMgt/_form', array(
                'model' => $model,
                'location' => $location,
                'executive' => $executive,
                'dependency' => (isset($dependency)?$dependency:null),
                'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
                'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
                'parentPk' => (isset($parentPk)?$parentPk:null),
                'parentId' => (isset($parentId)?$parentId:null),
            ));
            ?>
            <br>
        </div>
        <div id="executive-mgt-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'executive-mgt_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                                'id' => 'executive-mgt-table-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'executive-mgt-table-log-tab-btn'),
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
    $cs->registerScript(__CLASS__ . 'executive_mgt_table_log_control', $tableLogList);
// Tab Events
$cs->registerScript(__CLASS__ . 'executive_mgt_dependency_control', '
    $("#executive-mgt-table-log-tab-btn").click(function(){'.$tableLogList.'});
');
// Save Control
$cs->registerScript(__CLASS__ . 'executive_mgt_form_save', '
    $("#executive-mgt-update-save-btn").click(function(){
        $("#executive-mgt-form-save-btn").trigger("click")
    });
');

