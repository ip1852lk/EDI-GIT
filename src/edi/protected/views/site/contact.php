<?php
/* @var $this SiteController
 * @var $model ContactForm
 * @var $form TbActiveForm
 */
$this->pageTitle = Yii::app()->name . ' - '. Yii::t('app', 'Contact');
$this->breadcrumbs = array(
    Yii::t('app', Yii::app()->params['companyShortName']) => array('site/page', 'view' => 'about',),
    'Contact',
);
?>

<h3>Contact</h3>

<?php
if (Yii::app()->user->hasFlash('contact')) {
    Yii::app()->user->setFlash('info', Yii::app()->user->getFlash('contact'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => '×'), 
        ),
    ));
}
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => Yii::t('app', 'Location'),
    'headerIcon' => 'fa fa-thumb-tack fa-lg',
));
?>
    <div class="row">
        <div class="col-md-9">
            <?php echo Yii::app()->params['googleMap']; ?>
        </div>
        <div class="col-md-3">
            <address>
                <br><strong><?php echo Yii::app()->params['companyName']; ?></strong><br>
                <?php echo Yii::app()->params['companyAddress1']; ?>, <?php echo Yii::app()->params['companyAddress2']; ?><br>
                <?php echo Yii::app()->params['companyCity']; ?>, <?php echo Yii::app()->params['companyState']; ?> <?php echo Yii::app()->params['companyPostalCode']; ?><br>
                <a href="mailto:#"><?php echo Yii::app()->params['companyEmail']; ?></a><br>
                <abbr title="<?php echo Yii::t('app', 'Phone');?>">P:</abbr> <?php echo Yii::app()->params['companyPhone']; ?><br>
                <abbr title="<?php echo Yii::t('app', 'Fax');?>">F:</abbr> <?php echo Yii::app()->params['companyFax']; ?><br>
            </address>
        </div>
    </div>
<?php
$this->endWidget();
if (!Yii::app()->user->hasFlash('contact')) {
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'info',
        'title' => Yii::t('app', 'Contact Form'),
        'headerIcon' => 'fa fa-envelope fa-lg',
    ));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'contact-form',
        'method' => 'post',
        'type' => 'horizontal',
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError) { 
                if (!hasError) { 
                    bootbox.dialog({
                        title: \'' . Yii::t('app', 'Sending...') . '\',
                        message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while sending your message.') . '</p>\',
                    });
                    return true;
                }
            }',
        ),
    ));
    Yii::app()->user->setFlash('info', '<ul>
        <li>'.Yii::t('app', 'If you have any questions, please fill out this form to contact us.').'</li>
        <li>'.Yii::t('app', 'Fields with <span class="required">*</span> are required.').'</li>
    </ul>');
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => false), 
        ),
    ));
        echo $form->errorSummary($model);
        echo $form->textFieldGroup($model, 'name', array(
            'maxlength' => 128,
            'labelOptions' => array('class' => 'col-md-1'), 
            'wrapperHtmlOptions' => array('class' => 'col-md-4'), 
        ));
        echo $form->textFieldGroup($model, 'email', array(
            'maxlength' => 128,
            'labelOptions' => array('class' => 'col-md-1'), 
            'wrapperHtmlOptions' => array('class' => 'col-md-4'), 
        ));
        echo $form->textFieldGroup($model, 'subject', array(
            'maxlength' => 256,
            'labelOptions' => array('class' => 'col-md-1'), 
            'wrapperHtmlOptions' => array('class' => 'col-md-11'), 
        ));
        echo $form->textAreaGroup($model, 'body', array(
            'labelOptions' => array('class' => 'col-md-1'), 
            'widgetOptions' => array('htmlOptions' => array('rows' => 20)), 
            'wrapperHtmlOptions' => array('class' => 'col-md-11'), 
        ));
        if (CCaptcha::checkRequirements()) {
            echo $form->captchaGroup($model, 'verifyCode', array(), array(
                'hint' => '<span class="label label-info">'.Yii::t('app', 'Hint').'</span> '.Yii::t('app', 'Please enter the letters as they are shown in the image above. Letters are not case-sensitive.'),
                'labelOptions' => array('class' => 'col-md-1'),
                'wrapperHtmlOptions' => array('class' => 'col-md-4'),
            ));
        }
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-envelope',
                'label' => Yii::t('app', 'Submit'),
                'htmlOptions' => array('id' => 'contact-form-submit-btn',),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
<?php } ?><!-- contact-form -->
