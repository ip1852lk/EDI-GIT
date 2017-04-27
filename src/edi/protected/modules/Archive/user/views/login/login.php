<?php
/* @var $this LoginController
 * @var $model UserLogin
 */

// Title
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', "Login");
//$this->breadcrumbs = array(
//    Yii::t('app', "Login"),
//);

$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;

?>
    <script src="<?php echo $baseUrl . '/js/blurjs/blur.js'; ?>"></script>
    <div class="body-wrapper">
        <div id="logo" class="row row-centered">
            <div class="col-centered logo-wrapper">
                <?php
                echo CHtml::image($baseUrl.'/img/ComparatioLogo_3color.png', 'Logo', array(
                    'class' => 'img-responsive',
                    'style'=>'width:475px;',
                ));
                ?>
            </div>
        </div>
        <div id="dash-subheader" class="row-centered">
            <div class="col-centered">
                <h1 class="" style='color:white; font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; '>T I M E</h1>
            </div>
        </div>
        <div class="row-centered">
            <div id ="login-box" class="login col-centered">
                <?php
                if (Yii::app()->user->hasFlash('loginMessage')) {
                    Yii::app()->user->setFlash('info', Yii::app()->user->getFlash('loginMessage'));
                    $this->widget('booster.widgets.TbAlert', array(
                        'alerts' => array(
                            'info' => array('fade' => true, 'closeText' => false,),
                        ),
                    ));
                } else {
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'login-form',
                    'method' => 'post',
                    'type' => 'horizontal',
                    'showErrors' => false,
                    'showRequiredSymbol' => false,
                ));
                echo $form->errorSummary($model);
                echo $form->textFieldGroup($model, 'username', array(
                    'labelOptions' => array('class' => 'col-sm-3 col-md-3 col-lg-3'),
                    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-9 col-md-9 col-lg-9'),
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'maxlength' => 60,
                            'placeholder' => Yii::t('app', 'Username or Email'),
                        ),
                    ),
                    'prepend' => '<span class="fa fa-envelope fa-fw"></span>',
                    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
                ));
                echo $form->passwordFieldGroup($model, 'password', array(
                    'labelOptions' => array('class' => 'col-sm-3 col-md-3 col-lg-3'),
                    'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-9 col-md-9 col-lg-9'),
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'maxlength' => 128,
                        ),
                    ),
                    'prepend' => '<span class="fa fa-key fa-fw"></span>',
                    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
                ));
                ?>
                <div class="form-actions btn-toolbar">
                    <div class="btn-group">
                        <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => TbButton::BUTTON_SUBMIT,
//                            'context' => 'primary',
                            'icon' => 'fa fa-sign-in',
                            'label' => Yii::t('app', 'Login'),
                            'htmlOptions' => array('class' => 'btn-sm btn-login'),
                        ));
                        ?>
                    </div>
                    <div class="btn-group pull-right">
                        <?php
                        echo $form->checkboxGroup($model, 'rememberMe', array(
                            'labelOptions' => array('label' => false),
                            'wrapperHtmlOptions' => array('style' => 'width:100%'),
                        ));
                        ?>
                    </div>
                </div>
                <br>
                <div class="form-actions btn-toolbar">
                    <div class="btn-group">
                        <?php
                        echo CHtml::link(Yii::t('app', "Lost Password?"), Yii::app()->getModule('user')->recoveryUrl);
                        ?>
                    </div>
                    <div class="btn-group pull-right">
                        <em class="label label-info"><?php echo Yii::t('app', 'Version ') . Yii::app()->params['version']; ?></em>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <?php
                }
                ?><!-- login-form -->
            </div>
        </div>
    </div>
<?php
$cs ->registerScript(__CLASS__.'-form', "
    $('#login-box').hide();
    $('#logo').hide();
    $('#dash-subheader').hide();
    $.backstretch('" . $baseUrl ."/img/background/time-background.jpg');

    $(document).ready(function() {
        $('#logo').delay(0).fadeIn('medium');
        $('#dash-subheader').delay(600).fadeIn('slow');
        $('#login-box').delay(1500).fadeIn('slow');
        $('.backstretch').addClass('animation-pulseSlow');
    });

");