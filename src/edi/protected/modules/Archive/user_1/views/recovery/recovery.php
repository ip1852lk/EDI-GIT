<?php
/* @var $this RecoveryController
 * @var $model UserRecoveryForm
 */

$cs = Yii::app()->clientScript;
// Title
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', "Change Password");
$this->title = Yii::t('app', 'Change Password');
// Breadcrumbs
$this->breadcrumbs = array(
    Yii::t('app', "Login") => array('/user/login'),
    Yii::t('app', "Change Password"),
);
// Notes
if (Yii::app()->user->hasFlash('recoveryMessage')) {
    Yii::app()->user->setFlash('info', Yii::app()->user->getFlash('recoveryMessage'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
} elseif (Yii::app()->user->hasFlash('recoveryErrorMessage')) {
    Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('recoveryErrorMessage'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'error' => array('fade' => true, 'closeText' => false,), 
        ),
    ));
} else {
    // Menus
    $this->menu = array_merge($this->menu, array(
        array(
            'class' => 'booster.widgets.TbButton',
            'buttonType' => TbButton::BUTTON_BUTTON,
            'context' => 'primary',
            'icon' => 'fa fa-send fa-lg',
            'label' => '<span class="">' . Yii::t('app', 'Request') . '</span>',
            'url' => '#',
            'encodeLabel' => false,
            'htmlOptions' => array('id' => 'recovery-main-save-btn', 'class' => 'navbar-btn btn-sm',),
        ),
    ));
    // UIs
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'info',
        'title' => Yii::t('app', "Change Password"),
        'headerIcon' => 'fa fa-key fa-lg',
    ));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'password-restore-form',
        'method' => 'post',
        'type' => 'horizontal',
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError) { 
                    if (!hasError) { 
                        bootbox.dialog({
                            title: \'' . Yii::t('app', 'Sending...') . '\',
                            message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while sending recovery instructions to your email.') . '</p>\',
                        });
                        return true;
                    }
                }',
        ),
    ));
        echo $form->errorSummary($model);
        echo $form->textFieldGroup($model, 'login_or_email', array(
            'maxlength' => 128,
            'prepend' => '<i class="fa fa-envelope fa-lg"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
        ));
        if (UserModule::doCaptcha('recovery')) {
            echo $form->captchaGroup($model, 'verifyCode', array(), array(
                'hint' => Yii::t('app', '<span class="label label-info">Hint</span> Please enter the letters as they are shown in the image above. Letters are not case-sensitive.'),
                'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            ));
        }
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-send',
                'label' => Yii::t('app', 'Request'),
                'htmlOptions' => array('id' => 'recovery-form-save-btn', 'style' => 'display: none;'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    // Save Control
        $cs->registerScript(__CLASS__ . 'profile_form_save', '
        $("#recovery-main-save-btn").click(function(){
            $("#recovery-form-save-btn").trigger("click")
        });
    ');
    ?><!-- password-restore-form -->
    <?php
}
?>