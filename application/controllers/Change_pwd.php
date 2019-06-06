<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_pwd extends CI_Controller { 

	public function index(){
        $this->load->view('Change_pwd_view');
    }

    public function get_company_person()
    {
    	$username = $this->input->post('username');
    	$old_password = $this->input->post('old_pass');
        $new_password = $this->input->post('new_pass');
        $confirm_password = $this->input->post('confirm_pass');
        if($username == "" || $old_password == "" || $new_password == "" || $confirm_password == ""){
            echo "<script>alert('กรุณากรอกช้อมูลให้ครบถ้วน')</script>";
            redirect('http://prepro.informatics.buu.ac.th:8001/Change_pwd', 'refresh');
        }
        if ($new_password != $confirm_password) {
            echo "<script>alert('รหัสผ่านไม่ตรงกัน')</script>";
            redirect('http://prepro.informatics.buu.ac.th:8001/Change_pwd', 'refresh');
        }
    	$this->load->model('Change_pwd_model');
    	// $company_person = $this->Change_pwd_model->get_company_person($username);
    	$company_username = "";
    	$company_old_hash = "";
    	foreach($this->Change_pwd_model->get_company_person($username) as $row)
        {
            $company_username = $row['person_username'];
            $company_old_hash = $row['person_password'];
        }
    	// $company_person_username = $company_person['person_email'];
    	
    	// $company_old_verify = password_verify($old_password, $company_old_hash);
    	if (password_verify($old_password, $company_old_hash)) {
    		$this->load->model('Change_pwd_model');
    		$this->Change_pwd_model->Change_pwd_company_person($username);
    		echo "<script>alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว')</script>";
    		redirect('http://prepro.informatics.buu.ac.th:8001', 'refresh');
    	} else {
    		echo "<script>alert('รหัสผ่านผิดพลาด')</script>";
    		redirect('http://prepro.informatics.buu.ac.th:8001/Change_pwd', 'refresh');
    	}
    }
}
  

