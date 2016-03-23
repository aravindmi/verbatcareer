<?php

require_once APPPATH . 'libraries/Dropbox/autoload.php';

use \Dropbox as dbx;

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

    }


    public function do_backup()
    {

        $accessToken = "Qh4Z59HxYmAAAAAAAAAAB1s0uYd5UDE9w5SM1xodhh6kespnmbLb-yzr6t-og87J";
        $dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");

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

        $file_name = 'ze_' . date('d-M-y(h-s-i)') . '.gzip';

        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('file');
        write_file('./db/' . $file_name, $backup);

        if (is_readable('./db/' . $file_name)) {

            $f = fopen('./db/' . $file_name, "rb");
            $result = $dbxClient->uploadFile("/zest/$file_name", dbx\WriteMode::add(), $f);

            if(isset($result['path']) && $result['path'] != ''){

                echo "Sucess";

            }else{

                $msg = "Failed to Upload backup file";
                mail("miaravindh@gmaiil.com","Zest Backup Failed - Upload failed",$msg);
            }

        }else{


            $msg = "Failed to open backup file";
            mail("miaravindh@gmaiil.com","Zest Backup Failed - file not found",$msg);

        }

    }


}
