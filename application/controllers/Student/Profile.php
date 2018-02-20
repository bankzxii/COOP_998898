<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        if($this->Login_session->check_login()->login_type != 'student') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
    }


    public function view(){
        $student_id = $this->Login_session->check_login()->login_value;
        $data['student'] = $this->Student->get_student($student_id)[0];     
        $data['department'] = $this->Student->get_department( $data['student']['department_id'])[0];
        $data['coop_status_type'] = $this->Student->gets_coop_status_type( $data['student']['coop_status'])[0];
        $data['term'] = $this->Term->get_current_term( $data['student']['id'])[0];
        
        $data['pass_training'] = false;
        $train_type = $this->Training->get_student_stat_of_training($student_id)['train_type'];
        $data['train_type'] = array();
        foreach($train_type as $type) {
            $tmp['name'] = $type['name'];
            $tmp['total_hour'] = $type['total_hour'];
            $tmp['check_hour'] = 0;
            //calc total hour
            foreach($type['history'] as $history) {
                $tmp['check_hour'] += $history['check_hour'];
            }

            if($tmp['check_hour'] == $tmp['total_hour']) {
                $data['pass_training'] = true;
            } else {
                $data['pass_training'] = false;
            }
        }

        $this->template->view('Student/Student_data_view',$data);
        
        // ขอ Api
    }
  



}