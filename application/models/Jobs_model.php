<?php

/**
 * Admin_model Class 
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI 
 * */
class Jobs_model extends MY_Model {


    public function __construct() {

        parent::__construct();


        $this->_table_schools = $this->config->item('TBL_SCHOOLS', 'DB_TABLES');;
        $this->_table_districts = 'districts';
        $this->_table_states = 'states';
        $this->_table_candidates = $this->config->item('TBL_CANDIDATES', 'DB_TABLES');

        $this->_table = $this->_table_schools;
        $this->primary_key = 'school_id';
    }

    function getAllSchools($order_by = '') {

        if($order_by == ''){

            $order_by = '`districts`.`district_name`';
        }

        $sql = "SELECT `schools`.*,`districts`.`district_name`, COUNT(candidates.candidate_id) AS candidates_count
                FROM `schools`
                LEFT JOIN `districts` ON `districts`.`id` =`schools`.`district_id`
                LEFT JOIN `states` ON `states`.`id` =`schools`.`state_id`
                LEFT JOIN `candidates` ON (`candidates`.`school_id` =`schools`.`school_id` AND `candidates`.`deleted` = '0')
                WHERE `schools`.`deleted` = '0'
                GROUP BY `schools`.`school_id`
                ORDER BY ".$order_by;
        $result = $this->db->query($sql);

        return $result->result();

    }

    function getAllSchools_supervisor_count($order_by = '') {

        if($order_by == ''){

            $order_by = '`districts`.`district_name`';
        }

        $sql = "SELECT `schools`.*,`districts`.`district_name`, COUNT(candidates.candidate_id) AS candidates_count,COUNT(supervisors.supervisor_id) AS supervisor_count
                FROM `schools`
                LEFT JOIN `districts` ON `districts`.`id` =`schools`.`district_id`
                LEFT JOIN `states` ON `states`.`id` =`schools`.`state_id`
                LEFT JOIN `candidates` ON (`candidates`.`school_id` =`schools`.`school_id` AND `candidates`.`deleted` = '0')
                LEFT JOIN `supervisors` ON (`supervisors`.`school_id` =`schools`.`school_id` AND `supervisors`.`deleted` = '0')
                WHERE `schools`.`deleted` = '0'
                GROUP BY `schools`.`school_id`
                ORDER BY ".$order_by;
        $result = $this->db->query($sql);

        return $result->result();

    }



    function getOneSchools($school_id) {

        $sql = "SELECT `schools`.*,`districts`.`district_name`,`states`.`state_name`,COUNT(candidates.candidate_id) AS candidates_count
                FROM `schools`
                LEFT JOIN `districts` ON `districts`.`id` =`schools`.`district_id`
                LEFT JOIN `states` ON `states`.`id` =`schools`.`state_id`
                LEFT JOIN `candidates` ON (`candidates`.`school_id` =`schools`.`school_id` AND `candidates`.`deleted` = '0')
                WHERE `schools`.`deleted` = '0' AND `schools`.`school_id`='$school_id'";
        $result = $this->db->query($sql);

        return $result->row();

    }
    function getClasswise() {


        $sql = "SELECT schools.school_id,schools.school_name,schools.place,districts.district_name,schools.exam_date,candidates.candidate_class, COUNT(candidates.candidate_id) AS candidates_count
                    FROM candidates
                    JOIN schools ON (schools.school_id = candidates.school_id AND schools.deleted ='0')
                    LEFT JOIN districts on (schools.district_id = districts.id)
                    WHERE candidates.deleted = '0'
                    GROUP BY schools.school_id,candidates.candidate_class
                    ORDER BY schools.exam_date ASC, districts.district_name";
        $result = $this->db->query($sql);

        return $result->result();

    }

}

/* End of file admin_model.php */ 