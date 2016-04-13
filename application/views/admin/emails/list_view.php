<h2 class="page-header">Emails
    <a href="<?php echo site_url('admin/emails/create/'); ?>" class="btn btn-info pull-right" title="Create"><i
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

        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" >
                <?php if (isset($data) && count($data)) { ?>
                    <table class="table table-hover" id="list_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th data-sort="string" class="">Title</th>

                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $c = 1; ?>
                        <?php foreach ($data as $d) { ?>
                            <tr>
                                <td>
                                    <?php echo $c; ?>
                                </td>
                                <td class="table-bordered">
                                    <?php echo $d->job_email_title; ?>
                                </td>





                                <td class="table-bordered">


                                    <a href="<?php echo site_url('admin/emails/update/' . $d->job_email_id); ?>"
                                       class="btn btn-primary btn-circle" title="Edit"><i class="fa fa-edit"></i></a>

                                    <a href="<?php echo site_url('admin/emails/delete/' . $d->job_email_id); ?>"
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
            <?php echo isset($pagination) ? $pagination : '';?>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
