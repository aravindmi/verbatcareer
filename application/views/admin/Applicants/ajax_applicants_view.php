<?php if (isset($applicants) && count($applicants)) { ?>
    <table class="table table-hover" id="list_table">
        <thead>
        <tr>

            <th data-sort="string" class="">Id</th>
            <th data-sort="string" class="">Name</th>
            <th data-sort="string">Email</th>
            <th data-sort="string">Location</th>

            <th data-sort="string">Status</th>

            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($applicants as $applicant) { ?>
            <tr>

                <td class="table-bordered">
                    VT<?php echo $applicant->applicant_id; ?>
                </td>
                <td class="table-bordered">
                    <?php echo $applicant->applicant_first_name.' '.$applicant->applicant_last_name ; ?>
                </td>
                <td class="table-bordered">
                    <?php echo $applicant->applicant_mail; ?>
                </td>
                <td class="table-bordered">
                    <?php echo $applicant->applicant_location; ?>
                </td>


                <td class="table-bordered">
                    <?php echo $applicant->applicant_status; ?>
                </td>
                <td class="table-bordered">
                    <a href="<?php echo site_url('admin/applicants/view/' . $applicant->applicant_id); ?>"
                       class="btn btn-success btn-circle" title="View"><i class="fa fa-eye"></i></a>

                   <a href="<?php echo site_url('admin/applicants/delete/' . $applicant->applicant_id); ?>"
                       onclick="return confirm('Are you sure ?');"
                       class="btn btn-danger btn-circle btn-icon" title="Delete"><i
                            class="fa fa-trash"></i></a>
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
    <?php echo $this->ajax_pagination->create_links(); ?>
<?php } else {
    echo '<div class="alert alert-danger">No Records Found !!!</div>';
} ?>