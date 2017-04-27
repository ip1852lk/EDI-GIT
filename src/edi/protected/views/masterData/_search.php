<?php
/* @var $this MasterDataController
 * @var $model MasterData
 * @var $form TbActiveForm
 */

$masterDataAdmin = Yii::app()->user->checkAccess('MasterData.*');
?>
<div class="master-data-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'master-data-search-form'),
    ));
        echo $form->textFieldGroup($model, 'co1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
            'prepend' => '<i class="fa fa-building fa-fw"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'cu2_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
            'prepend' => '<i class="fa fa-users fa-fw"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'ra1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
            'prepend' => '<i class="fa fa-inbox fa-fw"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'contract_bin_id', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'customer_bin_id', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->dropDownListGroup($model, 'bt1_id', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BinType::getListData(null, true)),
            'prepend' => '<i class="fa fa-sitemap fa-fw"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'item_id', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 40)),
        ));
        echo $form->textFieldGroup($model, 'customer_part_no', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 40)),
        ));
        echo $form->textFieldGroup($model, 'pf1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
            'prepend' => '<i class="fa fa-tags fa-fw"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'item_desc', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 100)),
        ));
        echo $form->textFieldGroup($model, 'extended_desc', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 255)),
        ));
        echo $form->textFieldGroup($model, 'reorder_qty', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'p21_on_hand_qty', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'price', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
        ));
        echo $form->textFieldGroup($model, 'unit_of_measure', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 20)),
        ));
        if ($masterDataAdmin) {
            echo $form->textFieldGroup($model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'MasterData_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array( 
                    'htmlOptions' => array('id' => 'MasterData_mprofile_search_2'),
                ),
                'prepend' => '<i class="fa fa-user fa-fw"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo $form->datePickerGroup($model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'MasterData_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language), 
                    'htmlOptions' => array('id' => 'MasterData_modified_on_2'),
                ),
                'prepend' => '<i class="fa fa-calendar fa-fw"></i>',
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
                'htmlOptions' => array('class' => 'master-data-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div><!-- master-data-search-form -->

