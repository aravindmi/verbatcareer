<!--banner-->
<div class="banner_inner">

    <div class="page_container">

        <div class="banner_text_inner">
            <div class="text_strip">
                <h3><?php echo $job_data->job_title;?> - <?php echo $job_data->job_category_title;?></h3>
            </div>
            <div class="triangle-topleft"></div>
        </div>

    </div>

</div>
<!--banner-->
<div class="clear"></div>
<!--main-->

<div class="page_container">
    <div class="page_heading">
        <a href="<?php echo site_url();?>">Home</a> > <a href="<?php echo site_url('jobs-in-technopark-trivandrum');?>">Job opening</a> > <a href="#">Job details</a>
    </div>
    <div class="clear"></div>
    <div class="main_box">
        <div class="main_descri">

            <div class="main_descri_top">
                <h4><?php echo $job_data->job_title;?></h4>

                <div class="descr_strip">
                    <div class="descr_strip_inner"></div>
                </div>

                <div class="main_descri_top1">
                    Job code: <?php echo $job_data->job_code;?><br/>
                    Experience: <?php echo $job_data->job_experience;?><br/>
                    Location: <?php echo $job_data->job_sub_location; ?>, <?php echo $job_data->job_location_title;?>
                </div>
                <div class="view">
                    <a href="<?php echo site_url();?><?php echo $job_data->job_slug; ?>/apply"><img src="/assets/frontend/images/button.png"/></a>
                </div>
            </div>

            <div class="main_descri_middle">
                <h4>Share with friends</h4>
                <div class="social">
                    <ul>
                        <li><a href="https://www.facebook.com/verbatltd" target="_blank"><img src="/assets/frontend/images/facebook_rou.png"/></a></li>

                        <li><a href="https://twitter.com/verbatltd" target="_blank"><img src="/assets/frontend/images/twitter_rou.png"/></a></li>

                        <li><a href="http://www.linkedin.com/company/verbatltd" target="_blank"><img src="/assets/frontend/images/linked_rou.png"/></a></li>

                        <li><a href="https://plus.google.com/105815758225784915519/" target="_blank"><img src="/assets/frontend/images/google_rou.png"/></a></li>
                    </ul>
                </div>
            </div>

            <div class="main_descri_bottom">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span12">

                            <div class="carousel slide" id="myCarousel">
                                <div class="carousel-inner">

                                    <?php if (isset($related_jobs) && count($related_jobs)) { ?>
                                    <?php foreach ($related_jobs as $job) { ?>
                                    <div class="item">
                                        <ul class="thumbnails">

                                            <li class="span3">
                                                <div class="caption">
                                                    <h4>Related jobs</h4>
                                                    <p><?php echo $job->job_title; ?> - <?php echo $job->job_category_title; ?><br/>
                                                        Job code: <?php echo $job->job_code; ?><br/>
                                                        Experience: <?php echo $job->job_experience; ?><br/>
                                                        Location: <?php echo $job->job_location_title; ?>
                                                    </p><br/>
                                                    <a href="<?php echo site_url();?><?php echo $job->job_slug; ?>"><img src="/assets/frontend/images/button_apply.png"/></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                        <?php }} ?>

                                </div>

                                <div class="control-box">
                                    <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
                                    <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
                                </div><!-- /.control-box -->

                            </div><!-- /#myCarousel -->

                        </div><!-- /.span12 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div>
        </div>

        <div class="main_detail">
            <div class="main_detail_fix">
                <?php echo $job_data->job_description;?>

            </div>
        </div>
    </div>

</div>
     
     