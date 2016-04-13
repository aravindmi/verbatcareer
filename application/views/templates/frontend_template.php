<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta name="description" content="<?php if(isset($seo_description)){echo $seo_description;}else{echo "Software Development Companies in India | Kerala | Jobs";}?>">

    <meta name="Robots" content="noindex, nofollow, default" />


    <title><?php if(isset($title)){echo $title;}else{echo "Software Development Companies in India | Kerala | Jobs";}?></title>
    <link rel="shortcut icon" href="/assets/frontend/images/favicon.ico" />


    <!--[if lt IE 9]>

    <script src="/assets/frontend/js/html5shiv.min.js"></script>

    <script src="/assets/frontend/js/respond.min.js"></script>

    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css' />

    <link rel="stylesheet" href="/assets/frontend/css/styles.css">

    <link href="/assets/frontend/css/responsive.css" rel="stylesheet"/>

<?php if(isset($related_jobs)){?>

    <link rel="stylesheet" href="/assets/frontend/css/style-slider.css">
    <link rel="stylesheet" href="/assets/frontend/css/resposive-slider.css">
<?php } ?>
</head>

<body>



<header>

    <!--header-->

    <div class="page_container">

        <div class="logo">

            <a href="/"><img src="/assets/frontend/images/logo.gif" alt="Verbat Logo" /></a>

        </div><!--logo-->

        <div class="logo_head">

            <p>CAREERS</p>

        </div>

        <div class="head_right">

            <a href="<?php echo site_url();?>">Home</a>  &nbsp;|&nbsp;

            <a href="http://www.verbat.com/" target="_blank">About Verbat</a>  &nbsp;|&nbsp;

            <a href="http://www.verbat.com/contact/global-offices.aspx" target="_blank">Our Global Presence</a>

        </div>

    </div>



    <div class="clear"></div>



    <div class="header_strip"></div>

    <!--header-->

</header>

<div class="clear"></div>

<?php echo $this->ci_alerts->display('error'); ?><?php echo $this->ci_alerts->display('success'); ?>
<!--main container-->

<?php
if (isset($page)) {
    $this->load->view($page);
} else {
    echo $this->config->item('SITE_NAME');
}
?>


<!--main container2-->

<div class="clear"></div>

<br/>

<!--footer-->

<footer>

    <div class="page_container">

        <p class="footer_copy">© 1999-2016 Verbat Technologies. All Rights Reserved</p>

        <p class="footer_copy foot_second"><a href="http://www.verbat.com/terms/privacy-policy.aspx" target="_blank">Privacy Policy </a>|

            <a href="http://www.verbat.com/terms/cookie-policy.aspx" target="_blank">Cookie Policy</a>

        </p>

    </div>

</footer>

<!--footer-->




<!-- jQuery -->
<script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/js/bootstrap.min.js'></script>
<script>
    $(document).ready(function() {

        $('.carousel').find('.item').first().addClass('active');
        $('.carousel').carousel({
            interval: 6000
        })
    });
</script>
</body>

</html>