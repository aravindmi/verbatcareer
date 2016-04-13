
<h1 class="page-header">Update Location</h1>
<div class="panel panel-default">
    <div class="panel-heading">
        Details

    </div>
    <div class="panel-body">
        <!-- BEGIN FORM-->

        <?php if (count($data) > 0) { ?>

            <form class="horizontal-form" method="post">
                <div class="form-body">
                    <!-- <h3 class="form-section">Person Info</h3>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" placeholder="Title" class="form-control"
                                       name="job_location_title" id="job_location_title" value="<?php echo set_value('job_location_title',$data->job_location_title); ?>"
                                       required>
                                <?php echo form_error('job_location_title'); ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Slug</label>

                                <input type="text" placeholder="Slug" class="form-control"
                                       name="job_location_slug" id="job_location_slug" value="<?php echo set_value('job_location_slug',$data->job_location_slug); ?>"
                                       required>
                                <?php echo form_error('job_location_slug'); ?>
                            </div>

                            <div class="pull-right">
                                <a href="<?php echo site_url('admin/locations'); ?>" class="btn default" type="button">Cancel</a>
                                <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                            </div>

                        </div>
                    </div>
                    <div>
            </form>
        <?php } else {
            echo "Sorry record not found!";
        } ?>
    </div>


</div>
