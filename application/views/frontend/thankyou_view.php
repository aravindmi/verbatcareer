<!--banner-->

<div class="banner_inner">



    <div class="page_container">



        <div class="banner_text_inner">

            <div class="text_strip">

                <h3>Thank you</h3>

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

        <a href="<?php echo site_url();?>">Home</a> > <a href="<?php echo site_url('job-listing');?>">Job Listing </a> > <a href="#">Thank you</a>

    </div>

    <div class="clear"></div>

    <div class="main_box">

        <div class="thank-text">

            <h5>Thank you for submitting your resume at Verbat</h5>

            <img src="/assets/frontend/images/thank.png"/>
            <?php if(isset($applicant_id) && $applicant_id != ''){?>
            <p>Your reference # is <strong>VT<?php echo $applicant_id;?> </strong></p>
            <?php }else{ echo '<br>';} ?>
            <span>We shall contact you as soon as possible</span>

        </div>

        <div class="clear"></div>



    </div>



</div>

<!--main-->
