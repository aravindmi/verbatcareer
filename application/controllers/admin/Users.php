<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supervisors extends CI_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();

        if (!is_admin()) {
            redirect(site_url('auth/login'));
        }
        $this->load->model('school_model');
        $this->load->model('candidate_model');
        $this->load->model('supervisor_model');

        $this->_created_at = date("Y-m-d H:i:s");
        $this->_created_by = $this->session->userdata('user_id');
        $this->_updated_at = date("Y-m-d H:i:s");
        $this->_updated_by = $this->session->userdata('user_id');

        $this->load->library('pdf'); // Load library

        $this->_created_date = date("d-m-Y");

    }

    public function index()
    {

        $data['schools'] = $this->school_model->getAllSchools();
        $data['menu'] = 'supervisors';
        //$data['links'] = $this->pagination->create_links();
        $data['title'] = "List of Schools";

        $data['page'] = 'admin/supervisors/list_view';
        $this->load->view('templates/admin_template', $data);
    }

    /**
     * Create role
     */
    function create($school_id)
    {


        $this->form_validation->set_rules('supervisor_name', 'Supervisor Name', "required|trim|max_length[200]");
        $this->form_validation->set_rules('supervisor_contact', 'Supervisor Contact', 'required|trim|max_length[25]');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'school_id' => $school_id,
                'supervisor_name' => $this->input->post('candidate_name'),
                'supervisor_contact' => $this->input->post('candidate_class'),
                'created_at' => $this->_created_at,
                'created_by' => $this->_created_by
            );

            $candidate_id = $this->supervisor_model->insert($insert_data);
            if (!id) {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/supervisors/view/" . $school_id);

            } else {


                $this->ci_alerts->set('success', 'Saved Successfully');
                redirect("admin/supervisors/view/" . $school_id);
            }
        } else {

            $data['menu'] = 'supervisors';
            $data['school_data'] = $this->school_model->get($school_id);
            $data['page'] = 'admin/supervisors/create_view';
            $this->load->view('templates/admin_template', $data);

        }
    }

    /**
     * Update Users
     */
    function update($id, $school_id)
    {

        $this->form_validation->set_rules('supervisor_name', 'Supervisor Name', "required|trim|max_length[200]");
        $this->form_validation->set_rules('supervisor_contact', 'Supervisor Contact', 'required|trim|max_length[25]');

        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');


        if ($this->form_validation->run() == true) {

            /**
             * Create data to insert
             */
            $insert_data = array(
                'supervisor_name' => $this->input->post('supervisor_name'),
                'supervisor_contact' => $this->input->post('supervisor_contact'),

                'updated_at' => $this->_created_at,
                'updated_by' => $this->_created_by
            );


            if ($this->supervisor_model->update($id, $insert_data)) {

                $this->ci_alerts->set('success', 'Updated Successfully');
                redirect("admin/supervisors/view/" . $school_id);
            } else {

                $this->ci_alerts->set('error', 'Sorry ! failed to save, please try again');
                redirect("admin/supervisors/view/" . $school_id);
            }
        } else {

            $data['menu'] = 'supervisors';

            $data['school_data'] = $this->school_model->get($school_id);
            $data['supervisor_data'] = $this->supervisor_model->get($id);

            $data['page'] = 'admin/supervisors/update_view';
            $this->load->view('templates/admin_template', $data);
        }
    }

    /**
     * Project view
     */
    function view($school_id)
    {

        if ($school_id == null) {

            $this->ci_alerts->set('error', 'School ID not found');
            redirect('admin/candidates');
        }


        $data['menu'] = 'supervisors';
        $data['school_id'] = $school_id;

        $data['supervisors'] = $this->supervisor_model->get_supervisors($school_id);
        $data['school_data'] = $this->school_model->getOneSchools($school_id);

        $data['page'] = 'admin/supervisors/supervisors_list_view';
        $this->load->view('templates/admin_template', $data);


    }

    /**
     * Delete
     */
    public function delete($id, $school_id)
    {

        $insert_data = array(
            'deleted' => 1,
            'updated_at' => $this->_created_at,
            'updated_by' => $this->_created_by

        );

        if ($this->supervisor_model->update($id, $insert_data)) {

            $this->ci_alerts->set('success', 'Deleted Successfully');
            redirect("admin/supervisors/view/" . $school_id);

        } else {

            $this->ci_alerts->set('error', 'Sorry ! Deleted failed, please try again');
            redirect("admin/supervisors/view/" . $school_id);
        }
    }

    function upload($school_id = null)
    {
        if ($school_id == null) {

            $this->ci_alerts->set('error', 'School ID not found');
            redirect('admin/supervisors');
        }

       $school_data = $this->school_model->getOneSchools($school_id);

        if(count($school_data) <= 0){

            $this->ci_alerts->set('error', 'School ID not found');
            redirect('admin/supervisors');
        }


        $config_upload['upload_path'] = $this->config->item('SUPERVISOR_UPLOAD_PATH');
        $config_upload['allowed_types'] = $this->config->item('SUPERVISOR_UPLOAD_TYPES');
        $config_upload['max_size'] = $this->config->item('SUPERVISOR_UPLOAD_SIZE_LIMIT');
        $config_upload['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config_upload);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!$this->upload->do_upload()) {
                $data['upload_error'] = $this->upload->display_errors();
                $data['school_id'] = $school_id;

                $data['school_data'] = $school_data;

                $data['page'] = 'admin/supervisors/upload_view';

                $this->load->view('templates/admin_template', $data);

            } else {

                $upload_data = $this->upload->data();

                $this->process_upload($school_id, $upload_data['file_name'], $upload_data['orig_name']);

            }
        } else {

            $data['school_id'] = $school_id;

            $data['school_data'] = $school_data;
            $data['menu'] = 'supervisors';
            $data['page'] = 'admin/supervisors/upload_view';
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
            redirect('admin/supervisors/upload/' . $school_id);
        }

        if ($school_id == '') {

            $this->ci_alerts->set('error', $this->config->item('School ID not present !!!'));
            redirect('admin/supervisors/upload/' . $school_id);
        }


        $filename_date = date('mdyHsi');

        $excel_data = array();
        $filepath = './uploads/supervisors/' . $file_name;

        if (!is_readable($filepath)) {

            $this->ci_alerts->set('error', 'File is not readable !!');
            redirect('admin/supervisors/upload/' . $school_id);
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

                    if (trim($row[0]) != 'NAME' || trim($row[1]) != 'PHONE') {

                        $this->ci_alerts->set('error', 'Incorrect Format');
                        redirect('admin/supervisors/upload/' . $school_id);

                    }

                }

                $i++;

                //$count = count($row);
                //Backup DB


                if (count($row) > 1 && $row[0] != "NAME" && $row[1] != 'PHONE') {

                    $excel_data['school_id'] = $school_id;
                    $excel_data['supervisor_name'] = $row[0];
                    $excel_data['supervisor_contact'] = $row[1];


                    $excel_data['updated_at'] = $this->_updated_at;
                    $excel_data['updated_by'] = $this->_updated_by;

                    $excel_data['upload_file_name'] = $origin_file . '-' . $file_name;


                    if (isset($row[2]) && $row[2] != '' && $row[2] != '0') {

                        $current_candidate = $this->supervisor_model->get_by('supervisor_id', $row[2]);

                    } else {

                        $current_candidate = '';
                    }


                    if ($current_candidate) {

                        $this->supervisor_model->update($current_candidate->supervisor_id, $excel_data);

                    } else {

                        $excel_data['created_at'] = $this->_created_at;
                        $excel_data['created_by'] = $this->_created_by;

                        $this->supervisor_model->insert($excel_data);

                    }


                }

            }


            $this->ci_alerts->set('success', 'Supervisors details, Imported successfully');
            redirect('admin/supervisors/view/' . $school_id);


        } catch (Exception $E) {

            echo $E->getMessage();
            $this->ci_alerts->set('error', $E->getMessage());
            redirect('admin/supervisors');
        }

    }

    /**
     * Gen PDF
     */

    public function gen_pdf($school_id)
    {

        $school_data = $this->school_model->get($school_id);
        //$header =  array('Sl.No.', 'NAME', 'CLASS', 'ID');
        $data = $this->candidate_model->get_candidates($school_id);

        if (count($data) <= 0) {

            $this->ci_alerts->set('error', 'No candidate found in ' . $school_data->school_name);
            redirect('admin/candidates');
        }

        if ($school_data) {

            $this->pdf->title = 'CHECK LIST';
            $this->pdf->pdftype = 'candidates';
            $this->pdf->school_name = $school_data->school_name;
            $this->pdf->place = $school_data->place;
            $this->pdf->school_id = $school_data->school_id;
            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();


            //$this->pdf->AddPage();
            // Column widths
            $w = array(20, 120, 20, 30);
            // Header
            //for($i=0;$i<count($header);$i++)
            //$this->pdf->Cell($w[$i],7,$header[$i],1,0,'C');
            //$this->pdf->Ln();
            // Data
            $c = 1;
            foreach ($data as $row) {
                $this->pdf->Cell($w[0], 6, $c, '1');
                $this->pdf->Cell($w[1], 6, $row->candidate_name, '1');
                $this->pdf->Cell($w[2], 6, $row->candidate_class, '1', 0, 'C');
                $this->pdf->Cell($w[3], 6, $row->candidate_id, '1', 0, 'C');
                $this->pdf->Ln();
                $c++;
            }
            for ($x = 0; $x <= 9; $x++) {
                $this->pdf->Cell($w[0], 6, '', '1');
                $this->pdf->Cell($w[1], 6, '', '1');
                $this->pdf->Cell($w[2], 6, '', '1', 0, 'C');
                $this->pdf->Cell($w[3], 6, '', '1', 0, 'C');
                $this->pdf->Ln();
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

        $exceldata = "";
        foreach ($data as $row) {

            $row_data = array();
            $row_data['NAME'] = $row->candidate_name;
            $row_data['CLASS'] = $row->candidate_class;
            $row_data['ID'] = $row->candidate_id;

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
            'tables' => array('schools', 'candidates','supervisors'),   // Array of tables to backup.
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



}
