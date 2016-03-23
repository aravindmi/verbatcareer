<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schools extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('school_model');
        $this->load->model('district_model');
        $this->load->model('state_model');
        $this->load->model('candidate_model');

        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

        $this->_created_date = date("d-m-Y");

        //$this->load->library('pdf'); // Load library

    }

    public function index($district_id = '')
    {

        $data['schools'] = $this->school_model->getAllSchools($district_id);
        $data['menu'] = 'schools';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Schools";

        $data['states'] = $this->state_model->get_all();
        $data['districts'] = $this->district_model->get_all();


        $data['page'] = 'admin/schools/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create()
    {


        $this->form_validation->set_rules('school_name', 'School Name', "required|trim|max_length[150]");
        $this->form_validation->set_rules('principal_name', 'Pricipal Name', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('place', 'Place', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('state_id', 'State', 'required');
        $this->form_validation->set_rules('district_id', 'Disctrict', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('address', 'Address', 'max_length[250]');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'max_length[150]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|max_length[12]');
        $this->form_validation->set_rules('contact_number_land', 'Contact Number (land)', 'max_length[12]');

        $this->form_validation->set_rules('exam_date', 'Exam Date', 'required');
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'school_name' => $this->input->post('school_name'),
                'principal_name' => $this->input->post('principal_name'),
                'place' => $this->input->post('place'),
                'state_id' => $this->input->post('state_id'),
                'district_id' => $this->input->post('district_id'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person' => $this->input->post('contact_person'),
                'contact_number' => $this->input->post('contact_number'),
                'contact_number_land' => $this->input->post('contact_number_land'),
                'details' => $this->input->post('details'),
                'exam_date' => add_date($this->input->post('exam_date')),
                'created_at' => $this->_created_at,
                'created_by' => $this->_created_by
            );

            $project_id = $this->school_model->insert($insert_data);
            if (!$project_id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/schools");
            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/schools");
            }
        } else {

            $data['menu'] = 'schools';

            $data['states'] = $this->state_model->get_all();
            $data['districts'] = $this->district_model->get_all();

            $data['date'] = TRUE;

            $data['page'] = 'admin/schools/create_view';
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($school_id)
    {

        $this->form_validation->set_rules('school_name', 'School Name', "required|trim|max_length[150]");
        $this->form_validation->set_rules('principal_name', 'Pricipal Name', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('place', 'Place', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('state_id', 'State', 'required');
        $this->form_validation->set_rules('district_id', 'Disctrict', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('address', 'Address', 'max_length[250]');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'max_length[150]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|max_length[12]');
        $this->form_validation->set_rules('details', 'Details', 'trim|max_length[250]');
        $this->form_validation->set_rules('exam_date', 'Exam Date', 'required');
        $this->form_validation->set_rules('contact_number_land', 'Contact Number (land)', 'max_length[12]');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'school_name' => $this->input->post('school_name'),
                'principal_name' => $this->input->post('principal_name'),
                'place' => $this->input->post('place'),
                'state_id' => $this->input->post('state_id'),
                'district_id' => $this->input->post('district_id'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'contact_person' => $this->input->post('contact_person'),
                'contact_number' => $this->input->post('contact_number'),
                'contact_number_land' => $this->input->post('contact_number_land'),
                'details' => $this->input->post('details'),
                'exam_date' => add_date($this->input->post('exam_date')),
                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->school_model->update($school_id, $insert_data)) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/schools");
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/schools");
            }
        } else {

            $data['menu'] = 'schools';

            $data['states'] = $this->state_model->get_all();
            $data['districts'] = $this->district_model->get_all();

            $data['school_data'] = $this->school_model->get($school_id);

            $data['date'] = TRUE;

            $data['page'] = 'admin/schools/update_view';
            $this->load->view('templates/admin_template', $data);
        }
    }

    /**
     * Project view
     */
    function view($school_id)
    {
        $candidate_data = array();
        $data['menu'] = 'schools';

        $data['school_data'] = $this->school_model->getOneSchools($school_id);
        $candidate_count = $this->candidate_model->get_count_class($school_id);

        if (count($candidate_count) > 0) {
            foreach ($candidate_count as $c) {

                $candidate_data[$c->candidate_class] = array('amount' => $c->amount, 'candidate_count' => $c->candidate_count);
            }

        }

        $data['candidate_data'] = $candidate_data;

        $data['page'] = 'admin/schools/detail_view';
        $this->load->view('templates/admin_template', $data);

    }

    /**
     * Delete
     */
    public function delete($user_id)
    {

        $insert_data = array(
            'deleted' => 1,
            'updated_at' => $this->_created_at,
            'updated_by' => $this->_created_by

        );

        if ($this->school_model->update($user_id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("schools");

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("schools");
        }
    }

    /**
     * Gen PDF
     */

    public function gen_pdf()
    {
        $this->load->library('lpdf');
        $schools = $this->school_model->getAllSchools();

        if (count($schools) <= 0) {

            $this->ci_alerts->set('error', 'No schools found ');
            redirect('admin/schools');
        }


        $this->lpdf->title = 'List of Schools ';
        $this->lpdf->pdftype = 'schools';
        $this->lpdf->header = array('Sl.No.', 'NAME', 'PRINCIPAL', 'PLACE', 'CONTACT #', '# CAN');

        $this->lpdf->AddPage();
        $this->lpdf->AliasNbPages();


        //$this->pdf->AddPage();
        // Column widths
        $w = array(15, 90, 60, 60, 40, 15);
        // Header
        //for($i=0;$i<count($header);$i++)
        //$this->pdf->Cell($w[$i],7,$header[$i],1,0,'C');
        //$this->pdf->Ln();
        // Data
        $c = 1;
        foreach ($schools as $row) {
            $this->lpdf->SetFont('Arial', '', 10);
            $this->lpdf->Cell($w[0], 6, $c,'1', 'L', 0);
            $this->lpdf->Cell($w[1], 6, $row->school_name,'1', 'R');
            $this->lpdf->SetFont('Arial', '', 9);
            $this->lpdf->Cell($w[2], 6, $row->principal_name,'1', 'R');
            $this->lpdf->SetFont('Arial', 'I', 8);
            $this->lpdf->Cell($w[3], 6, $row->place.'('.$row->district_name.')','1', 'R');
            $this->lpdf->SetFont('Arial', '', 10);
            $this->lpdf->Cell($w[4], 6, $row->contact_number,'1', 'R',  'C');
            $this->lpdf->SetFont('Arial', 'B', 12);
            $this->lpdf->Cell($w[5], 6, $row->candidates_count,'1', 'R',  'C');
            $this->lpdf->Ln();
            $c++;
        }
        // Closing line
        $this->lpdf->Cell(array_sum($w), 0, '', 'T');

        $file_name = 'School_list_' . $this->_created_date . '.pdf';

        $this->lpdf->Output($file_name, 'D');

    }

    /**
     * Gen PDF
     */

    public function gen_exam_date_pdf()
    {
        $this->load->library('lpdf');
        $schools = $this->school_model->getAllSchools('`schools`.`exam_date` ASC');

        if (count($schools) <= 0) {

            $this->ci_alerts->set('error', 'No schools found ');
            redirect('admin/schools');
        }


        $this->lpdf->title = 'List of Schools ';
        $this->lpdf->pdftype = 'schools';
        $this->lpdf->header = array('Sl.No.', 'NAME', 'PLACE', 'EXAM DATE', 'CONTACT #', '# CAN');

        $this->lpdf->AddPage();
        $this->lpdf->AliasNbPages();


        //$this->pdf->AddPage();
        // Column widths
        $w = array(15, 90, 60, 60, 40, 15);
        // Header
        //for($i=0;$i<count($header);$i++)
        //$this->pdf->Cell($w[$i],7,$header[$i],1,0,'C');
        //$this->pdf->Ln();
        // Data
        $c = 1;
        foreach ($schools as $row) {
            $this->lpdf->SetFont('Arial', '', 10);
            $this->lpdf->Cell($w[0], 6, $c,'1', 'L', 'L');
            $this->lpdf->Cell($w[1], 6, $row->school_name,'1', 'R');
            $this->lpdf->SetFont('Arial', 'I', 8);
            $this->lpdf->Cell($w[2], 6, $row->place.'('.$row->district_name.')','1', 'R');
            $this->lpdf->SetFont('Arial', 'B', 10);
            $this->lpdf->Cell($w[3], 6, $row->exam_date,'1', 'R',  'C');
            $this->lpdf->SetFont('Arial', '', 10);
            $this->lpdf->Cell($w[4], 6, $row->contact_number,'1', 'R',  'C');
            $this->lpdf->SetFont('Arial', 'B', 12);
            $this->lpdf->Cell($w[5], 6, $row->candidates_count,'1', 'R',  'C');
            $this->lpdf->Ln();
            $c++;
        }
        // Closing line
        $this->lpdf->Cell(array_sum($w), 0, '', 'T');

        $file_name = 'School_list_' . $this->_created_date . '.pdf';

        $this->lpdf->Output($file_name, 'D');

    }

    public function gen_detail_pdf($school_id)
    {
        $this->load->library('pdf');
        $candidate_data = [];

        $school_data = $this->school_model->getOneSchools($school_id);

        if (count($school_data) <= 0) {

            $this->ci_alerts->set('error', 'No schools found ');
            redirect('admin/schools');
        }


        $candidate_count = $this->candidate_model->get_count_class($school_id);
        if (count($candidate_count) > 0) {
            foreach ($candidate_count as $c) {

                $candidate_data[$c->candidate_class] = array('amount' => $c->amount, 'candidate_count' => $c->candidate_count);
            }

        }


        $this->pdf->title = 'Registration Form ';
        $this->pdf->pdftype = 'school_details';
        $this->pdf->school_name = $school_data->school_name;
        $this->pdf->place = $school_data->place;
        $this->pdf->school_id = $school_data->school_id;

        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();

        $header = array('Sl.No.', 'NAME');

//$this->pdf->AddPage();
// Column widths
        $w = array(55, 140);

        $this->pdf->SetFont('Arial', '', 12);

        $this->pdf->Cell($w['0'], 7, 'Pricipal Name', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, $school_data->principal_name, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 10, 'Address', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 10, $school_data->place . ',' . $school_data->address, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'District,State', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, strtoupper($school_data->district_name) . ',' . strtoupper($school_data->state_name), 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'E-mail', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, $school_data->email, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'Contact Person', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, $school_data->contact_person, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'Contact Number', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, $school_data->contact_number . ',' . $school_data->contact_number_land, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 10, 'Other Details(if any)', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 10, $school_data->details, 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'Exam Date', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, show_date($school_data->exam_date), 1, 0, 'L');
        $this->pdf->Ln();
        $this->pdf->Cell($w['0'], 7, 'Total Candidate Count', 1, 0, 'L');
        $this->pdf->Cell($w['1'], 7, $school_data->candidates_count, 1, 0, 'L');
        $this->pdf->Ln(10);

// Arial 12
        $this->pdf->SetFont('Arial', '', 12);
// Background color
        $this->pdf->SetFillColor(200, 220, 255);
// Title
        $this->pdf->Cell(0, 7, "Candidate Details", 0, 1, 'L', true);

        if (count($candidate_data) > 0) {

            $c_l1 = array();
            $c_l2 = array();
            $a_l1 = array();
            $a_l2 = array();
            $stl1 = array();
            $stl2 = array();


            $header_l1 = array('LKG', 'UKG', '1', '2', '3', '4', '5', '6', '7');
            $header_l1_label = array('LKG', 'UKG', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII');
            $header_l2 = array('8', '9', '10');
            $header_l2_label = array('VIII', 'IX', 'X');

            $header_other_label = array('Sent on', 'Dispatched', 'Received');

            $wl1 = array(42, 17);

            $this->pdf->SetFont('Arial', 'B', 12);
            $this->pdf->Cell(0, 10, 'Grade LKG to VII', 0, 0, 'C');
            $this->pdf->SetFont('Arial', '', 12);
            $this->pdf->Ln(10);

            $this->pdf->Cell($wl1['0'], 7, 'Grade', 1, 0, 'L');


            foreach ($header_l1_label as $value) {
                $this->pdf->Cell($wl1['1'], 7, $value, 1, 0, 'C');
            }
            $this->pdf->Ln();
            $this->pdf->Cell($wl1['0'], 7, 'No. of Candidates', 1, 0, 'L');

            foreach ($header_l1 as $value) {
                $this->pdf->Cell($wl1['1'], 7, $c_l1[] = is_grade_count($candidate_data, $value), 1, 0, 'C');
            }
            foreach ($header_l1 as $value) {
                $a_l1[] = is_grade_amount($candidate_data, $value);
            }

            $stl1 = get_amountxcount($c_l1, $a_l1);
            $this->pdf->Ln();
            $this->pdf->Cell($wl1['0'], 7, 'Total Amount', 1, 0, 'L');
            foreach ($stl1 as $value) {

                $this->pdf->Cell($wl1['1'], 7, $value, 1, 0, 'C');
            }


            $this->pdf->Ln(10);

            $this->pdf->Cell(100, 7, 'Total Candidates', 1, 0, 'C');
            $this->pdf->Cell(95, 7, array_sum($c_l1), 1, 0, 'C');
            $this->pdf->Ln();
            $this->pdf->Cell(100, 10, 'Total Amount', 1, 0, 'C');
            $this->pdf->Cell(95, 10, array_sum($stl1) . '.00', 1, 0, 'C');

            $this->pdf->Ln(10);

            $wl2 = array(42, 51);
            $this->pdf->SetFont('Arial', 'B', 12);
            $this->pdf->Cell(0, 10, 'Grade VIII to X', 0, 0, 'C');
            $this->pdf->SetFont('Arial', '', 12);
            $this->pdf->Ln(10);

            $this->pdf->Cell($wl2['0'], 7, 'Grade', 1, 0, 'L');


            foreach ($header_l2_label as $value) {
                $this->pdf->Cell($wl2['1'], 7, $value, 1, 0, 'C');
            }
            $this->pdf->Ln();
            $this->pdf->Cell($wl2['0'], 7, 'No. of Candidates', 1, 0, 'L');

            foreach ($header_l2 as $value) {
                $this->pdf->Cell($wl2['1'], 7, $c_l2[] = is_grade_count($candidate_data, $value), 1, 0, 'C');
            }
            foreach ($header_l2 as $value) {
                $a_l2[] = is_grade_amount($candidate_data, $value);
            }

            $stl2 = get_amountxcount($c_l2, $a_l2);
            $this->pdf->Ln();
            $this->pdf->Cell($wl2['0'], 7, 'Total Amount', 1, 0, 'L');
            foreach ($stl2 as $value) {

                $this->pdf->Cell($wl2['1'], 7, $value, 1, 0, 'C');
            }


            $this->pdf->Ln(10);

            $this->pdf->Cell(100, 7, 'Total Candidates', 1, 0, 'C');
            $this->pdf->Cell(95, 7, array_sum($c_l2), 1, 0, 'C');
            $this->pdf->Ln();
            $this->pdf->Cell(100, 10, 'Total Amount', 1, 0, 'C');
            $this->pdf->Cell(95, 10, array_sum($stl2) . '.00', 1, 0, 'C');

            $this->pdf->Ln(15);

            $this->pdf->Cell(100, 7, 'Grand Total', 1, 0, 'C');
            $this->pdf->Cell(95, 7, array_sum($stl1) + array_sum($stl2) . '.00', 1, 0, 'C');

            $this->pdf->Ln(15);

            $this->pdf->Cell($wl2['0'], 7, '', 1, 0, 'L');


            foreach ($header_other_label as $value) {
                $this->pdf->Cell($wl2['1'], 7, $value, 1, 0, 'C');
            }
            $this->pdf->Ln();
            $this->pdf->Cell($wl2['0'], 7, 'Check list', 1, 0, 'L');
            foreach ($header_other_label as $value) {
                $this->pdf->Cell($wl2['1'], 7, '', 1, 0, 'L');
            }
            $this->pdf->Ln();
            $this->pdf->Cell($wl2['0'], 7, 'Hall Tickets/Docs', 1, 0, 'L');
            foreach ($header_other_label as $value) {
                $this->pdf->Cell($wl2['1'], 7, '', 1, 0, 'L');
            }
            $this->pdf->Ln();
            $this->pdf->Cell($wl2['0'], 7, 'Mark List', 1, 0, 'L');
            foreach ($header_other_label as $value) {
                $this->pdf->Cell($wl2['1'], 7, '', 1, 0, 'L');
            }
            $this->pdf->Ln();


// $this->pdf->SetFont('Arial', '', 12);
//$this->pdf->Cell(0, 10, 'Grade VIII to X', 0, 0, 'C');


        } else {

            $this->pdf->SetFont('Arial', '', 12);
            $this->pdf->Cell(0, 10, 'No candidates found', 0, 0, 'C');

        }


// Closing line
        $this->pdf->Cell(array_sum($w), 0, '', 'T');

        $file_name = $school_data->school_name . '_registration_form_' . $this->_created_date . '.pdf';

        $this->pdf->Output($file_name, 'D');
        //$this->pdf->Output();

    }

    public function gen_excel()
    {


        $data = $schools = $this->school_model->getAllSchools();

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No School found');
            redirect('admin/schools');
        }

//$total_paid = $this->report_model->total_paid($event_id);
//$total_unpaid = $this->report_model->total_unpaid($event_id);
//load our new PHPExcel library
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
//name the worksheet
        $this->excel->getActiveSheet()->setTitle('School List');
//set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'SCHOOL NAME')->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('B1', 'ID')->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C1', 'PRINCIPAL')->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('D1', 'PLACE')->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('E1', 'ADDRESS')->getStyle('E1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('F1', 'DISTRICT')->getStyle('F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('G1', 'CONTACT PERSON')->getStyle('G1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('H1', 'CONTACT NUMBER(LAND)')->getStyle('H1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('I1', 'CONTACT NUMBER')->getStyle('I1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('J1', 'CANDIDATE COUNT')->getStyle('J1')->getFont()->setBold(true);

        $exceldata = "";
        foreach ($data as $row) {

            $row_data = array();
            $row_data['school_name'] = $row->school_name;
            $row_data['school_id'] = $row->school_id;
            $row_data['pricipal_name'] = $row->principal_name;
            $row_data['place'] = $row->place;
            $row_data['address'] = $row->address;
            $row_data['district_name'] = strtoupper($row->district_name);
            $row_data['contact_person'] = $row->contact_person;
            $row_data['contact_number'] = $row->contact_number;
            $row_data['contact_number_land'] = $row->contact_number_land;
            $row_data['candidates_count'] = $row->candidates_count;

            $exceldata[] = $row_data;
        }

        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');


        $filename = 'School_list_' . $this->_created_date . '.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }


    public function gen_class_wise_excel()
    {


        $data = $schools = $this->school_model->getClasswise();

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No School found');
            redirect('admin/schools');
        }


//$total_paid = $this->report_model->total_paid($event_id);
//$total_unpaid = $this->report_model->total_unpaid($event_id);
//load our new PHPExcel library
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
//name the worksheet
        $this->excel->getActiveSheet()->setTitle('School List');
//set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'SCHOOL NAME')->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('B1', 'ID')->getStyle('B1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('C1', 'PLACE')->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('D1', 'DISTRICT')->getStyle('D1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('E1', 'EXAM DATE')->getStyle('E1')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('F1', 'LKG')->getStyle('F1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('G1', 'UKG')->getStyle('G1')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('H1', 'I')->getStyle('H1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('I1', 'II')->getStyle('I1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('J1', 'III')->getStyle('J1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('K1', 'IV')->getStyle('K1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('L1', 'V')->getStyle('L1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('M1', 'VI')->getStyle('M1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('N1', 'VII')->getStyle('N1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('O1', 'VIII')->getStyle('O1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('P1', 'IX')->getStyle('P1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('Q1', 'X')->getStyle('Q1')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->setCellValue('R1', 'TOTAL')->getStyle('R1')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->freezePane('A2');

        $exceldata = "";

        $currentdata = "";

        foreach ($data as $row) {

            $row_data = array();
            $row_data['school_name'] = $row->school_name;
            $row_data['school_id'] = $row->school_id;
            $row_data['place'] = $row->place;
            $row_data['district_name'] = strtoupper($row->district_name);
            $row_data['exam_date'] = $row->exam_date;

            foreach ($data as $new_row) {

                if($new_row-> school_id == $row->school_id){

                    $row_data['class'][$new_row->candidate_class] = $new_row->candidates_count;

                }

            }


            $currentdata[$row->school_id]= $row_data;
        }


        foreach ($currentdata as $cd){

            $cd_row_data = array();
            $cd_row_data['school_name'] = $cd['school_name'];
            $cd_row_data['school_id'] = $cd['school_id'];
            $cd_row_data['place'] = $cd['place'];
            $cd_row_data['district_name'] = strtoupper($cd['district_name']);
            $cd_row_data['exam_date'] = $cd['exam_date'];
            $cd_row_data['LKG'] = isset($cd['class']['LKG']) ? $cd['class']['LKG'] : '0' ;
            $cd_row_data['UKG'] = isset($cd['class']['UKG']) ? $cd['class']['UKG'] : '0' ;
            $cd_row_data['1'] = isset($cd['class']['1']) ? $cd['class']['1'] : '0' ;
            $cd_row_data['2'] = isset($cd['class']['2']) ? $cd['class']['2'] : '0' ;
            $cd_row_data['3'] = isset($cd['class']['3']) ? $cd['class']['3'] : '0' ;
            $cd_row_data['4'] = isset($cd['class']['4']) ? $cd['class']['4'] : '0' ;
            $cd_row_data['5'] = isset($cd['class']['5']) ? $cd['class']['5'] : '0' ;
            $cd_row_data['6'] = isset($cd['class']['6']) ? $cd['class']['6'] : '0' ;
            $cd_row_data['7'] = isset($cd['class']['7']) ? $cd['class']['7'] : '0' ;
            $cd_row_data['8'] = isset($cd['class']['8']) ? $cd['class']['8'] : '0' ;
            $cd_row_data['9'] = isset($cd['class']['9']) ? $cd['class']['9'] : '0' ;
            $cd_row_data['10'] = isset($cd['class']['10']) ? $cd['class']['10'] : '0' ;

            $cd_row_data['total'] = $cd_row_data['LKG'] + $cd_row_data['UKG']
                                    +$cd_row_data['1']+$cd_row_data['2']
                                    +$cd_row_data['3']+$cd_row_data['4']
                                    +$cd_row_data['5']+$cd_row_data['6']
                                    +$cd_row_data['7']+$cd_row_data['8']
                                    +$cd_row_data['9']+$cd_row_data['10'];


            $exceldata[]= $cd_row_data;
        }


        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');


        $filename = 'Class_wise_list' . $this->_created_date . '.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function get_emails()
    {

        $data = array();

        $schools = $this->school_model->getAllSchools();

        if (count($schools) > 0) {

            foreach ($schools as $s) {
                if ($s->email != '') {
                    $data[] = '"' . $s->school_name . '-' . $s->place . '-' . strtoupper($s->district_name) . '"<' . $s->email . '>';
                }
            }
        }


        $emails = implode(",\r\n", $data);

        $this->load->helper('download');
        force_download('zest_school_emails_' . date('d-M-y') . '.txt', $emails);

    }

    public function get_mobiles()
    {

        $data = array();

        $schools = $this->school_model->getAllSchools();

        if (count($schools) > 0) {

            foreach ($schools as $s) {
                if ($s->contact_number_land != '') {
                    $data[] = $s->contact_number_land;
                }
            }
        }


        $mobiles = implode(",", $data);

        $this->load->helper('download');
        force_download('zest_school_mobiles_' . date('d-M-y') . '.txt', $mobiles);

    }



}