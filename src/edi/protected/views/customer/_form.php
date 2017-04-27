<?php
/* @var $this CustomerController
 * @var $model Customer
 * @var $form TbActiveForm
 */

$customerAdmin = Yii::app()->user->checkAccess('Customer.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'headerIcon' => 'fa fa-users fa-lg',
    'title' => $model->isNewRecord ? Yii::t('app', 'Customer') : $model->cu1_code,
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'customer-form',
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
    if (!$model->isNewRecord && $customerAdmin) {
    ?>
    <div class="alert alert-block alert-info">
        <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
    echo $form->errorSummary($model);
    echo $form->dropDownListGroup($model, 'cu1_type', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('customerTypes')),
    ));
    echo $form->textFieldGroup($model, 'cu1_code', array(
        'maxlength' => 10,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    echo $form->textFieldGroup($model, 'cu1_name', array(
        'maxlength' => 250,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
    ));
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabMenuHtmlOptions' => array('id' => 'customer-internal-form-tab-menu'),
        'tabs' => array(
            array(
                'active' => true,
                'id' => 'customer-internal-form-tab-1',
                'label' => Yii::t('app', 'General Info.'),
                'content' => $this->renderPartial('//customer/_tab_1', array(
                    'model' => $model,
                    'form' => $form,
                    'dependency' => (isset($dependency) ? $dependency : null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                    'parentPk' => (isset($parentPk) ? $parentPk : null),
                    'parentId' => (isset($parentId) ? $parentId : null),
                ), true),
            ),
            array(
                'active' => false,
                'id' => 'customer-internal-form-tab-2',
                'label' => Yii::t('app', 'Options'),
                'content' => $this->renderPartial('//customer/_tab_2', array(
                    'model' => $model,
                    'form' => $form,
                    'dependency' => (isset($dependency) ? $dependency : null),
                    'dependencyTabIndex' => (isset($dependencyTabIndex) ? $dependencyTabIndex : null),
                    'dependencyTabDropdownIndex' => (isset($dependencyTabDropdownIndex) ? $dependencyTabDropdownIndex : null),
                    'parentPk' => (isset($parentPk) ? $parentPk : null),
                    'parentId' => (isset($parentId) ? $parentId : null),
                ), true),
            ),
        ),
    ));
    ?>
    <div class="form-actions btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-save',
            'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
            'htmlOptions' => array('id' => 'customer-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
        ));
        ?>
    </div>
<?php
$this->endWidget();
$this->endWidget();
?><!-- customer-form -->
