<?php
/* @var $this CompanyController
 * @var $model Company
 * @var $form TbActiveForm
 */

$companyAdmin = Yii::app()->user->checkAccess('Company.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-building fa-lg',
    'title' => $model->isNewRecord ? Yii::t('app', 'Company') : $model->co1_code,
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'company-form',
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
    if (!$model->isNewRecord && $companyAdmin) {
        ?>
        <div class="alert alert-block alert-info">
            <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
            <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
        </div>
    <?php
    }
    echo $form->errorSummary($model);
    echo $form->dropDownListGroup($model, 'co1_type', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('companyTypes')),
    ));
    echo $form->textFieldGroup($model, 'co1_code', array(
        'maxlength' => 10,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_name', array(
        'maxlength' => 250,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_phone', array(
        'maxlength' => 25,
        'prepend' => '<i class="fa fa-phone"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6'),
    ));
    echo $form->textFieldGroup($model, 'co1_fax', array(
        'maxlength' => 25,
        'prepend' => '<i class="fa fa-fax"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6'),
    ));
    echo $form->textFieldGroup($model, 'co1_url', array(
        'maxlength' => 250,
        'prepend' => '<i class="fa fa-link"></i>',
        'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7'),
    ));
    echo $form->fileFieldGroup($model, 'co1_logo', array(
        'maxlength' => 250,
        'maxFileSize' => 2000000,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
        'acceptFileTypes' => 'js:/(\.|\/)(gif|jpe?g|png)$/i', 'style' => 'margin-bottom: 10px;',
    ));
    echo $form->textFieldGroup($model, 'co1_address1', array(
        'maxlength' => 250,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_address2', array(
        'maxlength' => 250,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-7 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_city', array(
        'maxlength' => 50,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->dropDownListGroup($model, 'st1_id', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('data' => State::getListData(null, true)),
    ));
    echo $form->textFieldGroup($model, 'co1_postal_code', array(
        'maxlength' => 25,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_country', array(
        'maxlength' => 50,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_teamwork_id', array(
        'maxlength' => 50,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'co1_teamwork_desk_id', array(
        'maxlength' => 50,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    ?>
    <div class="form-actions btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-save',
            'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
            'htmlOptions' => array('id' => 'company-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
        ));
        ?>
    </div>
<?php
$this->endWidget();
$this->endWidget();
?><!-- company-form -->
