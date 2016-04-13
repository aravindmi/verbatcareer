<h1 class="page-header">Create Email</h1>
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
                            <label class="control-label">Email</label>
                            <input type="email" placeholder="Title" class="form-control"
                                   name="job_email_title" id="job_email_title" value="<?php echo set_value('job_email_title'); ?>"
                                   required>
                            <?php echo form_error('job_email_title'); ?>
                        </div>



                        <div class="pull-right">
                            <a href="<?php echo site_url('admin/emails'); ?>" class="btn default" type="button">Cancel</a>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                        </div>

                    </div>
                </div>
            </div>

        </form>

    </div>


</div>