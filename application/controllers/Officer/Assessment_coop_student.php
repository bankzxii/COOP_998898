<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Assessment_coop_student extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        if($this->Login_session->check_login()->login_type != 'officer') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
    }

		public function view($student_id){

	
		$this->template->view('Officer/Assessment_coop_student_view');
    } 
  
}
?>