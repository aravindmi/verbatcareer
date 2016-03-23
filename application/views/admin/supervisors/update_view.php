<h3 class="page-header">Update Supervisor - <?php echo $school_data->school_name.' (ID: '.$school_data->school_id.') - '.$school_data->place;?></h3>
<div class="panel panel-default">
    <div class="panel-heading">
        Supervisor Details

    </div>
    <div class="panel-body">

        <?php if (count($supervisor_data) > 0) {?>



        <!-- BEGIN FORM-->
        <form class="horizontal-form"  method="post">
            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" placeholder="Supervisor Name" class="form-control"
                               name="supervisor_name" value="<?php echo set_value('supervisor_name',$supervisor_data->supervisor_name); ?>" required>
                        <?php echo form_error('supervisor_name'); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Contact</label>
                        <input type="text" placeholder="Supervisor Contact" class="form-control"
                               name="supervisor_contact" value="<?php echo set_value('supervisor_contact',$supervisor_data->supervisor_contact); ?>"  required>
                        <?php echo form_error('supervisor_contact'); ?>
                    </div>


                        <div class="pull-right">
                            <a href="<?php echo site_url('supervisors/view/'.$school_data->school_id);?>" class="btn default" type="button">Cancel</a>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
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