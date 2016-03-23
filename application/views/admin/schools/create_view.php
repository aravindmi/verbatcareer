<h1 class="page-header">Create</h1>
<div class="panel panel-default">
    <div class="panel-heading">
        School Details

    </div>
    <div class="panel-body">
        <!-- BEGIN FORM-->
        <form class="horizontal-form"  method="post">
            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">School</label>
                            <input type="text" placeholder="School Name" class="form-control"
                                   name="school_name" value="<?php echo set_value('school_name'); ?>" required>
                            <?php echo form_error('school_name'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Principal</label>
                            <input type="text" placeholder="Principal Name" class="form-control"
                                   name="principal_name" value="<?php echo set_value('principal_name'); ?>"  required>
                            <?php echo form_error('principal_name'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Place</label>
                            <input type="text" placeholder="Place" class="form-control" name="place" value="<?php echo set_value('place'); ?>"
                                   required>
                            <?php echo form_error('place'); ?>
                        </div>


                        <div class="form-group">
                            <label class="control-label">State</label>
                            <select class="form-control" name="state_id">
                                <option value="" <?php echo  set_select('state_id', ''); ?>>Select State</option>

                                <?php if(count($states) > 0){foreach ($states as $state) {?>

                                    <option value="<?php echo $state->id;?>"  <?php echo  set_select('state_id', $state->id); ?>><?php echo $state->state_name;?></option>

                                <?php } }?>

                            </select>
                            <?php echo form_error('state_id'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <select class="form-control" name="district_id">
                                <option value="" <?php echo  set_select('district_id', ''); ?>>Select State</option>

                                <?php if(count($districts) > 0){foreach ($districts as $district) {?>

                                    <option value="<?php echo $district->id;?>"  <?php echo  set_select('district_id', $district->id); ?>><?php echo $district->district_name;?></option>

                                <?php } }?>
                            </select>
                            <?php echo form_error('district_id'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" placeholder="Email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" email>
                            <?php echo form_error('email'); ?>
                        </div>

                    </div>

                    <div class="col-md-6">



                        <div class="form-group">
                            <label class="control-label">Contact Person</label>
                            <input type="text" placeholder="Contact Person Name" class="form-control" value="<?php echo set_value('contact_person'); ?>" name="contact_person">
                            <?php echo form_error('contact_person'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact Number</label>
                            <input type="text" placeholder="Contact Number" class="form-control" value="<?php echo set_value('contact_number'); ?>" name="contact_number">
                            <?php echo form_error('contact_number'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact Number (2)</label>
                            <input type="text" placeholder="Contact Number" class="form-control" value="<?php echo set_value('contact_number_land'); ?>" name="contact_number_land">
                            <?php echo form_error('contact_number_land'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                                        <textarea placeholder="Address" class="form-control" name="address"><?php echo set_value('address'); ?>
                                        </textarea>
                            <?php echo form_error('address'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Other Details</label>
                                        <textarea placeholder="Address" class="form-control"  name="details" ><?php echo set_value('details'); ?>
                                        </textarea>
                            <?php echo form_error('details'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Exam Date</label>
                            <input type="text" placeholder="Exam Date" class="form-control datepicker" value="<?php echo set_value('exam_date','07-11-2015'); ?>" name="exam_date" required>
                            <?php echo form_error('exam_date'); ?>
                        </div>
                        <div class="pull-right">
                            <button class="btn default" type="button">Cancel</button>
                            <button class="btn blue" type="submit"><i class="fa fa-check"></i> Save</button>
                        </div>

                    </div>


        </form>

    </div>


</div>