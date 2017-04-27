<?php /* @var $this JController */ ?>
<?php $this->beginContent('//layouts/index');

?>

<div class="workspace-layout">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($this->breadcrumbs) && count($this->breadcrumbs) > 0) {
                    $this->widget('booster.widgets.TbBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                    echo '<!-- breadcrumbs -->';
                }
                echo '<br>';
                if ((isset($this->menu) && count($this->menu) > 0) || (isset($this->menu2) && count($this->menu2) > 0) || (isset($this->menu3) && count($this->menu3) > 0)) : ?>
                <div class="top-menu pull-left">
                    <div class="btn-toolbar">
                        <?php
                        if (isset($this->menu))
                            $this->widget('booster.widgets.TbButtonGroup', array(
                                'context' => 'primary',
                                'buttons' => $this->menu,
                                'htmlOptions' => array('class' => 'operations btn-group-sm'),
                            ));
                        if (isset($this->menu2))
                            $this->widget('booster.widgets.TbButtonGroup', array(
                                'context' => 'success',
                                'buttons' => $this->menu2,
                                'htmlOptions' => array('class' => 'operations btn-group-sm'),
                            ));
                        if (isset($this->menu3))
                            $this->widget('booster.widgets.TbButtonGroup', array(
                                'context' => 'warning',
                                'buttons' => $this->menu3,
                                'htmlOptions' => array('class' => 'operations btn-group-sm'),
                            ));
                        ?>
                    </div>
                </div><!-- top-menu -->
                <?php endif; ?>
                <?php echo $content; ?><!-- content -->
            </div>
        </div>
        <?php
        if (false) {
            echo '<footer class="row">
                <div class="pull-left">' .
                    Yii::app()->params['companyAddress1'] . ', ' . Yii::app()->params['companyAddress2'] . '<br/>' .
                    Yii::app()->params['companyCity'] . ', ' . Yii::app()->params['companyState'] . ' ' . Yii::app()->params['companyPostalCode'] . '<br/>' .
                    '<abbr title="Phone">P:</abbr> ' . Yii::app()->params['companyPhone'] . ', <abbr title="Fax">F:</abbr> ' . Yii::app()->params['companyFax'] . '<br/>' .
                '</div>' .
                '<div class="copyright pull-right">' .
                    'Copyright &copy; ' . date('Y') . ' by <a href="' . Yii::app()->params['companyURL'] . '">' . Yii::app()->params['companyName'] . '</a><br>' .
                    'All Rights Reserved.' .
                '</div>' .
            '</footer>';
        }
        ?>
        <br>
        <br>
    </div>
</div>



<?php $this->endContent(); ?>