<h2 class="page-header">Opportunities
    <a href="<?php echo site_url('admin/jobs/create/'); ?>" class="btn btn-info pull-right" title="Create"><i
            class="fa fa-plus"></i> Add new</a>
</h2>

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
                <a type="button" class="btn btn-default btn-xs" href="<?php echo site_url('admin/jobs/gen_excel/');?>">
                    <i class="fa fa-download"></i> Excel
                </a>
            </div>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" >
                <?php if (isset($jobs) && count($jobs)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-sort="string" class="">Title</th>
                            <th data-sort="string">Code</th>
                            <th data-sort="string">Location</th>
                            <th>Post Date</th>
                            <th>Status</th>
                            <th data-sort="int"># Applications</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $c = 1; ?>
                        <?php foreach ($jobs as $job) { ?>
                            <tr>
                                <td>
                                    <?php echo $c; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $job->job_title; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $job->job_code; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $job->job_location_title; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo show_date($job->created_at); ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo show_job_status($job->job_status);  ?>

                                </td>
                                <td class="table-bordered">
                                    <?php echo $job->application_count;  ?>

                                </td>

                                <td class="table-bordered">
                                    <a href="<?php echo site_url('admin/jobs/view/' . $job->job_id); ?>"
                                       class="btn btn-success btn-circle" title="View"><i class="fa fa-eye"></i></a>

                                    <a href="<?php echo site_url('admin/jobs/update/' . $job->job_id.'/'. $job->job_slug); ?>"
                                       class="btn btn-primary btn-circle" title="Edit"><i class="fa fa-edit"></i></a>

                                    <a href="<?php echo site_url('admin/jobs/delete/' . $job->job_id); ?>"
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
