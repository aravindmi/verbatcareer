<h3 class="page-header"> JOB TITLE</h3>
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                Total Applicants
            </div>
            <div class="panel-body">
                <h1 class="text-center">310</h1>
            </div>

        </div>
        <!-- /.col-lg-4 -->
    </div>
    <div class="col-lg-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                New Applicants

            </div>
            <div class="panel-body">
                <h1 class="text-center">100</h1>
            </div>

        </div>
        <!-- /.col-lg-4 -->
    </div>
    <div class="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Shortlisted
            </div>
            <div class="panel-body">
                <h1 class="text-center">10 </h1>
            </div>

        </div>
        <!-- /.col-lg-4 -->
    </div>
    <div class="col-lg-3">
        <div class="panel panel-red">
            <div class="panel-heading">
                Rejected
            </div>
            <div class="panel-body">
                <h1 class="text-center">200 </h1>
            </div>

        </div>
        <!-- /.col-lg-4 -->
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">

        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true"
           class="collapsed">Opportunity Details <i class="fa fa-chevron-down"></i> </a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse out" aria-expanded="true" style="height: auto;">
        <div class="panel-body">


            <!-- BEGIN FORM-->
            <?php if (count($job_data) > 0) { ?>


            <div class="horizontal-form" method="post">
                <div class="form-body">
                    <!-- <h3 class="form-section">Person Info</h3>-->
                    <form class="form-body" id="job_details">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" placeholder="Job Title" class="form-control"
                                       name="job_title" id="job_title"
                                       value="<?php echo set_value('job_title', $job_data->job_title); ?>" required>
                                <?php echo form_error('job_title'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">URL Slug</label>
                                <input type="text" placeholder="URL Slug" class="form-control"
                                       name="job_slug" id="job_slug"
                                       value="<?php echo set_value('job_slug', $job_data->job_slug); ?>" required>
                                <?php echo form_error('job_slug'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Code</label>
                                <input type="text" placeholder="Job Code" class="form-control"
                                       name="job_code"
                                       value="<?php echo set_value('job_code', $job_data->job_code); ?>" required>
                                <?php echo form_error('job_code'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Category</label>


                                <select class="form-control" name="job_category_id">
                                    <option value="" <?php echo set_select('job_category_id', ''); ?>>Select
                                        Category
                                    </option>

                                    <?php if (count($job_categories) > 0) {
                                        foreach ($job_categories as $job_category) { ?>

                                            <option
                                                value="<?php echo $job_category->job_category_id; ?>" <?php echo set_select('job_category_id', $job_category->job_category_id, is_same($job_category->job_category_id, $job_data->job_category_id)); ?>><?php echo $job_category->job_category_title; ?></option>

                                        <?php }
                                    } ?>

                                </select>
                                <?php echo form_error('job_category_id'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Location</label>
                                <select class="form-control" name="job_location_id">
                                    <option value="" <?php echo  set_select('job_location_id', ''); ?>>Select Category</option>

                                    <?php if(count($job_locations) > 0){foreach ($job_locations as $job_location) {?>

                                        <option value="<?php echo $job_location->job_location_id;?>"  <?php echo  set_select('job_location_id', $job_location->job_location_id,is_same($job_location->job_location_id,$job_data->job_location_id)); ?>><?php echo $job_location->job_location_title;?></option>

                                    <?php } }?>

                                </select>
                                <?php echo form_error('job_location_id'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Sub Location</label>
                                <input type="text" placeholder="Sub Location" class="form-control"
                                       name="job_experience" value="<?php echo set_value('job_sub_location',$job_data->job_sub_location); ?>"  required>
                                <?php echo form_error('job_sub_location'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Experience</label>
                                <input type="text" placeholder="Experience" class="form-control"
                                       name="job_experience"
                                       value="<?php echo set_value('job_experience', $job_data->job_experience); ?>"
                                       required>
                                <?php echo form_error('job_experience'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">No. of Vacancies</label>
                                <input type="text" placeholder="Job Vacancies" class="form-control"
                                       name="job_vacancies"
                                       value="<?php echo set_value('job_vacancies', $job_data->job_vacancies); ?>"
                                       required>
                                <?php echo form_error('job_vacancies'); ?>
                            </div>


                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control" name="job_status">
                                    <option value="" <?php echo set_select('job_status', ''); ?>>Select Status
                                    </option>
                                    <?php $job_status = $this->config->item('JOB_STATUS');; ?>
                                    <?php if (count($job_status) > 0) {
                                        foreach ($job_status as $j_s) { ?>

                                            <option
                                                value="<?php echo $j_s; ?>" <?php echo set_select('job_status', $j_s, is_same($j_s, $job_data->job_status)); ?>><?php echo show_job_status($j_s); ?></option>

                                        <?php }
                                    } ?>

                                </select>
                                <?php echo form_error('job_status'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                        <textarea placeholder="Description" id="job_description" class="form-control"
                                                  name="job_description"><?php echo set_value('job_description', $job_data->job_description); ?>
                                        </textarea>
                                <?php echo form_error('job_description'); ?>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label">SEO Title</label>
                                <input type="text" placeholder="SEO Title" class="form-control"
                                       name="job_seo_title" id="job_seo_title"
                                       value="<?php echo set_value('job_seo_title', $job_data->job_seo_title); ?>"
                                       required>
                                <?php echo form_error('job_seo_title'); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Logo Text</label>
                                <input type="text" placeholder="Job Logo Text" class="form-control"
                                       name="job_logo_text" id="job_logo_text" value="<?php echo set_value('job_logo_text',$job_data->job_logo_text); ?>"  required>
                                <?php echo form_error('job_logo_text'); ?>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label">SEO Description</label>
                                 <textarea placeholder="SEO Description" id="job_seo_description" class="form-control" name="job_seo_description"><?php echo set_value('job_seo_description',$job_data->job_seo_description); ?>
                                        </textarea>

                                <?php echo form_error('job_seo_description'); ?>
                            </div>

                        </div>


                    </form>

                    <?php } else { ?>
                        <div class="alert alert-danger">
                            No record found.
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#collapseTwo" aria-expanded="true"
                   class="collapsed">Applicants <i class="fa fa-chevron-down"></i> </a>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in" aria-expanded="true" style="height: auto;">
                <div class="panel-body">
                    <div class="table-responsive" id="applicants_list">
                        <?php if (isset($applicants) && count($applicants)) { ?>
                            <table class="table table-hover" id="list_table">
                                <thead>
                                <tr>

                                    <th data-sort="string" class="">Id</th>
                                    <th data-sort="string" class="">Name</th>
                                    <th data-sort="string">Email</th>
                                    <th data-sort="string">Location</th>

                                    <th>Status</th>

                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($applicants as $applicant) { ?>
                                    <tr>

                                        <td class="table-bordered">
                                            VT<?php echo $applicant->applicant_id; ?>
                                        </td>
                                        <td class="table-bordered">
                                            <?php echo $applicant->applicant_first_name.' '.$applicant->applicant_last_name ; ?>
                                        </td>
                                        <td class="table-bordered">
                                            <?php echo $applicant->applicant_mail; ?>
                                        </td>
                                        <td class="table-bordered">
                                            <?php echo $applicant->applicant_location; ?>
                                        </td>

                                        <td class="table-bordered">
                                            <?php echo $applicant->applicant_status; ?>
                                        </td>
                                        <td class="table-bordered">
                                           <a href="<?php echo site_url('admin/applicants/view/' . $applicant->applicant_id); ?>"
                                            class="btn btn-success btn-circle" title="View"><i class="fa fa-eye"></i></a>

                                            <a href="<?php echo site_url('admin/applicants/delete/' . $applicant->applicant_id); ?>"
                                               onclick="return confirm('Are you sure ?');"
                                               class="btn btn-danger btn-circle btn-icon" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>


                                <?php } ?>
                                </tbody>
                            </table>
                            <?php echo $this->ajax_pagination->create_links(); ?>
                        <?php } else {
                            echo '<div class="alert alert-danger">No Records Found !!!</div>';
                        } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#job_details :input").attr("disabled", true);
</script>