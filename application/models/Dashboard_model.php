<?php

class Dashboard_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();

        $this->jobs_table = 'jobs';
        $this->applicants_table = 'applicants';

    }

    function get_jobs_count()
    {
        $query = $this->db->select('count(job_id) as count')
            ->where('deleted', 0)
            ->get($this->jobs_table);
        $result = $query->first_row();
        return $result->count;
    }

    function get_applicants_count()
    {
        $query = $this->db->select('count(applicant_id) as count')
            ->where('deleted', 0)
            ->get($this->applicants_table);
        $result = $query->first_row();
        return $result->count;
    }
	

}
