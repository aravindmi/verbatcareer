<?php


 /**
 * Site constants
 * @package     ABB Dashboard
 * @subpackage  User Management controller
 * @author	ABB Dashboard Dev team <prasanth.mathew@verbat.com>
 * @copyright   Copyright (c) 2013, Verbat Technologies, Inc.
 * @since	Version 1.0, 16th July 2014
 * @filesource
 */
 
$config['SITE_NAME'] = 'Zest Educare - Dashboard'; // Site title
//$config['PATH_SEPERATOR'] = ''; // Site title
//$config['SITE_PATH'] = $_SERVER['DOCUMENT_ROOT'].$config['PATH_SEPERATOR'].'framework'; // Diractory path to the site root

//USER ROLE

$config['ADMIN'] = "ADMIN";
$config['USER'] =  "2";

//ADMIN ASSETS

$config['BACKEND_ASSETS'] = "assets/backend/";

//FRONTEND ASSETS

$config['FRONTEND_ASSETS'] = "assets/frontend/";

//FILE UPLOAD INFO

$config['EXT_ALLOWED_IMAGES'] = 'gif|jpg|png|jpeg';
$config['IMAGES_UPLOAD_SIZE'] = '200'; // 2100 KB
$config['IMAGES_UPLOAD_PATH'] = './uploads/images/';

$config['QUARTER_START'] = "1";

//EMAIL CONFIG INFO

$config['SEND_EMAIL_PENDING'] = 'pending';
$config['SEND_EMAIL_COMPLETED'] = 'completed';
$config['EMAIL_FROM_EMAIL'] = 'abbtestfrom@yopmail.com';
$config['EMAIL_FROM_NAME'] = 'testfrom';
$config['EMAIL_ALTERNATE_TO'] = 'abbtestto@yopmail.com';
$config['NOREPLY_EMAIL_FROM_NAME'] =  'noreply';
$config['NOREPLY_EMAIL_ALTERNATE_FROM'] = 'abbnoreplytest@yopmail.com';
$config['FEEDBACK_FROM_NAME'] =  'noreply';
$config['FEEDBACK_FROM_EMAIL'] = 'abbnoreplytest@yopmail.com';
//COPY RIGHT

$config['COPY_RIGHT']  = '&copy; ' . date("Y") . ' All rights reserved. Verbat Technologies';
$config['ENABLE_PROFILER'] = TRUE;//FALSE

//Permission constants


$permission_data = array(
'MANAGE_USERS'=>1,
'MANAGE_FILE'=>2,
'DASHBOARD'=>3
//'controller name'=>'number',   
        );//set also in the database 

$config['PERMISSION']=$permission_data; 

$config['REGION_PASS_SALT'] = 17;

$config['PRIORIY'] = array(1=>'High',2=>'Normal',3=>'Low');
$config['TASKSTATUS'] = array(1=>'Scheduled',2=>'In Progress',3=>'Completed');

//Pagination

$config['PROJECTGRID_PERPAGE'] = '4';

//Product upload config
$config['CANDIDATE_UPLOAD_PATH'] = 'uploads/resumes'; ///events
$config['CANDIDATE_UPLOAD_TYPES'] = 'doc|docx|pdf|rtf|txt|xls|xlsx|ppt|pptx';
$config['CANDIDATE_UPLOAD_SIZE_LIMIT'] = '2000';

//Product upload config
$config['SUPERVISOR_UPLOAD_PATH'] = 'uploads/supervisors'; ///events
$config['SUPERVISOR_UPLOAD_TYPES'] = 'xls|xlsx';
$config['SUPERVISOR_UPLOAD_SIZE_LIMIT'] = '10000';

$config['JOB_STATUS'] = array(1,0);

/* End of file site.constants.php */
/* Location: ./application/config/site.constants.php */
