<?php
/* @var $this TableLogController
 * @var $model TableLog
 * @var $form TbActiveForm
 */

?>
<div class="table-log-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'table-log-search-form'),
    ));
        echo $form->datePickerGroup($model, 'created_on', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'TableLog_created_on_2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'widgetOptions' => array(
                'options' => array('language' => Yii::app()->language), 
                'htmlOptions' => array('id' => 'TableLog_created_on_2'),
            ),
            'prepend' => '<i class="fa fa-calendar"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'cprofile_search', array(
            'maxlength' => 30,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'TableLog_cprofile_search_2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'widgetOptions' => array( 
                'htmlOptions' => array('id' => 'TableLog_cprofile_search_2'),
            ),
            'prepend' => '<i class="fa fa-user"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->dropDownListGroup($model, 'log_action', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => $model->itemAlias('logActionsForSearch')),
        ));
        echo $form->textAreaGroup($model, 'description', array(
            'maxlength' => 1000,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-9 col-md-9 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('rows' => 6)),
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
                'htmlOptions' => array('class' => 'table-log-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
</div><!-- table-log-search-form -->
