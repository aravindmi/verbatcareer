<h1 class="page-header">Create new opportunity</h1>
<div class="panel panel-default">
    <div class="panel-heading">
        Opportunity Details

    </div>
    <div class="panel-body">
        <!-- BEGIN FORM-->
        <form class="horizontal-form"  method="post">
            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" placeholder="Job Title" class="form-control"
                                   name="job_title" id="job_title" value="<?php echo set_value('job_title'); ?>" required>
                            <?php echo form_error('job_title'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">URL Slug</label>
                            <input type="text" placeholder="URL Slug" class="form-control"
                                   name="job_slug" id="job_slug" value="<?php echo set_value('job_slug'); ?>"  required>
                            <?php echo form_error('job_slug'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Code</label>
                            <input type="text" placeholder="Job Code" class="form-control"
                                   name="job_code" value="<?php echo set_value('job_code'); ?>"  required>
                            <?php echo form_error('job_code'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Category</label>


                            <select class="form-control" name="job_category_id">
                                <option value="" <?php echo  set_select('job_category_id', ''); ?>>Select Category</option>

                                <?php if(count($job_categories) > 0){foreach ($job_categories as $job_category) {?>

                                    <option value="<?php echo $job_category->job_category_id;?>"  <?php echo  set_select('job_category_id', $job_category->job_category_id); ?>><?php echo $job_category->job_category_title;?></option>

                                <?php } }?>

                            </select>
                            <?php echo form_error('job_category_id'); ?>

                        </div>
                        <div class="form-group">
                            <label class="control-label">Location</label>
                            <select class="form-control" name="job_location_id">
                                <option value="" <?php echo  set_select('job_location_id', ''); ?>>Select Category</option>

                                <?php if(count($job_locations) > 0){foreach ($job_locations as $job_location) {?>

                                    <option value="<?php echo $job_location->job_location_id;?>"  <?php echo  set_select('job_location_id', $job_location->job_location_id); ?>><?php echo $job_location->job_location_title;?></option>

                                <?php } }?>

                            </select>
                            <?php echo form_error('job_location_id'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label">Experience</label>
                            <input type="text" placeholder="Experience" class="form-control"
                                   name="job_experience" value="<?php echo set_value('job_experience'); ?>"  required>
                            <?php echo form_error('job_experience'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">No. of Vacancies</label>
                            <input type="text" placeholder="Job Vacancies" class="form-control"
                                   name="job_vacancies" value="<?php echo set_value('job_vacancies'); ?>"  required>
                            <?php echo form_error('job_vacancies'); ?>
                        </div>


                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <select class="form-control" name="job_status">
                                <option value="" <?php echo  set_select('job_status', ''); ?>>Select Status</option>
                                <?php $job_status = $this->config->item('JOB_STATUS');; ?>
                                <?php if(count($job_status) > 0){foreach ($job_status as $j_s) {?>

                                    <option value="<?php echo $j_s;?>"  <?php echo  set_select('job_status', $j_s); ?>><?php echo show_job_status($j_s);?></option>

                                <?php } }?>

                            </select>
                            <?php echo form_error('job_status'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">To Email</label>
                            <select class="form-control" name="job_email_id">
                                <option value="" <?php echo  set_select('job_email_id', ''); ?>>Select Email</option>

                                <?php if(count($job_emails) > 0){foreach ($job_emails as $job_email) {?>

                                    <option value="<?php echo $job_email->job_email_id;?>"  <?php echo  set_select('job_email_id', $job_email->job_email_id); ?>><?php echo $job_email->job_email_title;?></option>

                                <?php } }?>

                            </select>
                            <help> <em>Email to which application details to be send.</em></help>
                            <?php echo form_error('job_email_id'); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                                        <textarea placeholder="Description" id="job_description" class="form-control" name="job_description"><?php echo set_value('job_description'); ?>
                                        </textarea>
                            <?php echo form_error('job_description'); ?>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label">SEO Title</label>
                            <input type="text" placeholder="SEO Title" class="form-control"
                                   name="job_seo_title" id="job_seo_title" value="<?php echo set_value('job_seo_title'); ?>"  required>
                            <?php echo form_error('job_seo_title'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Logo Text</label>
                            <input type="text" placeholder="Job Logo Text" class="form-control"
                                   name="job_logo_text" id="job_logo_text" value="<?php echo set_value('job_logo_text'); ?>"  required>
                            <?php echo form_error('job_logo_text'); ?>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label">SEO Description</label>

                            <textarea placeholder="SEO Description" id="job_seo_description" class="form-control" name="job_seo_description"><?php echo set_value('job_seo_description'); ?>
                                        </textarea>

                            <?php echo form_error('job_seo_description'); ?>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo site_url('admin/jobs');?>" class="btn default" type="button">Cancel</a>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                        </div>

                    </div>


        </form>

    </div>


</div>
<script>

    $("#job_title").keypress(function() {
        $('#job_slug').val($('#job_title').val().replace(/\s+/g, '-').replace(/[^-A-Za-z0-9]+/g, '').toLowerCase());
        $('#job_seo_title').val($('#job_title').val());
    });

</script>