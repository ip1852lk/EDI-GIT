<?php
$baseUrl = Yii::app()->baseUrl;
$user = User::model()->findByPk(Yii::app()->user->id)->profile;
$data['firstName'] = $user->first_name;
$data['fullName'] = $user->getFullname();

$activity = array();

$user = User::model()->findByPk(Yii::app()->user->id);
$lastLogin = $user->lastvisit_at;
$lastLogin = Dashboard::time_elapsed_string($user->lastvisit_at);
//$reportsLastUpdated = RawSalesDataStoreMonth::getLastUpdatedDate();
//$reportsLastUpdated = Dashboard::time_elapsed_string($reportsLastUpdated);

?>

<!-- Page Wrapper -->
<body>
<div id="page-wrapper"<?php if (Yii::app()->params['page_preloader']) { echo ' class="page-loading"'; } ?>>
    <!-- Preloader -->
    <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
    <!-- Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
    <div class="preloader themed-background-dark">
        <h1 class="push-top-bottom text-light text-center"><strong>Comparatio</strong> EDI</h1>
        <div class="inner">
            <h3 class="text-light visible-lt-ie9 visible-lt-ie10"><strong>Loading..</strong></h3>
            <div class="preloader-spinner hidden-lt-ie9 hidden-lt-ie10"></div>
        </div>
    </div>
    <!-- END Preloader -->

    <!-- Page Container -->
    <!-- In the PHP version you can set the following options from inc/config file -->
    <!--
        Available #page-container classes:

        '' (None)                                       for a full main and alternative sidebar hidden by default (> 991px)

        'sidebar-visible-lg'                            for a full main sidebar visible by default (> 991px)
        'sidebar-partial'                               for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)
        'sidebar-partial sidebar-visible-lg'            for a partial main sidebar which opens on mouse hover, visible by default (> 991px)
        'sidebar-mini sidebar-visible-lg-mini'          for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)
        'sidebar-mini sidebar-visible-lg'               for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)

        'sidebar-alt-visible-lg'                        for a full alternative sidebar visible by default (> 991px)
        'sidebar-alt-partial'                           for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)
        'sidebar-alt-partial sidebar-alt-visible-lg'    for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)

        'sidebar-partial sidebar-alt-partial'           for both sidebars partial which open on mouse hover, hidden by default (> 991px)

        'sidebar-no-animations'                         add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!

        'style-alt'                                     for an alternative main style (without it: the default style)
        'footer-fixed'                                  for a fixed footer (without it: a static footer)

        'disable-menu-autoscroll'                       add this to disable the main menu auto scrolling when opening a submenu

        'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
        'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

        'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links
    -->
    <?php
        $page_classes = '';

        if (Yii::app()->params['header'] == 'navbar-fixed-top') {
            $page_classes = 'header-fixed-top';
        } else if (Yii::app()->params['header'] == 'navbar-fixed-bottom') {
            $page_classes = 'header-fixed-bottom';
        }

        if (Yii::app()->params['sidebar']) {
            $page_classes .= (($page_classes == '') ? '' : ' ') . Yii::app()->params['sidebar'];
        }

        if (Yii::app()->params['main_style'] == 'style-alt')  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'style-alt';
        }

        if (Yii::app()->params['footer'] == 'footer-fixed')  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'footer-fixed';
        }

        if (!Yii::app()->params['menu_scroll'])  {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'disable-menu-autoscroll';
        }

        if (Yii::app()->params['cookies'] === 'enable-cookies') {
            $page_classes .= (($page_classes == '') ? '' : ' ') . 'enable-cookies';
        }
    ?>
    <div id="page-container"<?php if ($page_classes) { echo ' class="' . $page_classes . '"'; } ?>>

        <?php
            $this->renderPartial('//layouts/_menu', array());
        ?>
        <!-- Main Container -->
        <div id="main-container">
            <!-- Header -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available header.navbar classes:

                'navbar-default'            for the default light header
                'navbar-inverse'            for an alternative dark header

                'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                    'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                    'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
            -->
            <header class="navbar<?php if (Yii::app()->params['header_navbar']) { echo ' ' . Yii::app()->params['header_navbar']; } ?><?php if (Yii::app()->params['header']) { echo ' '. Yii::app()->params['header']; } ?>">
                <?php if ( Yii::app()->params['header_content'] == 'horizontal-menu' ) { // Horizontal Menu Header Content ?>
                <!-- Navbar Header -->
                <div class="navbar-header">
                    <!-- Horizontal Menu Toggle + Alternative Sidebar Toggle Button, Visible only in small screens (< 768px) -->
                    <ul class="nav navbar-nav-custom pull-right visible-xs">
                        <li>
                            <a href="javascript:void(0)" data-toggle="collapse" data-target="#horizontal-menu-collapse">Menu</a>
                        </li>
                    </ul>
                    <!-- END Horizontal Menu Toggle + Alternative Sidebar Toggle Button -->

                    <!-- Main Sidebar Toggle Button -->
                    <ul class="nav navbar-nav-custom">
                        <li>
                            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                <i class="fa fa-bars fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- END Main Sidebar Toggle Button -->
                </div>
                <?php } else { // Default Header Content  ?>
                <!-- Left Header Navigation -->
                <ul class="nav navbar-nav-custom">
                    <!-- Main Sidebar Toggle Button -->
                    <li>
                        <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                            <i class="fa fa-bars fa-fw"></i>
                        </a>
                    </li>
                    <!-- END Main Sidebar Toggle Button -->
                </ul>

                    <i id="loading-indicator" class="fa fa-circle-o-notch fa-spin" style=" color: #352738; font-size:20pt;margin-top:12px;margin-bottom:10px; display:none"></i>


                    <?php

                    foreach($this->menu as $button){
                        $this->widget(
                            'booster.widgets.TbButton',
                            array(
                                'buttonType' => isset($button['buttonType'])?$button['buttonType']:'',
                                'context' => isset($button['context'])?$button['context']:'',
                                'icon' => isset($button['icon'])?$button['icon']:'',
                                'label' => isset($button['label'])?$button['label']:'',
                                'url' => isset($button['url'][0]) ? array($button['url'][0]) : '',
                                'encodeLabel' => isset($button['encodeLabel'])?$button['encodeLabel']:'',
                                'htmlOptions' => array(
                                    'id' => isset($button['htmlOptions']['id'])?$button['htmlOptions']['id']:'',
                                    'class' => isset($button['htmlOptions']['class'])?$button['htmlOptions']['class']:'',
                                ),

                            )
                        );
                    }


                    ?>
                    <!-- END Left Header Navigation -->
                    <div class="pull-right">
                        <h3 class="nav" style="float:left !important; margin-top:10px;margin-bottom:10px;margin-right:10px;"><?php echo isset($this->title)?  $this->title: ''; ?></h3>
                        <!-- Right Header Navigation -->
                        <ul class="nav navbar-nav-custom pull-right">

                            <!-- User Dropdown -->
                            <li class="dropdown">
                                <a href="void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $baseUrl;?>/img/placeholders/avatars/avatar2.jpg" alt="avatar"> <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                    <li class="dropdown-header text-center">Account</li>
                                    <li>
                                        <a href="<?php echo $baseUrl.'/user/logout';?>"><i class="fa fa-sign-out  fa-fw pull-right"></i> Logout</a>
                                    </li>

                                </ul>
                            </li>
                            <!-- END User Dropdown -->
                        </ul>
                    </div>

                <!-- Right Header Navigation -->
                <ul class="nav navbar-nav-custom pull-right">



                    <!-- END User Dropdown -->
                </ul>
                <!-- END Right Header Navigation -->
                <?php } ?>
            </header>
            <!-- END Header -->

            <!-- Page content -->
            <div id="page-content">
                <?php

                    echo $content;
                ?>
                <!-- END PageContent -->
            </div>
            <!--             Footer -->
            <footer class="clearfix">
                <div class="pull-right">
                </div>
                <div class="pull-left">
                    <span id="year-copy"></span> &copy; <a href="http://www.comparatio.com" target="_blank">Comparatio USA</a>
                </div>
            </footer>

            <!-- END Footer -->
        </div>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</div>
<!-- END Page Wrapper -->
</body>
<!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>