<!--banner-->

<div class="banner_inner">



    <div class="page_container">



        <div class="banner_text_inner">

            <div class="text_strip">

                <h3>Open Positions</h3>

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

        <a href="<?php echo site_url();?>">Home</a> > <a href="#">Open Positions </a>

    </div>

    <div class="clear"></div>

    <div class="main_box">



        <div class="search_area">

            <div class="box_area">

                <p>Fliter</p>

                <form>

                    <select class="filter_sty" name="category" id="category">
                        <option value="">Select Category</option>
                        <?php if(count($job_categories) > 0){foreach ($job_categories as $job_category) {?>

                            <option value="<?php echo $job_category->job_category_id;?>"><?php echo $job_category->job_category_title;?></option>

                        <?php } }?>
                    </select>

                    <select class="filter_sty" name="location" id="location">
                        <option value="">Select Location</option>
                        <?php if(count($job_locations) > 0){foreach ($job_locations as $job_location) {?>

                            <option value="<?php echo $job_location->job_location_id;?>"><?php echo $job_location->job_location_title;?></option>

                        <?php } }?>


                    </select>

                </form>



            </div>

        </div>





    </div>

    <div class="clear"></div>

    <div class="main_box" id="job_lists">

        <?php if (isset($jobs) && count($jobs)) { ?>
        <?php foreach ($jobs as $job) { ?>
            <div class="list_box1">

                <div class="list_circle"><p><?php echo $job->job_logo_text; ?></p></div>

                <div class="list_circle_text">

                    <a href="<?php echo site_url();?><?php echo $job->job_slug; ?>"><p> <?php echo $job->job_title; ?></p></a>

                        <span>Posted :-  <?php echo show_date($job->created_at); ?><br/>
                            Experience: <?php echo $job->job_experience; ?><br/>
                            Location: <?php echo $job->job_sub_location; ?>,<?php echo $job->job_location_title; ?>

                        </span>



                </div>

                <a href="<?php echo site_url();?><?php echo $job->job_slug; ?>"><img src="assets/frontend/images/listing_button.png"/></a>

            </div>

<?php }} ?>
    </div>

    <div class="clear"></div>


</div>





<!--main-->