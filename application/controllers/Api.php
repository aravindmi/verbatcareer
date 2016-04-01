<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    /**
	 * Index Page for this controller.
	 *
     * Single page Application
	 */
    
    public function __construct() {
        parent::__construct();
		header('Access-Control-Allow-Origin: http://blog.crowdinvest.com');
        header('Access-Control-Allow-Credentials: true');
        $this->load->helper('form'); 
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Apimodel');
        $this->load->library('encrypt');
		
    }

    public function signup(){
        $this->form_validation->set_message('is_unique', 'The email is already taken.');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[tbl_user_master.email]|max_length[50]');
        $this->form_validation->set_rules('firstname', 'firstname', 'required|max_length[50]');
        $this->form_validation->set_rules('lastname', 'lastname', 'required|max_length[50]');
        $this->form_validation->set_rules('password', 'password', 'required|max_length[20]');
        $this->form_validation->set_rules('interestarea', 'interestarea', 'required');
               
        if($this->input->post('interestarea') == "other"){
              $this->form_validation->set_rules('specified', 'specified', 'required|max_length[20]');
         }
        
        if ($this->form_validation->run()){ 
			$data['email']=$this->input->post('email');
			$data['firstname']=$this->input->post('firstname');
			$data['middlename']=$this->input->post('middlename');
			$data['lastname']=$this->input->post('lastname');
			$data['password']=$this->input->post('password');
			$data['role']=$this->input->post('role');
			$data['interest_area']=$this->input->post('interestarea');
			if($this->input->post('interestarea') == "other"){
				$data['specified']=$this->input->post('specified');
				$data['interest_area'] = $data['specified'];
			}

			$user_creation = $this->Apimodel->createuser($data);
		  if($data['role'] == 2){
					$role_name = "investor";
            }
				elseif($data['role']  == 1){
					
					$role_name = "entreprenuer";
					
				}elseif($data['role']  == 3){
					
					$role_name = "experts";
					
				}else{
					
					$role_name = "";
				}
			if($role_name != ''){
			 $this->send_mail($data['email'],$data['firstname'],$role_name);
			}
            $emailUrl= $data['email'];
            $nameUrl = $data['firstname'];
            $encrypted_string = base64_encode($emailUrl);
            $url = "http://www.crowdinvest.com/?signup=true&ci_source_e=".$encrypted_string."&ci_source_n=".$nameUrl;
            if($url != ""){
                $this->session->set_flashdata('signup', 'success');
             	redirect($url);
            }
		}
		else{
			$data['form_error'] = validation_errors();
            $this->load->view('home', $data);
		}
    }
    public function existence(){
         
         $email= $this->input->get('email');
         if($email != ''){
             $username = $this->Apimodel->userexistence($email);
             if($username) { echo 'false'; }else{ echo 'true'; }
         }else{
             echo 'true';
         }

     }
    
    //  User creation from home page slides -- role are investor and entreprenuer - Normal Submit
    public function join($role = ""){
             $this->form_validation->set_message('is_unique', 'The email is already taken.');
			 $this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
			 $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[tbl_user_master.email]|max_length[50]');
			 $this->form_validation->set_rules('interest[]', 'interest', 'required');
        
         if ($this->form_validation->run()){
            if($role == "investor"){
                $role_id= 2;
            }
            else if($role == "entreprenuer"){
                $role_id = 1;
            }
            else{
                $role_id = 0;
            }
            $data['role'] = $role_id;
          
            $data['email']=$this->input->post('email');
            $data['first_name']=$this->input->post('name');
            $data['interest_area']=$this->input->post('interest');
            
            //var_dump($data['interest_area']);
             $multiple_Choice = implode(",",$data['interest_area']);
             $data['interest_area'] = ($multiple_Choice);
             
            $user_info = $this->Apimodel->earlyaccess($data);
        	$emailUrl = $this->input->post('email');
        	$nameUrl = $this->input->post('name');
        	
            $this->send_mail($data['email'],$data['first_name'],$role);
            // $encrypted_string = $this->encrypt->encode($emailUrl);
            // $plaintext_string = $this->encrypt->decode($encrypted_string);
            $encrypted_string = base64_encode($emailUrl);
             /*echo "encrypted: ".$encrypted_string;
             echo "decrypted: ".$plaintext_string;
             exit;*/
			$url = "http://www.crowdinvest.com/?signup=true&ci_source_e=".$encrypted_string."&ci_source_n=".$nameUrl;
        
            if($user_info != ""){
                $this->session->set_flashdata('signup', 'success');
             	redirect($url);
                /*redirect("http://crowdinvest.referralrock.com/promotion/1?name=$data['first_name']&email=$data['email']&skipreg=1/");
                $this->session->set_flashdata('result', 'success');
                $this->session->set_flashdata('s_mail', $data['email']);
                $this->session->set_flashdata('s_name', $data['first_name']);
                redirect('/');*/
            }
            else{
                $this->session->set_flashdata('result', 'Failed');
                redirect('/');
            }
		 }
		else{
            $data['bannererrors'] = validation_errors();
            $this->load->view('home', $data);
        }
    }
        
    public function newsletter_existence(){
         
         $email= $this->input->get('email');
         if($email != ''){
             $username = $this->Apimodel->newsletter_existence($email);
             if($username) { echo 'false'; }else{ echo 'true'; }
         }else{
             echo 'no data';
         }

     }
    public function newsletter_add(){
	
	    
		
        $this->form_validation->set_message('is_unique', 'You are already a subscribed, Thank you');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[100]|is_unique[pl_signup.email]');
            
         if ($this->form_validation->run()){
        
            $email= $this->input->post('email');
             if($email != ''){
                 $username = $this->Apimodel->newsletter_add($email);
                 $this->send_mail($email,'','newsletter');
                                
                 if($username != "") { 
                    echo 'true'; //inserted
                 }else{ 
                    echo 'false'; 
                 }
             }else{
                 echo 'nodata';
             }
         }
        else{
            print_r(validation_errors());
        }
     }

	 
    function send_mail($email = '',$name = '', $template = ''){
        
                 //$template = 'entreprenuer'; // or investor or newslwtter or experts
				 
                   $template = $this->get_template($template,$email,$name);
		 
		    //$config = $this->config->item('email');

		   
                    $this->load->library('email');

                   //$config['charset'] = 'iso-8859-1';
                   //$config['mailtype'] = 'html';

                    //$this->email->initialize($config);

                    $this->email->from('hello@crowdinvest.com', 'CrowdInvest');
                    $this->email->to($email);
                    //$this->email->cc('another@another-example.com');
                    //$this->email->bcc('them@their-example.com');

                    $this->email->subject('Thank you for registering with us');
                    $this->email->message($template);

                    $send_mail = $this->email->send();
 //echo $this->email->print_debugger();
//exit;

		 }
		 
		 
		 
		 
	
    public function get_template($template = '',$email = '', $name = '') {
        switch($template) {
            case 'entreprenuer' :
                return '<html>
                            <body style="color:#999999;">
                            <h3 style="text-align:center;font-size:26px;color:#999999;">Welcome to <span style="color:#69C374;">CrowdInvest!</span> </h3>

                            <p>Hi '.$name.',</p>

                            <p>Thank you for joining us! We are as excited as you are about your project. And we promise to go an extra mile to help you out.</p>

                            <p>Our Chief Manager will soon contact you to check if your business qualifies for fundraising. </p>

                            <p>And yes! Don&#39;t forget to ask your friends to join the league with our <a href="http://www.ref-r.com/c/i/8540/2910645" style="color:#382F2E;">Referral Program</a> - &#8220;Give 20, Get 20&#8221;. We are opening the world of CrowdInvesting for you and your friends. </p>

                            <p>Happy CrowdInvesting! </p>

                            <p>Sincerely, <br>
                            <strong>Sanjay Choudhary</strong> <br><hr>
                            Founder & CEO - CrowdInvest <br>
                            <a href="https://twitter.com/crowdinvestnow" target="_blank" style="color:#382F2E;">Twitter</a> | 
                            <a href="https://web.facebook.com/CrowdInvest-Limited-1534541659958757" target="_blank" style="color:#382F2E;">Facebook</a> | 
                            <a href="https://www.linkedin.com/company/crowdinvest-limited" target="_blank" style="color:#382F2E;">LinkedIn</a> | 
                            <a href="https://www.pinterest.com/hello1392" target="_blank" style="color:#382F2E;">Pinit</a></p>

                            <p>P.S. If you haven&#39;t signed up with us, this email has come by error, please ignore it.</p>
                            </body>
                            </html>';
                break;
            case 'investor' :
                return '<html>
                            <body style="color:#999999;">
                            <h3 style="text-align:center;font-size:26px;color:#999999;">Welcome to <span style="color:#69C374;">CrowdInvest!</span> </h3>

                            <p>Thank you for joining us! We are excited to get to know you and are confident that you will find us a great addition to your investment portfolio.</p>

                            <p>Hang tight we are coming soon with high growth potential investment opportunities and we promise you�ll be the first to know.</p>

                            <p>Don&#39;t forget to check our <a href="http://www.ref-r.com/c/i/8540/2910645" style="color:#382F2E;">Referral Program</a> &#8220;Give 20, Get 20&#8221;. We are opening the world of CrowdInvesting for you and your friends.</p>

                            <p>So what are you waiting for....let&#39;s start CrowdInvesting! </p>

                            <p>Sincerely, <br>
                            <strong>Sanjay Choudhary</strong> <br><hr>
                            Founder & CEO - CrowdInvest <br>
                            <a href="https://twitter.com/crowdinvestnow" target="_blank" style="color:#382F2E;">Twitter</a> | 
                            <a href="https://web.facebook.com/CrowdInvest-Limited-1534541659958757" target="_blank" style="color:#382F2E;">Facebook</a> | 
                            <a href="https://www.linkedin.com/company/crowdinvest-limited" target="_blank" style="color:#382F2E;">LinkedIn</a> | 
                            <a href="https://www.pinterest.com/hello1392" target="_blank" style="color:#382F2E;">Pinit</a></p>

                            <p>P.S. If you haven&#39;t signed up with us, this email has come by error, please ignore it.</p>
                            </body>
                            </html>';
                break;
            case 'newsletter' :
                return '<html>
                            <body style="color:#999999;">
                            <h3 style="text-align:center;font-size:26px;color:#999999;">Welcome to <span style="color:#69C374;">CrowdInvest!</span> </h3>

                            <p>Hello,</p>

                            <p>We are happy to see you here.</p>

                            <p>Thank you for subscribing to our Newsletter.  We look forward to delivering stimulating, motivating and educational articles to you every week.</p>

                            <p>We would request you to <a href="http://www.crowdinvest.com/?signme='.$email.'" style="color:#382F2E;">sign up</a> and explore our high growth investment opportunities and be a part of Vibrant Investors and entrepreneurs community.</p>

                            <p>And don&#39;t forget to check our <a href="http://www.ref-r.com/c/i/8540/2910645" style="color:#382F2E;">Referral Program</a> &#8220;Give 20, Get 20&#8221;. We are opening the world of CrowdInvesting for you and your friends.</p>

                            <p>Happy CrowdInvesting! </p>

                            <p>Sincerely, <br>
                            <strong>Sanjay Choudhary</strong> <br><hr>
                            Founder & CEO - CrowdInvest <br>
                            <a href="https://twitter.com/crowdinvestnow" target="_blank" style="color:#382F2E;">Twitter</a> | 
                            <a href="https://web.facebook.com/CrowdInvest-Limited-1534541659958757" target="_blank" style="color:#382F2E;">Facebook</a> | 
                            <a href="https://www.linkedin.com/company/crowdinvest-limited" target="_blank" style="color:#382F2E;">LinkedIn</a> | 
                            <a href="https://www.pinterest.com/hello1392" target="_blank" style="color:#382F2E;">Pinit</a></p>

                            <p>P.S. If you haven&#39;t signed up with us, this email has come by error, please ignore it.</p>
                            </body>
                            </html>';
                break;
            case 'experts' :
                return '<html>
                            <body style="color:#999999;">
                            <h3 style="text-align:center;font-size:26px;color:#999999;">Welcome to <span style="color:#69C374;">CrowdInvest!</span> </h3>

                            <p>Hi '.$name.',</p>

                            <p>We are happy to see you here.</p>

                            <p>Thank you for joining us! We are excited to get to know you and are confident that you will find great carrier opportunities with us.</p>

                            <p>Don&#39;t forget to check our <a href="http://www.ref-r.com/c/i/8540/2910645" style="color:#382F2E;">Referral Program</a> &#8220;Give 20, Get 20&#8221;. We are opening the world of CrowdInvesting for you and your friends.</p>

                            <p>So what are you waiting for....let&#39;s start CrowdInvesting! </p>

                            <p>Sincerely, <br>
                            <strong>Sanjay Choudhary</strong> <br><hr>
                            Founder & CEO - CrowdInvest <br>
                            <a href="https://twitter.com/crowdinvestnow" target="_blank" style="color:#382F2E;">Twitter</a> | 
                            <a href="https://web.facebook.com/CrowdInvest-Limited-1534541659958757" target="_blank" style="color:#382F2E;">Facebook</a> | 
                            <a href="https://www.linkedin.com/company/crowdinvest-limited" target="_blank" style="color:#382F2E;">LinkedIn</a> | 
                            <a href="https://www.pinterest.com/hello1392" target="_blank" style="color:#382F2E;">Pinit</a></p>

                            <p>P.S. If you haven&#39;t signed up with us, this email has come by error, please ignore it.</p>
                            </body>
                            </html>';
                break;
            default : return '';break;
        }
    }
	 
    public function rr(){
        $rr= $this->input->post('rrId');
        if($rr != ""){
           $this->Apimodel->referrel_rock($rr); 
        }
    }
    
    public function users_excel() {
    
		$csv_data = $this->Apimodel->get_users_excel_data();
		
		
		$subject = 'Pre Launch User List - Sign up & join';
		$mailto = "sheetal@crowdinvest.com,kritika@crowdinvest.com,sanjay@crowdinvest.com,aravind.m@verbat.com";
		//$mailto = "aravind.m@verbat.com,miaravindh@gmail.com";
		$filename = 'sign_up.csv';
		
		
					$this->load->library('email');
					
					file_put_contents($filename, $csv_data);

                   //$config['charset'] = 'iso-8859-1';
                   //$config['mailtype'] = 'html';

                    //$this->email->initialize($config);

                    $this->email->from('hello@crowdinvest.com', 'CrowdInvest');
                    $this->email->to($mailto);
                    //$this->email->cc('another@another-example.com');
                    //$this->email->bcc('them@their-example.com');

                    $this->email->subject($subject);
					
					$this->email->attach($filename);  
					
                    $this->email->message('Please find the attachement, thank you');

                    $send_mail = $this->email->send();
		
		// Send the email, return the result
		//echo @mail($mailto , $subject, $body, implode("\r\n", $headers)); 
		
		
    }
    
    public function newsletter_excel() {
    
		$csv_data = $this->Apimodel->get_newsletter_excel_data();
		
		
		$subject = 'Pre Launch User List - Newsletter';
		$mailto = "sheetal@crowdinvest.com,kritika@crowdinvest.com,sanjay@crowdinvest.com,aravind.m@verbat.com";
		$filename = 'newsletter.csv';
		
		$this->load->library('email');
					
					file_put_contents($filename, $csv_data);

                   //$config['charset'] = 'iso-8859-1';
                   //$config['mailtype'] = 'html';

                    //$this->email->initialize($config);

                    $this->email->from('hello@crowdinvest.com', 'CrowdInvest');
                    $this->email->to($mailto);
                    //$this->email->cc('another@another-example.com');
                    //$this->email->bcc('them@their-example.com');

                    $this->email->subject($subject);
					
					$this->email->attach($filename);  
					
                    $this->email->message('Please find the attachement, thank you');

                    $send_mail = $this->email->send();
		
		
    }
    
      
}
