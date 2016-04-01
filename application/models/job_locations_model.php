<?php

/**
 * Admin_model Class 
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Job_locations_model extends MY_Model {


    public function __construct() {

        parent::__construct();

        $this->_table = 'job_locations';
        $this->primary_key = 'job_location_id';

    }


}

/* End of file admin_model.php */ 