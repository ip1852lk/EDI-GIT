<?php
/* @var $this ProductFamilyController
 * @var $model ProductFamily
 * @var $form TbActiveForm
 */

$productFamilyAdmin = Yii::app()->user->checkAccess('ProductFamily.*');
?>
<div class="product-family-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'product-family-search-form'),
    ));
        echo $form->textFieldGroup($model, 'pf1_family', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 4)),
        ));
        echo $form->textFieldGroup($model, 'pf1_commodity', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 4)),
        ));
        echo $form->textFieldGroup($model, 'pf1_desc1', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        echo $form->textFieldGroup($model, 'pf1_desc2', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        echo $form->textFieldGroup($model, 'pf1_desc3', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        if ($productFamilyAdmin) {
            echo $form->textFieldGroup($model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'ProductFamily_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array( 
                    'htmlOptions' => array('id' => 'ProductFamily_mprofile_search_2'),
                ),
                'prepend' => '<i class="fa fa-user"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo $form->datePickerGroup($model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'ProductFamily_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language), 
                    'htmlOptions' => array('id' => 'ProductFamily_modified_on_2'),
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
                'htmlOptions' => array('class' => 'product-family-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div><!-- product-family-search-form -->

