<h3 class="page-header">Candidates <span class="label label-success"><?php echo $school_data->candidates_count;?></span>
    - <?php echo $school_data->school_name . ' (ID: ' . $school_data->school_id . ') - ' . $school_data->place; ?>

</h3>
<div class="col-lg-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"
               class="collapsed">Quick Links <i class="fa fa-chevron-down"></i> </a>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true" style="height: auto;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-success">
                            <a href="<?php echo site_url('admin/candidates/gen_hallticket_pdf/' . $school_data->school_id); ?>"
                               class="alert-link">Generate Hall Ticket (All)</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <a href="#" onclick="document.getElementById('hall_ticket').submit();"
                               class="alert-link">Generate Hall Ticket (Selected)</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <a href="<?php echo site_url('admin/candidates/gen_candidate_list/' . $school_data->school_id); ?>"
                               class="alert-link">Generate Candidate List</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <a href="<?php echo site_url('admin/candidates/gen_attendance_sheet/' . $school_data->school_id); ?>"
                               class="alert-link">Generate Attendance Sheet</a>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="alert alert-success">
                            <a href="<?php echo site_url('admin/candidates/gen_pdf/' . $school_data->school_id); ?>"
                               class="alert-link">Generate Checklist</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <a href="<?php echo site_url('admin/candidates/gen_excel/' . $school_data->school_id); ?>"
                               class="alert-link">Generate Excel</a>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <a href="<?php echo site_url('admin/candidates/create/' . $school_data->school_id); ?>"
                               class="alert-link">Add Candidate</a>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="alert alert-success">
                            .
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                           .
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

</div>
<div class="col-lg-12">
    <div class="panel">
        <div class="form-inline">
            <div class="form-group">


                <input class="form-control" type="text" id="search_text" name="search_text"
                       placeholder="Search anything"/>
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
            List
            <div class="pull-right">
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/candidates/gen_pdf/' . $school_id); ?>">
                    <i class="fa fa-download"></i> PDF
                </a>
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/candidates/gen_excel/' . $school_id); ?>">
                    <i class="fa fa-download"></i> Excel
                </a>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" id="school_list_table">
                <?php if (isset($candidates) && count($candidates)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th data-sort="string">Name</th>
                            <th data-sort="string">Class</th>
                            <th data-sort="int">ID</th>

                            <th data-sort="string">Award</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <form method="post"
                              action="<?php echo site_url('admin/candidates/gen_selected_hallticket_pdf/'); ?>"
                              id="hall_ticket">
                            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
                            <tbody>
                            <?php $c = 1; ?>
                            <?php foreach ($candidates as $cand) { ?>
                                <tr>
                                    <td>

                                        <input type="checkbox" name="candidates_id[]"
                                               value="<?php echo $cand->candidate_id; ?>">
                                    </td>
                                    <td>
                                        <?php echo $c; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <?php echo $cand->candidate_name; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <?php echo $cand->candidate_class; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <?php echo $cand->candidate_id; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <select name="award" id="award_<?php echo $cand->candidate_id; ?>" onchange="update_award(<?php echo $cand->candidate_id; ?>)">
                                            <option value="Zest Acer"  <?php echo ($cand->candidate_award == 'Zest Acer') ? 'selected="selected"' : '';?> >Zest Acer (StateWide Top)</option>
                                            <option value="Green Scholar" <?php echo ($cand->candidate_award == 'Green Scholar') ? 'selected="selected"' : '';?>>Green Scholar (95% & above)</option>
                                            <option value="ACE Scholar" <?php echo ($cand->candidate_award == 'ACE Scholar') ? 'selected="selected"' : '';?>>ACE Scholar (90 - 94%)</option>
                                            <option value="ACE Star" <?php echo ($cand->candidate_award == 'ACE Star') ? 'selected="selected"' : '';?>>ACE Star (85 - 89%)</option>
                                            <option value="ACE Master" <?php echo ($cand->candidate_award == 'ACE Master') ? 'selected="selected"' : '';?>>ACE Master (80 - 84%)</option>
                                            <option value="ACE Perfect" <?php echo ($cand->candidate_award == 'ACE Perfect') ? 'selected="selected"' : '';?>>ACE Perfect (70 - 79%)</option>
                                            <option value="ACE Solace" <?php echo ($cand->candidate_award == 'ACE Solace') ? 'selected="selected"' : '';?>>ACE Solace (60 - 69%)</option>
                                            <option value="Absent" <?php echo ($cand->candidate_award == 'Absent') ? 'selected="selected"' : '';?>>Absent</option>
                                        </select>
                                    </td>

                                    <td class="table-bordered">


                                        <a href="<?php echo site_url('admin/candidates/update/' . $cand->candidate_id . '/' . $cand->school_id); ?>"
                                           class="btn btn-primary btn-circle" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="<?php echo site_url('admin/candidates/delete/' . $cand->candidate_id . '/' . $cand->school_id); ?>"
                                           onclick="return confirm('Are you sure ?');"
                                           class="btn btn-danger btn-circle btn-icon" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php $c++; ?>
                            <?php } ?>
                            </tbody>
                        </form>
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
