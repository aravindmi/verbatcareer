<?php

/**
 * Admin_model Class 
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Applicants_model extends MY_Model {


    public function __construct() {

        parent::__construct();


        $this->_table_schools = $this->config->item('TBL_SCHOOLS', 'DB_TABLES');;
        $this->_table_districts = 'districts';
        $this->_table_states = 'states';
        $this->_table_candidates = $this->config->item('TBL_CANDIDATES', 'DB_TABLES');

        $this->_table = $this->_table_candidates;
        $this->primary_key = 'candidate_id';
    }

    function get_candidates($school_id) {

        $sql = "SELECT `candidates`.*
                FROM `candidates`
                WHERE `candidates`.`deleted` = '0'
                AND `candidates`.`school_id` = '$school_id'
                ORDER BY LENGTH(`candidates`.`candidate_class`),`candidates`.`candidate_class`";
        $result = $this->db->query($sql);

        return $result->result();

    }
	
	function get_candidates_with_awards($school_id) {

        $sql = "SELECT `candidates`.*
                FROM `candidates`
                WHERE `candidates`.`deleted` = '0'
                AND `candidates`.`school_id` = '$school_id'
				AND `candidates`.`candidate_award` != 'Absent'
                ORDER BY LENGTH(`candidates`.`candidate_class`),`candidates`.`candidate_class`";
        $result = $this->db->query($sql);

        return $result->result();

    }

    function get_candidates_awards($school_id) {

        $sql = "SELECT `candidates`.`candidate_award`, COUNT(`candidates`.`candidate_award`) as award_count
                FROM `candidates`
                WHERE `candidates`.`deleted` = '0'
                AND `candidates`.`school_id` = '$school_id'
                GROUP BY `candidates`.`candidate_award`
                ORDER BY award_count DESC";
        $result = $this->db->query($sql);

        return $result->result();

    }

    function get_many_candidates($school_id, $candidate_id) {

        $c_id = implode("','",$candidate_id);

        $sql = "SELECT `candidates`.*
                FROM `candidates`
                WHERE `candidates`.`deleted` = '0'
                AND `candidates`.`school_id` = '$school_id'
                AND `candidates`.`candidate_id` IN ('$c_id')
                ORDER BY LENGTH(`candidates`.`candidate_class`),`candidates`.`candidate_class`";
        $result = $this->db->query($sql);

        return $result->result();

    }
    function get_count_class($school_id) {

        $sql = "SELECT CAST(`candidates`.`candidate_class` AS SIGNED) AS cast_col,`fees_master`.`amount`,`candidates`.`candidate_class`,COUNT(`candidates`.`candidate_id`) AS candidate_count
                FROM `candidates`
                LEFT JOIN `fees_master` ON `fees_master`.`class` = `candidates`.`candidate_class`
                WHERE `candidates`.`deleted` = '0'
                AND `candidates`.`school_id` = '$school_id'
                GROUP BY `candidates`.`candidate_class`
                ORDER BY cast_col";
        $result = $this->db->query($sql);

        return $result->result();

    }




}

/* End of file admin_model.php */ 