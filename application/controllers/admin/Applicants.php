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

    function update_status()
    {

        $this->form_validation->set_rules('candidate_id', 'Candidate ID', "required");
        $this->form_validation->set_rules('candidate_award', 'Award', 'required');


        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $candidate_id = $this->input->post('candidate_id');

            $update_data = array(
                'candidate_award' => $this->input->post('candidate_award'),
                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->candidate_model->update($candidate_id, $update_data)) {

                echo "success";

            } else {

                echo "failed";
            }
        } else {


            echo "failed";
        }
    }
}