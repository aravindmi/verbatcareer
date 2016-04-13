<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emails extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('job_emails_model');


        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

    }

    public function index()
    {


        $data['menu'] = 'settings';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "Locations";
        $current_page = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 0;

        $total_rows = $this->job_emails_model->count_all();
        $config = array();
        $config['base_url'] = site_url('admin/emails/index');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['data'] = $this->job_emails_model->limit($config['per_page'], $current_page)->get_all();

        $data['page'] = 'admin/emails/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create()
    {

        $this->form_validation->set_rules('job_email_title', 'Email', "required|trim|max_length[200]|valid_email");
        
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_email_title' => $this->input->post('job_email_title')
                
            );

            $l_id = $this->job_emails_model->insert($insert_data);

            if (!$l_id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/emails");

            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/emails");
            }
        } else {

            $data['menu'] = 'settings';
            $data['page'] = 'admin/emails/create_view';
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($id)
    {

        $this->form_validation->set_rules('job_email_title', 'Email', "required|trim|max_length[200]|valid_email");

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_email_title' => $this->input->post('job_email_title'),
                
            );

            $update = $this->job_emails_model->update($id, $insert_data);

            if ($update) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/emails/update/" . $id);
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/emails/update/" . $id);
            }
        } else {

            $data['menu'] = 'settings';

            $data['data'] = $this->job_emails_model->get($id);

            $data['page'] = 'admin/emails/update_view';
            $this->load->view('templates/admin_template', $data);
        }
    }




    /**
     * Delete
     */
    public function delete($id)
    {

        $insert_data = array(
            'deleted' => 1

        );

        if ($this->job_emails_model->update($id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/emails/");

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/emails/");
        }
    }



}