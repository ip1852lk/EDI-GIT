<?php
/* @var $this UserController
 * @var $model User
 * @var $form TbActiveForm
 */

$isAdmin = Yii::app()->user->checkAccess('Admin');

$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'User') : $model->email,
    'headerIcon' => 'fa fa-user fa-lg',
));
$form = $this->beginWidget('UActiveForm', array(
    'id' => 'user-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => !isset($dependency) ? 'js:function(form, data, hasError) { 
            if (!hasError) { 
                bootbox.dialog({
                    title: \'' . Yii::t('app', 'Saving...') . '\',
                    message: \'<p class="text-info"><span class="label label-danger">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\',
                });
                return true;
            }
        }' : 'js:function(form, data, hasError) {return true;}',
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
    echo $form->errorSummary(array($model, $profile));
    echo $form->textFieldGroup($model, 'username', array(
        'maxlength' => 20,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
    ));
    if ($isAdmin || $model->isNewRecord) {
        echo $form->passwordFieldGroup($model, 'password', array(
            'maxlength' => 128,
            'prepend' => '<i class="fa fa-key fa-lg"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6'),
            'hint' => Yii::t('app', '<span class="label label-info">Hint</span> Minimal password length 6 symbols.'),
        ));
    }
    echo $form->textFieldGroup($model, 'email', array(
        'maxlength' => 128,
        'prepend' => '<i class="fa fa-envelope fa-lg"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6'),
    ));
    if ($isAdmin|| $model->isNewRecord) {
        echo $form->dropDownListGroup($model, 'superuser', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
            'widgetOptions' => array('data' => $model->itemAlias('adminStatus')),
        ));
    }
    echo $form->dropDownListGroup($model, 'status', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('userStatus')),
    ));
    $profileFields = $profile->getFields();
    if ($profileFields) {
        foreach ($profileFields as $field) {
            if (($widgetEdit = $field->widgetEdit($profile, array('labelOptions' => array('class' => 'col-sm-2 col-md-3'), 'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm')), $form)))
                echo $widgetEdit;
            elseif ($field->range)
                echo $form->dropDownListGroup($profile, $field->varname, array(
                    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
                    'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
                    'widgetOptions' => array('data' => Profile::range($field->range)),
                ));
            elseif ($field->field_type == "TEXT")
                echo $form->textAreaGroup($profile, $field->varname, array(
                    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
                    'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-9 input-group-sm'),
                    'widgetOptions' => array('htmlOptions' => array('rows' => 6)),
                ));
            elseif ($field->field_type == "VARCHAR")
                if ($field->field_size >= 100)
                    echo $form->textFieldGroup($profile, $field->varname, array(
                        'maxlength' => $field->field_size,
                        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
                        'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-9 input-group-sm'),
                    ));
                else
                    echo $form->textFieldGroup($profile, $field->varname, array(
                        'maxlength' => ($field->field_size ? $field->field_size : 50),
                        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
                        'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
                    ));
            else
                echo $form->textFieldGroup($profile, $field->varname, array(
                    'maxlength' => ($field->field_size ? $field->field_size : 50),
                    'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
                    'wrapperHtmlOptions' => array('class' => 'col-sm-4 col-md-6 input-group-sm'),
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
            'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
            'htmlOptions' => array('id' => 'user-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;'),
        ));
        ?>
    </div>
<?php
$this->endWidget();
$this->endWidget();
?><!-- user-form -->

<?php
if ($profile->user_type == User::TYPE_CUSTOMER) {
    $defaultCondition = "
        $('label[for=\"Profile_lo1_id\"]').parent().hide();
        $('label[for=\"Profile_cu1_id\"]').parent().show();
        $('label[for=\"Profile_su1_id\"]').parent().hide();";
} elseif ($profile->user_type == User::TYPE_SUPPLIER) {
    $defaultCondition = "
        $('label[for=\"Profile_lo1_id\"]').parent().hide();
        $('label[for=\"Profile_cu1_id\"]').parent().hide();
        $('label[for=\"Profile_su1_id\"]').parent().show();";
} else {
    $defaultCondition = "
        $('label[for=\"Profile_lo1_id\"]').parent().show();
        $('label[for=\"Profile_cu1_id\"]').parent().hide();
        $('label[for=\"Profile_su1_id\"]').parent().hide();";
}
$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . 'user_type_control', "
    " . $defaultCondition . "
    $('#Profile_user_type').on('change', function(){
        if ($(this).val() == " . User::TYPE_CUSTOMER . ") {
            $('label[for=\"Profile_lo1_id\"]').parent().hide(500);
            $('label[for=\"Profile_cu1_id\"]').parent().show(500);
            $('label[for=\"Profile_su1_id\"]').parent().hide(500);
            $('#Profile_su1_id').val([]);
        } else if ($(this).val() == " . User::TYPE_SUPPLIER . ") {
            $('label[for=\"Profile_lo1_id\"]').parent().hide(500);
            $('#Profile_lo1_id').val([]);
            $('label[for=\"Profile_cu1_id\"]').parent().hide(500);
            $('#Profile_cu1_id').val([]);
            $('label[for=\"Profile_su1_id\"]').parent().show(500);
        } else {
            $('label[for=\"Profile_lo1_id\"]').parent().show(500);
            $('#Profile_lo1_id').val([]);
            $('label[for=\"Profile_cu1_id\"]').parent().hide(500);
            $('#Profile_cu1_id').val([]);
            $('label[for=\"Profile_su1_id\"]').parent().hide(500);
            $('#Profile_su1_id').val([]);
        }
    });
");
