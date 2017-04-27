<?php
/* @var $this RegistrationController
 * @var $model RegistrationForm
 */

$cs = Yii::app()->clientScript;
// Title
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Registration');
$this->title = Yii::t('app', 'Registration');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', "Login") => array('/user/login'),
    Yii::t('app', 'Registration'),
);
if (Yii::app()->user->hasFlash('registration')) {
    Yii::app()->user->setFlash('info', Yii::app()->user->getFlash('registration'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
} else {
    // Menus
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'primary',
            'icon' => 'fa fa-save fa-lg',
            'label' => '<span class="">' . Yii::t('app', 'Register') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('id' => 'registration-main-save-btn', 'class' => 'navbar-btn btn-sm',),
        ),
    ));
    // UIs
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'info',
        'title' => Yii::t('app', "Registration"),
        'headerIcon' => 'fa fa-user fa-lg',
    ));
    $form = $this->beginWidget('UActiveForm', array(
        'id' => 'registration-form',
        'method' => 'post',
        'type' => 'horizontal',
        'enableAjaxValidation' => false,
        'disableAjaxValidationAttributes' => array('RegistrationForm_verifyCode'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError) { 
                if (!hasError) { 
                    bootbox.dialog({
                        title: \'' . Yii::t('app', 'Registering...') . '\',
                        message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while registering your account.') . '</p>\',
                    });
                    return true;
                }
            }',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
        echo $form->errorSummary(array($model, $profile));
        echo $form->textFieldGroup($model, 'username', array(
            'maxlength' => 20,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
        ));
        echo $form->passwordFieldGroup($model, 'password', array(
            'maxlength' => 128, 
            'prepend' => '<i class="fa fa-key fa-lg"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4'),
            'hint' => '<span class="label label-info">'.Yii::t('app', 'Hint').'</span> '.Yii::t('app', 'Minimal password length 4 symbols.'),
        ));
        echo $form->passwordFieldGroup($model, 'verifyPassword', array(
            'maxlength' => 128, 
            'prepend' => '<i class="fa fa-key fa-lg"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4'),
        ));
        echo $form->textFieldGroup($model, 'email', array(
            'maxlength' => 255, 
            'prepend' => '<i class="fa fa-envelope fa-lg"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4'),
        ));
        $profileFields = $profile->getFields();
        if ($profileFields) {
            foreach ($profileFields as $field) {
                if (($widgetEdit = $field->widgetEdit($profile, array('labelOptions' => array('class' => 'col-sm-2 col-md-2'), 'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm')), $form)))
                    echo $widgetEdit;
                elseif ($field->range)
                    echo $form->dropDownListGroup($profile, $field->varname, array(
                        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                        'widgetOptions' => array('data' => Profile::range($field->range)),
                    ));
                elseif ($field->field_type == "TEXT")
                    echo $form->textAreaGroup($profile, $field->varname, array(
                        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                        'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-9 input-group-sm'),
                        'widgetOptions' => array('htmlOptions' => array('rows' => 6)),
                    ));
                elseif ($field->field_type == "VARCHAR")
                    if ($field->field_size >= 100)
                        echo $form->textFieldGroup($profile, $field->varname, array(
                            'maxlength' => $field->field_size,
                            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                            'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-6 input-group-sm'),
                        ));
                    else
                        echo $form->textFieldGroup($profile, $field->varname, array(
                            'maxlength' => ($field->field_size ? $field->field_size : 50),
                            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                            'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                        ));
                else
                    echo $form->textFieldGroup($profile, $field->varname, array(
                        'maxlength' => ($field->field_size ? $field->field_size : 50),
                        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                    ));
            }
        }
        if (UserModule::doCaptcha('registration')) {
            echo $form->captchaGroup($model, 'verifyCode', array(), array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                'hint' => '<span class="label label-info">'.Yii::t('app', 'Hint').'</span> '.Yii::t('app', 'Please enter the letters as they are shown in the image above. Letters are not case-sensitive.'),
            ));
        }
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-signin',
                'label' => Yii::t('app', 'Register'),
                'htmlOptions' => array('id' => 'registration-form-save-btn', 'style' => 'display: none;'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    // Save Control
    $cs->registerScript(__CLASS__ . 'profile_form_save', '
        $("#registration-main-save-btn").click(function(){
            $("#registration-form-save-btn").trigger("click")
        });
    ');
    ?><!-- registration-form -->
    <?php
}
?>
