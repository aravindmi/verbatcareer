<h2 class="page-header">Schools
    <a href="<?php echo site_url('admin/schools/create/'); ?>" class="btn btn-info pull-right" title="Create"><i
            class="fa fa-plus"></i> Add new</a>
</h2>

<div class="col-lg-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true"
               class="collapsed">Quick Links <i class="fa fa-chevron-down"></i> </a>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true" style="height: auto;">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-success">
                            <a href="<?php echo site_url('admin/schools/get_emails/'); ?>" class="alert-link">Get all emails</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <a href="<?php echo site_url('admin/schools/get_mobiles/'); ?>" class="alert-link">Get all mobiles</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <a href="#" class="alert-link">Generate seating plan</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <a href="<?php echo site_url('admin/schools/gen_exam_date_pdf/'); ?>" class="alert-link">Exam date wise list</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-success">
                          <a href="<?php echo site_url('admin/schools/gen_class_wise_excel/'); ?>" class="alert-link">Class wise list (Excel)</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-info">
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
            List
            <div class="pull-right">
                <a type="button" class="btn btn-default btn-xs" href="<?php echo site_url('admin/schools/gen_pdf/');?>">
                    <i class="fa fa-download"></i> PDF
                </a>
                <a type="button" class="btn btn-default btn-xs" href="<?php echo site_url('admin/schools/gen_excel/');?>">
                    <i class="fa fa-download"></i> Excel
                </a>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" >
                <?php if (isset($schools) && count($schools)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-sort="string" class="">Name</th>
                            <th data-sort="string">Principal</th>
                            <th data-sort="string">Place</th>
                            <th data-sort="string">District</th>
                            <th>Contact#</th>
                            <th data-sort="int">#Candidates</th>
                            <th>Action</th>
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
                                    <?php echo $school->principal_name; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $school->place; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo strtoupper($school->district_name); ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $school->contact_number;  ?>
                                    <?php if ($school->contact_number_land != ''){echo ' , '.$school->contact_number_land;}?>
                                </td>
                                <td class="table-bordered">
                                    <b><?php echo $school->candidates_count; ?></b>
                                </td>
                                <td class="table-bordered">
                                    <a href="<?php echo site_url('admin/schools/view/' . $school->school_id); ?>"
                                       class="btn btn-success btn-circle" title="View"><i class="fa fa-eye"></i></a>

                                    <a href="<?php echo site_url('admin/schools/update/' . $school->school_id); ?>"
                                       class="btn btn-primary btn-circle" title="Edit"><i class="fa fa-edit"></i></a>

                                    <a href="<?php echo site_url('admin/schools/delete/' . $school->school_id); ?>"
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
