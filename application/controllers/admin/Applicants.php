<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applicants extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('applicants_model');

        $this->load->library('Ajax_pagination');

        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

        $this->_created_date = date("d-m-Y");

        $this->perPage = '10';


        //$this->load->library('pdf'); // Load library

    }

    function ajax_applicants($job_id)
    {
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        //total rows count
        $totalRec = count($this->applicants_model->get_all_applicants(array('job_id'=>$job_id)));

        //pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'applicants_list'; //parent div tag id
        $config['base_url']    = base_url().'admin/applicants/ajax_applicants/'.$job_id;
        $config['uri_segment'] = 5;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['applicants'] = $this->applicants_model->get_all_applicants(array('start'=>$offset,'limit'=>$this->perPage,'job_id'=>$job_id));

        //load the view
        $this->load->view('admin/applicants/ajax_applicants_view', $data, false);
    }

    public function delete($applicant_id,$job_id)
    {

        $insert_data = array(
            'deleted' => 1,
            'updated_at' => $this->_created_at,
            'updated_by' => $this->_created_by

        );

        if ($this->applicants_model->update($applicant_id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/jobs/view/".$job_id);

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/jobs/view/".$job_id);
        }
    }

    function update_status()
    {

        $this->form_validation->set_rules('applicant_id', 'Applicant ID', "required");
        $this->form_validation->set_rules('applicant_status', 'Status', 'required');


        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $applicant_id = $this->input->post('applicant_id');

            $update_data = array(
                'applicant_status' => $this->input->post('applicant_status'),
                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->applicants_model->update($applicant_id, $update_data)) {

                echo "success";

            } else {

                echo "failed";
            }
        } else {


            echo "failed";
        }
    }
}