<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('job_categories_model');


        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

    }

    public function index()
    {


        $data['menu'] = 'settings';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "categories";
        $current_page = ($this->uri->segment(4)) ? ($this->uri->segment(4)) : 0;

        $total_rows = $this->job_categories_model->count_all();
        $config = array();
        $config['base_url'] = site_url('admin/categories/index');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['data'] = $this->job_categories_model->limit($config['per_page'], $current_page)->get_all();

        $data['page'] = 'admin/categories/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create()
    {

        $this->form_validation->set_rules('job_category_title', 'category Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_slug', 'category Slug', "required|trim|max_length[300]|alpha_dash|is_unique[job_categories.job_category_slug]");

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_category_title' => $this->input->post('job_category_title'),
                'job_category_slug' => $this->input->post('job_category_slug')
            );

            $l_id = $this->job_categories_model->insert($insert_data);

            if (!$l_id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/categories");

            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/categories");
            }
        } else {

            $data['menu'] = 'settings';
            $data['page'] = 'admin/categories/create_view';
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($id,$slug)
    {

        if($this->input->post('job_category_slug') != $slug) {
            $is_unique =  '|is_unique[job_categories.job_category_slug]';
        } else {
            $is_unique =  '';
        }

        $this->form_validation->set_rules('job_category_title', 'category Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_slug', 'category Slug', "required|trim|max_length[300]|alpha_dash".$is_unique);



        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_category_title' => $this->input->post('job_category_title'),
                'job_category_slug' => $this->input->post('job_category_slug')
            );

            $update = $this->job_categories_model->update($id, $insert_data);

            if ($update) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/categories/update/" . $id.'/'.$slug);
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/categories/update/" . $id.'/'.$slug);
            }
        } else {

            $data['menu'] = 'settings';

            $data['data'] = $this->job_categories_model->get($id);

            $data['page'] = 'admin/categories/update_view';
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

        if ($this->job_categories_model->update($id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/categories/");

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/categories/");
        }
    }



}