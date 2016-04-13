<!--banner-->

<div class="banner_inner">



    <div class="page_container">



        <div class="banner_text_inner">

            <div class="text_strip">

                <h3>Job Listing</h3>

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

        <a href="<?php echo site_url();?>">Home</a> > <a href="#">Job Listing </a>

    </div>

    <div class="clear"></div>

    <div class="main_box">



        <div class="search_area">

            <div class="box_area">

                <p>Fliter</p>

                <form method="post">

                    <select class="filter_sty" name="category_id" id="category">
                          <option value="">All Category</option>
                        <?php if(count($job_categories) > 0){foreach ($job_categories as $job_category) {?>

                            <option value="<?php echo $job_category->job_category_id;?>" <?php echo (is_same($job_category->job_category_id,$category_id)) ? 'selected="selected"':'';?>><?php echo $job_category->job_category_title;?></option>

                        <?php } }?>
                    </select>

                    <select class="filter_sty" name="location_id" id="location">
                        <option value="">All Location</option>
                        <?php if(count($job_locations) > 0){foreach ($job_locations as $job_location) {?>

                            <option value="<?php echo $job_location->job_location_id;?>" <?php echo (is_same($job_location->job_location_id,$location_id)) ? 'selected="selected"':'';?> ><?php echo $job_location->job_location_title;?></option>

                        <?php } }?>


                    </select>
					
					<input type="submit" value="Filter" class="button-filter">

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

                    <a href="<?php echo site_url('job-listing');?>/<?php echo $job->job_slug; ?>"><p> <?php echo $job->job_title; ?></p></a>

                        <span>Posted :  <?php echo show_date($job->created_at); ?><br/>
                            Experience: <?php echo $job->job_experience; ?><br/>
                            Location: <?php echo $job->job_location_title; ?>

                        </span>



                </div>

                <a href="<?php echo site_url('job-listing');?>/<?php echo $job->job_slug; ?>"><img src="/assets/frontend/images/listing_button.png"/></a>

            </div>

<?php }}else{echo "<p style='color:grey'>Sorry! No open position found for the filter you have selected.</p>";} ?>
    </div>

    <div class="clear"></div>


</div>





<!--main-->