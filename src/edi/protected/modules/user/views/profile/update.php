<?php
/* @var $this ProfileController
 * @var $model User
 * @var $profile Profile
 */

$cs = Yii::app()->clientScript;
// Title
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Update Profile");
$this->title = Yii::t('app', 'Update Profile');
// Breadcrumbs
$this->breadcrumbs = array(
    UserModule::t("Profile") => array('view'),
    UserModule::t("Update"),
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
        'htmlOptions' => array('id' => 'profile-update-save-btn', 'class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->email,
    'headerIcon' => 'fa fa-user fa-lg',
));
$form = $this->beginWidget('UActiveForm', array(
    'id' => 'profile-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError) { 
                if (!hasError) { 
                    bootbox.dialog({
                        title: \'' . Yii::t('app', 'Saving...') . '\',
                        message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\',
                    });
                    return true;
                }
            }',
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo $form->errorSummary(array($model, $profile));
echo $form->textFieldGroup($model, 'username', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
    'wrapperHtmlOptions' => array(
        'readonly' => true,
        'class' => 'col-sm-6 col-md-4 input-group-sm',
    ),
    'widgetOptions' => array(
        'htmlOptions' => array(
            'maxlength' => 20,
        ),
    ),
));
echo $form->textFieldGroup($model, 'email', array(
    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4'),
    'widgetOptions' => array(
        'htmlOptions' => array(
            'maxlength' => 128,
        ),
    ),
    'prepend' => '<i class="fa fa-envelope fa-lg"></i>',
    'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
));
$roles = Rights::getAssignedRoles($model->id, true);
$showLocation = true;
if ($roles === null || count($roles) == 0)
    $showLocation = false;
else {
    $roles = array_keys($roles);
    foreach ($roles as $role) {
        if ($role == 'Inactive')
            $showLocation = false;
    }
}
$user_type = $profile->user_type;
$profileFields = ProfileField::model()->forOwner()->sort()->findAll();
if ($profileFields) {
    foreach ($profileFields as $field) {
        if ($field->varname == 'lo1_id' && !$showLocation)
            continue;
        elseif ($field->widget && class_exists($field->widget))
            if ($field->varname == 'lo1_id') {
                $alias = Location::model()->getTableAlias(false, false);
                $criteria = new CDbCriteria();
                $criteria->condition = $alias . '.id=' . $model->profile->lo1_id;
                echo $form->dropDownListGroup($profile, $field->varname, array(
                    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                    'wrapperHtmlOptions' => array('readonly' => true, 'class' => 'disabled col-sm-6 col-md-4 input-group-sm'),
                    'widgetOptions' => array('data' => Location::getListData($criteria, false)),
                ));
            } elseif ($field->varname == 'cu1_id') {
                if ($user_type == User::TYPE_CUSTOMER) {
                    $alias = Customer::model()->getTableAlias(false, false);
                    $criteria = new CDbCriteria();
                    $criteria->condition = $alias . '.id=' . $model->profile->cu1_id;
                    echo $form->dropDownListGroup($profile, $field->varname, array(
                        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                        'wrapperHtmlOptions' => array('readonly' => true, 'class' => 'disabled col-sm-6 col-md-4 input-group-sm'),
                        'widgetOptions' => array('data' => Customer::getListData($criteria, false)),
                    ));
                }
            } elseif ($field->varname == 'su1_id') {
                if ($user_type == User::TYPE_SUPPLIER) {
                    $alias = Supplier::model()->getTableAlias(false, false);
                    $criteria = new CDbCriteria();
                    $criteria->condition = $alias . '.id=' . $model->profile->su1_id;
                    echo $form->dropDownListGroup($profile, $field->varname, array(
                        'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                        'wrapperHtmlOptions' => array('readonly' => true, 'class' => 'disabled col-sm-6 col-md-4 input-group-sm'),
                        'widgetOptions' => array('data' => Supplier::getListData($criteria, false)),
                    ));
                }
            } else {
                if (($widgetEdit = $field->widgetEdit($profile, array('labelOptions' => array('class' => 'col-sm-2 col-md-2'), 'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm')), $form)))
                    echo $widgetEdit;
            }
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
                    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                    'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-6 input-group-sm'),
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'maxlength' => $field->field_size,
                        ),
                    ),
                ));
            else
                echo $form->textFieldGroup($profile, $field->varname, array(
                    'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                    'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'maxlength' => ($field->field_size ? $field->field_size : 50),
                        ),
                    ),
                ));
        else
            echo $form->textFieldGroup($profile, $field->varname, array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-4 input-group-sm'),
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'maxlength' => ($field->field_size ? $field->field_size : 50),
                    ),
                ),
            ));
    }
}
?>
<div class="form-actions btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => UserModule::t('Save'),
        'htmlOptions' => array('id' => 'profile-form-save-btn', 'style' => 'display: none;'),
    ));
    ?>
</div>
<?php
$this->endWidget();
$this->endWidget();
// Save Control
$cs->registerScript(__CLASS__ . 'profile_form_save', '
    $("#profile-update-save-btn").click(function(){
        $("#profile-form-save-btn").trigger("click")
    });
');
?><!-- profile-form -->