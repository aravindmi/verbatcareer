<?php

/**
 * Applicants_model Class
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Applicants_model extends MY_Model {


    public function __construct() {

        parent::__construct();


        $this->jobs_table = 'jobs';
        $this->applicants_table = 'applicants';

        $this->_table = $this->applicants_table;
        $this->primary_key = 'applicant_id';
    }

    function get_all_applicants($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->applicants_table);
        $this->db->where('deleted',0);
        $this->db->where('job_id',$params['job_id']);
        $this->db->order_by('created_at','desc');

        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0)? $query->result():FALSE;
    }

}

/* End of file admin_model.php */ 