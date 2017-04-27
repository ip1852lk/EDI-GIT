<?php
/* @var $this LocationController
 * @var $model Location
 * @var $form TbActiveForm
 */

$locationAdmin = Yii::app()->user->checkAccess('Location.*');
?>
<div class="location-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'location-search-form'),
    ));
        echo $form->textFieldGroup($model, 'lo1_code', array(
            'maxlength' => 50,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'lo1_name', array(
            'maxlength' => 250,
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'rg1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-globe"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'co1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-building"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'us1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'prepend' => '<i class="fa fa-user"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        if ($locationAdmin) {
            echo $form->textFieldGroup($model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'Location_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array( 
                    'htmlOptions' => array('id' => 'Location_mprofile_search_2'),
                ),
                'prepend' => '<i class="fa fa-user"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo $form->datePickerGroup($model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'Location_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language), 
                    'htmlOptions' => array('id' => 'Location_modified_on_2'),
                ),
                'prepend' => '<i class="fa fa-calendar"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
        }
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
                'htmlOptions' => array('class' => 'location-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>
</div><!-- location-search-form -->
