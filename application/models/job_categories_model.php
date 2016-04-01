<?php

/**
 * Admin_model Class 
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Job_categories_model extends MY_Model {


    public function __construct() {

        parent::__construct();

        $this->_table = 'job_categories';
        $this->primary_key = 'job_category_id';

    }


}

/* End of file admin_model.php */ 