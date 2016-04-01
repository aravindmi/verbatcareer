<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        //$this->load->model('applicants_model');

        //$this->load->library('Ajax_pagination');

        $this->_created_at = date("Y-m-d H:i:s");

        $this->_updated_at = date("Y-m-d H:i:s");

        $this->perPage = '10';


        //$this->load->library('pdf'); // Load library

    }

    public function index()
    {

        //$data['jobs'] = $this->jobs_model->get_all_jobs();
        //$data['menu'] = 'jobs';
        //$data['links'] = $this->pagination->create_links();
        //$data['title'] = "List of Opportunities";

        $data['page'] = 'frontend/home_view';
        $this->load->view('templates/frontend_template', $data);
    }
}