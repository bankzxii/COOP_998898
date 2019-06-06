<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_document extends CI_Controller {

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
        $this->form();
    }

    public function form()
	{
        $term_id = $this->Login_session->check_login()->term_id;
        
        $student_id = $this->Login_session->check_login()->login_value;
        $data['session_alert'] = '';

        $this->form_validation->set_rules('coop_document_id', 'ประเภทเอกสาร', 'trim|required|is_natural_no_zero');
        
        // input form view
        if ($this->form_validation->run() != FALSE)
        {
        
        // if($this->input->post('coop_document_id')) {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'pdf|jpg|jpeg|png';
            $config['max_size']             = 2048;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file-input')) {
                $data['session_alert'] = '<div class="alert alert-warning">'.$this->upload->display_errors().'</div>';
            } else {
                $file = $this->upload->data();    

                $document_form = $this->Form->get_form($this->input->post('coop_document_id'))[0];

                //insert to db
                $insert['document_pdf_file'] = '/uploads/'.$file['file_name'];
                $insert['coop_document_id'] = $document_form['document_id'];
                $insert['student_id'] = $student_id;
                $insert['document_subject'] = 1;
                
                @$this->Coop_Submitted_Form_Search->delete_form_by_student_and_code($student_id, $document_form['document_id']);                    
                $this->Coop_Submitted_Form_Search->insert_form_by_student_and_code($insert);

                if($document_form['document_name'] == 'IN-S001') {
                    $this->Student->update_student($student_id, array(
                        'ins001_file' => $insert['document_pdf_file']
                    ));
                }
                $data['session_alert'] = '<div class="alert alert-success">อัพโหลดเอกสาร <b>'.$document_form['document_code'].' '.$document_form['document_name'].'</b> เรียบร้อย ขอบคุณที่ให้ความร่วมมือค่ะ</div>';
            }
        }
        
        //check old document        
        $data['documents'] = $this->Form->search_form_by_code(array('IN-S001', 'IN-S002'), $term_id);
        
        $this->breadcrumbs->push('อัพโหลดเอกสารที่เกี่ยวข้อง', '/Student/Upload_document/');
        
        

        $this->template->view('Student/Upload_document_view', $data);
        
       
    }

}