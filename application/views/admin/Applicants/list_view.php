<h2 class="page-header">Candidates

</h2>
<div class="col-lg-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"
               class="collapsed">Summary <i class="fa fa-chevron-down"></i> </a>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="height: 0px;">
            <div class="panel-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum.
            </div>
        </div>
    </div>

</div>
<div class="col-lg-12">
    <div class="panel">
        <div class="form-inline">
            <div class="form-group">


                <input class="form-control" type="text" id="search_text" name="search_text" placeholder="Search anything"/>
            </div>
            <!-- <button type="button" onclick="school_filter();" class="btn btn-primary">
                 Filter
             </button>-->
            <button type="button" onclick="refresh();" class="btn btn-info">
                Clear
            </button>


        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            School List - Select a school and click 'eye icon' to view candidates

        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" id="school_list_table">
                <?php if (isset($schools) && count($schools)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-sort="string" width="30%">Name</th>
                            <th data-sort="string" width="8%">Place</th>
                            <th data-sort="string" width="8%">District</th>
                            <th data-sort="string" width="12%">Date</th>
                            <th data-sort="int" width="10px">#Can</th>
                            <th width="16%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $c = 1; ?>
                        <?php foreach ($schools as $school) { ?>
                            <tr>
                                <td>
                                    <?php echo $c; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $school->school_name; ?> (ID - <?php echo $school->school_id;?>)
                                </td>

                                <td class="table-bordered">
                                    <?php echo $school->place; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo strtoupper($school->district_name); ?>
                                </td>
                                <td class="table-bordered">
                                    <b><?php echo show_date($school->exam_date); ?></b>
                                </td>
                                <td class="table-bordered">
                                    <b><?php echo $school->candidates_count; ?></b>
                                </td>
                                <td class="table-bordered">
                                    <a href="<?php echo site_url('admin/candidates/view/' . $school->school_id); ?>"
                                       class="btn btn-success btn-circle" title="View Candidate list"><i class="fa fa-eye"></i></a>

                                    <a href="<?php echo site_url('admin/candidates/upload/' . $school->school_id); ?>"
                                       class="btn btn-default btn-circle" title="Upload Candidate"><i class="fa fa-upload"></i></a>

                                    <a href="<?php echo site_url('admin/candidates/gen_seating_plan/' . $school->school_id); ?>"
                                       class="btn btn-primary btn-circle" title="Generate Seating plan">S</a>

                                    <a href="<?php echo site_url('admin/candidates/gen_attendance_sheet/' . $school->school_id); ?>"
                                       class="btn btn-warning btn-circle btn-icon" title="Attendance Sheet">A</a>
                                    <a href="<?php echo site_url('admin/candidates/gen_candidate_list/' . $school->school_id); ?>"
                                       class="btn btn-danger btn-circle btn-icon" title="Candidates List">L</a>
                                    <a href="<?php echo site_url('admin/candidates/gen_hallticket_pdf/' . $school->school_id); ?>"
                                       class="btn btn-info btn-circle btn-icon" title="Hall Ticket">H</a>
									<a href="<?php echo site_url('admin/candidates/gen_certificate/' . $school->school_id); ?>"
                                       class="btn btn-success btn-circle btn-icon" title="Centificate">C</a>
                                </td>
                            </tr>
                            <?php $c++; ?>
                        <?php } ?>
                        </tbody>
                    </table>

                <?php } else {
                    echo '<div class="alert alert-danger">No Records Found !!!</div>';
                } ?>

            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>

