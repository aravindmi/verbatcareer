<h1 class="page-header">Create Category</h1>
<div class="panel panel-default">
    <div class="panel-heading">
        Details

    </div>
    <div class="panel-body">
        <!-- BEGIN FORM-->
        <form class="horizontal-form" method="post">
            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" placeholder="Title" class="form-control"
                                   name="job_category_title" id="job_category_title" value="<?php echo set_value('job_category_title'); ?>"
                                   required>
                            <?php echo form_error('job_category_title'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Slug</label>

                            <input type="text" placeholder="Slug" class="form-control"
                                   name="job_category_slug" id="job_category_slug" value="<?php echo set_value('job_category_slug'); ?>"
                                   required>
                            <?php echo form_error('job_category_slug'); ?>
                        </div>

                        <div class="pull-right">
                            <a href="<?php echo site_url('admin/locations'); ?>" class="btn default" type="button">Cancel</a>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                        </div>

                    </div>
                </div>
            </div>

        </form>

    </div>


</div>