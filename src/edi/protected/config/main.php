<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$live = true; //This is a flag that changes the database settings to the live system credentials (see bottom of file). Comment out for development settings

$result =
array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    # project title
    'name' => 'Edi',
    # default language
    'language' => 'en',
    # source language for messages and views
    'sourceLanguage' => 'en_us',
    # charset to use
    'charset' => 'utf-8',
    # theme
    'theme' => '',
    # preloading components
    'preload' => array(
        'booster',
        'log',
        'user',
    ),
    # autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.components.behaviors.*',
        'application.models.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.rights.components.behaviors.*',
        'ext.bootstrap3.actions.*',
        'ext.bootstrap3.components.*',
        'ext.bootstrap3.helpers.*',
        'ext.bootstrap3.widgets.*',
        'ext.jui.*',
        'ext.yii-mail.*',
        'ext.yiiexport.*',
        'ext.EExcelView.EExcelView',
        'ext.PHPExcel.*',
        'ext.inc.*',
        'ext.tcpdf.*',
        'ext.Teamwork.*',
    ),
    # behaviors
    'behaviors' => array(
        'onBeginRequest' => array(
            'class' => 'application.components.behaviors.JLanguageBehavior'
        ),
    ),
    # modules
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'edi',
            'ipFilters' => array('127.0.0.1', '::1'), // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'generatorPaths' => array(
                'booster.gii',
            ),
        ),
        'user' => array(
            'tableUsers' => 'yii_user',
            'tableProfiles' => 'yii_profile',
            'tableProfileFields' => 'yii_profile_field',
            'hash' => 'md5', // encrypting method (php hash function)
            'sendActivationMail' => true, // send activation email
            'loginNotActiv' => false, // allow access for non-activated users
            'activeAfterRegister' => false, // activate user on registration (only sendActivationMail = false)
            'autoLogin' => true, // automatically login from registration
            'registrationUrl' => array('/user/registration'), // registration path
            'recoveryUrl' => array('/user/recovery'), // recovery password path
            'loginUrl' => array('/user/login'), // login form path
            'returnUrl' => array('/edi'), // page after login
            'returnLogoutUrl' => array('/user/login'), // page after logout
            'profileRelations' => array(
                'location' => array(CActiveRecord::BELONGS_TO, 'Location', 'lo1_id',),
                'customer' => array(CActiveRecord::BELONGS_TO, 'Customer', 'cu1_id',),
                'supplier' => array(CActiveRecord::BELONGS_TO, 'Supplier', 'su1_id',),
                'state' => array(CActiveRecord::BELONGS_TO, 'State', 'su1_id',),
            ),
            'defaultController' => 'user',
            'forceCopy' => YII_DEBUG,
        ),
        'rights' => array(
            'superuserName' => 'Admin', // Name of the role with super user privileges. 
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role. 
            'userIdColumn' => 'id', // Name of the user id column in the database. 
            'userNameColumn' => 'username', // Name of the user name column in the database. 
            'enableBizRule' => true, // Whether to enable authorization item business rules. 
            'enableBizRuleData' => true, // Whether to enable data for business rules. 
            'displayDescription' => true, // Whether to use item description instead of name. 
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages. 
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages. 
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested. 
            'layout' => 'rights.views.layouts.column4', // Layout to use for displaying Rights. 
            'appLayout' => '//layouts/index', //'application.views.layouts.main', // Application layout. 
            //'cssFile' => 'rights.css', // Style sheet file to use for Rights. 
            'install' => false, // Whether to enable installer. 
            'forceCopy' => YII_DEBUG,
        ),
    ),
    # application components
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
        ),
        'request' => array(
            'class' => 'application.components.JHttpRequest',
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'session' => array(
            'sessionName' => 'CODEBASE',
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'autoCreateSessionTable' => false,
            'sessionTableName' => 'yii_session',
            'autoStart' => true,
            'cookieMode' => 'allow',
            'timeout' => 2 * 60 * 60, // seconds
        ),
        'assetManager' => array(
            'forceCopy' => YII_DEBUG, // Set it as true for production
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array('Guest'),
            'assignmentTable' => 'yii_auth_assignment',
            'itemTable' => 'yii_auth_item',
            'itemChildTable' => 'yii_auth_item_child',
            'rightsTable' => 'yii_rights',
        ),
        'user' => array(
            'class' => 'RWebUser',
            'allowAutoLogin' => true, // cookie-based authentication
            'authTimeout' => 2 * 60 * 60, // seconds
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/edi'),
        ),
        'cache' => array(
            'class' => 'CDbCache',
        ),
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=comparatio_edi',
            'username' => 'root',
            'password' => 'toor',
            'charset' => 'utf8',
            'emulatePrepare' => !YII_DEBUG, // needed by some MySQL installations
            'schemaCachingDuration' => YII_DEBUG ? 0 : 2 * 60 * 60, // turn on schema caching to improve performance
            'tablePrefix' => '',
            'enableParamLogging' => true,
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
            'transportOptions' => array(
                'host' => 'newmail.comparatio.com',
                'port' => 587,
                'username' => 'noreply@comparatio.com',
                'password' => 'KHQsolul',
                //'encryption' => 'ssl',
                //'timeout' => '',
                //'extensionHandlers' => '',
            ),
        ),
        'booster' => array(
            'class' => 'ext.bootstrap3.components.Booster',
            'forceCopyAssets' => false,
            'responsiveCss' => true,
            'fontAwesomeCss' => true,
            'enableBootboxJS' => true,
            'disableZooming' => true,
        ),
        'teamworkDeskImport' => array(
            'class' => 'ext.Teamwork.Desk.TeamWorkDeskImport',
        ),
        'export' => array(
            'class' => 'ext.yiiexport.YiiExport',
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files',
        ),
        'browser' => array(
            'class' => 'ext.browser.CBrowserComponent',
        ),
        'curl' => array(
            'class' => 'ext.curl.Curl',
            'options' => array(
                /* additional curl options */
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                // Application logs
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // Debugging Logs
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info',
                    'logFile' => 'debug.log',
                ),
                // Database logs
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => YII_DEBUG?'error, warning, trace, log':'error, warning',
                    'categories' => 'system.db.CDbCommand',
                    'logFile' => 'db.log',
                ),
                // Runtime logs on your web browser
                //array('class' => 'CWebLogRoute',),
            ),
        ),
    ),
    # application-level parameters that can be accessed using Yii::app()->params['paramName']
    'params' => array(
        // Version Control
        'version' => '1.0.1',
        'adminEmail' => 'alex.lappen@comparatio.com',
        'appFullName' => 'Comparatio EDI',
        'appShortName' => 'EDI',
        // Menu Control
        'workspaceLabel' => 'Menus',
        'workspaceUrl' => '/dashboard',
        'settingsLabel' => 'Settings',
        'settingsUrl' => '/user/user/index',
        // Company Info
        'companyName' => 'Comparatio USA, LLC',
        'companyShortName' => 'Comparatio',
        'companyURL' => 'http://www.comparatio.com/',
        'companyEmail' => 'info@comparatio.com',
        'companyPhone' => '(952) 926-5500',
        'companyFax' => '(952) 926-5501',
        'companyAddress1' => '5353 Gamble Drive',
        'companyAddress2' => 'Suite 100',
        'companyCity' => 'St. Louis Park',
        'companyState' => 'MN',
        'companyPostalCode' => '55416',
        'companyCountry' => 'USA',
        'googleMap' => '<iframe width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0 style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Comparatio%20USA%2C%20Gamble%20Drive%2C%20St%20Louis%20Park%2C%20MN%2C%20United%20States&key=AIzaSyCKunFWVN2BpwO-hi1a2ix-w4fFWhfUfTo"></iframe>',
        // Locale Settings
        'supportedLanguages' => array(
            'en' => array('label' => 'English', 'currency' => 'USD', 'dateFormat' => 'm/d/Y', 'dateTimeFormat' => 'm/d/Y H:i:s', 'dateTimeFormat2' => 'm/d/Y g:i A', 'dateTimePickerFormat' => 'mm/dd/yyyy H:ii P'),
            'fr' => array('label' => 'French', 'currency' => 'EUR', 'dateFormat' => 'm/d/Y', 'dateTimeFormat' => 'm/d/Y H:i:s', 'dateTimeFormat2' => 'm/d/Y g:i A', 'dateTimePickerFormat' => 'mm/dd/yyyy H:ii P'),
            'ko' => array('label' => 'Korean', 'currency' => 'KRW', 'dateFormat' => 'Y-m-d', 'dateTimeFormat' => 'Y-m-d H:i:s', 'dateTimeFormat2' => 'Y-m-d g:i A', 'dateTimePickerFormat' => 'yyyy-mm-dd H:ii P'),
            'es' => array('label' => 'Spanish', 'currency' => 'USD', 'dateFormat' => 'm/d/Y', 'dateTimeFormat' => 'm/d/Y H:i:s', 'dateTimeFormat2' => 'm/d/Y g:i A', 'dateTimePickerFormat' => 'mm/dd/yyyy H:ii P'),
        ),
        'teamworkCompany' => 'comparatio',
        'teamworkAPIKey' => 'memory299abba',
        'teamworkDeskAPIKey' => 'En5JqeKWLdWv9XHtDCPUCGUCenUCMToGSCf0Zbc8My1Yeaqrfk',
        // Grid Control
        'pageSize' => 100,
        'pageSizeSet' => array(5=>5, 10=>10, 20=>20, 50=>50, 100=>100, 1000=>'All'),
        'pagerMaxButtonCount' => 3,
        // Dashboard Control
        'dashboardShowRandomTrend' => false,
        'dashboardCustomerLimit' => 10,
        'dashboardItemLimit' => 10,
        'dashboardYearDataCacheDuration' => 24 * 60 * 60,
        'dashboardMapDataCacheDuration' => 24 * 60 * 60,
        'dashboardTop5CustomersSalesCacheDuration' => 24 * 60 * 60,
        'dashboardStatePieChartDataCacheDuration' => 24 * 60 * 60,
        'dashboardStateSalesDataCacheDuration' => 24 * 60 * 60,
        'dashboardCustomerPieChartDataCacheDuration' => 24 * 60 * 60,
        'dashboardCustomerSalesDataCacheDuration' => 24 * 60 * 60,
        'dashboardCustomerSalesHistoryCacheDuration' => 24 * 60 * 60,
        'dashboardFacilityPieChartDataCacheDuration' => 24 * 60 * 60,
        'dashboardFacilitySalesDataCacheDuration' => 24 * 60 * 60,
        'dashboardFacilitySalesHistoryCacheDuration' => 24 * 60 * 60,
        'dashboardLocationPieChartDataCacheDuration' => 24 * 60 * 60,
        'dashboardLocationSalesDataCacheDuration' => 24 * 60 * 60,
        'dashboardLocationSalesHistoryCacheDuration' => 24 * 60 * 60,
        'dashboardLegendUp1' => 115, // Dashboard Legend
        'dashboardLegendUp2' => 105,
        'dashboardLegendDown2' => 95,
        'dashboardLegendDown1' => 85,
        // Others
//        'customerDefaultLogo' => '/nuventorydash/img/logo/default.png',
//        'supplierDefaultLogo' => '/nuventorydash/img/logo/default.png',
        'name'              => 'Time',
        'version'           => '3.4',
        'author'            => 'David Niaz',
        'robots'            => 'noindex, nofollow',
        'title'             => '',
        'description'       => '',
        // true                     enable page preloader
        // false                    disable page preloader
        'page_preloader'    => true,
        // true                     enable main menu auto scrolling when opening a submenu
        // false                    disable main menu auto scrolling when opening a submenu
        'menu_scroll'       => true,
        // 'navbar-default'         for a light header
        // 'navbar-inverse'         for a dark header
        'header_navbar'     => 'navbar-default',
        // ''                       empty for a static layout
        // 'navbar-fixed-top'       for a top fixed header / fixed sidebars
        // 'navbar-fixed-bottom'    for a bottom fixed header / fixed sidebars
        'header'            => 'navbar-fixed-top',
        // ''                                               for a full main and alternative sidebar hidden by default (> 991px)
        // 'sidebar-visible-lg'                             for a full main sidebar visible by default (> 991px)
        // 'sidebar-partial'                                for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
        // 'sidebar-partial sidebar-visible-lg'             for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
        // 'sidebar-mini sidebar-visible-lg-mini'           for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
        // 'sidebar-mini sidebar-visible-lg'                for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)
        // 'sidebar-alt-visible-lg'                         for a full alternative sidebar visible by default (> 991px)
        // 'sidebar-alt-partial'                            for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
        // 'sidebar-alt-partial sidebar-alt-visible-lg'     for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)
        // 'sidebar-partial sidebar-alt-partial'            for both sidebars partial which open on mouse hover, hidden by default (> 991px)
        // 'sidebar-no-animations'                          add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!
        'sidebar'           => 'sidebar-partial sidebar-visible-lg',
        // ''                       empty for a static footer
        // 'footer-fixed'           for a fixed footer
        'footer'            => 'footer-fixed',
        // ''                       empty for default style
        // 'style-alt'              for an alternative main style (affects main page background as well as blocks style)
        'main_style'        => 'flatie',
        // ''                           Disable cookies (best for setting an active color theme from the next variable)
        // 'enable-cookies'             Enables cookies for remembering active color theme when changed from the sidebar links (the next color theme variable will be ignored)
        'cookies'           => '',
        // 'night', 'amethyst', 'modern', 'autumn', 'flatie', 'spring', 'fancy', 'fire', 'coral', 'lake',
        // 'forest', 'waterlily', 'emerald', 'blackberry' or '' leave empty for the Default Blue theme
        'theme'             => 'blackberry',
        // ''                       for default content in header
        // 'horizontal-menu'        for a horizontal menu in header
        // This option is just used for feature demostration and you can remove it if you like. You can keep or alter header's content in page_head.php
        'header_content'    => '',
        'active_page'       => basename($_SERVER['PHP_SELF'])
    ),
);

if(isset($live) && $live == true){
    //This will overwrite development database settings with live settings for swift deployment
    $result['components']['db'] = array(
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=comparatio_edi',
        'username' => 'root',
        'password' => 'toor',
        'charset' => 'utf8',
        'emulatePrepare' => !YII_DEBUG, // needed by some MySQL installations
        'schemaCachingDuration' => YII_DEBUG ? 0 : 2 * 60 * 60, // turn on schema caching to improve performance
        'tablePrefix' => '',
        'enableParamLogging' => true,
    );
}

return $result;