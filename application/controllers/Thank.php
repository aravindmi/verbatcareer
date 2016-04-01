<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Thank extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();



    }

    public function you($applicant_id = '')
    {
        $data['applicant_id'] = $applicant_id;
        $data['page'] = 'frontend/thankyou_view';
        $this->load->view('templates/frontend_template', $data);
    }
}