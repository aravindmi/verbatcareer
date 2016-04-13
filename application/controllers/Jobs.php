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

        $location = $this->input->post('location_id');
        $category = $this->input->post('category_id');

        $data['jobs'] = $this->jobs_model->get_all_open_jobs($location, $category, '');
        $data['job_categories'] = $this->job_categories_model->get_all();
        $data['job_locations'] = $this->job_locations_model->get_all();
        $data['location_id'] = $location;
        $data['category_id'] = $category;

        //$data['menu'] = 'jobs';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Open Positions";

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
                $insert_data['job_location_title'] = $job_details->job_location_title;
                $insert_data['job_email_title'] = $job_details->job_email_title;
                $insert_data['job_title'] = $job_details->job_title;
                $insert_data['job_code'] = $job_details->job_code;
                $insert_data['job_slug'] = $job_details->job_slug;
                $this->send_mail($insert_data);
                redirect("thank/you/" . $applicant_id);
            }
        } else {


            $data['page'] = 'frontend/job_apply_view';


            $this->load->view('templates/frontend_template', $data);

        }
    }


    function submit_resume()
    {


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

                'job_id' => 0,
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
                redirect("submit-resume");

            } else {

                $this->send_mail($insert_data);
                redirect("thank/you/");
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
    public function filters()
    {

        $location = $this->input->post('location_slug');
        $category = $this->input->post('category_slug');

        if ($location != '' && $category != '') {

            redirect('job-list/' . $location . '/' . $category);

        } elseif ($location != '') {
            redirect('job-list/' . $location);

        } elseif ($category != '') {

            redirect('job-list/' . $category);

        } else {


            redirect('job-listing');

        }

    }


    function send_mail($applicant_data)
    {


        $this->load->library('email');

        if (isset($applicant_data['job_location_title']) && isset($applicant_data['job_title'])) {

            $email = ($applicant_data['job_email_title'] != '') ? $applicant_data['job_email_title'] : get_email('India');
            $this->email->subject('Resume : '.$applicant_data['job_code']. ' : '.$applicant_data['job_title']);
            $message = '<html>



                    <table cellspacing="0" cellpadding="0" border="0" width="400">
                        <tr>
                            <td width="100"><strong>Name:</strong></td>
                            <td width="300">' . $applicant_data['applicant_first_name'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Email:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_mail'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Location:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_location'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Cover Letter:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_cover_letter'] . ' </td>
                        </tr>
                    </table>
                    </html>';

        } else {


            $email = get_email('India');
            $this->email->subject('Resume');
            $message = '<html>
                   <table cellspacing="0" cellpadding="0" border="0" width="400">
                        <tr>
                            <td width="100" style="padding:5px"><strong>Name:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_first_name'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Email:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_mail'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Location:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_location'] . '</td>
                        </tr>
                        <tr>
                            <td width="100" style="padding:5px"><strong>Cover Letter:</strong></td>
                            <td width="300" style="padding:5px">' . $applicant_data['applicant_cover_letter'] . ' </td>
                        </tr>
                    </table>
                    </html>';
        }


        $this->email->from($applicant_data['applicant_mail'], $applicant_data['applicant_first_name']. '' .$applicant_data['applicant_last_name'] );
        $this->email->to($email);
        //$this->email->cc('another@another-example.com');
        $this->email->bcc('aravind.m@verbat.com');

        $this->email->message($message);
        $this->email->attach('uploads/resumes/' . $applicant_data['applicant_resume']);

        $send_mail = $this->email->send();
        //echo $this->email->print_debugger();
//exit;

    }

}