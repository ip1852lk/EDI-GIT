<?php
/* @var $this UserController
 * @var $model User
 * @var $form TbActiveForm
 */

$isAdmin = Yii::app()->user->checkAccess('Admin');
?>

<div class="user-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'user-search-form'),
    ));
        echo $form->dropDownListGroup($model, 'profile_user_type_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => $model->itemAlias('userTypesForSearch')),
        ));
        echo $form->textFieldGroup($model, 'username', array(
            'maxlength' => 20,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'email', array(
            'maxlength' => 128,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        if ($isAdmin) {
            echo $form->dropDownListGroup($model, 'superuser', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
                'widgetOptions' => array('data' => $model->itemAlias('adminStatusForSearch')),
            ));
            echo $form->dropDownListGroup($model, 'status', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
                'widgetOptions' => array('data' => $model->itemAlias('userStatusForSearch')),
            ));
        }
        echo $form->textFieldGroup($model, 'profile_full_name_search', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'co1_search', array(
            'maxlength' => 100,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-building"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'lo1_search', array(
            'maxlength' => 100,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-map-marker"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'cu1_search', array(
            'maxlength' => 100,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-users" style="font-size: 9px;"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        /*echo $form->textFieldGroup($model, 'su1_search', array(
            'maxlength' => 100,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-truck"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));*/
        echo $form->datePickerGroup($model, 'create_at', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'User-create-at-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'widgetOptions' => array(
                'options' => array('language' => Yii::app()->language),
                'htmlOptions' => array('id' => 'User-create-at-2'),
            ),
            'prepend' => '<i class="fa fa-calendar"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->datePickerGroup($model, 'lastvisit_at', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'User-lastvisit-at-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'widgetOptions' => array(
                'options' => array('language' => Yii::app()->language),
                'htmlOptions' => array('id' => 'User-lastvisit-at-2'),
            ),
            'prepend' => '<i class="fa fa-calendar"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
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
                'htmlOptions' => array('class' => 'user-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div><!-- user-search-form -->