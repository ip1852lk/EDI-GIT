<?php
/* @var $this ProfileFieldController
 * @var $model ProfileField
 */

// Title
$this->title = Yii::t('app', 'Profile Fields');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['settingsLabel']) => array(Yii::app()->params['settingsUrl']),
    UserModule::t('Profile Fields'),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'success',
        'icon' => 'fa fa-plus-square fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Create') . '</span>',
        'url' => array('/user/profileField/create'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'info',
        'icon' => 'fa fa-file-excel-o fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Export') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'profile-field-export-btn navbar-btn btn-sm'),
    ),
));
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'warning',
        'icon' => 'fa fa-filter fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Advanced Search') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'profile-field-search-btn navbar-btn btn-sm'),
    ),
));
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'profile_field_search', "
    $('.profile-field-search-btn, .profile-field-search-close-btn').click(function(event) {
        event.preventDefault();
        if ($('.profile-field-search-container').is(':visible')) {
            $('html, body').animate({ scrollTop: 0 }, 100);
            $('.profile-field-search-container').slideUp('slow');
        } else {
            $('.profile-field-search-container').slideDown('slow');
        }
    });
    $('.profile-field-search-form').submit(function(){
        $('#profile-field-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
    $('.profile-field-export-btn').click(function(event) {
        $.fn.yiiGridView.update('profile-field-grid', {
            data: $(this).serialize()+'&export=true',
            success: function(data) {
                if (data.status === '200') {
                    window.location.href = data.body;
                } else {
                    bootbox.dialog({
                        title: '".Yii::t('app', 'EXPORT ERROR')."',
                        message: '<span class=\"label label-danger\">ERROR '+data.status+'</span> '+data.body,
                        buttons: {
                            'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                        }
                    });
                }
            },
            error: function(XHR) {
                bootbox.dialog({
                    title: '".Yii::t('app', 'EXPORT ERROR')."',
                    message: '<span class=\"label label-danger\">".Yii::t('app', 'NETWORK ERROR')."</span> ".Yii::t('app', 'Please refresh this page and try again shortly.')."',
                    buttons: {
                        'close':{label:'".Yii::t('app', 'Close')."', className:'btn-default', },
                    }
                });
            }
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model,));
// Notes
Yii::app()->user->setFlash('info', Yii::t('app', '<span class="label label-danger">IMPORTANT</span> If you don\'t know what the profile fields are, please do <strong><span class="text-error">NOT</span></strong> change any of them. Otherwise, this system might not work.'));
$this->widget('booster.widgets.TbAlert', array(
    'alerts' => array(
        'info' => array('fade' => true, 'closeText' => false,),
    ),
));
?>
<p></p>
<div class="profile-field-grid-status-msg">
    <?php
    if (Yii::app()->user->hasFlash('success')) 
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'success' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    elseif (Yii::app()->user->hasFlash('error')) 
        $this->widget('booster.widgets.TbAlert', array(
            'alerts' => array(
                'error' => array('fade' => true, 'closeText' => '×'), 
            ),
        ));
    ?>
</div>
<?php
// UIs
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'profile-field-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'ajaxUpdate' => false,
    'enablePagination' => true,
    'template' => '{items}{pager}',
    'type' => 'striped bordered condensed',
    'summaryText' => true,
    'summaryText' => Yii::t('app', 'Displaying {start}-{end} of {count} results.'),
    'columns' => array(
        array(
            'name' => 'varname',
            'type' => 'raw',
            'value' => 'TbHtml::link(UHtml::markSearch($data, "varname"), array("/user/profileField/update", "id" => $data->id))',
        ),
        array(
            'name' => 'title',
            'value' => 'UserModule::t($data->title)',
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'name' => 'field_type',
            'value' => '$data->field_type',
            'filter' => ProfileField::itemAlias("field_type"),
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
        ),
        array(
            'name' => 'field_size',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
        ),
        //'field_size_min',
        array(
            'name' => 'required',
            'value' => 'ProfileField::itemAlias("required", $data->required)',
            'filter' => ProfileField::itemAlias("required"),
        ),
        //'match',
        //'range',
        //'error_message',
        //'other_validator',
        //'default',
        array(
            'name' => 'position',
            'htmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'filterHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
            'headerHtmlOptions' => array('class' => 'hidden-xs hidden-sm'),
        ),
        array(
            'name' => 'visible',
            'value' => 'ProfileField::itemAlias("visible", $data->visible)',
            'filter' => ProfileField::itemAlias("visible"),
            'htmlOptions' => array('class' => 'hidden-xs'),
            'filterHtmlOptions' => array('class' => 'hidden-xs'),
            'headerHtmlOptions' => array('class' => 'hidden-xs'),
        ),
        array(
            'header' => TbHtml::dropDownList(
                'pageSize', 
                Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']), 
                Yii::app()->params['pageSizeSet'], 
                array(
                    'onchange' => "$.fn.yiiGridView.update('profile-field-grid', {data:{pageSize:$(this).val()}})",
                )
            ),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{delete}', //'{view} {update} {delete}',
            'htmlOptions' => array('style' => 'width: 75px; text-align: center;'),
            'buttons' => array(
                'view' => array(
                    'icon' => 'fa fa-lg fa-eye',
                    'url' => 'array("/user/profileField/view", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'View')),
                ),
                'update' => array(
                    'icon' => 'fa fa-lg fa-pencil',
                    'url' => 'array("/user/profileField/update", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Update')),
                ),
                'delete' => array(
                    'icon' => 'fa fa-lg fa-trash-o',
                    'url' => 'array("/user/profileField/delete", "id" => $data->id)',
                    'options' => array('title' => Yii::t('app', 'Delete')),
                    'click' => 'function(){ 
                        var th = this;
                        var afterDelete = function(link,success,data){ $(".profile-field-grid-status-msg").html(data); };
                        bootbox.dialog({
                            title: "' . Yii::t('app', 'Delete Record?') . '",
                            message: "' . Yii::t('app', 'Are you sure you want to delete this record?') . '",
                            buttons: {
                                "delete":{label:"' . Yii::t('app', 'Delete') . '", className:"btn-danger", callback:function(){ 
                                    $("#profile-field-grid").yiiGridView("update", {
                                        type: "POST",
                                        url: $(th).attr("href"),
                                        data: { "YII_CSRF_TOKEN":"' . Yii::app()->request->csrfToken . '" },
                                        success: function(data) {
                                            $("#profile-field-grid").yiiGridView("update");
                                            afterDelete(th, true, data);
                                        },
                                        error: function(XHR) {
                                            return afterDelete(th, false, XHR);
                                        }
                                    });
                                }},
                                "cancel":{label:"' . Yii::t('app', 'Cancel') . '", className:"btn-default", },
                            }
                        });
                        return false;
                    }',
                ),
            ),
        ),
    ),
    'pager' => array(
        'class' => 'booster.widgets.TbPager',
        'displayFirstAndLast' => true,
        'alignment' => TbPager::ALIGNMENT_CENTER,
        'maxButtonCount' => Yii::app()->params['pagerMaxButtonCount'],
        'prevPageLabel' => '&lt;',
        'nextPageLabel' => '&gt;',
        'firstPageLabel' => '&lt;&lt;',
        'lastPageLabel' => '&gt;&gt;',
     ),
));
?><!-- profile-field-grid -->
