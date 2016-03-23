<h3 class="page-header">Supervisors
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

                            <a href="<?php echo site_url('admin/supervisors/create/' . $school_data->school_id); ?>"
                               class="alert-link" title="Add Candidate">Add Supervisor</a>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <a href="<?php echo site_url('admin/supervisors/upload/' . $school_data->school_id); ?>"
                               class="alert-link" title="Upload Candidate">Upload Supervisors</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <a href="#" class="alert-link"></a>.
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
            <!--<div class="pull-right">
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/candidates/gen_pdf/' . $school_id); ?>">
                    <i class="fa fa-download"></i> PDF
                </a>
                <a type="button" class="btn btn-default btn-xs"
                   href="<?php echo site_url('admin/candidates/gen_excel/' . $school_id); ?>">
                    <i class="fa fa-download"></i> Excel
                </a>
            </div>-->
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" id="school_list_table">
                <?php if (isset($supervisors) && count($supervisors)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>

                            <th>Action</th>
                        </tr>
                        </thead>

                            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
                            <tbody>
                            <?php $c = 1; ?>
                            <?php foreach ($supervisors as $sup) { ?>
                                <tr>

                                    <td>
                                        <?php echo $c; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <?php echo $sup->supervisor_name; ?>
                                    </td>
                                    <td class="table-bordered">
                                        <?php echo $sup->supervisor_contact; ?>
                                    </td>

                                    <td class="table-bordered">


                                        <a href="<?php echo site_url('admin/supervisors/update/' . $sup->supervisor_id . '/' . $sup->school_id); ?>"
                                           class="btn btn-primary btn-circle" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="<?php echo site_url('admin/supervisors/delete/' . $sup->supervisor_id . '/' . $sup->school_id); ?>"
                                           onclick="return confirm('Are you sure ?');"
                                           class="btn btn-danger btn-circle btn-icon" title="Delete"><i
                                                class="fa fa-trash"></i></a>
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

