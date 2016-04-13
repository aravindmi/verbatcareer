<?php

/**
 * Jobs_model Class
 * @package Webpagetest
 * @subpackage admin
 * @category Controller
 * @author AMI
 * */
class Jobs_model extends MY_Model {


    public function __construct() {

        parent::__construct();


        $this->jobs_table = 'jobs';
        $this->applicants_table = 'applicants';

        $this->_table = $this->jobs_table;
        $this->primary_key = 'job_id';
    }

    function get_all_jobs($order_by = '') {



        if($order_by == ''){

            $order_by = '`jobs`.`created_at`';
        }



        $sql = "SELECT `jobs`.*,`job_categories`.*,`job_locations`.*,`job_emails`.*, COUNT(applicants.applicant_id) AS application_count
                FROM `jobs`
                LEFT JOIN `applicants` ON (`applicants`.`job_id` =`jobs`.`job_id` AND `applicants`.`deleted` = '0')
                LEFT JOIN `job_categories` ON `jobs`.`job_category_id` =`job_categories`.`job_category_id`
                LEFT JOIN `job_locations` ON `jobs`.`job_location_id` =`job_locations`.`job_location_id`
                 LEFT JOIN `job_emails` ON `jobs`.`job_email_id` =`job_emails`.`job_email_id`
                WHERE `jobs`.`deleted` = '0'
                GROUP BY `jobs`.`job_id`
                ORDER BY ".$order_by;
        $result = $this->db->query($sql);

        return $result->result();

    }

    function get_all_open_jobs($location_id = '',$category_id = '',$order_by = '') {

        if($order_by == ''){

            $order_by = '`jobs`.`created_at` DESC';
        }
if($category_id != ''){

            $category = " AND `jobs`.`job_category_id` = '".$category_id."'";

        }else{

			$category = ' ';
		}

		if($location_id != ''){

           $location = " AND `jobs`.`job_location_id` = '".$location_id."'";


        }else{

			$location = '';

		}
        $sql = "SELECT `jobs`.*,`job_categories`.*,`job_locations`.*,`job_emails`.*, COUNT(applicants.applicant_id) AS application_count
                FROM `jobs`
                LEFT JOIN `applicants` ON (`applicants`.`job_id` =`jobs`.`job_id` AND `applicants`.`deleted` = '0')
                JOIN `job_categories` ON `jobs`.`job_category_id` =`job_categories`.`job_category_id`
                JOIN `job_locations` ON `jobs`.`job_location_id` =`job_locations`.`job_location_id`
                JOIN `job_emails` ON `jobs`.`job_email_id` =`job_emails`.`job_email_id`
                WHERE `jobs`.`deleted` = '0'
                AND `jobs`.`job_status` = '1'
				".$category.$location."
                GROUP BY `jobs`.`job_id`
                ORDER BY ".$order_by;
        $result = $this->db->query($sql);

        return $result->result();

    }


    function get_job_by_slug($job_slug) {

        $sql = "SELECT `jobs`.*,`job_categories`.*,`job_locations`.*, `job_emails`.*
                FROM `jobs`
                LEFT JOIN `job_categories` ON `jobs`.`job_category_id` =`job_categories`.`job_category_id`
                LEFT JOIN `job_locations` ON `jobs`.`job_location_id` =`job_locations`.`job_location_id`
                LEFT JOIN `job_emails` ON `jobs`.`job_email_id` =`job_emails`.`job_email_id`
                WHERE `jobs`.`deleted` = '0' AND `jobs`.`job_slug`='$job_slug'";
        $result = $this->db->query($sql);

        return $result->row();

    }

    function get_job_by_category($cat_id) {

        $sql = "SELECT `jobs`.*,`job_categories`.*,`job_locations`.*,`job_emails`.*
                FROM `jobs`
                LEFT JOIN `job_categories` ON `jobs`.`job_category_id` =`job_categories`.`job_category_id`
                LEFT JOIN `job_locations` ON `jobs`.`job_location_id` =`job_locations`.`job_location_id`
                LEFT JOIN `job_emails` ON `jobs`.`job_email_id` =`job_emails`.`job_email_id`
                WHERE `jobs`.`deleted` = '0' AND `jobs`.`job_status` = '1' AND `job_categories`.`job_category_id`='$cat_id' LIMIT 5";
        $result = $this->db->query($sql);

        return $result->result();

    }

    function get_job_by_category_slug($cat_slug) {

        $sql = "SELECT `jobs`.*,`job_categories`.*,`job_locations`.*,`job_emails`.*
                FROM `jobs`
                LEFT JOIN `job_categories` ON `jobs`.`job_category_id` =`job_categories`.`job_category_id`
                LEFT JOIN `job_locations` ON `jobs`.`job_location_id` =`job_locations`.`job_location_id`
                LEFT JOIN `job_emails` ON `jobs`.`job_email_id` =`job_emails`.`job_email_id`
                WHERE `jobs`.`deleted` = '0' AND `jobs`.`job_status` = '1' AND `job_categories`.`job_category_slug`='$cat_slug'";
        $result = $this->db->query($sql);

        return $result->result();

    }

}

/* End of file admin_model.php */ 