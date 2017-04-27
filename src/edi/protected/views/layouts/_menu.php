<?php

$baseUrl = Yii::app()->baseUrl;
$isGuest = Yii::app()->user->isGuest;
$isAdmin = Yii::app()->user->checkAccess('Admin');
$isInternal = Yii::app()->user->checkAccess('Internal');
$isCustomer = Yii::app()->user->checkAccess('Customer');
$isShopManager = Yii::app()->user->checkAccess('ShopManager');
$isStandardUser = Yii::app()->user->checkAccess('StandardUser');
$isSupplier = Yii::app()->user->checkAccess('Supplier');

$user = User::model()->findByPk(Yii::app()->user->id);
$lastLogin = $user->lastvisit_at;
$lastLogin = Dashboard::time_elapsed_string($user->lastvisit_at);

$primary_nav = array(
    array(
        'name'  => 'Dashboard',
        'url'   => $baseUrl.'/dashboard/index',
        'icon'  => 'fa fa-home',
        'active' => $this->isActive(array('dashboard')),
        'visible' => $isAdmin || $isInternal || $isCustomer || $isShopManager || $isStandardUser || $isSupplier,
    ),
    array(
        'name'  => 'Sections',
        'opt'   =>
            '<a href="javascript:void(0)" data-toggle="tooltip" title="The main areas for Time."><i class="gi gi-lightbulb"></i></a>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'EDI Transactions',
        'url'   => $baseUrl.'/edi',
        'icon'  => 'fa fa-exchange',
        'active' => $this->isActive(array('edi/index', 'edi/create', 'edi/view', 'edi/update',)),
        'visible' => true,
    ),
    array(
        'name'  => 'Vendors',
        'url'   => $baseUrl.'/vendor',
        'icon'  => 'fa fa-building',
        'active' => $this->isActive(array('vendor/index', 'vendor/create', 'vendor/view', 'vendor/update',)),
        'visible' => true,
    ),
    array(
        'name'  => 'Customers',
        'url'   => $baseUrl.'/customer_EDI',
        'icon'  => 'fa fa-users',
        'active' => $this->isActive(array('customer_EDI/index', 'customer_EDI/create', 'customer_EDI/view', 'customer_EDI/update',)),
        'visible' => true,
    ),
    array(
        'name'  => 'Admin',
        'opt'   =>
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Admin functions for the system."><i class="gi gi-lightbulb"></i></a>',
        'url'   => 'header',
        'visible' => true,
    ),
    array(
        'name'  => 'Account Profile',
        'url'   => $baseUrl.'/user/profile',
        'icon'  => 'fa fa-user-plus',
        'active' => $this->isActive(array('user/profileField',)),
//        'visible' => $isAdmin,
        'visible' => true,
    ),
    array(
        'name'  => 'Rights',
        'url'   => $baseUrl.'/rights',
        'icon'  => 'fa fa-wrench',
        'visible' => $isInternal,
        'active' => $this->isActive(array('rights')),
    ),
    array(
        'name'  => 'Users',
        'url'   => $baseUrl.'/user/',
        'icon'  => 'fa fa-user',
        'active' => $this->isActive(array('user/user/index', 'user/user/create', 'user/user/view', 'user/user/update',)),
//        'visible' => $isAdmin,
        'visible' => true,
    ),
    array(
        'name'  => 'User Logs',
        'url'   => $baseUrl.'/user/userLog',
        'icon'  => 'fa fa-history',
        'active' => $this->isActive(array('user/userLog/index',)),
//        'visible' => $isAdmin,
        'visible' => true,
    ),
    array(
        'name'  => 'Links',
        'opt'   =>
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Convenient external link(s)."><i class="gi gi-lightbulb"></i></a>',
        'url'   => 'header',
    ),
    array(
        'name'  => 'Comparatio.com',
        'url'   => 'http://comparatio.com',
        'icon'  => 'gi gi-link',
        'visible' => $isAdmin || $isInternal || $isCustomer || $isShopManager || $isStandardUser || $isSupplier,
    ),

);
?>

<!-- Main Sidebar -->
<div id="sidebar">
    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Brand -->
            <a href="<?php echo $baseUrl?>" class="sidebar-brand">
                <i class="gi gi-flash"></i>
                <span class="sidebar-nav-mini-hide" style=""><strong>Comparatio</strong> EDI</span>
            </a>
            <!-- END Brand -->

            <!-- User Info -->
            <div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
                <div class="sidebar-user-avatar">
                    <a href="page_ready_user_profile.php">
                        <img src="<?php echo $baseUrl;?>/img/placeholders/avatars/avatar2.jpg" alt="avatar">
                    </a>
                </div>
                <div class="sidebar-user-name"><?php echo $user->getFullname();?></div>
                <div class="sidebar-user-links">
                    <a href="<?php echo $baseUrl.'/user/profile'?>" data-toggle="tooltip" data-placement="bottom" title="Profile"><i class="gi gi-user"></i></a>
                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="gi gi-envelope"></i></a>
                    <!-- Opens the user settings modal that can be found at the bottom of each page (page_footer.php in PHP version) -->
                    <a href="javascript:void(0)" class="enable-tooltip" data-placement="bottom" title="Settings"><i class="gi gi-cogwheel"></i></a>
                    <a href="<?php echo $baseUrl.'/user/logout';?>" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out"></i></a>
                </div>
            </div>
            <!-- END User Info -->

            <?php if ($primary_nav) { ?>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <?php foreach( $primary_nav as $key => $link ) {
                        $link_class = '';
                        $li_active  = '';
                        $menu_link  = '';

                        // Get 1st level link's vital info
                        $url        = (isset($link['url']) && $link['url']) ? $link['url'] : '#';
                        $active     = (isset($link['active']) && ($link['active']==true) ? '  active' : '');
                        $visible     = (isset($link['visible']) && ($link['visible']==true)) ? '' : ' hidden';
                        $disabled     = (isset($link['disabled']) && ($link['disabled']==true)) ? ' menu-disabled' : '';
                        $icon       = (isset($link['icon']) && $link['icon']) ? '<i class="' . $link['icon'] . ' sidebar-nav-icon"></i>' : '';

                        // Check if the link has a submenu
                        if (isset($link['sub']) && $link['sub']) {
                            // Since it has a submenu, we need to check if we have to add the class active
                            // to its parent li element (only if a 2nd or 3rd level link is active)
                            foreach ($link['sub'] as $sub_link) {
                                if (in_array(Yii::app()->params['active_page'], $sub_link)) {
                                    $li_active = ' class="active"';
                                    break;
                                }

                                // 3rd level links
                                if (isset($sub_link['sub']) && $sub_link['sub']) {
                                    foreach ($sub_link['sub'] as $sub2_link) {
                                        if (in_array(Yii::app()->params['active_page'], $sub2_link)) {
                                            $li_active = ' class="active"';
                                            break;
                                        }
                                    }
                                }
                            }

                            $menu_link = 'sidebar-nav-menu';
                        }

                        // Create the class attribute for our link
                        //if ($menu_link || $active || $visible) {
                        $link_class = ' class="'. $menu_link . $visible . $active . $disabled .  '"';
                        //}
                        ?>
                        <?php if ($url == 'header') { // if it is a header and not a link ?>
                            <li class="sidebar-header">
                                <?php if (isset($link['opt']) && $link['opt']) { // If the header has options set ?>
                                    <span class="sidebar-header-options clearfix"><?php echo $link['opt']; ?></span>
                                <?php } ?>
                                <span class="sidebar-header-title"><?php echo $link['name']; ?></span>
                            </li>
                        <?php } else { // If it is a link ?>
                            <li<?php echo $li_active; ?>>
                                <a href="<?php echo $url; ?>"<?php echo $link_class; ?>><?php if (isset($link['sub']) && $link['sub']) { // if the link has a submenu ?><i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><?php } echo $icon; ?><span class="sidebar-nav-mini-hide"><?php echo $link['name']; ?></span></a>
                                <?php if (isset($link['sub']) && $link['sub']) { // if the link has a submenu ?>
                                    <ul>
                                        <?php foreach ($link['sub'] as $sub_link) {
                                            $link_class = '';
                                            $li_active = '';
                                            $submenu_link = '';

                                            // Get 2nd level link's vital info
                                            $url        = (isset($sub_link['url']) && $sub_link['url']) ? $sub_link['url'] : '#';
                                            $active     = (isset($sub_link['url']) && (Yii::app()->params['active_page'] == $sub_link['url'])) ? ' active' : '';

                                            // Check if the link has a submenu
                                            if (isset($sub_link['sub']) && $sub_link['sub']) {
                                                // Since it has a submenu, we need to check if we have to add the class active
                                                // to its parent li element (only if a 3rd level link is active)
                                                foreach ($sub_link['sub'] as $sub2_link) {
                                                    if (in_array(Yii::app()->params['active_page'], $sub2_link)) {
                                                        $li_active = ' class="active"';
                                                        break;
                                                    }
                                                }

                                                $submenu_link = 'sidebar-nav-submenu';
                                            }

                                            if ($submenu_link || $active) {
                                                $link_class = ' class="'. $submenu_link . $active .'"';
                                            }
                                            ?>
                                            <li<?php echo $li_active; ?>>
                                                <a href="<?php echo $url; ?>"<?php echo $link_class; ?>><?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?><i class="fa fa-angle-left sidebar-nav-indicator"></i><?php } echo $sub_link['name']; ?></a>
                                                <?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?>
                                                    <ul>
                                                        <?php foreach ($sub_link['sub'] as $sub2_link) {
                                                            // Get 3rd level link's vital info
                                                            $url    = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                                            $active = (isset($sub2_link['url']) && (Yii::app()->params['active_page'] == $sub2_link['url'])) ? ' class="active"' : '';
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo $url; ?>"<?php echo $active ?>><?php echo $sub2_link['name']; ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <!-- END Sidebar Navigation -->
            <?php } ?>

            <!-- Sidebar Notifications -->
            <div class="sidebar-header sidebar-nav-mini-hide">
                        <span class="sidebar-header-options clearfix">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Refresh"><i class="gi gi-refresh"></i></a>
                        </span>
                <span class="sidebar-header-title">Activity</span>
            </div>
            <div class="sidebar-section sidebar-nav-mini-hide">

                <div class="alert alert-info alert-alt">
                    <small><?php echo $lastLogin;?></small><br>
                    <i class="fa fa-arrow-up fa-fw"></i> Last Login
                </div>
            </div>
            <!-- END Sidebar Notifications -->
        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
</div>
<!-- END Main Sidebar -->