<?php
/**
 * The following variables are available in this template:
/* @var $this BootstrapCode
 */

echo 
"<?php 
/* @var \$this {$this->getControllerClass()}
 * @var \$model {$this->modelClass}
 * @var \$form TbActiveForm
 */

\${$this->class2var($this->modelClass)}Admin = Yii::app()->user->checkAccess('{$this->modelClass}.*');
// UIs
\$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => \$model->isNewRecord ? Yii::t('app', '{$this->class2name($this->modelClass)}') : \$model->{$this->tableSchema->primaryKey},
    'headerIcon' => 'fa {$this->icon} fa-lg',
));
\$form = \$this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => '".$this->class2id($this->modelClass)."-form',
    'method' => 'post',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => !isset(\$dependency) ? 'js:function(form, data, hasError) { 
            if (!hasError) { 
                bootbox.dialog({
                    title: \\'' . Yii::t('app', 'Saving...') . '\\',
                    message: \\'<p class=\"text-info\"><span class=\"label label-danger\">' . Yii::t('app', 'Important') . '</span> ' . Yii::t('app', 'Please wait while the record is being saved.') . '</p>\\',
                });
                return true;
            }
        }' : 'js:function(form, data, hasError) {return true;}',
    ),
));
";
if ($this->useDefaultColumns == 1) {
echo
"    if (!\$model->isNewRecord && \${$this->class2var($this->modelClass)}Admin) {
    ?>
    <div class=\"alert alert-block alert-info\">
        <p class=\"hidden-xs\"><?php echo Yii::t('app', 'Created by'); ?> <span class=\"text-warning\"><?php echo isset(\$model->cprofile->first_name) && isset(\$model->cprofile->last_name) ? CHtml::encode(\$model->cprofile->first_name . ' ' . \$model->cprofile->last_name) : 'Unknown User'; ?></span> on <span class=\"text-warning\"><?php echo isset(\$model->created_on) ? Yii::app()->dateFormatter->formatDateTime(\$model->created_on, 'medium', 'short') : ''; ?></span></p>
        <p><?php echo Yii::t('app', 'Modified by'); ?> <span class=\"text-warning\"><?php echo isset(\$model->mprofile->first_name) && isset(\$model->mprofile->last_name) ? CHtml::encode(\$model->mprofile->first_name . ' ' . \$model->mprofile->last_name) : 'Unknown User'; ?></span> on <span class=\"text-warning\"><?php echo isset(\$model->modified_on) ? Yii::app()->dateFormatter->formatDateTime(\$model->modified_on, 'medium', 'short') : ''; ?></span></p>
    </div>
    <?php
    }
";
}
echo
"    echo \$form->errorSummary(array(\$model));\n";
foreach ($this->tableSchema->columns as $column) {
    if ($column->isPrimaryKey) continue;
    echo $this->generateActiveGroup($this->modelClass, $column, 'col-sm-2 col-md-3', 'col-sm-6 col-md-6', "    ");
}
echo
"    echo '<div class=\"form-actions btn-toolbar\">';
    \$this->widget('booster.widgets.TbButton', array(
        'buttonType' => TbButton::BUTTON_SUBMIT,
        'context' => 'primary',
        'icon' => 'fa fa-save',
        'label' => (\$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        'htmlOptions' => array('id' => '{$this->class2id($this->modelClass)}-form-save-btn', 'class' => 'btn-sm', 'style' => 'display: none;',),
    ));
    echo '</div>';
\$this->endWidget();
\$this->endWidget();

// Relations
// TODO: The following code will display a popup window with a customer list.
//\$cs = Yii::app()->clientScript;
//\$cs->registerScript(__CLASS__ . '{$this->class2dbid($this->modelClass)}_relation', '
//    // Relations in {$this->modelClass}: Customer
//    $(\"#{$this->class2id($this->modelClass)}-form\").on(\"click\", \"#customer-select-btn\", function() {
//        window.openRelationPopup(
//            \"'.\$this->createUrl('/customer/relation', array(
//                'parentPk' => isset(\$parentPk) ? \$parentPk : null,
//                'parentId' => isset(\$parentId) ? \$parentId : null,
//                'relationIndex' => 1,
//                'relationSelectableRows' => 1,
//            )).'\", 
//            \"customer-relation-select-btn-1\", 
//            \"customer-relation-close-btn-1\", 
//            function() {
//                var rows = $(\"#customer-grid-1 tbody input[type=checkbox]:checked\").map(function() {
//                    return $(this).parent().next().html();
//                }).get();
//                $.each(rows, function(i, row) {
//                    metadata = row.split(\"|\");
//                    $.each(metadata, function(k, column) {
//                        value = column.split(\"==\");
//                        if (value[0] == \"id\") 
//                            $(\"#{$this->modelClass}_cu1_id\").val(value[1]);
//                        if (value[0] == \"cu1_name\") 
//                            $(\"#Customer_cu1_name\").val(value[1]);
//                    });
//                });
//                window.relationBootbox.modal(\"hide\");
//            },
//            \"'.Yii::t('app', 'Please select a CUSTOMER in the list.').'\", 
//            \"'.Yii::t('app', 'Loading...').'\", 
//            \"'.Yii::t('app', 'Server Error').'\", 
//            \"'.Yii::t('app', 'Please refresh this page and try again shortly.').'\"
//        );
//        return false;
//    });
//    $(\"#customer-clear-btn\").click(function() {
//        $(\"#{$this->modelClass}_cu1_id\").val(\"\");
//        $(\"#Customer_cu1_name\").val(\"\");
//        return false;
//    });
//');

?><!-- {$this->class2id($this->modelClass)}-form -->\n";