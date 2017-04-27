<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$this->layout = '//layouts/column1';
$baseUrl = Yii::app()->request->baseUrl;
?>

<div id="main-carousel" class="carousel">
    <ol class="carousel-indicators">
        <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#main-carousel" data-slide-to="1"></li>
        <li data-target="#main-carousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <img class="carousel-background" src="<?php echo $baseUrl . '/images/vector/bg2.jpg'; ?>" alt="" />
            <div class="carousel-caption">
                <h4>Welcome to <?php echo Yii::app()->params['companyName']; ?> EDI!</h4>
            </div>
        </div>
        <div class="item">
            <img class="carousel-background" src="<?php echo $baseUrl . '/images/vector/bg3.jpg'; ?>" alt="" />
            <div class="carousel-caption">
                <h4>Welcome to <?php echo Yii::app()->params['companyName']; ?> EDI!</h4>
            </div>
        </div>
        <div class="item">
            <img class="carousel-background" src="<?php echo $baseUrl . '/images/vector/bg4.jpg'; ?>" alt="" />
            <div class="carousel-caption">
                <h4>Welcome to <?php echo Yii::app()->params['companyName']; ?> EDI!</h4>
            </div>
        </div>
    </div>
    <a class="carousel-control left" href="#main-carousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#main-carousel" data-slide="next">&rsaquo;</a>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('#main-carousel').carousel({interval: 4000});
    });
</script>

<div class="container">
    <div class="container-fluid"></div>
    <div class="footer row">
        <div class="pull-left">
            <?php echo Yii::app()->params['companyAddress1']; ?>, <?php echo Yii::app()->params['companyAddress2']; ?><br>
            <?php echo Yii::app()->params['companyCity']; ?>, <?php echo Yii::app()->params['companyState']; ?> <?php echo Yii::app()->params['companyPostalCode']; ?><br>
            <abbr title="Phone">P:</abbr> <?php echo Yii::app()->params['companyPhone']; ?>, <abbr title="Fax">F:</abbr> <?php echo Yii::app()->params['companyFax']; ?><br>
        </div>
        <div class="copyright pull-right">
            Copyright &copy; <?php echo date('Y'); ?> by <a href="<?php echo Yii::app()->params['companyURL']; ?>"><?php echo Yii::app()->params['companyName']; ?></a><br>
            All Rights Reserved.
        </div>
        </footer><!-- footer -->
    </div>
</div>