<?php

/**
 * ## TbDetailView class file.
 *
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */
Yii::import('zii.widgets.CDetailView');

/**
 * ## Bootstrap Zii detail view.
 *
 * @package booster.widgets.grouping
 */
class TbDetailView extends CDetailView
{

    // Table types.
    const TYPE_STRIPED = 'striped';
    const TYPE_BORDERED = 'bordered';
    const TYPE_CONDENSED = 'condensed';

    /**
     * @var string|array the table type.
     * Valid values are 'striped', 'bordered' and/or 'condensed'.
     */
    public $type = array(self::TYPE_STRIPED, self::TYPE_CONDENSED);

    /**
     * @var string the URL of the CSS file used by this detail view.
     * Defaults to false, meaning that no CSS will be included.
     */
    public $cssFile = false;

    /**
     * @var string the template used to render a single attribute. Defaults to a table row.
     * These tokens are recognized: "{class}", "{label}" and "{value}". They will be replaced
     * with the CSS class name for the item, the label and the attribute value, respectively.
     * @see itemCssClass
     */
    public $itemTemplate="<tr class=\"row {class}\"><th class=\"col-xs-1 col-sm-2 col-md-2\">{label}</th><td class=\"col-xs-11 col-sm-10 col-md-10\">{value}</td></tr>\n";

    /**
     * ### .init()
     *
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $classes = array('table');

        if (isset($this->type)) {
            if (is_string($this->type)) {
                $this->type = explode(' ', $this->type);
            }

            $validTypes = array(self::TYPE_STRIPED, self::TYPE_BORDERED, self::TYPE_CONDENSED);

            if (!empty($this->type)) {
                foreach ($this->type as $type) {
                    if (in_array($type, $validTypes)) {
                        $classes[] = 'table-' . $type;
                    }
                }
            }
        }

        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] .= ' ' . $classes;
            } else {
                $this->htmlOptions['class'] = $classes;
            }
        }
    }

}
