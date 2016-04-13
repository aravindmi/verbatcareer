<?php

/**
 * Admin_model Class 
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Job_emails_model extends MY_Model {


    public function __construct() {

        parent::__construct();

        $this->_table = 'job_emails';
        $this->primary_key = 'job_email_id';
        $this->soft_delete = TRUE;

    }


}

/* End of file admin_model.php */ 