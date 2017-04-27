<?php
/* @var $this JController */

if ($this->isMobile) {
    /*$cs = Yii::app()->clientScript;
    $cs->registerScript(__CLASS__ . 'table_log_form_save', '
        window.addEventListener("load", function(e) {
            setTimeout(function() { window.scrollTo(0, 1); }, 1);
        }, false);
    ');*/
}
$this->beginContent(Rights::module()->appLayout);
$this->widget('booster.widgets.TbNavbar', array(
    'fixed' => 'top',
    'fluid' => true,
    'collapse' => false,
    'headerOptions' => array('class' => 'pull-right'),
    'brand' => isset($this->title) ? '<h3 class="navbar-header">'.$this->title.'</h3>' : "",
    'brandUrl' => '#',
    'brandOptions' => array('class' => 'navbar-right'),
    'items' => array_merge(
        array(
            array(
                'class' => 'booster.widgets.TbButton',
                'buttonType' => TbButton::BUTTON_BUTTON,
                'context' => 'default',
                'icon' => 'fa fa-lg fa-bars',
                'label' => '',
                'url' => '#',
                'encodeLabel' => false,
                'htmlOptions' => array('class' => 'menu-toggle navbar-btn btn-sm',),
            ),
            '<span class="navbar-spacer"></span>',
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'context' => 'primary',
                'size' => 'small',
                'htmlOptions' => array('class' => 'dropdown navbar-btn btn-sm',),
                'buttons' => array(
                    array(
                        'encodeLabel' => false,
                        'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Rights') . '</span>',
                        'icon' => 'fa fa-lg fa-wrench',
                        'items' => array(
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'icon' => 'fa fa-paperclip',
                                'label' => Yii::t('app', 'Assignments'),
                                'url' => array('assignment/view'),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'icon' => 'fa fa-lock',
                                'label' => Yii::t('app', 'Permissions'),
                                'url' => array('authItem/permissions'),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'icon' => 'fa fa-users',
                                'label' => Yii::t('app', 'Roles'),
                                'url' => array('authItem/roles'),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'icon' => 'fa fa-tasks',
                                'label' => Yii::t('app', 'Tasks'),
                                'url' => array('authItem/tasks'),
                            ),
                            array(
                                'buttonType' => TbButton::BUTTON_LINK,
                                'icon' => 'fa fa-legal',
                                'label' => Yii::t('app', 'Operations'),
                                'url' => array('authItem/operations'),
                            ),
                        )
                    ),
                ),
            ),
        ),
        $this->menu
    ),
));
echo '<!-- navbar -->';
?>
<div class="body-wrapper">
    <?php if (!Yii::app()->user->isGuest) $this->renderPartial('//layouts/_sidebar'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php
            if (isset($this->breadcrumbs) && count($this->breadcrumbs) > 0) {
                echo '<div class="row"><div class="col-md-12">';
                $this->widget('booster.widgets.TbBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'htmlOptions' => array('class' => 'breadcrumb hidden-xs'),
                ));
                echo '</div></div>';
                echo '<!-- breadcrumbs -->';
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo $content; ?>
                </div>
            </div><!-- content -->
            <br>
            <br>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>