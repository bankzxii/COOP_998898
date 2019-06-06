<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_pwd extends CI_Controller { 

	public function index(){
        $this->load->view('forgot_password_view');
    }

    public function reset_pwd()
    {

    	$username = $this->input->post('username');
    	$this->load->model('Forgot_pwd_model');
    	$username_db = "";
    	foreach($this->Forgot_pwd_model->get_company_person($username) as $row)
        {
            $username_db = $row['person_username'];
        }
        if($username_db == "") {
        	echo "<script>alert('username is invalid')</script>";
            redirect('http://prepro.informatics.buu.ac.th:8001/Forgot_pwd', 'refresh');
        } else {
            $password_gen = generateStrongPassword(8);
            $password_gen_db = password_hash($password_gen, PASSWORD_DEFAULT);
            $this->Forgot_pwd_model->update_password($username, $password_gen_db);

            $to = $username;
            $subject = 'คุณได้กดลืมรหัสผ่านระบบสหกิจศึกษา มหาวิทยาลัยบูรพา';
            $msg = 'รหัสผ่านใหม่ของ Username: '.$username.' | Password: '.$password_gen.' | '.site_url();
            //sentmail here
            $this->load->library('email');
            $this->email->from('buu.coopsystem@gmail.com', 'Informatics CoOp');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();

            echo "<script>alert('ระบบได้ส่ง username / password ไปที่ email ที่กรอกมาเรียบร้อยค่ะ')</script>";
            redirect('http://prepro.informatics.buu.ac.th:8001', 'refresh');
        }

    }
}
  

