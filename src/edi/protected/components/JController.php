<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class JController extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column4';

    /**
     * @var string the title of a page.
     */
    public $title = "";

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $wMain = array();
    public $wSetting = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * @var string Base path for assests
     */
    private $_assetsBase;

    /**
     * @var boolean Check if this is an administrator or not.
     */
    public $isAdmin;

    /**
     * @var boolean Check if this is an internal user or not.
     */
    public $isInternal;

    /**
     * @var boolean Check if this is a customer user or not.
     */
    public $isCustomer;

    /**
     * @var boolean Check if this is a supplier user or not.
     */
    public $isSupplier;

    /**
     * @var boolean Check if this is the client is a mobile device or not.
     */
    public $isMobile;

    /**
     * @var boolean Indicate whether or not the background image needs to be displayed.
     */
    public $showBackgroundImage = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->isAdmin = Yii::app()->user->checkAccess('Admin');
        $this->isInternal = !$this->isAdmin && Yii::app()->user->checkAccess('Internal');
        $this->isCustomer = !$this->isAdmin && Yii::app()->user->checkAccess('Customer');
        $this->isSupplier =!$this->isAdmin && Yii::app()->user->checkAccess('Supplier');
        $this->isMobile = Yii::app()->browser->isMobile();
    }

    /**
     * Returns
     * @return string the base path of this application's assets
     */
    public function getAssetsBase()
    {
        if ($this->_assetsBase === null) 
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.assets'), false, -1, false
            );
        return $this->_assetsBase;
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return boolean
     */
    public function isActive($routes = array())
    {
        $routeCurrent = '';
        if ($this->module !== null)
            $routeCurrent .= sprintf('%s/', $this->module->id);
        if (isset($this->action->view))
            $routeCurrent .= sprintf('%s/%s', $this->id, $this->action->view);
        else
            $routeCurrent .= sprintf('%s/%s', $this->id, $this->action->id);
        foreach ($routes as $route) {
            $pattern = sprintf('~%s~', preg_quote($route));
            if (preg_match($pattern, $routeCurrent)) 
                return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function beforeAction($action)
    {
        if (YII_DEBUG)
            Yii::app()->assetManager->forceCopy = true;
        return parent::beforeAction($action);
    }
}
