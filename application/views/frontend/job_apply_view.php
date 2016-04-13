<!--banner-->
<script src='https://www.google.com/recaptcha/api.js'></script>

<div class="banner_inner">


    <div class="page_container">


        <div class="banner_text_inner">

            <div class="text_strip">

                <h3>Apply Now</h3>

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

        <a href="<?php echo site_url();?>">Home</a> > <a href="<?php echo site_url('job-listing');?>">Job Listing </a> > <a href="#">Apply Now</a>

    </div>

    <div class="clear"></div>

    <div class="main_box">
        <form method="post" enctype="multipart/form-data">

            <div class="form_box">

<?php if(isset($job_data->job_code) && isset($job_data->job_title)){?>
                <div class="div-row">

                    <div class="divCell text-form">Job Code</div>

                    <div class="divCell">

                        <input name="Job_code" type="text" value="<?php echo $job_data->job_code; ?>" readonly
                               class="field_bod"/>

                    </div>

                    <div class="divCell text-form form_left">Job Tittle</div>

                    <div class="divCell ">

                        <input name="Job_title" type="text"
                               value="<?php echo $job_data->job_title; ?>"
                               readonly class="field_bod"/>


                    </div>


                </div>
    <br/>
                <?php } ?>



                <div class="div-row">

                    <div class="divCell text-form">First Name
                        <span class="form-star">*</span>
                    </div>


                    <div class="divCell">

                        <input name="applicant_first_name" type="text" value="<?php echo set_value('applicant_first_name'); ?>" required/>
                        <?php echo form_error('applicant_first_name'); ?>

                    </div>

                    <div class="divCell text-form form_left">Last Name</div>

                    <div class="divCell">

                        <input name="applicant_last_name" type="text" value="<?php echo set_value('applicant_last_name'); ?>"/>
                        <?php echo form_error('applicant_last_name'); ?>

                    </div>

                </div>

                <br/>

                <div class="div-row">

                    <div class="divCell text-form">Email ID
                        <span class="form-star">*</span>
                    </div>

                    <div class="divCell">

                        <input name="applicant_mail" type="text" value="<?php echo set_value('applicant_mail'); ?>" required/>
                        <?php echo form_error('applicant_mail'); ?>

                    </div>

                    <div class="divCell text-form form_left">Location
                        <span class="form-star">*</span>
                    </div>

                    <div class="divCell">

                        <input name="applicant_location" type="text" value="<?php echo set_value('applicant_location'); ?>" required/>
                        <?php echo form_error('applicant_location'); ?>

                    </div>

                </div>

                <br/>

                <div class="div-row">

                    <div class="divCell text-form">Cover Letter
                        <span class="form-star">*</span>
                    </div>

                    <div class="form_text">

                        <textarea name="applicant_cover_letter" type="text" id=""
                                  class="cover-form form_text_res" required><?php echo set_value('applicant_cover_letter'); ?></textarea>
                        <?php echo form_error('applicant_cover_letter'); ?>


                    </div>

                </div>

                <br/>

                <div class="div-row form_up">

                    <div class="divCell text-form">Upload Resume
                        <span class="form-star">*</span>
                    </div>

                    <div class="divCell">


                        <input type="file" name="userfile" required/><br/>
                        <span>(Attach only doc,docx,ppt,pptx,pdf,rtf,txt and size less than 2MB)</span>

                        <?php echo form_error('applicant_resume'); ?>

                    </div>

                </div>
                <br/>

                <div class="clear"></div>

                <div class="div-row form_up">

                    <div class="divCell text-form">Security Check
                        <span class="form-star">*</span>
                    </div>

                    <div class="divCell">

                        <div class="g-recaptcha" data-sitekey="6LdxFBwTAAAAAAsJneK-OG5Ij1KMl8iqwTD44jQr"></div>
                        <?php echo form_error('recaptcha'); ?>

                    </div>

                </div>

                <br/>

                <div class="clear"></div>

                <input type="submit" value="Submit" class="button_sty">


            </div>
        </form>
        <div class="clear"></div>


    </div>


</div>

<!--main-->