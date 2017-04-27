<?php
/* @var $this UserLogController
 * @var $model UserLog
 * @var $form CActiveForm
 */

$isAdmin = Yii::app()->user->checkAccess('Admin');
?>

<div class="user-log-search-container" style="display:none">
    <?php
    $this->beginWidget('booster.widgets.TbPanel', array(
        'context' => 'warning',
        'title' => Yii::t('app', 'Advanced Search'),
        'headerIcon' => 'fa fa-filter fa-lg',
    ));
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'showErrors' => false,
        'showRequiredSymbol' => false,
        'htmlOptions' => array('class' => 'user-log-search-form'),
    ));
        echo $form->datePickerGroup($model, 'login_time', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-1',  'for' => 'UserLog-login-time-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array(
                'options' => array('language' => Yii::app()->language),
                'htmlOptions' => array('id' => 'UserLog-login-time-2'),
            ),
            'prepend' => '<i class="fa fa-calendar"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->datePickerGroup($model, 'logout_time', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-1',  'for' => 'UserLog-logout-time-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array(
                'options' => array('language' => Yii::app()->language),
                'htmlOptions' => array('id' => 'UserLog-logout-time-2'),
            ),
            'prepend' => '<i class="fa fa-calendar"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'profile_search', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-1'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'ip_address', array(
            'maxlength' => 32,
            'labelOptions' => array('class' => 'col-sm-2 col-md-1'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'user_agent', array(
            'maxlength' => 255,
            'labelOptions' => array('class' => 'col-sm-2 col-md-1'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        ?>
        <div class="form-actions btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_SUBMIT,
                'context' => 'primary',
                'icon' => 'fa fa-search',
                'label' => Yii::t('app', 'Search'),
                'htmlOptions' => array('class' => 'btn-sm'),
            ));
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => TbButton::BUTTON_BUTTON,
                'context' => 'default',
                'icon' => 'fa fa-times',
                'label' => Yii::t('app', 'Close'),
                'htmlOptions' => array('class' => 'user-log-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
</div><!-- user-log-search-form -->