<?php 
/**
 * BootSelGridView v2.3
 * 
 * for usage with twitter bootstrap Yii components
 * 
 * BootSelGridView remembers selected rows of gridview when sorting or navigating by pages. Also it can select particular rows by GET param when page is loading
 *
 * to highlignh selection add this code to your css:
 * 
 * table.table tr.selected td, table.table tr.selected:hover td {
 *    background: none repeat scroll 0 0 #BCE774;
 * }
 */
class JGridView extends TbGridView
{
    /**
    * GET param name to pass selected row(s)
    * 
    * @var mixed
    */
    public $selVar;

    /**
     * @var mixed $additionalScriptUrl
     */
    public $additionalScriptUrl;

    /**
     * @var bool $fixedHeader if set to true will keep the header fixed  position
     */
    public $fixedHeader = true;

    /**
     * @var integer $headerOffset, when $fixedHeader is set to true, headerOffset will position table header top position
     * at $headerOffset. If you are using bootstrap and has navigation top fixed, its height is 40px, so it is recommended
     * to use $headerOffset=40;
     */
    public $headerOffset = 50;

    public function init()
    {
        if($this->additionalScriptUrl===null) {
            $this->additionalScriptUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('ext.jgridview.assets')
            );
        }
        if ($this->selectableRows > 0) {
            //generate name of variable for selection from request
            if (empty($this->selVar)) {
                $id = $this->dataProvider->getId();
                if (empty($id)) $id = $this->id;
                $this->selVar = (empty($id)) ? 'sel' : $id.'_sel';
            }
        }
        parent::init();
    }

    /**
    * Creates column objects and initializes them. 
    * Automatically add hidden checkbox column.
    */
    protected function initColumns()
    {
        parent::initColumns();

        if($this->selectableRows == 0) return;
        //define primaryKey expression
        if($this->dataProvider instanceOf CActiveDataProvider) 
            $primaryKey = '$data->primaryKey';
        else 
            $primaryKey = '$data["'.$this->dataProvider->keyField.'"]';
        $checkedExpression = 
            'isset($_GET["'.$this->selVar.'"]) ? in_array('.$primaryKey.', is_array($_GET["'.$this->selVar.'"]) ? $_GET["'.$this->selVar.'"] : array($_GET["'.$this->selVar.'"])) : false;';
        //if gridview already has user defined Checkbox column --> set "checked" and exit
        //thanks to Horacio Segura http://www.yiiframework.com/extension/selgridview/#c7346
        foreach($this->columns as $col) {
            if($col instanceof CCheckBoxColumn) {
                $col->checked = $checkedExpression;
                $col->init();
                return;
            }
        }
        //creating hidden checkbox column
        $checkboxColumn = new CCheckBoxColumn($this);   
        $checkboxColumn->checked = $checkedExpression;
        $checkboxColumn->htmlOptions = array('style'=>'display:none');
        $checkboxColumn->headerHtmlOptions = array('style'=>'display:none');
        $checkboxColumn->init(); 

        $this->columns[] = $checkboxColumn;
    }

    /**
    * Registers necessary client scripts. 
    * Automaticlly prepend user's beforeajaxUpdate with needed code that will modify GET params when navigating and sorting
    */
    public function registerClientScript()
    {
        parent::registerClientScript();
        $cs = Yii::app()->getClientScript();
        $id = $this->getId();
        if ($this->selectableRows > 0) {
            $options = CJavaScript::encode(array(
                'selVar' => $this->selVar,
            ));
            $cs->registerScriptFile($this->additionalScriptUrl.'/jquery.selgridview.js',CClientScript::POS_END);
            $cs->registerScript(__CLASS__.'#'.$id.'_multiple_selection',
                "jQuery('#$id').selGridView($options);"
            );
        }

        if(isset($this->dataProvider->model)){
            $class = get_class($this->dataProvider->model);

            $dependency = isset($_GET['dependency']) ? $_GET : false;

            if (isset($dependency) && $dependency != false){
                $updateURL = Yii::app()->createUrl($class."/update/xxxidxxx", array(
                    'dependency' => (isset($_GET['dependency'])?$_GET['dependency']:null),
                    'dependencyTabIndex' => (isset($_GET['dependencyTabIndex'])?$_GET['dependencyTabIndex']:null),
                    'dependencyTabDropdownIndex' => (isset($_GET['dependencyTabDropdownIndex'])?$_GET['dependencyTabDropdownIndex']:null),
                    'parentPk' => (isset($_GET['parentPk'])?$_GET['parentPk']:null),
                    'parentId' => (isset($_GET['parentId'])?$_GET['parentId']:null),
                ));
            }else{
                $updateURL = Yii::app()->createUrl($class."/update/xxxidxxx", array());
            }
            $cs->registerScript(__CLASS__ . 'click-to-update', '
            $("body").on("dblclick", \'.grid-view tbody tr\', function(event){
                var rowNum = $(this).index();
                var keys = $(\'.grid-view > div.keys > span\');
                var rowId = keys.eq(rowNum).text();
                var url = "' . $updateURL . '";
                //Insert the ID of the record being updated
                url = url.replace("xxxidxxx", rowId);
                location.href = url;
            });
        ');
        }

        if ($this->fixedHeader) {
            Booster::getBooster()->registerAssetJs('jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js');
            $cs->registerScript(__CLASS__.'#'.$id.'_sticky_header', '
                $("#'.$id.' table.items").stickyTableHeaders({ fixedOffset: '.$this->headerOffset.' });
                $("#'.$id.' thead.tableFloatingHeaderOriginal tr.filters input, #'.$id.' thead.tableFloatingHeaderOriginal tr.filters select").on({
                    change: function() {
                        $("#'.$id.' table.items thead.tableFloatingHeader tr.filters #"+$(this).attr("id")).val($(this).val());
                    },
                    keydown: function(event) {
                        $("#'.$id.' table.items thead.tableFloatingHeader tr.filters #"+$(this).attr("id")).val($(this).val());
                    },
                });
                $("#'.$id.' thead.tableFloatingHeader tr.filters input, #'.$id.' thead.tableFloatingHeader tr.filters select").on({
                    change: function() {
                        $("#'.$id.' table.items thead.tableFloatingHeaderOriginal tr.filters #"+$(this).attr("id")).val($(this).val());
                    },
                    keydown: function(event) {
                        $("#'.$id.' table.items thead.tableFloatingHeaderOriginal tr.filters #"+$(this).attr("id")).val($(this).val());
                    },
                });
            ');
        }
    }

}
