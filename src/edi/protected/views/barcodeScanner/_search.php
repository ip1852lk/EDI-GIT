<?php
/* @var $this BarcodeScannerController
 * @var $model BarcodeScanner
 * @var $form TbActiveForm
 */

$barcodeScannerAdmin = Yii::app()->user->checkAccess('BarcodeScanner.*');
?>
<div class="barcode-scanner-search-container" style="display:none">
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
        'htmlOptions' => array('class' => 'barcode-scanner-search-form'),
    ));
        echo $form->textFieldGroup($model, 'us1_search', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 250)),
            'prepend' => '<i class="fa fa-user"></i>',
            'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
        ));
        echo $form->textFieldGroup($model, 'bs1_mac_address', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('htmlOptions' => array('maxlength' => 50)),
        ));
        echo $form->dropDownListGroup($model, 'bs1_model', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('modelForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_com_port', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('comPortForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_speed', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('speedForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_data_bit', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('dataBitForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_parity', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('parityForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_stop_bit', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('stopBitForSearch')),
        ));
        echo $form->dropDownListGroup($model, 'bs1_flow_control', array(
            'labelOptions' => array('class' => 'col-sm-2 col-md-2'),
            'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4 input-group-sm'),
            'widgetOptions' => array('data' => BarcodeScanner::itemAlias('flowControlForSearch')),
        ));
        if ($barcodeScannerAdmin) {
            echo $form->textFieldGroup($model, 'mprofile_search', array(
                'maxlength' => 30,
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'BarcodeScanner_mprofile_search_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array( 
                    'htmlOptions' => array('id' => 'BarcodeScanner_mprofile_search_2'),
                ),
                'prepend' => '<i class="fa fa-user"></i>',
                'prependOptions' => array('inputGroupOptions' => array('class' => 'input-group-sm')),
            ));
            echo $form->datePickerGroup($model, 'modified_on', array(
                'labelOptions' => array('class' => 'col-sm-2 col-md-2', 'for' => 'BarcodeScanner_modified_on_2'),
                'wrapperHtmlOptions' => array('class' => 'col-sm-5 col-md-4'),
                'widgetOptions' => array(
                    'options' => array('language' => Yii::app()->language), 
                    'htmlOptions' => array('id' => 'BarcodeScanner_modified_on_2'),
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
                'htmlOptions' => array('class' => 'barcode-scanner-search-close-btn btn-sm'),
            ));
            ?>
        </div>
    <?php
    $this->endWidget();
    $this->endWidget();
    ?>
</div><!-- barcode-scanner-search-form -->

