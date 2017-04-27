<?php
/* @var $this TableLogController
 * @var $model TableLog
 * @var $form TbActiveForm
 */

$tableLogAdmin = Yii::app()->user->checkAccess('TableLog.*');
// UIs
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->isNewRecord ? Yii::t('app', 'Change Log') : TableLog::itemAlias('logActions', $model->log_action).' ('.Yii::app()->dateFormatter->formatDateTime($model->created_on, "medium", "short").')',
    'headerIcon' => 'fa fa-history fa-lg',
));
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'table-log-form',
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
    if (!$model->isNewRecord && $tableLogAdmin) {
    ?>
        <div class="alert alert-block alert-info">
            <p class="hidden-xs"><?php echo Yii::t('app', 'Created by'); ?> <span class="text-warning"><?php echo isset($model->cprofile->first_name) && isset($model->cprofile->last_name) ? CHtml::encode($model->cprofile->first_name . ' ' . $model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->created_on) ? Yii::app()->dateFormatter->formatDateTime($model->created_on, 'medium', 'short') : ''; ?></span></p>
            <p><?php echo Yii::t('app', 'Modified by'); ?> <span class="text-warning"><?php echo isset($model->mprofile->first_name) && isset($model->mprofile->last_name) ? CHtml::encode($model->mprofile->first_name . ' ' . $model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class="text-warning"><?php echo isset($model->modified_on) ? Yii::app()->dateFormatter->formatDateTime($model->modified_on, 'medium', 'short') : ''; ?></span></p>
        </div>
    <?php
    }
    echo $form->errorSummary($model);
    echo $form->hiddenField($model, 'model');
    echo $form->hiddenField($model, 'model_id');
    echo $form->dropDownListGroup($model, 'log_action', array(
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-md-6 input-group-sm'),
        'widgetOptions' => array('data' => $model->itemAlias('logActions')),
    ));
//    echo $form->ckEditorGroup($model, 'description', array(
//        'maxlength' => 1000,
//        'labelOptions' => array('class' => 'col-md-2'),
//        'widgetOptions' => array(
//            'editorOptions' => array(
//                // From basic `build-config.js` minus 'undo', 'clipboard' and 'about'
//                //'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects',
//                'fullpage' => 'js:true',
//                /* 'width' => '640', */
//                /* 'resize_maxWidth' => '640', */
//                /* 'resize_minWidth' => '320'*/
//            )
//        ),
//        'wrapperHtmlOptions' => array('class' => 'col-md-9'),
//        
//    ));
    echo $form->textAreaGroup($model, 'description', array(
        'maxlength' => 1000,
        'labelOptions' => array('class' => 'col-sm-2 col-md-3'),
        'wrapperHtmlOptions' => array('class' => 'col-sm-10 col-md-9 input-group-sm'),
        'widgetOptions' => array('htmlOptions' => array('rows' => 10)),
        //'widgetOptions' => array(
        //    'htmlOptions' => array('disabled' => true)
        //),
    ));
    ?>
    <div class="form-actions btn-toolbar">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => TbButton::BUTTON_SUBMIT,
            'context' => 'primary',
            'icon' => 'fa fa-save',
            'label' => ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
            'htmlOptions' => array('id' => 'table-log-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
        ));
        ?>
    </div>
<?php
$this->endWidget();
$this->endWidget();
?><!-- table-log-form -->
