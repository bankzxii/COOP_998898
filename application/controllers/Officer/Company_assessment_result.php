<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_assessment_result extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        $user = $this->Login_session->check_login();
        if($user->login_type != 'officer') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }

        // $this->breadcrumbs->unshift('ระบบสหกิจ', '/'); //home
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.$user->login_type); //actor
    }

    
        public function index()
        {   
            // $data = array();
            $data['data'] = array();

            foreach($this->Company->gets_company()as $row) {
            
            $tmp_array = array();
            $tmp_array = $row;
            $tmp_array['count'] = count($this->Coop_Student->gets_coop_student_by_company($row['id']));
            array_push($data['data'], $tmp_array);
            }

            // add breadcrumbs
            $this->breadcrumbs->push('รายชื่อสถานประกอบการ', '/Officer/Company_assessment_result/index');

            $this->template->view('Officer/Company_assessment_result_list_view', $data);
        }


        public function assessment_detail($company_id)
        {

            $data['data'] = array();
            foreach($this->Company_Assessment_Form->gets_form_for_company() as $row)
            {
                $tmp_array = array();
                $tmp_array['questionnaire_subject'] = $row;
                $tmp_array['questionnaire_item'] = $this->Company_Assessment_Form->get_company_questionnaire_item_avg_result_by_subject_and_company($row['id'], $company_id);
                if( count($tmp_array['questionnaire_item']) > 0 ) {
                    array_push($data['data'], $tmp_array);
                }
            }

            // add breadcrumbs
            $this->breadcrumbs->push('รายชื่อสถานประกอบการ', '/Officer/Company_assessment_result/index');
            $this->breadcrumbs->push('ผลประเมินบริษัท', '/Officer/Company_assessment_result/assessment_detail');

            $this->template->view('Officer/Company_assessment_result_score_view', $data);
        } 
    
    
    
    }