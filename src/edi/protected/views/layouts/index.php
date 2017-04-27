<!DOCTYPE html>
<html xml:lang="en" lang="en">
    <head>
        <?php $baseUrl = Yii::app()->baseUrl; ?>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- Icons -->
        <link rel="shortcut icon" href="<?php echo $baseUrl . '/img/logo/nuventory-icon.png'; ?>">
        <link rel="apple-touch-icon" href="<?php echo $baseUrl . '/img/logo/nuventory-icon.png'; ?>" sizes="180x180">

        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/main.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/js/sweetalert/dist/sweetalert.css'; ?>" />
        <script src="<?php echo $baseUrl . '/js/sweetalert/dist/sweetalert.min.js'; ?>"></script>

        <!-- Remember to include excanvas for IE8 chart support -->

        <!--[if IE 8]><!--<script src="js/helpers/excanvas.min.js"></script>--><![endif]
        <script src="<?php echo $baseUrl . '/js/dash/helpers/excanvas.min.js'; ?>"></script>

        <?php //include 'inc/template_scripts.php'; ?>

        <!-- Google Maps API + Gmaps Plugin, must be loaded in the page you would like to use maps -->
        <script src="//maps.google.com/maps/api/js"></script>
<!--            <script src="js/helpers/gmaps.min.js"></script>-->
        <script src="<?php echo $baseUrl . '/js/dash/helpers/gmaps.min.js'; ?>"></script>


        <!-- Load and execute javascript code used only in this page -->
        <script src="<?php echo $baseUrl . '/js/dash/pages/index.js'; ?>"></script>
<!---->
<!--        <script>$(function(){ Index.init(); });</script>-->

        <script src="<?php echo $baseUrl . '/js/pace.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/app.plugin.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/app.data.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/sparkline/jquery.sparkline.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/easypiechart/jquery.easy-pie-chart.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/flot/jquery.flot.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/flot/jquery.flot.tooltip.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/flot/jquery.flot.resize.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/flot/jquery.flot.orderBars.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/flot/jquery.flot.pie.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/Chart.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/moment.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/daterangepicker/daterangepicker.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/highcharts.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/jBox/jbox.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/highcharts/data.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/highcharts/drilldown.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/charts/highcharts/exporting.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/dash/plugins.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/dash/app.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/dash/pages/widgetsStats.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/backstretch.min.js'; ?>"></script>
        <script src="<?php echo $baseUrl . '/js/datatables/jquery.dataTables.min.js';?>"></script>
        <!-- Modernizr (browser feature detection library) & Respond.js (enables responsive CSS code on browsers that don't support it, eg IE8) -->
<!--        <script src="--><?php //echo $baseUrl?><!--/dashboard/js/vendor/modernizr-respond.min.js"></script>-->



        <!-- Stylesheets -->

        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/dash/plugins.css'; ?>"/>

        <!-- Bootstrap is included in its original form, unaltered -->
        <!--        <link rel="stylesheet" href="--><?php //echo $baseUrl?><!--/css/dash/bootstrap.min.css">-->

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo $baseUrl ?>/css/dash/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/dash/main.css'; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/font.css'; ?>"/>
        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/dash/themes.css'; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/css/dashcss/font-awesome.min.css'; ?>"/>

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->
        <?php if (Yii::app()->params['theme']) { ?><link id="theme-link" rel="stylesheet" href="<?php echo $baseUrl ?>/css/dash/themes/<?php echo Yii::app()->params['theme']; ?>.css"><?php } ?>


        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/js/jBox/jbox.css'; ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/js/daterangepicker/daterangepicker.css'; ?>"/>
        <?php
            Yii::app()->clientScript->registerScript(__CLASS__ . '-site-js', '
                //MAIN NOTIFIER METHOD
                function notifyUser(message){
                    var options = {
                        title: "Heads Up!",
                        content: message,
                        offset:{
                        x:13,
                        y:45
                        },
                        closeOnClick:"body",
                    };
                    new jBox("Notice", options);
                }
            ');
        ?>
    </head>

    <?php
        echo $content;
    ?>


