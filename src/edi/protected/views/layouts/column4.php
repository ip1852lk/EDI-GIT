<head>
    <link rel="stylesheet" href="/edi/assets/Remodal-1.1.0/dist/remodal.css">
    <link rel="stylesheet" href="/edi/assets/Remodal-1.1.0/dist/remodal-default-theme.css">
</head>

<body>
<script src="/edi/assets/Remodal-1.1.0/dist/remodal.min.js"></script>
</body>
<?php
///* @var $this JController */
$baseUrl = Yii::app()->baseUrl;
//if ($this->isMobile) {
//    /*$cs = Yii::app()->clientScript;
//    $cs->registerScript(__CLASS__ . 'table_log_form_save', '
//        window.addEventListener("load", function(e) {
//            setTimeout(function() { window.scrollTo(0, 1); }, 1);
//        }, false);
//    ');*/
//}

$this->beginContent('//layouts/index');
if (!Yii::app()->user->isGuest || count($this->menu) > 0 || strlen($this->title) > 0) {

}
?>
    <?php if (!Yii::app()->user->isGuest) {
//        $this->renderPartial('//layouts/template_start', array());
        ?>
        <div class="remodal-bg">
            <?php
        $this->renderPartial('//layouts/page_head', array('content'=>$content));
            ?>
        </div>
<?php
    }
    ?>

<!--    <div style="background-color:white;min-height: 100%; /* min. height for IE */overflow:scroll !important; /* FF scroll-bar */">-->
        <?php
//            echo $content;
        ?>
<!--    </div>-->
<?php
    if (!Yii::app()->user->isGuest) {
//    $this->renderPartial('//layouts/page_footer', array());
    }

$this->endContent();
?>



