<?php

class ProfileFieldController extends RController
{

    private static $_widgets = array();
    public $defaultAction = 'index';
    public $layout = '//layouts/column4';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
                    'rights', // perform access control for CRUD operations
                    'postOnly + delete', // we only allow deletion via POST request
        ));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view', array(
            'model' => $this->loadModel(),
        ));
    }

    /**
     * Register Script
     */
    public function registerScript()
    {
        $baseUrl = Yii::app()->getModule('user')->getAssetsUrl();
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($baseUrl . '/css/redmond/jquery-ui.css');
        $cs->registerCssFile($baseUrl . '/css/style.css');
        $cs->registerScriptFile($baseUrl . '/js/jquery-ui.min.js');
        //$cs->registerScriptFile($baseUrl . '/js/form.js');
        $cs->registerScriptFile($baseUrl . '/js/jquery.json.js');

        $widgets = self::getWidgets();

        $wgByTypes = ProfileField::itemAlias('field_type');
        foreach ($wgByTypes as $k => $v) {
            $wgByTypes[$k] = array();
        }

        foreach ($widgets[1] as $widget) {
            if (isset($widget['fieldType']) && count($widget['fieldType'])) {
                foreach ($widget['fieldType'] as $type) {
                    array_push($wgByTypes[$type], $widget['name']);
                }
            }
        }
        //echo '<pre>'; print_r($widgets[1]); die();
        $js = "

	var name = $('#name'),
	value = $('#value'),
	allFields = $([]).add(name).add(value),
	tips = $('.validateTips');
	
	var listWidgets = jQuery.parseJSON('" . str_replace("'", "\'", CJavaScript::jsonEncode($widgets[0])) . "');
	var widgets = jQuery.parseJSON('" . str_replace("'", "\'", CJavaScript::jsonEncode($widgets[1])) . "');
	var wgByType = jQuery.parseJSON('" . str_replace("'", "\'", CJavaScript::jsonEncode($wgByTypes)) . "');
	
	var fieldType = {
            'INTEGER':{
                'hide':['match','other_validator','widgetparams'],
                'val':{
                    'field_size':10,
                    'default':'0',
                    'range':'',
                    'widgetparams':''
                }
            },
            'VARCHAR':{
                'hide':['widgetparams'],
                'val':{
                    'field_size':255,
                    'default':'',
                    'range':'',
                    'widgetparams':''
                }
            },
            'TEXT':{
                'hide':['field_size','range','widgetparams'],
                'val':{
                    'field_size':0,
                    'default':'',
                    'range':'',
                    'widgetparams':''
                }
            },
            'DATE':{
                'hide':['field_size','field_size_min','match','range','widgetparams'],
                'val':{
                    'field_size':0,
                    'default':'0000-00-00',
                    'range':'',
                    'widgetparams':''
                }
            },
            'FLOAT':{
                'hide':['match','other_validator','widgetparams'],
                'val':{
                    'field_size':'10.2',
                    'default':'0.00',
                    'range':'',
                    'widgetparams':''
                }
            },
            'DECIMAL':{
                'hide':['match','other_validator','widgetparams'],
                'val':{
                    'field_size':'10,2',
                    'default':'0',
                    'range':'',
                    'widgetparams':''
                }
            },
            'BOOL':{
                'hide':['field_size','field_size_min','match','widgetparams'],
                'val':{
                    'field_size':0,
                    'default':0,
                    'range':'1==" . UserModule::t('Yes') . ";0==" . UserModule::t('No') . "',
                    'widgetparams':''
                }
            },
            'BLOB':{
                'hide':['field_size','field_size_min','match','widgetparams'],
                'val':{
                    'field_size':0,
                    'default':'',
                    'range':'',
                    'widgetparams':''
                }
            },
            'BINARY':{
                'hide':['field_size','field_size_min','match','widgetparams'],
                'val':{
                    'field_size':0,
                    'default':'',
                    'range':'',
                    'widgetparams':''
                }
            }
        };
			
	function showWidgetList(type) {
            $('div.widget select').empty();
            $('div.widget select').append('<option value=\"\">" . UserModule::t('No') . "</option>');
            if (wgByType[type]) {
                for (var k in wgByType[type]) {
                    $('div.widget select').append('<option value=\"'+wgByType[type][k]+'\">'+widgets[wgByType[type][k]]['label']+'</option>');
                }
            }
	}
		
	function setFields(type) {
            if (fieldType[type]) {
                if (" . ((isset($_GET['id'])) ? 0 : 1) . ") {
                    showWidgetList(type);
                    $('#widgetlist option:first').attr('selected', 'selected');
                }

                $('div.row').addClass('toshow').removeClass('tohide');
                if (fieldType[type].hide.length) $('div.'+fieldType[type].hide.join(', div.')).addClass('tohide').removeClass('toshow');
                if ($('div.widget select').val()) {
                    $('div.widgetparams').removeClass('tohide');
                }
                $('div.toshow').show(500);
                $('div.tohide').hide(500);
                " . ((!isset($_GET['id'])) ? "
                for (var k in fieldType[type].val) { 
                    $('div.'+k+' input').val(fieldType[type].val[k]);
                }" : '') . "
            }
	}
	
	function isArray(obj) {
            if (obj.constructor.toString().indexOf('Array') == -1)
                return false;
            else
                return true;
	}
		
	$('#form-dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 400,
            modal: true,
            buttons: {
                '" . UserModule::t('Save') . "': function() {
                    var wparam = {};
                    var fparam = {};
                    $('#form-dialog fieldset .wparam').each(function(){
                            if ($(this).val()) wparam[$(this).attr('name')] = $(this).val();
                    });

                    var tab = $('#tabs ul li.ui-tabs-selected').text();
                    fparam[tab] = {};
                    $('#form-dialog fieldset .tab-'+tab).each(function(){
                            if ($(this).val()) fparam[tab][$(this).attr('name')] = $(this).val();
                    });

                    if ($.JSON.encode(wparam)!='{}') $('div.widgetparams input').val($.JSON.encode(wparam));
                    if ($.JSON.encode(fparam[tab])!='{}') $('div.other_validator input').val($.JSON.encode(fparam)); 

                    $(this).dialog('close');
                },
                '" . UserModule::t('Cancel') . "': function() {
                    $(this).dialog('close');
                }
            },
            close: function() {
            }
	});


	$('#widgetparams').focus(function() {
            var widget = widgets[$('#widgetlist').val()];
            var html = '';
            var wparam = ($('div.widgetparams input').val())?$.JSON.decode($('div.widgetparams input').val()):{};
            var fparam = ($('div.other_validator input').val())?$.JSON.decode($('div.other_validator input').val()):{};

            // Class params
            for (var k in widget.params) {
                html += '<label for=\"name\">'+((widget.paramsLabels[k])?widget.paramsLabels[k]:k)+'</label>';
                html += '<input type=\"text\" name=\"'+k+'\" id=\"widget_'+k+'\" class=\"text wparam ui-widget-content ui-corner-all\" value=\"'+((wparam[k])?wparam[k]:widget.params[k])+'\" />';
            }
            // Validator params		
            if (widget.other_validator) {
                var tabs = '';
                var li = '';
                for (var t in widget.other_validator) {
                    tabs += '<div id=\"tab-'+t+'\" class=\"tab\">';
                    li += '<li'+((fparam[t])?' class=\"ui-tabs-selected\"':'')+'><a href=\"#tab-'+t+'\">'+t+'</a></li>';

                    for (var k in widget.other_validator[t]) {
                        tabs += '<label for=\"name\">'+((widget.paramsLabels[k])?widget.paramsLabels[k]:k)+'</label>';
                        if (isArray(widget.other_validator[t][k])) {
                            tabs += '<select type=\"text\" name=\"'+k+'\" id=\"filter_'+k+'\" class=\"text fparam ui-widget-content ui-corner-all tab-'+t+'\">';
                            for (var i in widget.other_validator[t][k]) {
                                tabs += '<option value=\"'+widget.other_validator[t][k][i]+'\"'+((fparam[t]&&fparam[t][k])?' selected=\"selected\"':'')+'>'+widget.other_validator[t][k][i]+'</option>';
                            }
                            tabs += '</select>';
                        } else {
                            tabs += '<input type=\"text\" name=\"'+k+'\" id=\"filter_'+k+'\" class=\"text fparam ui-widget-content ui-corner-all tab-'+t+'\" value=\"'+((fparam[t]&&fparam[t][k])?fparam[t][k]:widget.other_validator[t][k])+'\" />';
                        }
                    }
                    tabs += '</div>';
                }
                html += '<div id=\"tabs\"><ul>'+li+'</ul>'+tabs+'</div>';
            }

            $('#form-dialog fieldset').html(html);

            $('#tabs').tabs();

            // Show form
            $('#form-dialog').dialog('open');
	});
	
	$('#field_type').change(function() {
		setFields($(this).val());
	});
	
	$('#widgetlist').change(function() {
            if ($(this).val()) {
                $('div.widgetparams').show(500);
            } else {
                $('div.widgetparams').hide(500);
            }
		
	});
	
	// show all function 
	$('div.form p.note').html('<br/><a href=\"#\" id=\"showAll\">" . UserModule::t('Show Options') . "</a>');
        $('#showAll').toggle(function() {
            $('div.row.option-row').slideDown();
            $(this).text('Hide Options');
        }, function() {
            $('div.row.option-row').slideUp();
            $(this).text('Show Options');
        });
	
	// init
	setFields($('#field_type').val());
	
	";
        $cs->registerScript(__CLASS__ . '#dialog', $js);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ProfileField;
        $scheme = get_class(Yii::app()->db->schema);
        if (isset($_POST['ProfileField'])) {
            $model->attributes = $_POST['ProfileField'];
            if ($model->validate()) {
                $sql = 'ALTER TABLE ' . Profile::model()->tableName() . ' ADD `' . $model->varname . '` ';
                $sql .= $this->fieldType($model->field_type);
                if ($model->field_type != 'TEXT' &&
                        $model->field_type != 'DATE' &&
                        $model->field_type != 'BOOL' &&
                        $model->field_type != 'BLOB' &&
                        $model->field_type != 'BINARY') {
                    $sql .= '(' . $model->field_size . ')';
                }
                $sql .= ' NOT NULL ';
                if ($model->field_type != 'TEXT' && $model->field_type != 'BLOB' || $scheme != 'CMysqlSchema') {
                    if ($model->default)
                        $sql .= " DEFAULT '" . $model->default . "'";
                    else
                        $sql .=
                            ($model->field_type == 'TEXT' || $model->field_type == 'VARCHAR' || $model->field_type == 'BLOB' || $model->field_type == 'BINARY') ?
                            " DEFAULT ''" :
                            (($model->field_type == 'DATE') ? " DEFAULT '0000-00-00'" : " DEFAULT 0");
                }
                $model->dbConnection->createCommand($sql)->execute();
                $model->save();
                $this->redirect(array('index'));
            }
        }
        $this->registerScript();
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
        if (isset($_POST['ProfileField'])) {
            $model->attributes = $_POST['ProfileField'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->registerScript();
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel();
            try {
                $scheme = get_class(Yii::app()->db->schema);
                if ($scheme == 'CSqliteSchema') {
                    $attr = Profile::model()->attributes;
                    unset($attr[$model->varname]);
                    $attr = array_keys($attr);
                    $connection = Yii::app()->db;
                    $transaction = $connection->beginTransaction();
                    $status = true;
                    try {
                        $sql = '';
                        $connection->createCommand(
                            "CREATE TEMPORARY TABLE " . Profile::model()->tableName() . "_backup (" . implode(',', $attr) . ")"
                        )->execute();

                        $connection->createCommand(
                            "INSERT INTO " . Profile::model()->tableName() . "_backup SELECT " . implode(',', $attr) . " FROM " . Profile::model()->tableName()
                        )->execute();

                        $connection->createCommand(
                            "DROP TABLE " . Profile::model()->tableName()
                        )->execute();

                        $connection->createCommand(
                            "CREATE TABLE " . Profile::model()->tableName() . " (" . implode(',', $attr) . ")"
                        )->execute();

                        $connection->createCommand(
                            "INSERT INTO " . Profile::model()->tableName() . " SELECT " . implode(',', $attr) . " FROM " . Profile::model()->tableName() . "_backup"
                        )->execute();

                        $connection->createCommand(
                            "DROP TABLE " . Profile::model()->tableName() . "_backup"
                        )->execute();

                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $status = false;
                    }
                    if ($status) {
                        $model->delete();
                    }
                } else {
                    $sql = 'ALTER TABLE ' . Profile::model()->tableName() . ' DROP `' . $model->varname . '`';
                    $model->dbConnection->createCommand($sql)->execute();
                    $model->delete();
                }
                if (!isset($_REQUEST['ajax']))
                    Yii::app()->user->setFlash('success', UserModule::t('<span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.', array(':record' => $model->varname)));
                else
                    echo UserModule::t('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-success">DELETED</span> <span class="label label-warning">:record</span> is deleted successfully.</div>', array(':record' => $model->varname));
            } catch (CDbException $e) {
                Yii::log('Failed to delete a user. ' . $e->getMessage(), CLogger::LEVEL_ERROR);
                if (!isset($_REQUEST['ajax']))
                    Yii::app()->user->setFlash('error', UserModule::t('<span class="label label-danger">ERROR</span> <span class="label label-warning">:record</span> cannot be deleted.', array(':record' => $model->varname)));
                else
                    echo UserModule::t('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><span class="label label-danger">ERROR</span> <span class="label label-warning">:record</span> cannot be deleted.</div>', array(':record' => $model->varname));
            }
            if (!isset($_REQUEST['ajax']))
                $this->redirect(array('index'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']>5?(int)$_GET['pageSize']:(int)Yii::app()->params['pageSize']);
            unset($_GET['pageSize']);
        } else {
            Yii::app()->user->setState('pageSize',(int)Yii::app()->params['pageSize']);
        }
        $model = new ProfileField('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProfileField']))
            $model->attributes = $_GET['ProfileField'];
        if (isset($_GET['export'])) {
            if (Yii::app()->user->checkAccess('User.ProfileField.Export')) {
                if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'profile-field-grid') {
                    header('Content-type: application/json');
                    $file = $model->export(false);
                    if ($file === false) {
                        $status = '500';
                        $statusText = 'fail';
                        $body = Yii::t('app', 'Profile Field data cannot be exported.');
                    } else {
                        $status = '200';
                        $statusText = 'success';
                        $body = $file;
                    }
                    echo CJSON::encode(array(
                        'status' => $status,
                        'statusText' => $statusText,
                        'body' => $body,
                    ));
                    Yii::app()->end();
                } else {
                    if (!$model->export(true)) {
                        Yii::log('Profile Field data cannot be exported.', CLogger::LEVEL_ERROR);
                        throw new CHttpException(500, Yii::t('app', 'Profile Field data cannot be exported.'));
                    }
                }
            } else {
                Yii::log('This user is not permitted to export Profile Field data.', CLogger::LEVEL_ERROR);
                throw new CHttpException(401, Yii::t('app', 'You are not fully authorized to export Profile Field data.'));
            }
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * @deprecated since version 2.0.0
     * Exports records to Excel.
     */
    public function actionExport()
    {
        throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = ProfileField::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->_model;
    }

    /**
     * MySQL field type
     * @param $type string
     * @return string
     */
    public function fieldType($type)
    {
        $type = str_replace('UNIX-DATE', 'INTEGER', $type);
        return $type;
    }

    public static function getWidgets($fieldType = '')
    {
        $basePath = Yii::getPathOfAlias('application.modules.user.components');
        $widgets = array();
        $list = array('' => UserModule::t('No'));
        if (self::$_widgets) {
            $widgets = self::$_widgets;
        } else {
            $d = dir($basePath);
            while (false !== ($file = $d->read())) {
                if (strpos($file, 'UW') === 0) {
                    list($className) = explode('.', $file);
                    if (class_exists($className)) {
                        $widgetClass = new $className;
                        if ($widgetClass->init()) {
                            $widgets[$className] = $widgetClass->init();
                            if ($fieldType) {
                                if (in_array($fieldType, $widgets[$className]['fieldType']))
                                    $list[$className] = $widgets[$className]['label'];
                            } else {
                                $list[$className] = $widgets[$className]['label'];
                            }
                        }
                    }
                }
            }
            $d->close();
        }
        return array($list, $widgets);
    }

    /**
     * Performs the AJAX validation.
     * @param CModel|array $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === 'profile-field-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
