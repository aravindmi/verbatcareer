<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        $this->load->model('jobs_model');
        $this->load->model('applicants_model');
        $this->load->model('job_categories_model');
        $this->load->model('job_locations_model');
        $this->_created_at = date("Y-m-d H:i:s");
        $this->_updated_at = date("Y-m-d H:i:s");

    }

    public function index()
    {

        $data['jobs'] = $this->jobs_model->get_all_jobs();
        $data['job_categories'] = $this->job_categories_model->get_all();
        $data['job_locations'] = $this->job_locations_model->get_all();
        //$data['menu'] = 'jobs';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Opportunities";

        $data['page'] = 'frontend/job_list_view';
        $this->load->view('templates/frontend_template', $data);
    }

    function apply($job_slug)
    {

        if ($job_slug == null) {

            $this->ci_alerts->set('error', 'Job Slug not found');
            redirect('/');
        }


        $job_details = $this->jobs_model->get_job_by_slug($job_slug);
        $data['job_data'] = $job_details;


        if (count($job_details) > 0) {

            $data['title'] = $job_details->job_seo_title . ' | Apply Now';
            $data['seo_description'] = $job_details->job_seo_description;

        } else {

            redirect('/');
        }


        $this->form_validation->set_rules('applicant_first_name', 'First Name', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('applicant_last_name', 'Last Name', "trim|max_length[200]");
        $this->form_validation->set_rules('applicant_mail', 'Email', 'required|trim|max_length[200]|valid_email');
        $this->form_validation->set_rules('applicant_location', 'Location', "required|trim|max_length[200]");
        $this->form_validation->set_rules('applicant_cover_letter', 'Cover Letter', 'required|max_length[1000]');
        $this->form_validation->set_rules('applicant_resume', 'Resume', 'callback_handle_upload');

        $this->form_validation->set_rules('recaptcha', 'Recaptcha', 'callback_handle_recaptcha');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(

                'job_id' => $job_details->job_id,
                'applicant_first_name' => $this->input->post('applicant_first_name'),
                'applicant_last_name' => $this->input->post('applicant_last_name'),
                'applicant_mail' => $this->input->post('applicant_mail'),
                'applicant_location' => $this->input->post('applicant_location'),
                'applicant_cover_letter' => $this->input->post('applicant_cover_letter'),
                'applicant_ip' => $this->input->ip_address(),
                'applicant_resume' => $this->input->post('applicant_resume'),
                'created_at' => $this->_created_at

            );

            $applicant_id = $this->applicants_model->insert($insert_data);

            if (!$applicant_id) {

                $this->ci_alerts->set('error', 'Sorry ! Some error occurred, please try again');
                redirect($job_details->job_slug . "/apply");

            } else {
                $insert_data['job_location'] = $job_details->job_location_title;
                $insert_data['job_title'] = $job_details->job_title;
                $insert_data['job_code'] = $job_details->job_code;
                $insert_data['job_slug'] = $job_details->job_slug;
                $this->send_mail($insert_data);
                redirect("thank/you/".$applicant_id);
            }
        } else {


            $data['page'] = 'frontend/job_apply_view';


            $this->load->view('templates/frontend_template', $data);

        }
    }


    function handle_upload()
    {
        if (isset($_FILES['userfile']) && !empty($_FILES['userfile']['name'])) {

            $config_upload['upload_path'] = $this->config->item('CANDIDATE_UPLOAD_PATH');
            $config_upload['allowed_types'] = $this->config->item('CANDIDATE_UPLOAD_TYPES');
            $config_upload['max_size'] = $this->config->item('CANDIDATE_UPLOAD_SIZE_LIMIT');
            $config_upload['encrypt_name'] = TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config_upload);

            if ($this->upload->do_upload('userfile')) {
                // set a $_POST value for 'image' that we can use later
                $upload_data = $this->upload->data();
                $_POST['applicant_resume'] = $upload_data['file_name'];
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_upload', "Please upload your resume");
            return false;
        }
    }

    function handle_recaptcha()
    {
        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');

        if (!empty($recaptcha)) {

            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) and $response['success'] === true) {

                return true;

            } else {

                $this->form_validation->set_message('handle_recaptcha', "Security check failed, please try again");
                return false;
            }

        } else {

            $this->form_validation->set_message('handle_recaptcha', "Security Check failed, please try again");
            return false;
        }

    }


    /**
     * Project view
     */
    function view($job_slug)
    {

        if ($job_slug == null) {

            $this->ci_alerts->set('error', 'Job Slug not found');
            redirect('/');
        }


        $job_details = $this->jobs_model->get_job_by_slug($job_slug);
        $data['job_data'] = $job_details;


        if (count($job_details) > 0) {

            $data['title'] = $job_details->job_seo_title;
            $data['seo_description'] = $job_details->job_seo_description;

        } else {

            redirect('/');
        }


        $data['title'] = $data['job_data']->job_seo_title;


        $data['seo_description'] = $data['job_data']->job_seo_description;


        $data['related_jobs'] = $this->jobs_model->get_job_by_category($job_details->job_category_id);

        $data['page'] = 'frontend/job_details_view';
        $this->load->view('templates/frontend_template', $data);


    }


    /**
     * Delete
     */
    public function delete($job_id)
    {

        $insert_data = array(
            'deleted' => 1,
            'updated_at' => $this->_created_at,
            'updated_by' => $this->_created_by

        );

        if ($this->jobs_model->update($job_id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/jobs/");

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/jobs/");
        }
    }


    function send_mail($applicant_data){


        $this->load->library('email');


        $email = get_email($applicant_data['job_location']);

        $message = '<html>
                    <body style="color:white;">
                    <p><b>Applicant Details</b></p>
                    <p>Applicant First Name: \'.$applicant_data[\'applicant_first_name\'].\'</p>
                    <p>Applicant Last Name: \'.$applicant_data[\'applicant_last_name\'].\'</p>
                    <p>Applicant Email: \'.$applicant_data[\'applicant_mail\'].\',</p>
                    <p>Applicant Location: \'.$applicant_data[\'applicant_location\'].\'</p>
                    <p>Cover Letter: \'.$applicant_data[\'applicant_cover_letter\'].\'</p>
                    <p>Please find the attached resume</p>

                    <p><b>Opportunity Details</b></p>
                    <p>Job Title: \'.$applicant_data[\'job_title\'].\'</p>
                    <p>Job Code: \'.$applicant_data[\'job_code\'].\'</p>
                    <p>Job Location: \'.$applicant_data[\'job_location_title\'].\'</p>
                    <p>Job URL: <a href="\'site_url().$applicant_data[\'job_slug\'].\'">Click here</a></p>
                    <p><b>Thank you</b></p>
                    </body>
                    </html>';

        $this->email->from('careers@verbat.com', 'Verbat Careers');
        $this->email->to($email);
        //$this->email->cc('another@another-example.com');
        $this->email->bcc('aravind.m@verbat.com');

        $this->email->subject('A new application received for the position '.$applicant_data['job_title']);
        $this->email->message($message);
        $this->email->attach('uploads/resumes/'.$applicant_data['applicant_resume']);

        $send_mail = $this->email->send();
        //echo $this->email->print_debugger();
//exit;

    }

}