<?php
/* @var $this ProfileController
 * @var $model User
 * @var $profile Profile
 */

// Title
$this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Profile");
$this->title = Yii::t('app', 'Profile');
// Breadcrumbs
$this->breadcrumbs = array(
    UserModule::t("Profile"),
);
// Menus
$this->menu = array_merge($this->menu, array(
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'success',
        'icon' => 'fa fa-user fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Update') . '</span>',
        'url' => array('update'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'success',
        'icon' => 'fa fa-key fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Change Password') . '</span>',
        'url' => array('changepassword'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
    array(
        'class' => 'booster.widgets.TbButton',
        'buttonType' => TbButton::BUTTON_LINK,
        'context' => 'danger',
        'icon' => 'fa fa-sign-out fa-lg',
        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Logout') . '</span>',
        'url' => array('/user/logout'),
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'navbar-btn btn-sm',),
    ),
));
// UIs
if (Yii::app()->user->hasFlash('profileMessage')) {
    Yii::app()->user->setFlash('info', Yii::app()->user->getFlash('profileMessage'));
    $this->widget('booster.widgets.TbAlert', array(
        'alerts' => array(
            'info' => array('fade' => true, 'closeText' => '×'), 
        ),
    ));
}
$this->beginWidget('booster.widgets.TbPanel', array(
    'context' => 'info',
    'title' => $model->email,
    'headerIcon' => 'fa fa-user fa-lg',
));
$attributes = array(
    'username',
    'email',
);
$roles = Rights::getAssignedRoles($model->id, true);
$showLocation = true;
if ($roles === null || count($roles) == 0)
    $showLocation = false;
else {
    $roles = array_keys($roles);
    foreach ($roles as $role) {
        if ($role == 'Inactive')
            $showLocation = false;
    }
}
$user_type = $model->profile->user_type;
$profileFields = ProfileField::model()->forOwner()->sort()->findAll();
if ($profileFields) {
    foreach ($profileFields as $field) {
        $addField = false;
        if ($user_type == User::TYPE_CUSTOMER) {
            if ($field->varname !== 'su1_id')
                $addField = true;
        } elseif ($user_type == User::TYPE_SUPPLIER) {
            if ($field->varname !== 'cu1_id')
                $addField = true;
        } else {
            if ($field->varname !== 'cu1_id' && $field->varname !== 'su1_id')
                $addField = true;
        }
        if ($field->varname == 'lo1_id' && !$showLocation)
            $addField = false;
        if ($addField)
            array_push($attributes, array(
                'label' => UserModule::t($field->title),
                'name' => $field->varname,
                'type' => 'raw',
                'value' => (
                $field->widgetView($model->profile) ?
                        $field->widgetView($model->profile) : (
                        $field->range ?
                                Profile::range($field->range, $model->profile->getAttribute($field->varname)) :
                                $model->profile->getAttribute($field->varname)
                        )
                ),
            ));
    }
}
array_push($attributes, array(
    'name' => 'create_at',
    'value' => ($model->create_at == '' || $model->create_at == '0000-00-00 00:00:00' ? '' : date('m/d/Y h:i a', strtotime($model->create_at))),
        ), array(
    'name' => 'lastvisit_at',
    'value' => ($model->lastvisit_at == '' || $model->lastvisit_at == '0000-00-00 00:00:00' ? UserModule::t('Not visited') : date('m/d/Y h:i a', strtotime($model->lastvisit_at))),
        )
);
$this->widget('booster.widgets.TbDetailView', array(
    'type' => 'striped',
    'data' => $model,
    'attributes' => $attributes,
));
$this->endWidget();
