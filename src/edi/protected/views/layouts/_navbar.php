<?php
/* @var $this JController */

$baseUrl = Yii::app()->baseUrl;
$isGuest = Yii::app()->user->isGuest;
$isAdmin = Yii::app()->user->checkAccess('Admin');
$isInternal = Yii::app()->user->checkAccess('Internal');
$isCustomer = Yii::app()->user->checkAccess('Customer');
$isSupplier = Yii::app()->user->checkAccess('Supplier');
$userInfo = '';
if (!$isGuest) {
    $profile = Yii::app()->getModule('user')->user()->profile;
    if (isset($profile) && isset($profile->first_name))
        $userInfo = $profile->first_name . ' ' . $profile->last_name;
    if (!$isAdmin && $isCustomer)
        $userInfo .= ' (' . $profile->customer->cu1_code . ')';
    elseif (!$isAdmin && $isSupplier)
        $userInfo .= ' (' . $profile->supplier->su1_code . ')';
}

if ($isAdmin) {
    $workspace = array(
        array(
            'url' => array('/dashboard'),
            'icon' => 'fa fa-dashboard',
            'label' => Yii::t('app', 'Sales Overview'),
            'active' => $this->isActive(array('dashboard')),
        ),
//        '---',
//        array(
//            'url' => array('/report/salesbystate'),
//            'icon' => 'fa fa-bar-chart',
//            'label' => Yii::t('app', 'Sales Report by State'),
//            'active' => $this->isActive(array('report/salesbystate')),
//        ),
//        array(
//            'url' => array('/report/salesbycustomer'),
//            'icon' => 'fa fa-bar-chart',
//            'label' => Yii::t('app', 'Sales Report by Customer'),
//            'active' => $this->isActive(array('report/salesbycustomer')),
//        ),
        '---',
        array(
            'url' => array('/customer/index'),
            'icon' => 'fa fa-users',
            'label' => Yii::t('app', 'Customers'),
            'active' => $this->isActive(array('customer')),
        ),
        array(
            'url' => array('/facility/index'),
            'icon' => 'fa fa-map-marker',
            'label' => Yii::t('app', 'Facilities'),
            'active' => $this->isActive(array('facility')),
        ),
        array(
            'url' => array('/location/index'),
            'icon' => 'fa fa-thumb-tack',
            'label' => Yii::t('app', 'Locations'),
            'active' => $this->isActive(array('location')),
        ),
        array(
            'url' => array('/item/index'),
            'icon' => 'fa fa-gift',
            'label' => Yii::t('app', 'Items'),
            'active' => $this->isActive(array('item')),
        ),
        array(
            'url' => array('/bin/index'),
            'icon' => 'fa fa-inbox',
            'label' => Yii::t('app', 'Bins'),
            'active' => $this->isActive(array('bin')),
        ),
        '---',
        array(
            'url' => array('/user'),
            'icon' => 'fa fa-user',
            'label' => Yii::t('app', 'Users'),
            'active' => $this->isActive(array('user/user',)),
        ),
        array(
            'url' => array('/user/userLog'),
            'icon' => 'fa fa-history',
            'label' => Yii::t('app', 'User Logs'),
            'active' => $this->isActive(array('user/userLog',)),
        ),
        array(
            'url' => array('/user/profileField'),
            'icon' => 'fa fa-bars',
            'label' => Yii::t('app', 'Profile Fields'),
            'active' => $this->isActive(array('user/profileField',)),
        ),
        array(
            'url' => array('/rights'),
            'icon' => 'fa fa-wrench',
            'label' => Yii::t('app', 'Rights'),
            'active' => $this->isActive(array('rights')),
        ),
    );
} elseif ($isInternal) {
    $workspace = array(
        array(
            'url' => array('/dashboard'),
            'icon' => 'fa fa-dashboard',
            'label' => Yii::t('app', 'Sales Overview'),
            'active' => $this->isActive(array('dashboard')),
        ),
        '---',
        array(
            'url' => array('/customer/index'),
            'icon' => 'fa fa-users',
            'label' => Yii::t('app', 'Customers'),
            'active' => $this->isActive(array('customer')),
        ),
        array(
            'url' => array('/facility/index'),
            'icon' => 'fa fa-map-marker',
            'label' => Yii::t('app', 'Facilities'),
            'active' => $this->isActive(array('facility')),
        ),
        array(
            'url' => array('/location/index'),
            'icon' => 'fa fa-thumb-tack',
            'label' => Yii::t('app', 'Locations'),
            'active' => $this->isActive(array('location')),
        ),
        array(
            'url' => array('/item/index'),
            'icon' => 'fa fa-gift',
            'label' => Yii::t('app', 'Items'),
            'active' => $this->isActive(array('item')),
        ),
        array(
            'url' => array('/bin/index'),
            'icon' => 'fa fa-inbox',
            'label' => Yii::t('app', 'Bins'),
            'active' => $this->isActive(array('bin')),
        ),
        '---',
        array(
            'url' => array('/user'),
            'icon' => 'fa fa-user',
            'label' => Yii::t('app', 'Users'),
            'active' => $this->isActive(array('user/user')),
        ),
        array(
            'url' => array('/user/userLog'),
            'icon' => 'fa fa-history',
            'label' => Yii::t('app', 'User Logs'),
            'active' => $this->isActive(array('user/userLog',)),
        ),
    );
} elseif ($isCustomer) {
    $workspace = array(
        array(
            'url' => array('/dashboard'),
            'icon' => 'fa fa-dashboard',
            'label' => Yii::t('app', 'Purchase Overview'),
            'active' => $this->isActive(array('dashboard')),
        ),
    );
} elseif ($isSupplier) {
    $workspace = array(
        array(
            'url' => array('/dashboard'),
            'icon' => 'fa fa-dashboard',
            'label' => Yii::t('app', 'Sales Overview'),
            'active' => $this->isActive(array('dashboard')),
        ),
    );
} else {
    $workspace = array();
}
$this->widget('booster.widgets.TbNavbar', array(
    'brand' => '<img src="'.$baseUrl.'/img/logo/logo.png" alt=""  />', //Yii::app()->name,
    //'type' => 'inverse',
    'fixed' => 'top',
    'fluid' => true,
    'collapse' => true,
    'htmlOptions' => array('style' => 'position:absolute'),
    'items' => array(
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'items' => array(
//                array(
//                    'label' => Yii::t('app', 'Home'),
//                    'url' => array('/site/index'),
//                    'active' => $this->isActive(array('site/index')),
//                ),
//                array(
//                    'label' => Yii::t('app', Yii::app()->params['appShortName']),
//                    'active' => $this->isActive(array('site/page', 'site/contact',)),
//                    'items' => array(
//                        array(
//                            'label' => Yii::t('app', 'About'),
//                            'url' => array('/site/page', 'view' => 'about'),
//                            'active' => $this->isActive(array('site/page')),
//                        ),
//                        array(
//                            'label' => Yii::t('app', 'Contact'),
//                            'url' => array('/site/contact'),
//                            'active' => $this->isActive(array('site/contact')),
//                        ),
//                    ),
//                ),
                array(
                    'label' => Yii::app()->params['workspaceLabel'],
                    'url' => array(Yii::app()->params['workspaceUrl']),
                    'active' => $this->isActive(array(
                        'dashboard', 'report', 'bin', 'item', 'location', 'facility', 'customer', 'user/user', 'user/profileField', 'user/userLog', 'rights',
                    )),
                    'visible' => !$isGuest,
                    'items' => $workspace,
                ),
//                array(
//                    'label' => Yii::t('app', 'Login'),
//                    'url' => array('/user/login'),
//                    'active' => $this->isActive(array('user/login', 'user/recovery', 'user/registration')),
//                    'visible' => $isGuest,
//                ),
                array(
                    'label' => $userInfo,
                    'active' => $this->isActive(array('user/profile/view', 'user/profile/edit', 'user/profile/changepassword', 'user/logout',)),
                    'visible' => !$isGuest,
                    'items' => array(
                        array(
                            'label' => Yii::t('app', 'View Profile'),
                            'url' => array('/user/profile'),
                            'active' => $this->isActive(array('user/profile/view', 'user/profile/edit', 'user/profile/changepassword',)),
                            'icon' => 'fa fa-user',
                        ),
                        '---',
                        array(
                            'label' => Yii::t('app', 'Logout'),
                            'url' => array('/user/logout'),
                            'active' => $this->isActive(array('user/logout')),
                            'icon' => 'fa fa-sign-out',
                        ),
                    ),
                ),
            )
        )
    )
));
?>
