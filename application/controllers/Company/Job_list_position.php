<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_list_position extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $user = $this->Login_session->check_login();
        
        if(!$user) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        if($user->login_type != 'company') {
            redirect(ucfirst($user->login_type).'/main/');
            die();
        }
        //add breadcrumbs
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }

	public function index()
	{

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];
        $data['company_status_Type'] = $this->Job->gets_company_status_type();
        // print_r($this->Job->get_student_by_company_id($data['trainer_id']));
        $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ ', '/Company/Job_list_position/index');
		$this->template->view('Company/Job_list_position_view', $data);
    }

    public function company_status_id1()
    {

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];
        $data['company_status_Type'] = $this->Job->gets_company_status_type();
        // print_r($this->Job->get_student_by_company_id($data['trainer_id']));
        $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ ', '/Company/Job_list_position/company_status_id1');
        $this->template->view('Company/Company_status_id1_view', $data);
    }

    public function company_status_id2()
    {

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];
        $data['company_status_Type'] = $this->Job->gets_company_status_type();
        // print_r($this->Job->get_student_by_company_id($data['trainer_id']));
        $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ ', '/Company/Job_list_position/company_status_id2');
        $this->template->view('Company/Company_status_id2_view', $data);
    }

    public function company_status_id3()
    {

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];
        $data['company_status_Type'] = $this->Job->gets_company_status_type();
        // print_r($this->Job->get_student_by_company_id($data['trainer_id']));
        $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ ', '/Company/Job_list_position/company_status_id3');
        $this->template->view('Company/Company_status_id3_view', $data);
    }
    public function company_status_id4()
    {

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];
        $data['company_status_Type'] = $this->Job->gets_company_status_type();
        // print_r($this->Job->get_student_by_company_id($data['trainer_id']));
        $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ ', '/Company/Job_list_position/company_status_id4');
        $this->template->view('Company/Company_status_id4_view', $data);
    }
    
    public function ajax_list()
    {
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];

        $return['data'] = array();

        //cache here
        foreach($this->Job->gets_company_status_type() as $rrr) {
            $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        }

        if($this->input->get('company_status_id') && is_numeric($this->input->get('company_status_id'))) {
            $this->Job->company_status_id = $this->input->get('company_status_id');
        }
        // Edit By B&M
        foreach($this->Job->get_student_by_company_id($company_id) as $row)
        {
            $tmp_array = array();
            
            // $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            $tmp_array['student']['student_gpax'] = $row['student_gpax'];
            $tmp_array['student']['student_id'] = $row['student_id'];
            

            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Company/Student/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';            


            $tmp_array['job_position'] = array();
            $tmp_array['job_position']['job_title'] = $row['job_title'];
            
            $tmp_array['company_status_type']['company_status_name'] = $row['company_status_name'];

            $company_type_Render = '<select name="company_status_type" onchange="change_company_type('.$row['student_id'].', this.value)">';
            foreach($cache['company_status_type'] as $key => $coop_type) {
                if($key == $row['company_status_id']) {
                    $company_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['company_status_name'].'</option>';
                } else {
                    $company_type_Render .= '<option value="'.$key.'">'.$coop_type['company_status_name'].'</option>';
                }
            }
            $company_type_Render .= '</select>';

            $tmp_array['company_status_type']['status_name'] = str_replace(" ", "", $tmp_array['company_status_type']['company_status_name']);
            $tmp_array['company_status_type']['select_box'] = $company_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];

            //print_r($tmp_array);
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }

    public function ajax_list1()
    {
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];

        $return['data'] = array();

        //cache here
        foreach($this->Job->gets_company_status_type() as $rrr) {
            $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        }

        if($this->input->get('company_status_id') && is_numeric($this->input->get('company_status_id'))) {
            $this->Job->company_status_id = $this->input->get('company_status_id');
        }
        // Edit By B&M
        foreach($this->Job->get_student_by_company_id1($company_id) as $row)
        {
            $tmp_array = array();
            
            // $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            $tmp_array['student']['student_gpax'] = $row['student_gpax'];
            $tmp_array['student']['student_id'] = $row['student_id'];
            

            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Company/Student/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';            


            $tmp_array['job_position'] = array();
            $tmp_array['job_position']['job_title'] = $row['job_title'];
            
            $tmp_array['company_status_type']['company_status_name'] = $row['company_status_name'];

            $company_type_Render = '<select name="company_status_type" onchange="change_company_type('.$row['student_id'].', this.value)">';
            foreach($cache['company_status_type'] as $key => $coop_type) {
                if($key == $row['company_status_id']) {
                    $company_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['company_status_name'].'</option>';
                } else {
                    $company_type_Render .= '<option value="'.$key.'">'.$coop_type['company_status_name'].'</option>';
                }
            }
            $company_type_Render .= '</select>';

            $tmp_array['company_status_type']['status_name'] = str_replace(" ", "", $tmp_array['company_status_type']['company_status_name']);
            $tmp_array['company_status_type']['select_box'] = $company_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];

            //print_r($tmp_array);
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }
    public function ajax_list2()
    {
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];

        $return['data'] = array();

        //cache here
        foreach($this->Job->gets_company_status_type() as $rrr) {
            $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        }

        if($this->input->get('company_status_id') && is_numeric($this->input->get('company_status_id'))) {
            $this->Job->company_status_id = $this->input->get('company_status_id');
        }
        // Edit By B&M
        foreach($this->Job->get_student_by_company_id2($company_id) as $row)
        {
            $tmp_array = array();
            
            // $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            $tmp_array['student']['student_gpax'] = $row['student_gpax'];
            $tmp_array['student']['student_id'] = $row['student_id'];
            

            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Company/Student/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';            


            $tmp_array['job_position'] = array();
            $tmp_array['job_position']['job_title'] = $row['job_title'];
            
            $tmp_array['company_status_type']['company_status_name'] = $row['company_status_name'];

            $company_type_Render = '<select name="company_status_type" onchange="change_company_type('.$row['student_id'].', this.value)">';
            foreach($cache['company_status_type'] as $key => $coop_type) {
                if($key == $row['company_status_id']) {
                    $company_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['company_status_name'].'</option>';
                } else {
                    $company_type_Render .= '<option value="'.$key.'">'.$coop_type['company_status_name'].'</option>';
                }
            }
            $company_type_Render .= '</select>';

            $tmp_array['company_status_type']['status_name'] = str_replace(" ", "", $tmp_array['company_status_type']['company_status_name']);
            $tmp_array['company_status_type']['select_box'] = $company_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];

            //print_r($tmp_array);
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }
    public function ajax_list3()
    {
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];

        $return['data'] = array();

        //cache here
        foreach($this->Job->gets_company_status_type() as $rrr) {
            $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        }

        if($this->input->get('company_status_id') && is_numeric($this->input->get('company_status_id'))) {
            $this->Job->company_status_id = $this->input->get('company_status_id');
        }
        // Edit By B&M
        foreach($this->Job->get_student_by_company_id3($company_id) as $row)
        {
            $tmp_array = array();
            
            // $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            $tmp_array['student']['student_gpax'] = $row['student_gpax'];
            $tmp_array['student']['student_id'] = $row['student_id'];
            

            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Company/Student/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';            


            $tmp_array['job_position'] = array();
            $tmp_array['job_position']['job_title'] = $row['job_title'];
            
            $tmp_array['company_status_type']['company_status_name'] = $row['company_status_name'];

            $company_type_Render = '<select name="company_status_type" onchange="change_company_type('.$row['student_id'].', this.value)">';
            foreach($cache['company_status_type'] as $key => $coop_type) {
                if($key == $row['company_status_id']) {
                    $company_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['company_status_name'].'</option>';
                } else {
                    $company_type_Render .= '<option value="'.$key.'">'.$coop_type['company_status_name'].'</option>';
                }
            }
            $company_type_Render .= '</select>';

            $tmp_array['company_status_type']['status_name'] = str_replace(" ", "", $tmp_array['company_status_type']['company_status_name']);
            $tmp_array['company_status_type']['select_box'] = $company_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];

            //print_r($tmp_array);
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }
    public function ajax_list4()
    {
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $data['trainer_id'] = $tmp['person_id'];

        $return['data'] = array();

        //cache here
        foreach($this->Job->gets_company_status_type() as $rrr) {
            $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        }

        if($this->input->get('company_status_id') && is_numeric($this->input->get('company_status_id'))) {
            $this->Job->company_status_id = $this->input->get('company_status_id');
        }
        // Edit By B&M
        foreach($this->Job->get_student_by_company_id4($company_id) as $row)
        {
            $tmp_array = array();
            
            // $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            $tmp_array['student']['student_gpax'] = $row['student_gpax'];
            $tmp_array['student']['student_id'] = $row['student_id'];
            

            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Company/Student/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';            


            $tmp_array['job_position'] = array();
            $tmp_array['job_position']['job_title'] = $row['job_title'];
            
            $tmp_array['company_status_type']['company_status_name'] = $row['company_status_name'];

            $company_type_Render = '<select name="company_status_type" onchange="change_company_type('.$row['student_id'].', this.value)">';
            foreach($cache['company_status_type'] as $key => $coop_type) {
                if($key == $row['company_status_id']) {
                    $company_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['company_status_name'].'</option>';
                } else {
                    $company_type_Render .= '<option value="'.$key.'">'.$coop_type['company_status_name'].'</option>';
                }
            }
            $company_type_Render .= '</select>';

            $tmp_array['company_status_type']['status_name'] = str_replace(" ", "", $tmp_array['company_status_type']['company_status_name']);
            $tmp_array['company_status_type']['select_box'] = $company_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];

            //print_r($tmp_array);
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }

    public function ajax_delete_student()
    {  
        foreach ($this->input->post('students') as $student_id) {
            $this->Job->update_student_register_from_company($student_id);
            $this->Job->delete_student_register_from_company($student_id);
            $this->Job->delete_student_document($student_id);
            $this->Job->update_company_status($student_id);

            // $status_type = $this->input->post('status');
            // foreach($this->input->post('students') as $student_id) {
            //     if($this->Student->get_student($student_id)) {
            //         //update status
            //         $this->Job->update_student($student_id, array( 'company_status_id' => $status_type ));

            //         if($status_type == 1) {
            //             $this->Student->update_student($student_id, array( 'company_status_id' => $status_type, 'coop_status_id' => 1 ));
            //         } else {
            //             $this->Student->update_student($student_id, array( 'company_status_id' => $status_type ));
            //         }
            //     }
            // }
        }
        //print_r($student_id);
    }

    public function ajax_change_status()
    {
        $data = array();
        $data['status'] = false;
        $data['msg'] = 'ผิดพลาด';
        $data['msg_icon'] = 'warning';
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status','status','required|numeric');
        if($this->form_validation->run() != false){


            $status_type = $this->input->post('status');
            foreach($this->input->post('students') as $student_id) {
                if($this->Student->get_student($student_id)) {
                    //update status
                    $this->Job->update_student($student_id, array( 'company_status_id' => $status_type ));
                    $this->Job->update_tb_student($student_id, array( 'company_status_id' => $status_type ));
                    //
                }
            }
            
            $data['status'] = true;
            $data['msg'] = 'เปลี่ยนสถานะสำเร็จ';
            $data['msg_icon'] = 'success';
            
            
        }
        
        echo json_encode($data);
    }

    public function ajax_send_email_to_officer()
    {
     
        
    
        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $msg2 = "";
        foreach($this->Job->get_name_by_company_id($company_id) as $row)
        {
            $company_name_arr= $row['company_name_th'];
            $msg2 = $msg2."\n".$company_name_arr;
        }
        print_r($msg2);

        $to = "coopofficerbuu@gmail.com"; //Officer Email
        $subject = 'แจ้งรายชื่อนิสิตที่ถูกเรียกสัมภาษณ์';
        $msg = (string)$student_id;
        $this->load->library('email');
        $this->email->from('buu.coopsystem@gmail.com', 'Informatics CoOp');
        $this->email->to($to);
        $this->email->cc('mixmaajix@gmail.com');
        $this->email->subject($subject);
        foreach ($this->input->post('students') as $student_id) {
            $msg = $msg."\n".$student_id;
            $this->Job->update_tb_student_coop($student_id);
        }
        $this->email->message($msg2." ได้ทำการเรียกสัมภาษณ์นิสิตที่มีรหัสนิสิตดังต่อไปนี้".$msg);
        $this->email->send();
        //echo $this->email->print_debugger();


        // $this->cache->file->save('userpass_'.$data['last_id'], $msg, 86400*365);

        /*$data['status'] = true;
        $data['text'] = 'ระบบได้ส่ง username / password ไปที่ email ที่กรอกมาเรียบร้อยค่ะ';
        $data['color'] = 'success';*/
        // $this->email->print_debugger();

        echo json_encode($data);
    }

    public function ajax_send_email_to_officer_pass()
    {  

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];
        $msg2 = "";
        foreach($this->Job->get_name_by_company_id($company_id) as $row)
        {
            $company_name_arr= $row['company_name_th'];
            $msg2 = $msg2."\n".$company_name_arr;
        }
        //print_r($msg2);
        $to = "coopofficerbuu@gmail.com"; //Officer Email
        $subject = 'แจ้งรายชื่อนิสิตที่ผ่านการสัมภาษณ์จาก '.$msg2;
        $msg = (string)$student_id;
        $this->load->library('email');
        $this->email->from('buu.coopsystem@gmail.com', 'Informatics CoOp');
        $this->email->to($to);
        $this->email->cc('mixmaajix@gmail.com');
        $this->email->subject($subject);
        foreach ($this->input->post('students') as $student_id) {
            $msg = $msg."\r\n".$student_id;
        }
        $this->email->message("รหัสนิสิตดังต่อไปนี้ได้ผ่านการสัมภาษณ์จาก ".$msg2."</br>".$msg);
        $this->email->send();
        //echo $this->email->print_debugger();


        // $this->cache->file->save('userpass_'.$data['last_id'], $msg, 86400*365);

        /*$data['status'] = true;
        $data['text'] = 'ระบบได้ส่ง username / password ไปที่ email ที่กรอกมาเรียบร้อยค่ะ';
        $data['color'] = 'success';*/
        // $this->email->print_debugger();

        echo json_encode($data);
    }


}  
  
