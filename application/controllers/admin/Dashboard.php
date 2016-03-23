<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('auth_model');
        //$this->output->enable_profiler(TRUE);
        if (!is_admin()) {

            redirect(site_url('auth/login'));

        }

        $this->load->model('dashboard_model');


    }

    public function index()
    {

        $data['menu'] = 'dashboard';
        $data['jobs_count'] = $this->dashboard_model->get_jobs_count();
        $data['applicants_count'] = $this->dashboard_model->get_applicants_count();
		


        $data['page'] = 'admin/dashboard_view';

        $data['page'] = 'admin/dashboard_view';
        $this->load->view('templates/admin_template',$data);

    }


}
