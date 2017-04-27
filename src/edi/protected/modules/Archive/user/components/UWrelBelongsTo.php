<?php

class UWrelBelongsTo
{

    public $params = array(
        'modelName' => '',
        'optionName' => '',
        'emptyField' => '',
        'relationName' => '',
    );

    /**
     * Widget initialization
     * @return array
     */
    public function init()
    {
        return array(
            'name' => __CLASS__,
            'label' => UserModule::t('Relation Belongs To', array(), __CLASS__),
            'fieldType' => array('INTEGER'),
            'params' => $this->params,
            'paramsLabels' => array(
                'modelName' => UserModule::t('Model Name', array(), __CLASS__),
                'optionName' => UserModule::t('Label field names separated by comma', array(), __CLASS__),
                'emptyField' => UserModule::t('Empty item name', array(), __CLASS__),
                'relationName' => UserModule::t('Profile model relation name', array(), __CLASS__),
            ),
        );
    }

    /**
     * @param $value
     * @param $model
     * @param $field_varname
     * @return string
     */
    public function setAttributes($value, $model, $field_varname)
    {
        return $value;
    }

    /**
     * @param $model - profile model
     * @param $field - profile fields model item
     * @return string
     */
    public function viewAttribute($model, $field)
    {
        $relation = $model->relations();
        if ($this->params['relationName'] && isset($relation[$this->params['relationName']])) {
            $m = $model->__get($this->params['relationName']);
        } else {
            $m = CActiveRecord::model($this->params['modelName'])->findByPk($model->getAttribute($field->varname));
        }
        if ($m) {
            if (isset($this->params['optionName'])) {
                $returnValue = '';
                $optionNames = explode(',', $this->params['optionName']);
                foreach ($optionNames as $optionName) {
                    if (strlen($returnValue) > 0)
                        $returnValue .= ' - ';
                    $returnValue .= $m->getAttribute(trim($optionName));
                }
                return $returnValue;
            } else {
                return $m->id;
            }
        } else {
            return $this->params['emptyField'];
        }
    }

    /**
     * @param $model - profile model
     * @param $field - profile fields model item
     * @param $htmlOptions - htmlOptions
     * @param TbActiveForm $form - form instance
     * @return string
     */
    public function editAttribute($model, $field, $htmlOptions = array(), $form = null)
    {
        $list = array();
        if ($this->params['emptyField'])
            $list[0] = $this->params['emptyField'];
        $models = CActiveRecord::model($this->params['modelName'])->findAll();
        foreach ($models as $m) {
            if (isset($this->params['optionName'])) {
                $optionNames = explode(',', $this->params['optionName']);
                foreach ($optionNames as $optionName) {
                    if (isset($list[$m->id])) {
                        $list[$m->id] .= ' - ' . $m->getAttribute(trim($optionName));
                    } else {
                        $list[$m->id] = $m->getAttribute(trim($optionName));
                    }
                }
            } else {
                $list[$m->id] = $m->id;
            }
        }
        if ($form) {
            return $form->dropDownListGroup($model, $field->varname, array(
                'widgetOptions' => array(
                    'data' => $list,
                    'htmlOptions' => isset($htmlOptions['htmlOptions']) ? $htmlOptions['htmlOptions'] : array(),
                ),
                'wrapperHtmlOptions' => isset($htmlOptions['wrapperHtmlOptions']) ? $htmlOptions['wrapperHtmlOptions'] : array(),
                'labelOptions' => isset($htmlOptions['labelOptions']) ? $htmlOptions['labelOptions'] : array(),
            ));
        } else {
            return CHtml::activeDropDownList($model, $field->varname, $list, $htmlOptions ? $htmlOptions : array());
        }
    }

}
