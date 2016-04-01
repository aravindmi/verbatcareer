<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('jobs_model');
        $this->load->model('applicants_model');
        $this->load->model('job_categories_model');
        $this->load->model('job_locations_model');

        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

        $this->load->library('Ajax_pagination');

        $this->_created_date = date("d-m-Y");

        $this->perPage = '10';

    }

    public function index()
    {

        $data['jobs'] = $this->jobs_model->get_all_jobs();
        $data['menu'] = 'jobs';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Opportunities";

        $data['page'] = 'admin/jobs/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create()
    {

        $this->form_validation->set_rules('job_title', 'Job Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_slug', 'Job Slug', 'required|trim|max_length[300]|alpha_dash|is_unique[jobs.job_slug]');
        $this->form_validation->set_rules('job_code', 'Job Code', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_id', 'Job Category', 'required|trim|max_length[10]|integer');
        $this->form_validation->set_rules('job_location_id', 'Job Location', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_sub_location', 'Job Sub Location', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_experience', 'Job Experience', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('job_vacancies', 'Job Vacancies', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_status', 'Job Status', 'required|trim|max_length[1]|integer');
        $this->form_validation->set_rules('job_description', 'Job Description', "required|trim|max_length[5000]");
        $this->form_validation->set_rules('job_seo_title', 'Job SEO Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('job_seo_description', 'Job SEO Description', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('job_logo_text', 'Job Logo Text', 'required|trim|max_length[3]');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_title' => $this->input->post('job_title'),
                'job_slug' => $this->input->post('job_slug'),
                'job_code' => $this->input->post('job_code'),
                'job_category_id' => $this->input->post('job_category_id'),
                'job_location_id' => $this->input->post('job_location_id'),
                'job_sub_location' => $this->input->post('job_sub_location'),
                'job_experience' => $this->input->post('job_experience'),
                'job_vacancies' => $this->input->post('job_vacancies'),
                'job_status' => $this->input->post('job_status'),
                'job_description' => $this->input->post('job_description'),
                'job_seo_title' => $this->input->post('job_seo_title'),
                'job_seo_description' => $this->input->post('job_seo_description'),
                'job_logo_text' => $this->input->post('job_logo_text'),
                'created_at' => $this->_created_at,
                'created_by' => $this->_created_by
            );

            $job_id = $this->jobs_model->insert($insert_data);

            if (!$job_id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/jobs");

            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/jobs");
            }
        } else {

            $data['menu'] = 'jobs';
            $data['page'] = 'admin/jobs/create_view';

            $data['job_categories'] = $this->job_categories_model->get_all();
            $data['job_locations'] = $this->job_locations_model->get_all();
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($job_id, $job_slug)
    {

        if($this->input->post('job_slug') != $job_slug) {
            $is_unique =  '|is_unique[jobs.job_slug]';
        } else {
            $is_unique =  '';
        }

        $this->form_validation->set_rules('job_title', 'Job Title', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_slug', 'Job Slug', 'required|trim|max_length[300]|alpha_dash'.$is_unique);
        $this->form_validation->set_rules('job_code', 'Job Code', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_category_id', 'Job Category', 'required|trim|max_length[10]|integer');
        $this->form_validation->set_rules('job_sub_location', 'Job Sub Location', "required|trim|max_length[200]");
        $this->form_validation->set_rules('job_location_id', 'Job Location', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_experience', 'Job Experience', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('job_vacancies', 'Job Vacancies', "required|trim|max_length[10]|integer");
        $this->form_validation->set_rules('job_status', 'Job Status', 'required|trim|max_length[1]|integer');
        $this->form_validation->set_rules('job_description', 'Job Description', "required|trim|max_length[5000]");
        $this->form_validation->set_rules('job_seo_title', 'Job SEO Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('job_seo_description', 'Job SEO Description', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('job_logo_text', 'Job Logo Text', 'required|trim|max_length[3]');


        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'job_title' => $this->input->post('job_title'),
                'job_slug' => $this->input->post('job_slug'),
                'job_code' => $this->input->post('job_code'),
                'job_category_id' => $this->input->post('job_category_id'),
                'job_location_id' => $this->input->post('job_location_id'),
                'job_sub_location' => $this->input->post('job_sub_location'),
                'job_experience' => $this->input->post('job_experience'),
                'job_vacancies' => $this->input->post('job_vacancies'),
                'job_status' => $this->input->post('job_status'),
                'job_description' => $this->input->post('job_description'),
                'job_seo_title' => $this->input->post('job_seo_title'),
                'job_seo_description' => $this->input->post('job_seo_description'),
                'job_logo_text' => $this->input->post('job_logo_text'),
                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->jobs_model->update($job_id, $insert_data)) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/jobs/view/" . $job_id);
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/jobs/view/" . $job_id);
            }
        } else {

            $data['menu'] = 'jobs';

            $data['job_categories'] = $this->job_categories_model->get_all();
            $data['job_locations'] = $this->job_locations_model->get_all();

            $data['job_data'] = $this->jobs_model->get($job_id);

            $data['page'] = 'admin/jobs/update_view';
            $this->load->view('templates/admin_template', $data);
        }
    }



    /**
     * Project view
     */
    function view($job_id)
    {

        if ($job_id == null) {

            $this->ci_alerts->set('error', 'Job ID not found');
            redirect('admin/jobs');
        }


        $data['menu'] = 'jobs';
        $data['job_id'] = $job_id;

        $data['job_categories'] = $this->job_categories_model->get_all();
        $data['job_locations'] = $this->job_locations_model->get_all();
        $data['job_data'] = $this->jobs_model->get($job_id);
        //$data['job'] = $this->jobs_model->get_one_job($job_id);

        //total rows count
        $totalRec = count($this->applicants_model->get_all_applicants(array('job_id'=>$job_id)));

        //pagination configuration
        $config['first_link']  = 'First';
        $config['div']         = 'applicants_list'; //parent div tag id
        $config['base_url']    = site_url().'admin/applicants/ajax_applicants/'.$job_id;
        $config['uri_segment'] = 5;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;

        $this->ajax_pagination->initialize($config);

        //get the applicants data
        $data['applicants'] = $this->applicants_model->get_all_applicants(array('limit'=>$this->perPage,'job_id'=>$job_id));

        $data['page'] = 'admin/jobs/detail_view';
        $this->load->view('templates/admin_template', $data);


    }




    /**
     * Delete
     */
    public function delete($job_id)
    {

        $insert_data = array(
            'deleted' => 1,
            'updated_at' => $this->_created_at,
            'updated_by' => $this->_created_by

        );

        if ($this->jobs_model->update($job_id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/jobs/");

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/jobs/");
        }
    }

    function upload($school_id = null)
    {
        if ($school_id == null) {

            $this->ci_alerts->set('error', 'School ID not found');
            redirect('admin/candidates');
        }

        $school_data = $this->school_model->getOneSchools($school_id);

        if (count($school_data) <= 0) {

            $this->ci_alerts->set('error', 'School ID not found');
            redirect('admin/candidates');
        }


        $config_upload['upload_path'] = $this->config->item('CANDIDATE_UPLOAD_PATH');
        $config_upload['allowed_types'] = $this->config->item('CANDIDATE_UPLOAD_TYPES');
        $config_upload['max_size'] = $this->config->item('CANDIDATE_UPLOAD_SIZE_LIMIT');
        $config_upload['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config_upload);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!$this->upload->do_upload()) {
                $data['upload_error'] = $this->upload->display_errors();
                $data['school_id'] = $school_id;

                $data['school_data'] = $school_data;

                $data['page'] = 'admin/candidates/upload_view';

                $this->load->view('templates/admin_template', $data);

            } else {

                $upload_data = $this->upload->data();

                $this->process_upload($school_id, $upload_data['file_name'], $upload_data['orig_name']);

            }
        } else {

            $data['school_id'] = $school_id;

            $data['school_data'] = $school_data;
            $data['menu'] = 'candidates';
            $data['page'] = 'admin/candidates/upload_view';
            $this->load->view('templates/admin_template', $data);
        }


    }

    /**
     * Process Uploaded Excel
     * @param $form_id
     * @param string $file_name
     */

    public function process_upload($school_id, $file_name = '', $origin_file = '', $temp = FALSE)
    {
        if ($file_name == '') {

            $this->ci_alerts->set('error', 'File Name no present !!');
            redirect('admin/candidates/upload/' . $school_id);
        }

        if ($school_id == '') {

            $this->ci_alerts->set('error', $this->config->item('School ID not present !!!'));
            redirect('admin/candidates/upload/' . $school_id);
        }


        $filename_date = date('mdyHsi');

        $excel_data = array();
        $filepath = './uploads/candidates/' . $file_name;

        if (!is_readable($filepath)) {

            $this->ci_alerts->set('error', 'File is not readable !!');
            redirect('admin/candidates/upload/' . $school_id);
        }

        //BAckup DB
        $this->db();
        //$ext = pathinfo($filepath, PATHINFO_EXTENSION);

        //ini_set('max_execution_time', '50000000');
        //echo $id;

        //$file_name_indb = $filename_date . '-' . $file_name;

        //$this->load->library('Excel');
        $this->load->library('SpreadsheetReader');

        try {


            $reader = new SpreadsheetReader($filepath);
            $i = 1;

            foreach ($reader as $row) {

                if ($i == 1) {

                    if (trim($row[0]) != 'NAME' || trim($row[1]) != 'CLASS') {

                        $this->ci_alerts->set('error', 'Incorrect Format');
                        redirect('admin/candidates/upload/' . $school_id);

                    }

                }

                $i++;

                //$count = count($row);
                //Backup DB


                if (count($row) > 1 && $row[0] != "NAME" && $row[1] != 'CLASS') {

                    $excel_data['school_id'] = $school_id;
                    $excel_data['candidate_name'] = $row[0];
                    $excel_data['candidate_class'] = $row[1];
                    $excel_data['candidate_class_alias'] = isset($row[3]) ? $row[3] : '';
                    //$excel_data['candidate_mark'] = isset($row[4]) ? $row[4] : '';


                    $excel_data['updated_at'] = $this->_updated_at;
                    $excel_data['updated_by'] = $this->_updated_by;

                    $excel_data['upload_file_name'] = $origin_file . '-' . $file_name;


                    if (isset($row[2]) && $row[2] != '' && $row[2] != '0') {

                        $current_candidate = $this->candidate_model->get_by('candidate_id', $row[2]);

                    } else {

                        $current_candidate = '';
                    }


                    if ($current_candidate) {

                        $this->candidate_model->update($current_candidate->candidate_id, $excel_data);

                    } else {

                        $excel_data['created_at'] = $this->_created_at;
                        $excel_data['created_by'] = $this->_created_by;

                        $this->candidate_model->insert($excel_data);

                    }


                }

            }


            $this->ci_alerts->set('success', 'Candidates details, Imported successfully');
            redirect('admin/candidates/view/' . $school_id);


        } catch (Exception $E) {

            echo $E->getMessage();
            $this->ci_alerts->set('error', $E->getMessage());
            redirect('admin/candidates');
        }

    }

    /**
     * Gen PDF
     */

    public function gen_pdf($school_id)
    {
        $this->load->library('pdf'); // Load library

        $school_data = $this->school_model->get($school_id);
        //$header =  array('Sl.No.', 'NAME', 'CLASS', 'ID');
        $data = $this->candidate_model->get_candidates($school_id);

        $award_data = $this->candidate_model->get_candidates_awards($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }
        $last_page = false;

        if ($school_data) {
            if ($last_page) {
                //do noithing
            } else {
                $this->pdf->title = 'AWARD LIST';
                $this->pdf->pdftype = 'candidates';
                $this->pdf->school_name = $school_data->school_name;
                $this->pdf->place = $school_data->place;
                $this->pdf->school_id = $school_data->school_id;
                $this->pdf->header = array('Sl.No.', 'NAME', 'CLASS', 'ID', 'AWARD');
                $w = array(20, 75, 25, 20, 50);
                $this->pdf->wdth = $w;

                $this->pdf->AddPage();
                $this->pdf->AliasNbPages();
            }


            $c = 1;
            foreach ($data as $row) {
                $this->pdf->Cell($w[0], 6, $c, '1');
                $this->pdf->Cell($w[1], 6, $row->candidate_name, '1');
                $this->pdf->Cell($w[2], 6, $row->candidate_class_alias == '' ? $row->candidate_class : $row->candidate_class_alias, '1', 0, 'C');
                $this->pdf->Cell($w[3], 6, $row->candidate_id, '1', 0, 'C');
                $this->pdf->Cell($w[4], 6, $row->candidate_award, '1');
                $this->pdf->Ln();
                $c++;
            }


            if (count($award_data) > 0) {

                $last_page = true;
                $this->pdf->title = 'AWARD LIST';
                $this->pdf->pdftype = 'candidates';
                $this->pdf->school_name = $school_data->school_name;
                $this->pdf->place = $school_data->place;
                $this->pdf->school_id = $school_data->school_id;

                $this->pdf->header = array('Sl.No.', 'Award Name', 'Total');
                $w = array(20, 90, 40);
                $this->pdf->wdth = $w;
                $this->pdf->AddPage();
                $this->pdf->AliasNbPages();


                $c = 1;

                foreach ($award_data as $row) {
					
					
 				 switch ($row->candidate_award) {
						case "Zest Acer":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "Green Scholar":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "ACE Scholar":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "ACE Star":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "ACE Master":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "ACE Perfect":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "ACE Solace":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						case "Absent":
							$this->pdf->Cell($w[0], 6, $c, '1', 0, 'C');
							$this->pdf->Cell($w[1], 6, $row->candidate_award, '1', 0, 'C');
							$this->pdf->Cell($w[2], 6, $row->award_count, '1', 0, 'C');
							$this->pdf->Ln();
						break;
						default:
						//do nothing
					}
					
                    $c++;

                }


                $this->pdf->Ln(30);
                $this->pdf->SetFont('Arial','B');
                $this->pdf->Cell(150, 6, 'Award Categorisation', '1', 0, 'C');
                $this->pdf->SetFont('Arial','',9);
                $this->pdf->Ln(20);

                $this->pdf->Cell(10, 0, '1', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'GREEN SCHOLAR (Marks above 95 %)', '0');
                $this->pdf->Cell(100, 0, 'Rs.500 Prize Money, Trophy & Certificate.', '0');
                $this->pdf->Ln(5);
                $this->pdf->Cell(10, 0, '2', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'ACE SCHOLAR  (Marks above 90-95 %)', '0');
                $this->pdf->Cell(100, 0, 'Rs.250 Prize Money, Trophy & Certificate.', '0');
                $this->pdf->Ln(5);
                $this->pdf->Cell(10, 0, '3', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'ACE STAR  (Marks above 85- 89 %)', '0');
                $this->pdf->Cell(100, 0, 'Rs.150 Prize Money, Gold Medal & Certificate.', '0');
                $this->pdf->Ln(5);
                $this->pdf->Cell(10, 0, '4', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'ACE MASTER  (Marks above 80 - 84 %)', '0');
                $this->pdf->Cell(100, 0, 'Rs.100 Prize Money, Silver Medal & Certificate.', '0');
                $this->pdf->Ln(5);
                $this->pdf->Cell(10, 0, '5', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'ACE PERFECT  (Marks above  70 -79 %)', '0');
                $this->pdf->Cell(100, 0, 'Certificate & Bronze Medal.', '0');
                $this->pdf->Ln(5);
                $this->pdf->Cell(10, 0, '6', '0', 0, 'C');
                $this->pdf->Cell(70, 0, 'ACE SOLACE  (Marks above 60 - 69 %)', '0');
                $this->pdf->Cell(100, 0, 'Certificate only.', '0');
                $this->pdf->Ln(5);


            }

            // Closing line
            $this->pdf->Cell(array_sum($w), 0, '', 'T');

            $file_name = $school_data->school_name . '-' . $school_data->place . '_' . $this->_created_date . '.pdf';

            $this->pdf->Output($file_name, 'D');
        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }

    /**
     * Gen candidate list PDF
     */

    public function gen_candidate_list($school_id)
    {
        $this->load->library('pdf'); // Load library
        $school_data = $this->school_model->getOneSchools($school_id);
        //$header =  array('Sl.No.', 'NAME', 'CLASS', 'ID');
        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        if ($school_data) {

            $this->pdf->title = 'CANDIDATES LIST';
            $this->pdf->pdftype = 'candidates';
            $this->pdf->school_name = $school_data->school_name;
            $this->pdf->place = $school_data->place;
            $this->pdf->school_id = $school_data->school_id;


            $this->pdf->header = array('Sl.No.', 'Reg.No.', 'NAME', 'CLASS');
            $w = array(20, 30, 80, 50);
            $this->pdf->wdth = $w;

            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();

            $c = 1;
            foreach ($data as $row) {
                $this->pdf->Cell($w[0], 6, $c, '1');
                $this->pdf->Cell($w[1], 6, $row->candidate_id, '1', 0, 'C');
                $this->pdf->Cell($w[2], 6, $row->candidate_name, '1');
                $this->pdf->Cell($w[3], 6, $row->candidate_class_alias == '' ? $row->candidate_class : $row->candidate_class_alias, '1', 0, 'C');

                $this->pdf->Ln();
                $c++;
            }


            // Closing line
            $this->pdf->Cell(array_sum($w), 0, '', 'T');

            $file_name = strtoupper($school_data->district_name) . '-' . $school_data->school_name . '-' . $school_data->place . '_CL' . '.pdf';

            $this->pdf->Output($file_name, 'D');
        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }
	
	
	/**
     * Gen cenrtificate PDF
     */

    public function gen_certificate($school_id)
    {
        $this->load->library('tpdf'); // Load library
        $school_data = $this->school_model->getOneSchools($school_id);
        //$header =  array('Sl.No.', 'NAME', 'CLASS', 'ID');
        $data = $this->candidate_model->get_candidates_with_awards($school_id);

        if ($school_data && count($data)>0) {

				$c = 0;
				$site_url = site_url();
				$img_file = $site_url . 'assets/images/certi_new.jpg';
				
				$pdf = new Tpdf('P', 'mm', 'A4', true, 'UTF-8', false);
				
				$pdf->SetHeaderMargin(0);
				$pdf->SetFooterMargin(0);

				// remove default header/footer
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);
				
				// set margins
				$pdf->SetMargins(0, 0, 0, true);

				// set auto page breaks false
				$pdf->SetAutoPageBreak(false, 0);

				// define barcode style
				$style = array(
					'border' => 0,
					'vpadding' => 'auto',
					'hpadding' => 'auto',
					'fgcolor' => array(0,0,0),
					'bgcolor' => false, //array(255,255,255)
					'module_width' => 1, // width of a single module in points
					'module_height' => 1 // height of a single module in points
				);
				
				$linestyle = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'phase' => 0,'color' => array(200, 200, 200));
				
				$html = '';
				
			    foreach ($data as $row) {
					
					
					
					if(fmod($c,2) == 0){
						
						$pdf->AddPage('L', 'A3');
						$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
					
						
						$pdf->SetFont('helvetica', 'B', 18);
						$pdf->MultiCell(210, 0, $row->candidate_name, 0, 'C', 0, 1, 0, 154, true);
						
						$pdf->SetFont('helvetica', '', 15);
						$pdf->MultiCell(210, 0, $school_data->school_name, 0, 'C', 0, 1, 0, 177, true);
						
						$pdf->SetFont('helvetica', 'B', 15);
						$pdf->MultiCell(168, 0, conver_classname($row->candidate_class), 0, 'R', 0, 1, 0, 195, true);
						
						$pdf->SetFont('helvetica', 'B', 18);
						$pdf->MultiCell(210, 0, strtoupper($row->candidate_award), 0, 'C', 0, 1, 0, 220, true);
						
						$pdf->SetFont('helvetica', '', 8);
						$pdf->MultiCell(186, 0, 'School Code: '.$school_data->school_id.', Place: '.$school_data->place, 0, 'R', 0, 1, 0, 280, true);
						
						$pdf->SetFont('helvetica', '', 10);
						$pdf->write2DBarcode('www.zestedu.in - Congrats '.$row->candidate_name, 'QRCODE,L', 15, 240, 25, 25, $style, 'N');

					}else{
						
						$pdf->Image($img_file, 210, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
						
						$pdf->SetFont('helvetica', 'B', 18);
						$pdf->MultiCell(210, 0, $row->candidate_name, 0, 'C', 0, 1, 210, 154, true);
						
						$pdf->SetFont('helvetica', '', 15);
						$pdf->MultiCell(210, 0, $school_data->school_name, 0, 'C', 0, 1, 210, 177, true);
						
						$pdf->SetFont('helvetica', 'B', 15);
						$pdf->MultiCell(168, 0, conver_classname($row->candidate_class), 0, 'R', 0, 1, 210, 195, true);
						
						$pdf->SetFont('helvetica', 'B', 18);
						$pdf->MultiCell(210, 0, strtoupper($row->candidate_award), 0, 'C', 0, 1, 210, 220, true);
						
						$pdf->SetFont('helvetica', '', 8);
						$pdf->MultiCell(186, 0, 'School Code: '.$school_data->school_id.', Place: '.$school_data->place, 0, 'R', 0, 1, 210, 280, true);
						
						$pdf->SetFont('helvetica', '', 10);
						$pdf->write2DBarcode('www.zestedu.in - Congrats '.$row->candidate_name, 'QRCODE,L', 225, 240, 25, 25, $style, 'N');
						$pdf->Line(210, 0, 210, 300, $linestyle);
					}
					
					$c++;
				}

				
				$pdf->writeHTML($html, true, false, true, false, '');
				//Close and output PDF document
				$file_name = strtoupper($school_data->district_name) . '-' . $school_data->school_name . '-' . $school_data->place . '_CF' . '.pdf';
				
				$pdf->Output($file_name, 'D');

			

        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }

    /**
     * Gen candidate list PDF
     */

    public function gen_attendance_sheet($school_id)
    {
        $this->load->library('pdf'); // Load library
        $school_data = $this->school_model->getOneSchools($school_id);
        //$header =  array('Sl.No.', 'NAME', 'CLASS', 'ID');
        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        if ($school_data) {

            $this->pdf->title = 'ATTENDANCE/MARK SHEET';
            $this->pdf->pdftype = 'candidates';
            $this->pdf->school_name = $school_data->school_name;
            $this->pdf->place = $school_data->place;
            $this->pdf->school_id = $school_data->school_id;
            $this->pdf->note = '*Must do the corrections in candidate\'s name if any.';

            $this->pdf->header = array('Sl.No.', 'Reg.No.', 'NAME', 'CLASS', 'ATTENDANCE', 'MARK');
            $w = array(15, 25, 60, 40, 30, 20);
            $this->pdf->wdth = $w;

            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();

            $c = 1;
            foreach ($data as $row) {
                $this->pdf->Cell($w[0], 6, $c, '1');
                $this->pdf->Cell($w[1], 6, $row->candidate_id, '1', 0);
                $this->pdf->Cell($w[2], 6, $row->candidate_name, '1');
                $this->pdf->Cell($w[3], 6, $row->candidate_class_alias == '' ? $row->candidate_class : $row->candidate_class_alias, '1', 0, 'C');
                $this->pdf->Cell($w[4], 6, '', '1');
                $this->pdf->Cell($w[5], 6, '', '1');

                $this->pdf->Ln();
                $c++;
            }

            // Closing line
            $this->pdf->Cell(array_sum($w), 0, '', 'T');

            $file_name = strtoupper($school_data->district_name) . '-' . $school_data->school_name . '-' . $school_data->place . '_AS' . '.pdf';

            $this->pdf->Output($file_name, 'D');
        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }

    public function gen_excel($school_id)
    {


        $school_data = $this->school_model->get($school_id);

        if (!$school_data) {
            $this->ci_alerts->set('error', 'School not found in the system');
            redirect('admin/candidates');
        }

        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        //$total_paid = $this->report_model->total_paid($event_id);
        //$total_unpaid = $this->report_model->total_unpaid($event_id);
        //load our new PHPExcel library
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($school_data->school_id);
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'NAME')->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('B1', 'CLASS')->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C1', 'ID')->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('D1', 'CLASSALIAS')->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('E1', 'AWARD')->getStyle('E1')->getFont()->setBold(true);
        //$this->excel->getActiveSheet()->setCellValue('F1', 'AWARD')->getStyle('F1')->getFont()->setBold(true);

        $exceldata = "";
        foreach ($data as $row) {

            $row_data = array();
            $row_data['NAME'] = $row->candidate_name;
            $row_data['CLASS'] = $row->candidate_class;
            $row_data['ID'] = $row->candidate_id;
            $row_data['CLASSALIAS'] = $row->candidate_class_alias;
            $row_data['MARK'] = $row->candidate_award;
            //$row_data['AWARD'] = '';

            $exceldata[] = $row_data;
        }

        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');


        $filename = $school_data->school_name . '-' . $school_data->place . '_' . $this->_created_date . '.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function db()
    {
        // Load the DB utility class
        $this->load->dbutil();
        $prefs = array(
            'tables' => array('schools', 'candidates'),   // Array of tables to backup.
            'ignore' => array(),                     // List of tables to omit from the backup
            'format' => 'gzip',                       // gzip, zip, txt
            'filename' => 'mybackup.gzip',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE,                        // Whether to add INSERT data to backup file
            'newline' => "\n"                         // Newline character used in backup file
        );
        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('file');
        write_file('./db/ze_' . date('d-M-Y(h-s-i)') . '.gzip', $backup);
        //echo "Back up done";
        //$this->ci_alerts->set('success', 'Backuped Successfully');

    }


    /**
     * Gen PDF
     */

    public function gen_hallticket_pdf($school_id)
    {
        $this->load->library('pdf'); // Load library
        $school_data = $this->school_model->getOneSchools($school_id);

        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        if ($school_data) {


            $this->pdf->noHeader = TRUE;
            $this->pdf->pdftype = '';
            $this->pdf->noFooter = TRUE;
            //$this->pdf->school_name = $school_data->school_name;
            //$this->pdf->place = $school_data->place;
            //$this->pdf->school_id = $school_data->school_id;

            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();

            $site_url = site_url();

            foreach ($data as $row) {
                /*
                                $this->pdf->Image($site_url . 'assets/images/hallticket_header.jpg', 5, null, 0);

                                $this->pdf->Ln(20);

                                $this->pdf->SetFont('Arial', '', 12);
                                $this->pdf->Cell(60, 10, 'Candidate\'s Name: '.$row->candidate_name, 0, 0, 'L');
                                // Move to the right
                                $this->pdf->Cell(85);

                                $this->pdf->Cell(40, 10, 'Class: '.conver_classname($row->candidate_class), 0, 0, 'R');
                                $this->pdf->Ln(20);
                                $this->pdf->SetFont('Arial', '', 12);
                                $this->pdf->Cell(60, 10, 'Exam Center: '.$school_data->school_name.' ('.$school_data->school_id.') - '.$school_data->place, 0, 0, 'L');
                                $this->pdf->Ln(20);

                                $this->pdf->Cell(60, 10, 'Register No: '.$row->candidate_id, 0, 0, 'L');
                                $this->pdf->Cell(45);

                                $this->pdf->Cell(80, 10, 'Exam Date & Time: '.show_date($school_data->exam_date).' (10.00 am to 12.00 pm)', 0, 0, 'R');
                                $this->pdf->SetDash(4, 2);

                                $current_y = $this->pdf->GetY();

                                $this->pdf->Line(5, $current_y + 20, 200, $current_y + 20);
                                $this->pdf->SetDash();

                                $this->pdf->Ln(25);
                 */
                //$this->pdf->Image($site_url . 'assets/images/a.jpg', 5, 0, 200);
                //$this->pdf->Ln(20);
                $this->pdf->SetFont('Arial', 'B', 12);
                $this->pdf->Cell(50);
                $this->pdf->Cell(30, 10, $row->candidate_id, 0, 0, 'L');
                $this->pdf->Cell(72);
                $this->pdf->Cell(30, 10, show_date($school_data->exam_date) . ' (10 am to 12 pm)', 0, 0, 'R');
                $this->pdf->Ln(17);
                $this->pdf->Cell(50);
                $this->pdf->Cell(60, 10, $row->candidate_name, 0, 0, 'L');
                $this->pdf->Cell(40);
                $this->pdf->Cell(40, 10, $row->candidate_class_alias == '' ? conver_classname($row->candidate_class) : $row->candidate_class_alias, 0, 0, 'L');
                $this->pdf->Ln(20);
                $this->pdf->Cell(50);
                $this->pdf->Cell(60, 10, $school_data->school_name . ' (' . $school_data->school_id . ')', 0, 0, 'L');
                $this->pdf->Ln(56);
            }

            // Closing line
            //$this->pdf->Cell(array_sum($w), 0, '', 'T');

            $file_name = strtoupper($school_data->district_name) . '-' . $school_data->school_name . '-' . $school_data->place . '_HS' . '.pdf';

            $this->pdf->Output($file_name, 'D');
            //$this->pdf->Output();
        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }


    /**
     * Gen PDF
     */

    public function gen_selected_hallticket_pdf()
    {
        $this->load->library('pdf'); // Load library
        $school_id = $this->input->post('school_id');

        if ($school_id == '') {

            $this->ci_alerts->set('error', 'No School ID found');
            redirect('admin/candidates');
        }

        $school_data = $this->school_model->getOneSchools($school_id);

        if (count($school_data) <= 0) {

            $this->ci_alerts->set('error', 'No School found with ID ' . $school_id);
            redirect('admin/candidates');
        }

        $candidate_id = $this->input->post('candidates_id[]');

        if (count($candidate_id) <= 0) {

            $this->ci_alerts->set('error', 'No candidates selected, please slect some candidates');
            redirect('admin/candidates/view/' . $school_id);
        }


        $data = $this->candidate_model->get_many_candidates($school_id, $candidate_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'Selected candidates not found in Database ');
            redirect('admin/candidates/view/' . $school_id);
        }


        if ($school_data) {


            $this->pdf->noHeader = TRUE;
            $this->pdf->pdftype = '';
            $this->pdf->noFooter = TRUE;
            //$this->pdf->school_name = $school_data->school_name;
            //$this->pdf->place = $school_data->place;
            //$this->pdf->school_id = $school_data->school_id;

            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();

            $site_url = site_url();

            foreach ($data as $row) {
                /*
                                $this->pdf->Image($site_url . 'assets/images/hallticket_header.jpg', 5, null, 0);

                                $this->pdf->Ln(20);

                                $this->pdf->SetFont('Arial', '', 12);
                                $this->pdf->Cell(60, 10, 'Candidate\'s Name: '.$row->candidate_name, 0, 0, 'L');
                                // Move to the right
                                $this->pdf->Cell(85);

                                $this->pdf->Cell(40, 10, 'Class: '.conver_classname($row->candidate_class), 0, 0, 'R');
                                $this->pdf->Ln(20);
                                $this->pdf->SetFont('Arial', '', 12);
                                $this->pdf->Cell(60, 10, 'Exam Center: '.$school_data->school_name.' ('.$school_data->school_id.') - '.$school_data->place, 0, 0, 'L');
                                $this->pdf->Ln(20);

                                $this->pdf->Cell(60, 10, 'Register No: '.$row->candidate_id, 0, 0, 'L');
                                $this->pdf->Cell(45);

                                $this->pdf->Cell(80, 10, 'Exam Date & Time: '.show_date($school_data->exam_date).' (10.00 am to 12.00 pm)', 0, 0, 'R');
                                $this->pdf->SetDash(4, 2);

                                $current_y = $this->pdf->GetY();

                                $this->pdf->Line(5, $current_y + 20, 200, $current_y + 20);
                                $this->pdf->SetDash();

                                $this->pdf->Ln(25);
                 */
                //$this->pdf->Image($site_url . 'assets/images/a.jpg', 5, 0, 200);
                //$this->pdf->Ln(20);
                $this->pdf->SetFont('Arial', 'B', 12);
                $this->pdf->Cell(50);
                $this->pdf->Cell(30, 10, $row->candidate_id, 0, 0, 'L');
                $this->pdf->Cell(80);
                $this->pdf->Cell(30, 10, show_date($school_data->exam_date) . ' (10 am to 12 pm)', 0, 0, 'R');
                $this->pdf->Ln(17);
                $this->pdf->Cell(50);
                $this->pdf->Cell(60, 10, $row->candidate_name, 0, 0, 'L');
                $this->pdf->Cell(40);
                $this->pdf->Cell(40, 10, $row->candidate_class_alias == '' ? conver_classname($row->candidate_class) : $row->candidate_class_alias, 0, 0, 'L');
                $this->pdf->Ln(21);
                $this->pdf->Cell(50);
                $this->pdf->Cell(60, 10, $school_data->school_name . ' (' . $school_data->school_id . ')', 0, 0, 'L');
                $this->pdf->Ln(61);
            }

            // Closing line
            //$this->pdf->Cell(array_sum($w), 0, '', 'T');

            $file_name = strtoupper($school_data->district_name) . '-' . $school_data->school_name . '-' . $school_data->place . '_HS' . '.pdf';

            $this->pdf->Output($file_name, 'D');
            //$this->pdf->Output();
        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }

    public function gen_seating_plan($school_id)
    {

        $school_data = $this->school_model->getOneSchools($school_id);

        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        if ($school_data) {

            $can_class = [];

            foreach ($data as $cn) {


                $can_class[$cn->candidate_class][] = $cn->candidate_id . ' (Std: ' . ($cn->candidate_class_alias == '' ? $cn->candidate_class : $cn->candidate_class_alias) . ')';

            }

            $seats = $this->seating_manager($can_class);


            $school_ukg = isset($can_class['UKG']) ? $can_class['UKG'] : array();
            $school_lkg = isset($can_class['LKG']) ? $can_class['LKG'] : array();
            $school_1 = isset($can_class['1']) ? $can_class['1'] : array();

            $lkg_count = count($school_lkg);
            $ukg_count = count($school_ukg);
            $I_count = count($school_1);


            $lkg_mod = 0;
            $ukg_mod = 0;
            $I_mod = 0;


            if ($lkg_count <= 22) {

                $lkg_d = 22;

            } else {
                $lkg_d = 16;
                $lkg_mod = $lkg_count % $lkg_d;
                for ($lkg_d; $lkg_mod < 12; $lkg_d++) {

                    $lkg_mod = $lkg_count % $lkg_d;

                }
            }

            if ($ukg_count <= 24) {

                $ukg_d = 24;

            } else {
                $ukg_d = 18;
                $ukg_mod = $ukg_count % $ukg_d;
                for ($ukg_d; $ukg_mod < 12; $ukg_d++) {

                    $ukg_mod = $ukg_count % $ukg_d;

                }
            }

            if ($I_count <= 30) {

                $I_d = 30;

            } else {
                $I_d = 24;
                $I_mod = $I_count % $I_d;
                for ($I_d; $I_mod < 12; $I_d++) {

                    $I_mod = $I_count % $I_d;

                }
            }


            $school_lkg = array_chunk($school_lkg, $lkg_d);
            $school_ukg = array_chunk($school_ukg, $ukg_d);
            $school_I = array_chunk($school_1, $I_d);


            //$school_lkg = array_chunk($school_lkg, '18');
            //$school_ukg = array_chunk($school_ukg, '24');
            //$school_I = array_chunk($school_1, '32');

            $this->load->library('lpdf');
            $this->lpdf->title = 'SEATING PLAN';
            $this->lpdf->pdftype = 'seating';

            $this->lpdf->school_name = $school_data->school_name;
            $this->lpdf->place = $school_data->place;
            $this->lpdf->school_id = $school_data->school_id;

            // $this->lpdf->AddPage();
            $this->lpdf->AliasNbPages();

            $h = 15;


            $this->lpdf->SetFont('Arial', '', 10);


            if (count($school_lkg) > 0) {

                foreach ($school_lkg as $k) {


                    $this->lpdf->total_candidate = count($k);
                    $this->lpdf->AddPage();

                    for ($xlkg = 0; $xlkg < ($lkg_d); $xlkg++) {

                        $this->lpdf->Cell(5);
                        $this->lpdf->Cell(40, $h, isset($k[$xlkg]) ? $k[$xlkg] : '', '1', 0, 'C', 0);
                        $this->lpdf->Cell(1);

                        if (($xlkg + 1) % 6 == 0) {


                            $this->lpdf->Ln($h + 5);
                        }

                    }

                }

            }

            if (count($school_ukg) > 0) {

                foreach ($school_ukg as $k) {


                    $this->lpdf->total_candidate = count($k);
                    $this->lpdf->AddPage();

                    for ($xlkg = 0; $xlkg < ($ukg_d); $xlkg++) {

                        $this->lpdf->Cell(5);
                        $this->lpdf->Cell(40, $h, isset($k[$xlkg]) ? $k[$xlkg] : '', '1', 0, 'C', 0);
                        $this->lpdf->Cell(1);

                        if (($xlkg + 1) % 6 == 0) {


                            $this->lpdf->Ln($h + 5);
                        }

                    }

                }

            }

            if (count($school_I) > 0) {

                foreach ($school_I as $k) {


                    $this->lpdf->total_candidate = count($k);
                    $this->lpdf->AddPage();

                    for ($xlkg = 0; $xlkg < ($I_d); $xlkg++) {

                        $this->lpdf->Cell(5);
                        $this->lpdf->Cell(40, $h, isset($k[$xlkg]) ? $k[$xlkg] : '', '1', 0, 'C', 0);
                        $this->lpdf->Cell(1);

                        if (($xlkg + 1) % 6 == 0) {


                            $this->lpdf->Ln($h + 5);
                        }

                    }

                }

            }

            $seats_count = count($seats);

            $seat_mod = 0;
            if ($seats_count <= 40) {

                $seat_d = 40;

            } else {
                $seat_d = 30;
                $seat_mod = $seats_count % $seat_d;

                for ($seat_d; $seat_mod < 10; $seat_d++) {

                    $seat_mod = $seats_count % $seat_d;

                }

            }


            $seats = array_chunk($seats, $seat_d);

            if (count($seats) > 0) {

                foreach ($seats as $s) {

                    $this->lpdf->total_candidate = count($s);
                    $this->lpdf->AddPage();

                    for ($x = 0; $x < ($seat_d); $x++) {

                        $this->lpdf->Cell(5);
                        $this->lpdf->Cell(40, $h, isset($s[$x]) ? $s[$x] : '', '1', 0, 'C', 0);
                        $this->lpdf->Cell(1);

                        if (($x + 1) % 6 == 0) {

                            $this->lpdf->Ln($h + 5);
                        }

                    }
                }
            }

            $file_name = strtoupper($school_data->district_name) . '_' . $school_data->school_name . '_SP.pdf';

            $this->lpdf->Output($file_name, 'D');
            //$this->lpdf->Output();


        } else {

            $this->ci_alerts->set('error', 'School not found');
            redirect('admin/candidates/');
        }


    }

    function seating_manager($school)
    {

        unset($school['UKG']);
        unset($school['LKG']);
        unset($school['1']);

        $seats = array();
        $i = 1;
        while (!empty($school)) {
            $first_class = array_shift($school);
            $second_class = array_shift($school);


            if (is_array($first_class)) {

                $first = array_splice($first_class, 0, 15);
            } else {

                $first = array();
            }

            if (is_array($second_class)) {

                $second = array_splice($second_class, 0, 15);
            } else {

                $second = array();
            }


            while (!empty($school) && count($first) < 15) {
                $first_class = array_shift($school);
                $first_add = array_splice($first_class, 0, (15 - count($first)));

                $first = array_merge($first, $first_add);


            }
            while (!empty($school) && count($second) < 15) {
                $second_class = array_shift($school);
                $second_add = array_splice($second_class, 0, (15 - count($second)));
                $second = array_merge($second, $second_add);

            }
            if (!empty($first_class)) {
                array_unshift($school, $first_class);


            }
            if (!empty($second_class)) {
                array_unshift($school, $second_class);
            }


            for ($j = 1; $j <= 30; $j++) {

                $seats['hall' . $i][$j] = ($j % 2 == 0) ? array_shift($second) : array_shift($first);

            }
            $i++;
        }

        $can = array();

        if (count($seats) > 0) {

            foreach ($seats as $s) {
                if (count($s) > 0) {

                    foreach ($s as $v) {
                        if ($v != '') {

                            $can[] = $v;
                        }

                    }

                }
            }
        }

        return $can;
    }
}