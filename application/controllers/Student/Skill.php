<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skill extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        $user = $this->Login_session->check_login();
        if($user->login_type != 'student') {
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
            die();
        }
      
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }

    public function index()
    {
        $status = $this->session->flashdata('status');

        if( $status == 'success'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'บันทึกสำเร็จ';
        }
        else if($status == 'error'){
            $data['status']['color'] = 'warning';            
            $data['status']['text'] = 'กรุณาเลือก';

        }
        else if($status == 'select_before'){
            $data['status']['color'] = 'info';            
            $data['status']['text'] = 'กรุณาเลือกทักษะที่ถนัดก่อนใช้งานระบบ';
        }
        else {
            $data['status'] = '';
        } 
        $student_id = $this->Login_session->check_login()->login_value;

        $data['has_skill'] = array();
        foreach($this->Skill_Search->search_skill_by_student($student_id) as $has_skill) {
            $data['has_skill'][] = $has_skill['skill_id'];
        }
        $data['skills'] = array();
        foreach ($this->Skill->gets_skill_category() as $row) {
            $tmp_array = array();
            $tmp_array = $row;
            $tmp_array['skills'] = $this->Skill->gets_skill_by_category_id($row['skill_category_id']);
            array_push($data['skills'], $tmp_array);
        }

        $this->breadcrumbs->push('ทักษะที่ถนัด', '/Student/Skill/index');
        // print_r($data);
        $this->template->view('Student/Skill_form_view',@$data);
    }

    public function save()
    {
        if(count($this->input->post('skill')) < '1') {
            $this->session->set_flashdata('status', 'error');
            redirect('Student/Skill/index/?','refresh');
        }
        else
        {
            $student_id = $this->Login_session->check_login()->login_value;
            //delete old skill
            $this->Skill_Search->delete_by_student($student_id);
            foreach($this->input->post('skill') as $skill){
                $insert = array();
                $insert['student_id'] = $student_id;
                $insert['skill_id'] = $skill;
                $this->Skill_Search->insert_student_has_skill($insert);
            }
           
            $this->session->set_flashdata('status', 'success');
            redirect('http://prepro.informatics.buu.ac.th:8001/index.php/Student/Job/lists','refresh');
        }
    
        
    }
}