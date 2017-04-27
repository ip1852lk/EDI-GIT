<?php 
/* @var $this EdiController
 * @var $model Edi
 */

$cs = Yii::app()->clientScript;
$ediAdmin = Yii::app()->user->checkAccess('Edi.*');
$ediView = Yii::app()->user->checkAccess('Edi.View');
$ediDelete = Yii::app()->user->checkAccess('Edi.Delete');
// Title
$this->title = Yii::t('app', 'Edi').' <span class="text-warning">'.$model->ED1_ID.'</span>';
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['workspaceLabel']) => array(Yii::app()->params['workspaceUrl']),
    Yii::t('app', 'Edis') => array('index'),
    $model->ED1_ID => array('view', 'id' => $model->ED1_ID),
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
        'htmlOptions' => array('id' => 'edi-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
if ($ediDelete) {
    $this->menu = array_merge($this->menu, array(
//        array(
//            'class' => 'booster.widgets.TbButton',
//            'buttonType' => TbButton::BUTTON_BUTTON,
//            'context' => 'danger',
//            'icon' => 'fa fa-trash-o fa-lg',
//            'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Delete') . '</span>',
//            'url' => '#',
//            'encodeLabel' => false,
//            'htmlOptions' => array('class' => 'edi-delete-btn navbar-btn btn-sm',),
//            'visible' => $ediDelete,
//        ),
    ));
    if (isset($dependency))
        $deleteUrl = array(
            'id' => $model->ED1_ID,
            'dependency' => $dependency,
            'dependencyTabIndex' => $dependencyTabIndex,
            'dependencyTabDropdownIndex' => $dependencyTabDropdownIndex,
            'parentPk' => $parentPk,
            'parentId' => $parentId,
        );
    else
        $deleteUrl = array('id' => $model->ED1_ID);
    $cs->registerCoreScript('yii');
    $cs->registerScript(__CLASS__ . 'edi_delete', '
        $(".edi-delete-btn").click(function(){
            bootbox.dialog({
                title: "' . Yii::t('app', 'Delete Record?') . '",
                message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                buttons: {
                    delete:{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){
                        $.yii.submitForm($(".edi-delete-btn")[0], "' . $this->createUrl('delete', $deleteUrl) . '", {YII_CSRF_TOKEN:"' . Yii::app()->request->csrfToken . '"});
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
$logList = 'window.getDependencyGrid(
    "'.$this->createUrl('/log/dependency', array(
        'dependency' => '/edi/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'ED1_ID',
        'parentId' => $model->ED1_ID,
    )).'",
    "edi-table-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';
$tableLogList = 'window.getDependencyGrid(
    "'.$this->createUrl('/tableLog/dependency', array(
        'dependency' => '/edi/update',
        'dependencyTabIndex' => 1,
        'dependencyTabDropdownIndex' => 0,
        'parentPk' => 'Edi',
        'parentId' => $model->ED1_ID,
    )).'",
    "edi-table-change-log-tab",
    "'.Yii::t('app', 'Loading...').'",
    "'.Yii::t('app', 'Server Error').'",
    "'.Yii::t('app', 'Please refresh this page and try again shortly.').'"
);';

// Tab UIs
if ($this->isMobile) {
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'edi_form_tab_menu'),
        'tabs' => array(
            array(
                'active' => isset($tabIndex) && $tabIndex==0 ? true : false,
                'id' => 'edi-form-tab',
                'label' => Yii::t('app', 'Edi'),
                'content' => $this->renderPartial('//edi/_form', array(
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
                        'id' => 'edi-table-log-tab',
                        'label' => Yii::t('app', 'Logs'),
                        'icon' => 'fa fa-history',//TODO Put a new icon here
                        'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                        'linkOptions' => array('id' => 'edi-log-tab-btn'),
                    ),
                )
            ),
        ),
    ));
} else { ?>
    <div id="edi-form-content" class="row">
        <div class="col-sm-12 col-md-5">
            <?php
            $this->renderPartial('//edi/_form', array(
                'model' => $model,
                'dependency' => (isset($dependency)?$dependency:null),
                'dependencyTabIndex' => (isset($dependencyTabIndex)?$dependencyTabIndex:null),
                'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex)?$dependencyTabDropdownIndex:null),
                'parentPk' => (isset($parentPk)?$parentPk:null),
                'parentId' => (isset($parentId)?$parentId:null),
            ));
            ?>
            <br>
        </div>
        <div id="edi-dependency-content" class="col-sm-12 col-md-7">
            <?php
            $this->widget('booster.widgets.TbTabs', array(
                'type' => 'tabs',
                'tabMenuHtmlOptions' => array('id' => 'edi_form_tab_menu', 'class' => 'dependency-dropdown'),
                'tabs' => array(
                    array(
                        'active' => isset($tabIndex) && $tabIndex==1 ? true : false,
                        'label' => Yii::t('app', 'Dependency Lists'),
                        'items' => array(
                            array(
                                'active' => isset($tabIndex) && $tabIndex==2 && isset($tabDropdownIndex) && $tabDropdownIndex==1 ? true : false,
                                'id' => 'edi-table-change-log-tab',
                                'label' => Yii::t('app', 'Change Logs'),
                                'icon' => 'fa fa-history',
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'edi-table-change-log-tab-btn'),
                            ),
                            array(
                                'active' => isset($tabIndex) && $tabIndex==1 && isset($tabDropdownIndex) && $tabDropdownIndex==0 ? true : false,
                                'id' => 'edi-table-log-tab',
                                'label' => Yii::t('app', 'Logs'),
                                'icon' => 'fa fa-history',//TODO Put a new icon here
                                'content' => '<i class="fa fa-spin fa-spinner"></i> '.Yii::t('app', 'Loading...'),
                                'linkOptions' => array('id' => 'edi-log-tab-btn'),
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
if ($tabIndex ==2 && $tabDropdownIndex == 1)
    $cs->registerScript(__CLASS__ . 'edi_table_log_control', $tableLogList);
if ($tabIndex == 1 && $tabDropdownIndex == 0)
    $cs->registerScript(__CLASS__ . 'edi_table_log_control', $logList);
// Tab Events
$cs->registerScript(__CLASS__ . 'edi_dependency_control', '
    $("#edi-table-change-log-tab-btn").click(function(){'.$tableLogList.'});
    $("#edi-log-tab-btn").click(function(){alert("log tab clicked")});
    $("#edi-log-tab-btn").click(function(){'.$logList.'});
');

// Save Control
$cs->registerScript(__CLASS__ . 'edi_form_save', '
    $("#edi-update-save-btn").click(function(){
        $("#edi-form-save-btn").trigger("click")
    });
');

