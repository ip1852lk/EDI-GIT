<?php
/* @var $this ProfileController
 * @var $model UserChangePassword
 */

$cs = Yii::app()->clientScript;
// Title
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', "Change Password");
$this->title = Yii::t('app', 'Change Password');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', "Profile") => array('view'),
    Yii::t('app', "Change Password"),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_BUTTON,
        'context' => 'primary',
        'icon' => 'fa fa-save fa-lg',
        'label' => '<span class="">' . Yii::t('app', 'Save') . '</span>',
        'url' => '#',
        'encodeLabel' => false,
        'htmlOptions' => array('id' => 'password-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Yii::app()->user->email,
    'headerIcon' => 'fa fa-user fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'password-change-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError) { 
                if (!hasError) { 
                    bootbox.dialog({
                        title: \'' . Yii::t('app', 'Updating...') . '\',
                        message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while updating your new password.') . '</p>\',
                    });
                    return true;
                }
            }',
    ),
));
    echo $form->errorSummary($model);
    echo $form->passwordFieldGroup($model, 'oldPassword', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-2 col-lg-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-5 col-lg-5'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'maxlength' => 128,
            ),
        ),
        'prepend' => '<i class="fa fa-key fa-lg"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    echo $form->passwordFieldGroup($model, 'password', array(
        'labelOptions' => array(
            'label' => Yii::t('app', 'New Password'),
            'class' => 'col-sm-2 col-md-2 col-lg-2',
        ),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-5 col-lg-5'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'maxlength' => 128,
            ),
        ),
        'prepend' => '<i class="fa fa-key fa-fw"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        'hint' => Yii::t('app', '<span class="label label-info">Hint</span> Minimal password length 4 symbols.'),
    ));
    echo $form->passwordFieldGroup($model, 'verifyPassword', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-2 col-lg-2'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-5 col-lg-5'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'maxlength' => 128,
            ),
        ),
        'prepend' => '<i class="fa fa-key fa-lg"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
    ));
    ?>
    <div class="form-actions btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-lock',
            'label' => Yii::t('app', 'Change'),
            'htmlOptions' => array('id' => 'password-form-save-btn', 'style' => 'display: none;'),
        ));
        ?>
    </div>
<?php
$this->endWidget();
$this->endWidget();
// Save Control
$cs->registerScript(__CLASS__ . 'profile_form_save', '
    $("#password-update-save-btn").click(function(){
        $("#password-form-save-btn").trigger("click")
    });
');
?><!-- password-change-form -->