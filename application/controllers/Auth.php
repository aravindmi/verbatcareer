<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        //$this->output->enable_profiler(TRUE);
    }

    public function index() {
        if (logged_in()) {
            redirect(site_url('admin/dashboard'));
        } else {
            redirect(site_url('auth/login'));
        }
    }

    public function login() {

        if (logged_in()) {
            redirect(site_url('admin/dashboard'));
        }

        $this->form_validation->set_rules('email_id', 'Email ID', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');
        

        if ($this->form_validation->run() !== false) {
            //$category_id = $this->input->post('category');
            $res = $this->auth_model->verify_user($this->input->post('email_id'), $this->input->post('password'));

            
            if ($res !== false) {
                if ($res->num_rows() > 0) {
                    $row = $res->row();

                    $user_id = $row->id;
                    $user_email = $row->email_id;
                    $name= $row->name;
                    $role_id= $row->role_id;
                   
                }
                $new_data = array('user_id' => $user_id, 'first_name' => $name,'email_id'=>$user_email, 'role_id'=>$role_id  );

                $this->session->set_userdata($new_data);

                 $this->auth_model->update_login($user_id, date('Y-m-d H:i:s', time()), $this->input->ip_address());

                redirect(site_url('admin/dashboard'));
                
            } else {
                
                $this->ci_alerts->set('error', 'Invalid username or password');
                
                redirect('auth/login');
            }
        }
        
        
        $this->load->view('templates/login_template');

    }

    /**
     * Logout process
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url(), 'refresh');
    }

    
    
    /**
     * change password process
     */
    public function change_password() {

        $this->form_validation->set_rules('user_name', 'Username', 'required|trim');
        $this->form_validation->set_rules('oldpassword', 'Current Password', 'required|min_length[4]');
        $this->form_validation->set_rules('newpassword', 'New Password', 'required|min_length[4]');
        $this->form_validation->set_rules('conpassword', 'Confirm Password', 'required|min_length[4]|matches[newpassword]');
        if ($this->form_validation->run() !== false) {

            $res = $this->admin_model->verify_user($this->input->post('user_name'), $this->input->post('oldpassword'));

            if ($res !== false) {
                if ($this->admin_model->change_password($this->session->userdata('user_id'), set_value('conpassword'))) {
                    $this->ci_alerts->set('success', 'Password updated successfully');
                    redirect(site_url('auth/change_password'));
                } else {
                    $this->ci_alerts->set('error', 'No data updated');
                    redirect(site_url('auth/change_password'));
                }
            } else {
                $this->ci_alerts->set('error', 'Current password in valid');
                redirect(site_url('auth/change_password'));
            }
        }
        $data['title'] = 'Welcome :: Zest';

        $this->load->view('pages/admin/change_pass_view', $data);

    }

}
