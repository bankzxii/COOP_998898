<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
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

    public function index($status = '')
    {
        if($status == 'success_insert' ) {
            $data['status']['color'] = 'success';
            $data['status']['text'] = 'ทำการเพิ่มสถานประกอบการเรียบร้อย';
        } else if($status == 'error_add' ) {
            $data['status']['color'] = 'danger';
            $data['status']['text'] = 'ผิดพลาด โปรดตรวจสอบ';
        } else if($status != '' ) {
            $data['status']['color'] = 'danger';
            $data['status']['text'] = $status;
        } 
        else {
            $data['status'] = '';
        }

        $data['data'] = $this->Company->gets_company();
    
        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลสถานประกอบการ', '/Officer/Company/index');

        $this->template->view('Officer/List_company_view',$data);
    }
    public function address($company_id){

        $data['data'] = $this->Address->get_address_by_company($company_id)[0];  
        $data['tmp'] = $this->Company->get_company($company_id)[0];  
        $data['contact'] = @$this->Trainer->get_trainer($data['tmp']['contact_person_id'])[0];

        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลสถานประกอบการ', '/Officer/Company/index');
        $this->breadcrumbs->push('ที่อยู่สถานประกอบการ', '/Officer/Company/address/'.$company_id);

        $this->template->view('Officer/Address_company_view',$data);
    }
    public function delete($id)
    {
            if(@$this->Company->get_company($id)) {
                //delete
                $this->Company->delete_company($id);
                return $this->index('success_delete');
                die();
            } else {
                return $this->index();
                die();
            }
        
    }
    public function post_add()
    {
        //insert
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('company_name', 'ชื่อสถานประกอบการ', 'trim|required|is_unique[company.name_th]');

        if ($this->form_validation->run() != FALSE) {
            
            $insert['name_th'] = $this->input->post('company_name');
            
 
            if($this->Company->insert_company($insert)) {
                // return $this->index('success_insert');
                redirect('/Officer/Company_info/step1/'.$this->db->insert_id(), 'refresh');
                die();
            } else {
                return $this->index('error_add');
                die();
            }
        } else {
            return $this->index(validation_errors());
            die();
        }
    }



    

}