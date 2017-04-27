<?php
$baseUrl = Yii::app()->baseUrl;
//Yii::import('booster.widgets.TbButton');
//if(isset($_GET['Edi'])) {
//    $Edi->attributes = $_GET['Edi'];
//    $Edi->edi_status_search = $Edi->getStatusLabel($_GET['Edi']['edi_status_search']);
//}
?>

<script src="<?php echo $baseUrl . '/js/datatables/jquery.dataTables.min.js'; ?>" type="text/javascript"></script>

<!-- Dashboard Header -->
<!-- For an image header add the class 'content-header-media' and an image as in the following example -->
<div class="content-header content-header-media">
    <div class="header-section">
        <div class="row">
            <!-- Main Title (hidden on small devices for the statistics to fit) -->
            <div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
                <h1>Welcome <strong><?php echo $data['firstName'];?></php></strong>
                    <br><small><?php echo $data['companyName'];?></php></small>
                </h1>
            </div>
            <!-- END Main Title -->

            <!-- Top Stats -->
            <div class="col-md-8 col-lg-6">
                <div class="row text-center">
                    <!--                        <div class="col-xs-4 col-sm-3">-->
                    <!--                            <h2 class="animation-hatch">-->
                    <!--                                <strong>--><?php //echo $data['grossProfPercAvg'];?><!--</strong >%<br>-->
                    <!--                                <small><i class="fa fa-dollar"></i> Gross Profit</small>-->
                    <!--                            </h2>-->
                    <!--                        </div>-->
                    <!--                        <div class="col-xs-4 col-sm-3">-->
                    <!--                            <h2 class="animation-hatch">-->
                    <!--                                <strong>--><?php //echo $data['numOfShops'];?><!--</strong><br>-->
                    <!--                                <small><i class="fa fa-building-o"></i> Shops</small>-->
                    <!--                            </h2>-->
                    <!--                        </div>-->
                    <!-- We hide the last stat to fit the other 3 on small devices -->
                    <div class="col-sm-3 ">
                        <h2 class="animation-hatch">
                            <strong><?php echo isset(Yii::app()->session['degrees'])? Yii::app()->session['degrees']:'';?>&deg; F</strong><br>
                            <small><i class="fa fa-map-marker"></i> <?php echo $data['city'];?></small>
                        </h2>
                    </div>
                </div>
            </div>
            <!-- END Top Stats -->
        </div>
    </div>
    <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
    <img src="<?php echo $baseUrl;?>/img/headers/article_header.jpg" alt="header image">
</div>
<div class="content-header">
    <ul class="nav-horizontal text-center">
        <li class="active">
            <a href="<?php echo $baseUrl.'/dashboard';?>"><i class="fa fa-home"></i> Dashboard</a>
        </li>
        <li>
            <a href="<?php echo $baseUrl.'/edi';?>"><i class="fa fa-bars"></i> EDI</a>
        </li>
        <li>
            <a href="<?php echo $baseUrl.'/vendor';?>"><i class="fa fa-truck"></i> Vendor</a>
        </li>
        <li>
            <a href="<?php echo $baseUrl.'/customer_EDI';?>"><i class="fa fa-bar-chart"></i> Customer</a>
        </li>
    </ul>
</div>

<!-- Graphs go here -->
<div class="row">
<div class="hidden-xs hidden-sm hidden-md col-lg-6">
    <div class="panel panel-info">
        <div id="doughnutContainer" style="min-width: 256px; height: 256px; margin: 0 auto"></div>
    </div>
</div>
<div class="hidden-xs hidden-sm hidden-md col-lg-6">
    <div class="panel panel-info">
        <div id="pieContainer" style="min-width: 256px; height: 256px; margin: 0 auto"></div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
        <div id="container" style="min-width: 256px; height: 256px; margin: 0 auto"></div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Latest Orders Block -->
        <div class="block" style="overflow: auto;">
            <!-- Latest Orders Title -->
            <div class="block-title">
                <h2><strong>Recent</strong> Records</h2>
            </div>
            <!-- END Latest Orders Title -->

            <!-- Latest Orders Content -->
            <?php

            $this->widget('booster.widgets.TbButton', array(
//                    'class' => 'booster.widgets.TbButton',
                    'buttonType' => TbButton::BUTTON_BUTTON,
                    'context' => 'primary',
                    'icon' => 'fa fa-repeat fa-lg',
                    'label' => '<span class="hidden-xs hidden-sm">' . Yii::t('app', 'Resend Checked') . '</span>',
                    'url' => '#',
                    'encodeLabel' => false,
                    'htmlOptions' => array('id' => 'edi-resend-checked-btn', 'class'=>' navbar-btn btn-sm disabled'),
                ));
            echo $this->renderPartial('//edi/_grid', array(
                'model' => $data['model'],
                'allUserRecentRecords' => true,
            ),true);
            ?>
            <br>
            <!-- END Latest Orders Content -->
        </div>
        <!-- END Latest Orders Block -->
    </div>
</div>

<?php

$chartData = Edi::getChartData();
$pieChartData = Edi::getPieChartData();
$dateString = Edi::getDates();
$inOutData = Edi::getSuccessFailedData();

$cs = Yii::app()->clientScript;
$cs->registerScript(__CLASS__ . '_dashboard', '

$(document).ready(function(){

    $("#container").highcharts({
        chart: {
            type: "column"
        },
        title: {
            text: "EDI Transactions Per Day"
        },
        xAxis: {
            type: "category"
            //categories: [' . $dateString . '],
        },
        yAxis: {
            min: 0,
            title: {
                text: "Number of Transactions"
            }
        },
        tooltip: {
            headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
            pointFormat: \'<tr><td style="color:{series.color};padding:0">{series.name}: </td>\' +
                \'<td style="padding:0"><b>{point.y:.1f} transactions</b></td></tr>\',
            footerFormat: \'</table>\',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: \'EDI\',
            data: [{' . $chartData[0] .'}]
        }],
        drilldown: {
            series: [' . $chartData[1] . ']
        }
    });

    $(\'#pieContainer\').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            type: \'pie\'
        },
        title: {
            text: \'EDI Transactions Per Trading Partner\'
        },
        tooltip: {
            pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: \'pointer\',
                dataLabels: {
                    enabled: true,
                    format: \'<b>{point.name}</b>: {point.percentage:.1f} %\',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || \'black\'
                    }
                }
            }
        },
        series: [{
            name: \'Transactions\',
            colorByPoint: true,
            data: [' . $pieChartData . ']
        }]
    });

    $(\'#doughnutContainer\').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: \'Inbound<br>/<br>Outbound\',
            align: \'center\',
            verticalAlign: \'middle\',
            y: 40
        },
        tooltip: {
            pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    style: {
                        fontWeight: \'bold\',
                        color: \'white\'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: [\'50%\', \'75%\']
            }
        },
        series: [{
            type: \'pie\',
            name: \'Transactions\',
            innerSize: \'70%\',
            data: [' . $inOutData . ']
        }]
    });
});
');
?>
