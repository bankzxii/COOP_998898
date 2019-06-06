<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainer extends CI_Controller {
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
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
            die();
        }
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }

    public function lists($company_id, $status = '')
    {
        if($status == '') {
            $status = $this->session->flashdata('status');
        }

        if( $status == 'success'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'เพิ่มสำเร็จ';
        }
        else if($status == 'error_input'){
            $data['status']['color'] = 'warning';            
            $data['status']['text'] = 'เพิ่มไม่สำเร็จ';

        }
        else if($status == 'success_delete'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'ลบสำเร็จ';

        }
        else if($status == 'success_update'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'แก้ไขสำเร็จ';

        }
        else if($status == 'error_delete'){
            $data['status']['color'] = 'warning';            
            $data['status']['text'] = 'ลบไม่สำเร็จ';

        }
        else {
            $data['status'] = '';
        }

        $data['data'] = array();

        $data['company'] = $this->Company->get_company($company_id)[0];

        foreach($this->Trainer->gets_trainer_by_company($company_id) as $row) {
            $tmp_array = array();
            $tmp_array['company_person'] = $row;
            
            array_push($data['data'], $tmp_array);

        }
        // print_r($data);
        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลสถานประกอบการ', '/Officer/Company/index');
        $this->breadcrumbs->push('เจ้าหน้าที่ในบริษัท', '/Officer/Trainer/lists/'.$company_id);
        
        $this->template->view('Officer/List_trainer_view',$data);
    }

    public function insert_person()
    {
        $this->template->view('Officer/insert_person_view');
    }
   
    public function delete()
    {
        //check if exist
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('company_person_id', 'company_person_id', 'trim|required|numeric');
        $this->form_validation->set_rules('company_id', 'company_id', 'trim|required|numeric');
        $company_id = $this->input->post('company_id');
        if ($this->form_validation->run() != FALSE) {
            $company_person_id = $this->input->post('company_person_id');

            if($this->Trainer->get_trainer($company_person_id)) {
                //delete
                $this->Trainer->update_trainer($company_person_id, array(
                    'person_active' => 0
                ));
                // $this->Trainer->delete_trainer($company_person_id);
                return $this->lists($company_id, 'success_delete');
                die();
            } else {
                return $this->lists($company_id, 'error_delete');
                die();
            }
        } else {
            return $this->lists($company_id, 'error_delete');
            die();
        }
        
    }

    // public function add_employee()
    // {
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('person_fullname','ชื่อ-นามสกุล','required');
    //     $this->form_validation->set_rules('person_position','ตำเเหน่ง','required');
    //     $this->form_validation->set_rules('person_department','เเผนกงาน','required');
    //     $this->form_validation->set_rules('person_telephone','เบอร์โทร','required|numeric');
    //     $this->form_validation->set_rules('person_fax_number','FAX');
    //     $this->form_validation->set_rules('person_email','E-mail','required|valid_email|is_unique[tb_company_person.person_email]');
    //     $this->form_validation->set_rules('company_id','company_id','required');
    //     $array['company_id'] = $this->input->post('company_id');

    //     $password_gen = generateStrongPassword(8);
    //     $password_gen_db = password_hash($password_gen, PASSWORD_DEFAULT);

    //     if($this->form_validation->run() == false){
    //         //get employee by email
    //         $company_person = $this->Trainer->get_trainer_by_email($this->input->post('person_email'))[0];
    //         if($company_person) {
    //             //update status active and gen new password
    //             $array['person_fullname'] = $this->input->post('person_fullname');
    //             $array['person_position'] = $this->input->post('person_position');
    //             $array['person_department'] = $this->input->post('person_department');
    //             $array['person_telephone'] = $this->input->post('person_telephone');
    //             $array['person_fax_number'] = $this->input->post('person_fax_number');
    //             $array['person_active'] = 1;
    //             $array['person_password'] = $password_gen_db;

    //             $this->Trainer->update_trainer($company_person['person_id'], $array);

    //             //sent email to person
    //             $to = $company_person['person_email'];
    //             $subject = 'แจ้งข้อมูลเข้าใช้งานระบบสหกิจศึกษา มหาวิทยาลัยบูรพา';
    //             $msg = 'Username: '.$company_person['person_username'].' | Password: '.$password_gen.' | '.site_url();
    //             $this->cache->file->save('userpass_'.$company_person['id'], $msg, 86400*365);    
    //             // echo $msg;
    //             // mail($to, $subject, $msg);

    //             redirect('Officer/Trainer/lists/'.$array['company_id'].'/?status=success','refresh');
                

    //         } else {
    //             redirect('Officer/Trainer/lists/'.$array['company_id'].'/?status=error_input','refresh');
    //         }
            

    //     } else {
    //         //success
    //         $array['person_fullname'] = $this->input->post('person_fullname');
    //         $array['person_position'] = $this->input->post('person_position');
    //         $array['person_department'] = $this->input->post('person_department');
    //         $array['person_telephone'] = $this->input->post('person_telephone');
    //         $array['person_fax_number'] = $this->input->post('person_fax_number');
    //         $array['person_email'] = $this->input->post('person_email');
    //         $array['company_id'] = $this->input->post('company_id');
    //         $array['person_username'] = $this->input->post('person_email');

    //         $array['person_password'] = $password_gen_db;
            
    //         $this->Trainer->insert_trainer($array);

    //         //sent email to person
    //         $to = $array['person_email'];
    //         $subject = 'แจ้งข้อมูลเข้าใช้งานระบบสหกิจศึกษา มหาวิทยาลัยบูรพา';
    //         $msg = 'Username: '.$array['person_username'].' | Password: '.$password_gen.' | http://localhost:8080/';
    //         $this->cache->file->save('userpass_'.$this->db->insert_id(), $msg, 86400*365);
    //         // echo $msg;
    //         // mail($to, $subject, $msg);

    //     }
        
    //     redirect('Officer/Trainer/lists/'.$array['company_id'].'/?status=success','refresh');
    // }

    public function edit_form($trainer_id, $status = '')
    {
        if($status == '') {
            $status = $this->session->flashdata('status');
        }

        if($status == 'error_update'){
            $data['status']['color'] = 'warning';            
            $data['status']['text'] = 'แกไข้ไม่สำเร็จ';

        }
        else {
            $data['status'] = '';
        }
        //print_r($trainer_id);
        $data['person'] = $this->Trainer->get_trainer($trainer_id)[0];
        // print_r($data);

         // add breadcrumbs
         $this->breadcrumbs->push('จัดการข้อมูลสถานประกอบการ', '/Officer/Company/index');
         $this->breadcrumbs->push('เจ้าหน้าที่ในบริษัท', '/Officer/Trainer/lists/'.$trainer_id);
         $this->breadcrumbs->push('แก้ไขข้อมูลเจ้าหน้าที่', '/');

         $this->template->view('Officer/Edit_person_trainer_view',$data);
    }

    public function edit($trainer_id)
    {
        $company_id = $this->input->post('company_id');
        // print_r($company_id);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('person_fullname','ชื่อ-นามสกุล','required');
        $this->form_validation->set_rules('person_position','ตำเเหน่ง','required');
        $this->form_validation->set_rules('person_email','E-mail','required|valid_email');
        if($this->form_validation->run() == false){
            $this->session->set_flashdata('status', 'error_update');
            redirect('Officer/Trainer/edit_form/'.$trainer_id.'/?','refresh');
        } else {
            //success

            $array['person_fullname'] = $this->input->post('person_fullname');
            $array['person_email'] = $this->input->post('person_email');
            $array['person_position'] = $this->input->post('person_position');

            $this->Trainer->update_trainer($trainer_id,$array);
            $this->session->set_flashdata('status', 'success_update');
            redirect('Officer/Trainer/lists/'.$company_id.'/?status=success_update','refresh');
        }
        
    }



    public function ajax_save_trainer()
    {
        $data = array();
        $data['status'] = false;
        $data['text'] = 'ผิดพลาด มีผู้ใช้ E-mail นี้อยู่แล้ว';
        $data['color'] = 'warning';
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('person_fullname','ชื่อ-นามสกุล','required');
        $this->form_validation->set_rules('person_position','ตำเเหน่ง','required');
        $this->form_validation->set_rules('person_department','เเผนกงาน','required');
        $this->form_validation->set_rules('person_telephone','เบอร์โทร','required');
        $this->form_validation->set_rules('company_id','IDสถานประกอบการ','required|numeric');
        $this->form_validation->set_rules('person_fax_number','FAX');
        // $this->form_validation->set_rules('person_email','E-mail','required|valid_email|is_unique[tb_company_person.person_email]');
        $this->form_validation->set_rules('person_email','E-mail','required|valid_email');


        if($this->form_validation->run() != false){

            $person_email = $this->input->post('person_email');
            $tmp = "";
            $company_person = $this->Trainer->get_trainer_by_email();
            foreach ($company_person as $person) {
                if($person['person_email'] == $person_email){
                    $tmp = $person['person_email'];
                }
            }

            if($tmp == ""){

                $password_gen = generateStrongPassword(8);
                $password_gen_db = password_hash($password_gen, PASSWORD_DEFAULT);


                $array['company_id'] = $this->input->post('company_id');

                $array['person_fullname'] = $this->input->post('person_fullname');
                $array['person_position'] = $this->input->post('person_position');
                $array['person_department'] = $this->input->post('person_department');
                $array['person_telephone'] = $this->input->post('person_telephone');
                $array['person_fax_number'] = $this->input->post('person_fax_number');
                $array['person_email'] = $this->input->post('person_email');
                $array['person_username'] = $array['person_email'];
                $array['person_active'] = 1;

                $array['person_password'] = $password_gen_db;
                
                $this->Trainer->insert_trainer($array);
                $data['last_id'] = $this->db->insert_id();
                
                $to = $array['person_email'];
                $subject = 'แจ้งข้อมูลเข้าใช้งานระบบสหกิจศึกษา มหาวิทยาลัยบูรพา';
                $msg = 'Username: '.$array['person_username'].' | Password: '.$password_gen.' | '.site_url();
                //sentmail here
                $this->load->library('email');
                $this->email->from('buu.coopsystem@gmail.com', 'Informatics CoOp');
                $this->email->to($array['person_email']);
                $this->email->subject('แจ้งรายละเอียดข้อมูลเข้าระบบสหกิจ');
                $this->email->message($msg);
                $this->email->send();
                //echo $this->email->print_debugger();


                // $this->cache->file->save('userpass_'.$data['last_id'], $msg, 86400*365);

                $data['status'] = true;
                $data['text'] = 'ระบบได้ส่ง username / password ไปที่ email ที่กรอกมาเรียบร้อยค่ะ';
                $data['color'] = 'success';
            }
            
        } else {

            $data['text'] = strip_tags(validation_errors());
            
        }

        echo json_encode($data);
    }
}






