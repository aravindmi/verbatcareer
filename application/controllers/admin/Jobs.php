<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('jobs_model');
        $this->load->model('applicants_model');
        $this->load->model('job_categories_model');
        $this->load->model('job_locations_model');
        $this->load->model('job_emails_model');

        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

        $this->load->library('Ajax_pagination');

        $this->_created_date = date("d-m-Y");

        $this->perPage = '10';

    }

    public function index()
    {

        $data['jobs'] = $this->jobs_model->get_all_jobs();
        $data['menu'] = 'jobs';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Open Positions";

        $data['page'] = 'admin/jobs/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create()
    {

        $this->form_validation->set_rules('job_title', 'Job Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_slug', 'Job Slug', 'required|trim|max_length[300]|alpha_dash|is_unique[jobs.job_slug]');
        $this->form_validation->set_rules('job_code', 'Job Code', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_id', 'Job Category', 'required|trim|max_length[10]|integer');
        $this->form_validation->set_rules('job_location_id', 'Job Location', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_email_id', 'Job Email', 'required|trim|max_length[10]|integer');
        //$this->form_validation->set_rules('job_sub_location', 'Job Sub Location', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_experience', 'Job Experience', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('job_vacancies', 'Job Vacancies', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_status', 'Job Status', 'required|trim|max_length[1]|integer');
        $this->form_validation->set_rules('job_description', 'Job Description', "required|trim|max_length[5000]");
        $this->form_validation->set_rules('job_seo_title', 'Job SEO Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('job_seo_description', 'Job SEO Description', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('job_logo_text', 'Job Logo Text', 'required|trim|max_length[3]');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_title' => $this->input->post('job_title'),
                'job_slug' => $this->input->post('job_slug'),
                'job_code' => $this->input->post('job_code'),
                'job_category_id' => $this->input->post('job_category_id'),
                'job_location_id' => $this->input->post('job_location_id'),
                'job_email_id' => $this->input->post('job_email_id'),
                'job_experience' => $this->input->post('job_experience'),
                'job_vacancies' => $this->input->post('job_vacancies'),
                'job_status' => $this->input->post('job_status'),
                'job_description' => $this->input->post('job_description'),
                'job_seo_title' => $this->input->post('job_seo_title'),
                'job_seo_description' => $this->input->post('job_seo_description'),
                'job_logo_text' => $this->input->post('job_logo_text'),
                'created_at' => $this->_created_at,
                'created_by' => $this->_created_by
            );

            $job_id = $this->jobs_model->insert($insert_data);

            if (!$job_id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/jobs");

            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/jobs");
            }
        } else {

            $data['menu'] = 'jobs';
            $data['page'] = 'admin/jobs/create_view';

            $data['job_categories'] = $this->job_categories_model->get_all();
            $data['job_locations'] = $this->job_locations_model->get_all();
            $data['job_emails'] = $this->job_emails_model->get_all();
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($job_id, $job_slug)
    {

        if($this->input->post('job_slug') != $job_slug) {
            $is_unique =  '|is_unique[jobs.job_slug]';
        } else {
            $is_unique =  '';
        }

        $this->form_validation->set_rules('job_title', 'Job Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_slug', 'Job Slug', 'required|trim|max_length[300]|alpha_dash'.$is_unique);
        $this->form_validation->set_rules('job_code', 'Job Code', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_id', 'Job Category', 'required|trim|max_length[10]|integer');
        $this->form_validation->set_rules('job_email_id', 'Job Email', 'required|trim|max_length[10]|integer');
        //$this->form_validation->set_rules('job_sub_location', 'Job Sub Location', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_location_id', 'Job Location', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_experience', 'Job Experience', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('job_vacancies', 'Job Vacancies', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_status', 'Job Status', 'required|trim|max_length[1]|integer');
        $this->form_validation->set_rules('job_description', 'Job Description', "required|trim|max_length[5000]");
        $this->form_validation->set_rules('job_seo_title', 'Job SEO Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('job_seo_description', 'Job SEO Description', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('job_logo_text', 'Job Logo Text', 'required|trim|max_length[3]');


        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_title' => $this->input->post('job_title'),
                'job_slug' => $this->input->post('job_slug'),
                'job_code' => $this->input->post('job_code'),
                'job_category_id' => $this->input->post('job_category_id'),
                'job_location_id' => $this->input->post('job_location_id'),
                'job_email_id' => $this->input->post('job_email_id'),
                'job_experience' => $this->input->post('job_experience'),
                'job_vacancies' => $this->input->post('job_vacancies'),
                'job_status' => $this->input->post('job_status'),
                'job_description' => $this->input->post('job_description'),
                'job_seo_title' => $this->input->post('job_seo_title'),
                'job_seo_description' => $this->input->post('job_seo_description'),
                'job_logo_text' => $this->input->post('job_logo_text'),
                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->jobs_model->update($job_id, $insert_data)) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/jobs/view/" . $job_id);
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/jobs/view/" . $job_id);
            }
        } else {

            $data['menu'] = 'jobs';

            $data['job_categories'] = $this->job_categories_model->get_all();
            $data['job_locations'] = $this->job_locations_model->get_all();
            $data['job_emails'] = $this->job_emails_model->get_all();

            $data['job_data'] = $this->jobs_model->get($job_id);

            $data['page'] = 'admin/jobs/update_view';
            $this->load->view('templates/admin_template', $data);
        }
    }



    /**
     * Project view
     */
    function view($job_id)
    {

        if ($job_id == null) {

            $this->ci_alerts->set('error', 'Job ID not found');
            redirect('admin/jobs');
        }


        $data['menu'] = 'jobs';
        $data['job_id'] = $job_id;

        $data['job_categories'] = $this->job_categories_model->get_all();
        $data['job_locations'] = $this->job_locations_model->get_all();



        $data['job_data'] = $this->jobs_model->get($job_id);


        //$data['job'] = $this->jobs_model->get_one_job($job_id);

        //total rows count
        $totalRec = count($this->applicants_model->get_all_applicants(array('job_id'=>$job_id)));

        //pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'applicants_list'; //parent div tag id
        $config['base_url']    = site_url().'admin/applicants/ajax_applicants/'.$job_id;
        $config['uri_segment'] = 5;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the applicants data
        $data['applicants'] = $this->applicants_model->get_all_applicants(array('limit'=>$this->perPage,'job_id'=>$job_id));

        $data['applicant_all_count'] = $this->applicants_model->get_count_all($job_id);
        $data['applicant_new_count'] = $this->applicants_model->get_counts($job_id,'1');
        $data['applicant_shortlist_count'] = $this->applicants_model->get_counts($job_id,'2');
        $data['applicant_rejected_count'] = $this->applicants_model->get_counts($job_id,'3');

        $data['page'] = 'admin/jobs/detail_view';
        $this->load->view('templates/admin_template', $data);


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


    public function db()
    {
        // Load the DB utility class
        $this->load->dbutil();
        $prefs = array(
            'tables' => array('schools', 'candidates'),   // Array of tables to backup.
            'ignore' => array(),                     // List of tables to omit from the backup
            'format' => 'gzip',                       // gzip, zip, txt
            'filename' => 'mybackup.gzip',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE,                        // Whether to add INSERT data to backup file
            'newline' => "\n"                         // Newline character used in backup file
        );
        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('file');
        write_file('./db/ze_' . date('d-M-Y(h-s-i)') . '.gzip', $backup);
        //echo "Back up done";
        //$this->ci_alerts->set('success', 'Backuped Successfully');

    }



}