<h3 class="page-header">Create Candidate - <?php echo $school_data->school_name.' (ID: '.$school_data->school_id.') - '.$school_data->place;?></h3>
<div class="panel panel-default">
    <div class="panel-heading">
        Candidate Details

    </div>
    <div class="panel-body">
        <!-- BEGIN FORM-->
        <form class="horizontal-form"  method="post">
            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" placeholder="Candidate Name" class="form-control"
                                   name="candidate_name" value="<?php echo set_value('candidate_name'); ?>" required>
                            <?php echo form_error('candidate_name'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Class</label>
                            <input type="text" placeholder="Candidate Class" class="form-control"
                                   name="candidate_class" value="<?php echo set_value('candidate_class'); ?>"  required>
                            <?php echo form_error('candidate_class'); ?>
                        </div>

                        <div class="pull-right">
                            <a href="<?php echo site_url('candidates/view/'.$school_data->school_id);?>" class="btn default" type="button">Cancel</a>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                        </div>

                    </div>


        </form>

    </div>


</div>