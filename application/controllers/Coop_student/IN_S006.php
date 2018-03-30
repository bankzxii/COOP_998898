<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IN_S006 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        $user = $this->Login_session->check_login();
        if($user->login_type != 'coop_student') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
      
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.$user->login_type); //actor
    }
    public function form($status = ''){
        if($status == '') {
            $status = $this->input->get('status');
        }

        if( $status == 'success'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'บันทึกสำเร็จ';
        }
        else if($status == 'error_input'){
            $data['status']['color'] = 'warning';            
            $data['status']['text'] = 'เพิ่มไม่สำเร็จ';

        }
        else {
            $data['status'] = '';
        }
        $student_id = $this->Login_session->check_login()->login_value;
        // print_r($student_id);

        $data['subject_report'] = @$this->Subject_Report->get_report($student_id)[0];
        // print_r($data);
        
        // Breadcrumb
        $this->breadcrumbs->push('จัดการหัวข้อรายงาน', '/Coop_student/IN_S006/form');

        $this->template->view('Coop_student/Reportmanager_view', $data);
    }

    public function post_report(){

        // print_r($_POST);
        $student_id = $this->Login_session->check_login()->login_value;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject_th', 'หัวข้อภาษาไทย', 'required');
        $this->form_validation->set_rules('subject_en', 'หัวข้อภาษาอังกฤษ', 'required|alpha');
        $this->form_validation->set_rules('report_detail', 'รายละเอียดเนื้อหาของรายงาน', 'required');

        if ($this->form_validation->run() == FALSE)
                {
                    redirect('Coop_student/IN_S006/form/?status=error_input','refresh');

                }else{
                    $array['student_id'] = $student_id ;
                    $array['subject_th'] = $this->input->post('subject_th');
                    $array['subject_en'] = $this->input->post('subject_en');
                    $array['report_detail'] = $this->input->post('report_detail');

                    $sql_status = false;
                    $sql_status = $this->Subject_Report->save($array);
                    if($sql_status) {
                        //chek=c if print
                        if($this->input->post('print') == 1){
                            $this->print_data();

                        }else {
                            redirect('Coop_student/IN_S006/form/?status=success','refresh');
                        }
                        
                    } else {
                        redirect('Coop_student/IN_S006/form/?status=error_input','refresh');
                    }
                
                }
                    
        }
    
                public function print_data()
                {
                    $student_id = $this->Login_session->check_login()->login_value;
                    $data['student'] = @$this->Student->get_student($student_id)[0];
                    $data['coop_student'] = @$this->Coop_Student->get_coop_student($student_id)[0];
                    $data['department'] = @$this->Student->get_department($data['student']['department_id'])[0];
                    $data['subject_report'] = @$this->Subject_Report->get_report($student_id)[0];
                    $data['company'] = @$this->Company->get_company($data['coop_student']['company_id'])[0];
                    $data['company_person'] = @$this->Trainer->get_trainer($data['company']['contact_person_id'])[0];
                    $data['company_address'] = @$this->Address->get_address_by_company($data['company']['id'])[0];
                    

                    $template_file = "template/IN-S006.docx";        
                    $save_filename = "download/".$student_id."-IN-S006.docx";
                    $data_array = [
                        "student_fullname_th" => $data['student']['fullname'],
                        "student_id" => $data['student']['id'],
                        "student_course" => $data['student']['student_course'],
                        "department_name" => $data['department']['name'],
                        "company_name_th" => $data['company']['name_th'],
                        "company_number" => $data['company_address']['number'],
                        "company_road" => $data['company_address']['road'],
                        "company_alley" => $data['company_address']['alley'],
                        "company_district" => $data['company_address']['district'],
                        "company_area" => $data['company_address']['area'],
                        "{company_province" => $data['company_address']['province'],
                        "company_postal_code" => $data['company_address']['postal_code'],
                        "company_person_telephone" => $data['company_person']['telephone'],
                        "company_person_fax_number" => $data['company_person']['fax_number'],
                        "company_person_email" => $data['company_person']['email'],
                        "coop_student_subject_th" => $data['subject_report']['subject_th'],
                        "coop_student_subject_en" => $data['subject_report']['subject_en'],
                        "coop_student_report_detail" => $data['subject_report']['report_detail'],

                        
                    ];
            
                    // print_r($data_array);
                    // die();
            
                    $result = $this->service_docx->print_data($data_array, $template_file, $save_filename);
                    // print_r($result);
                    // redirect(base_url($result['full_url']), 'refresh');
            
                    //insert to db
                    $coop_document_id = $this->Form->get_form_by_name('IN-S006', $this->Login_session->check_login()->term_id)[0]['id'];
                    $word_file = '/uploads/'.basename($save_filename);
                    $this->Form->submit_document($student_id, $coop_document_id, NULL, $word_file);
            
            
                    // redirect(base_url($result['full_url']), 'refresh');
                    echo "
                        <img src='".base_url('assets/img/loading.gif')."' />
                        <script>
                            window.location = '".base_url($result['full_url'])."';
                            setTimeout(function(){
                                window.location = '".site_url()."';
                            }, 1500);
                        </script>
                    ";
            
            
                }
}