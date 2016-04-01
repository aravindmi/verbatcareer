<?php if (count($school_data) > 0) {

    $c_l1 = array();
    $c_l2 = array();
    $a_l1 = array();
    $a_l2 = array();
    $stl1 = array();
    $stl2 = array();


    $header_l1 = array('LKG','UKG','1','2','3','4','5','6','7');
    $header_l2 = array('8','9','10');
    ?>


    <h3 class="page-header"><?php echo '<b>' . $school_data->school_name . '</b> (ID: ' . $school_data->school_id . ') - ' . $school_data->place; ?>


    </h3>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Exam Scheduled Date
                </div>
                <div class="panel-body">
                    <h1 class="text-center"><?php echo show_date($school_data->exam_date); ?></h1>
                </div>

            </div>
            <!-- /.col-lg-4 -->
        </div>
        <div class="col-lg-4">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    Total Candidates
                    <a type="button" class="btn btn-default btn-xs pull-right"
                       href="<?php echo site_url('admin/candidates/view/' . $school_data->school_id); ?>">
                        <i class="fa fa-eye"></i> View All
                    </a>
                </div>
                <div class="panel-body">
                    <h1 class="text-center"><?php echo $school_data->candidates_count; ?></h1>
                </div>

            </div>
            <!-- /.col-lg-4 -->
        </div>
        <div class="col-lg-4">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Important Notes
                </div>
                <div class="panel-body">
                    <h1 class="text-center">N/A </h1>
                </div>

            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            School Details


            <div class="pull-right">
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/schools/gen_detail_pdf/'.$school_data->school_id); ?>">
                    <i class="fa fa-download"></i> PDF
                </a>
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/schools/update/' . $school_data->school_id); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>

            </div>
        </div>
        <div class="panel-body">


            <!-- BEGIN FORM-->

            <div class="form-body">
                <!-- <h3 class="form-section">Person Info</h3>-->
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label">Principal</label>
                            <input type="text" placeholder="Principal Name" class="form-control"
                                   name="principal_name"
                                   value="<?php echo set_value('principal_name', $school_data->principal_name); ?>"
                                   readonly>
                            <?php echo form_error('principal_name'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Place</label>
                            <input type="text" placeholder="Place" class="form-control" name="place"
                                   value="<?php echo set_value('place', $school_data->place); ?>"
                                   readonly>
                            <?php echo form_error('place'); ?>
                        </div>


                        <div class="form-group">
                            <label class="control-label">State</label>
                            <input type="text" placeholder="Email" class="form-control" name="email"
                                   value="<?php echo $school_data->state_name; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <input type="text" placeholder="Email" class="form-control" name="email"
                                   value="<?php echo $school_data->district_name; ?>" readonly>

                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" placeholder="Email" class="form-control" name="email"
                                   value="<?php echo set_value('email', $school_data->email); ?>" readonly>
                            <?php echo form_error('email'); ?>
                        </div>

                    </div>

                    <div class="col-md-6">


                        <div class="form-group">
                            <label class="control-label">Contact Person</label>
                            <input type="text" placeholder="Contact Person Name" class="form-control"
                                   value="<?php echo set_value('contact_person', $school_data->contact_person); ?>"
                                   name="contact_person" readonly>
                            <?php echo form_error('contact_person'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact Number</label>
                            <input type="text" placeholder="Contact Number" class="form-control"
                                   value="<?php echo set_value('contact_number', $school_data->contact_number); ?>"
                                   name="contact_number" readonly>
                            <?php echo form_error('contact_number'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contact Number (2)</label>
                            <input type="text" placeholder="Contact Number" class="form-control" value="<?php echo set_value('contact_number_land',$school_data->contact_number_land); ?>" name="contact_number_land" readonly>
                            <?php echo form_error('contact_number_land'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                                        <textarea placeholder="Address" class="form-control" name="address" rows="4"
                                                  readonly><?php echo set_value('address', $school_data->address); ?>
                                        </textarea>
                            <?php echo form_error('address'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Other Details</label>
                                        <textarea placeholder="Address" class="form-control" name="details"
                                                  readonly><?php echo set_value('details', $school_data->details); ?>
                                        </textarea>
                            <?php echo form_error('details'); ?>
                        </div>

                    </div>

                </div>


            </div>


        </div>

    </div>
    <?php if (count($candidate_data) > 0) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Candidate details
                        <a type="button" class="btn btn-default btn-xs pull-right"
                           href="<?php echo site_url('admin/candidates/view/' . $school_data->school_id); ?>">
                            <i class="fa fa-eye"></i> View All
                        </a>
                    </div>
                    <div class="panel-body">

                        <h4 class="text-center"><b>Grade LKG to VII</b></h4>

                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                <tr>


                                    <th>Grade</th>
                                    <th>LKG</th>
                                    <th>UKG</th>
                                    <th>Std. I</th>
                                    <th>Std. II</th>
                                    <th>Std. III</th>
                                    <th>Std. IV</th>
                                    <th>Std. V</th>
                                    <th>Std. VI</th>
                                    <th>Std. VII</th>

                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <th>No. of Candidates</th>
                                    <?php foreach($header_l1 as $value){?>
                                    <td><?php echo $c_l1[] = is_grade_count($candidate_data,$value);?></td>
                                    <?php } ?>

                                </tr>
                                <!--<tr>
                                    <th>Amount per head</th>
                                    <?php foreach($header_l1 as $value){?>
                                        <td><?php echo $a_l1[] = is_grade_amount($candidate_data,$value);?></td>
                                    <?php } ?>

                                </tr>-->
                                <tr>
                                    <th>Total amount</th>
                                    <?php $stl1 = get_amountxcount($c_l1,$a_l1); ?>

                                    <?php foreach($stl1 as $value){?>
                                        <td><?php echo $value;?></td>
                                    <?php } ?>

                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning">

                            <p class="text-center">Total No. of Candidates :<b><?php echo array_sum($c_l1);?> </b> |
                                Total Amount : <b><?php echo array_sum($stl1).'.00';?></b></p>
                        </div>

                        <hr>


                        <h4 class="text-center"><b>Grade VII to X</b></h4>

                        <div class="table-responsive table-bordered">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Grade</th>

                                    <th>Std. VIII</th>
                                    <th>Std. IX</th>
                                    <th>Std. X</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>No. of Candidates</th>
                                    <?php foreach($header_l2 as $value){?>
                                        <td><?php echo $c_l2[] = is_grade_count($candidate_data,$value);?></td>
                                    <?php } ?>

                                </tr>
                              <!--  <tr>
                                    <th>Amount per head</th>
                                    <?php foreach($header_l2 as $value){?>
                                        <td><?php echo $a_l2[] = is_grade_amount($candidate_data,$value);?></td>
                                    <?php } ?>

                                </tr>-->
                                <tr>
                                    <th>Total amount</th>
                                    <?php $stl2 = get_amountxcount($c_l2,$a_l2); ?>

                                    <?php foreach($stl2 as $value){?>
                                        <td><?php echo $value;?></td>
                                    <?php } ?>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-warning">

                            <p class="text-center">Total No. of Candidates : <b><?php echo array_sum($c_l2);?> </b> |
                                Total Amount : <b><?php echo array_sum($stl2);?>.00</b></p>
                        </div>

                        <div class="alert alert-info">

                            <p class="text-center">Grand Total : <b><?php echo array_sum($stl1)+array_sum($stl2);?>.00</b></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="alert alert-danger">
        No record found.
    </div>
<?php } ?>