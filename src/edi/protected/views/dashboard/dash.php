<?php
/**
 * @var $this DashboardController
 */

// Title
$this->pageTitle = Yii::t('app', 'Time - Dashboard');
$this->title = 'Welcome ' .  User::model()->findByPk(Yii::app()->user->id)->profile->first_name;



$baseUrl = Yii::app()->request->baseUrl;

$cs = Yii::app()->clientScript;
$cs->registerCssFile($baseUrl . '/css/dash.css');
?>
<div id="page-header" class="clearfix">
    <div class="page-header">
        <h2>Dashboard</h2>
    </div>

</div>
<div class="row">
    <!-- .row -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- .col-md-3 -->
        <div class="panel panel-info tile panelClose panelRefresh" id="dyn_0">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Total Hours</h4>
                <div class="panel-controls panel-controls-right"><a href="#" class="panel-refresh"></a></div></div>
            <div class="panel-body pt0">
                <div class="progressbar-stats-1">
                    <div class="stats">
                        <i class="fa fa-clock-o"></i>
                        <div class="stats-number" data-from="0" data-to="76">76</div>
                    </div>
                    <div class="progress animated-bar flat transparent progress-bar-xs mb10 mt0">
                        <div class="progress-bar progress-bar-white" role="progressbar" data-transitiongoal="63" style="width: 63%;" aria-valuenow="63"></div>
                    </div>
                    <div class="comparison">
                        <p class="mb0"><i class="fa fa-arrow-circle-o-up s20 mr5 pull-left"></i> 10% up from last month</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- / .col-md-3 -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- .col-md-3 -->
        <div class="panel panel-success tile panelClose panelRefresh" id="dyn_1">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Projects</h4>
                <div class="panel-controls panel-controls-right"><a href="#" class="panel-refresh"></a></div></div>
            <div class="panel-body pt0">
                <div class="progressbar-stats-1">
                    <div class="stats">
                        <i class="fa fa-rocket"></i>
                        <div class="stats-number" data-from="0" data-to="2547">2547</div>
                    </div>
                    <div class="progress animated-bar flat transparent progress-bar-xs mb10 mt0">
                        <div class="progress-bar progress-bar-white" role="progressbar" data-transitiongoal="86" style="width: 86%;" aria-valuenow="86"></div>
                    </div>
                    <div class="comparison">
                        <p class="mb0"><i class="fa fa-arrow-circle-o-up s20 mr5 pull-left"></i> 2% up from last month</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- / .col-md-3 -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- .col-md-3 -->
        <div class="panel panel-danger tile panelClose panelRefresh" id="dyn_2">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Vacation Days</h4>
                <div class="panel-controls panel-controls-right"><a href="#" class="panel-refresh"></a></div></div>
            <div class="panel-body pt0">
                <div class="progressbar-stats-1">
                    <div class="stats">
                        <i class="fa fa-star"></i>
                        <div class="stats-number" data-from="0" data-to="78">78</div>
                    </div>
                    <div class="progress animated-bar flat transparent progress-bar-xs mb10 mt0">
                        <div class="progress-bar progress-bar-white" role="progressbar" data-transitiongoal="35" style="width: 35%;" aria-valuenow="35"></div>
                    </div>
                    <div class="comparison">
                        <p class="mb0"><i class="fa fa-arrow-circle-o-down s20 mr5 pull-left"></i> 2% down from last month</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- / .col-md-3 -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <!-- .col-md-3 -->
        <div class="panel panel-default tile panelClose panelRefresh" id="dyn_3">
            <!-- Start .panel -->
            <div class="panel-heading">
                <h4 class="panel-title">Sick Days</h4>
                <div class="panel-controls panel-controls-right"><a href="#" class="panel-refresh"></a></div></div>            <div class="panel-body pt0">
                <div class="progressbar-stats-1 dark">
                    <div class="stats">
                        <i class="fa fa-stethoscope"></i>
                        <div class="stats-number money" data-from="0" data-to="24568">24568</div>
                    </div>
                    <div class="progress animated-bar flat transparent progress-bar-xs mb10 mt0">
                        <div class="progress-bar progress-bar-white" role="progressbar" data-transitiongoal="55" style="width: 55%;" aria-valuenow="55"></div>
                    </div>
                    <div class="comparison">
                        <p class="mb0"><i class="fa fa-arrow-circle-o-down s20 mr5 pull-left"></i> 1% down from last month</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End .panel -->
    </div>
    <!-- / .col-md-3 -->
</div>