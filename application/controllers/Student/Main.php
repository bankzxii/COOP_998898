<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// student
class Main extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $user = $this->Login_session->check_login();
        
        if(!$user) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        if($user->login_type != 'student') {
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
            die();
        }
      
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
        // $this->output->enable_profiler(TRUE);

    }

	public function index()
	{
        $student_id = $this->Login_session->check_login()->login_value; 
        $term_id = $this->Login_session->check_login()->term_id;  
        


        $data['rowNews'] = $this->News->gets_news();
        $this->breadcrumbs->push('ประกาศข่าวสาร', '/Student/Job/lists');

        //check ins001 register
        $coop_document_id = @$this->Form->get_form_by_name('IN-S001', $term_id)[0]['document_id'];        
        $data['ins001'] = $this->Coop_Submitted_Form_Search->search_uploaded_form_by_student_and_codes($student_id, [$coop_document_id]);

        $status = $this->session->flashdata('status');

        $data['status'] = [];

        $data['session_alert'] = $this->session->flashdata('status');


		$this->template->view('Student/Main_view', $data);
		
    }
    
    public function coop_register()
    {
        $student_id = $this->Login_session->check_login()->login_value;    


	   $data['student'] = @$this->Student->get_student($student_id)[0];
	   $data['sum_credit'] = @$this->Student->get_student_sum_credit($student_id);
        $data['department'] = @$this->Student->get_department($data['student']['department_id'])[0];
        $data['term'] = @$this->Term->get_term($data['student']['term_id'])[0];
        $student_info = $this->Student->get_student_data_from_profile($student_id);
        // array_walk($student_info, 'replace_null_val');
        $student_info = array_map('replace_null_val', $student_info);
        
        
        //print
        $template_file = "template/IN-S001.docx";
        $save_filename = "download/".$student_id."-IN-S001-O.docx";
        $data_array = [
            'student_id' => $student_id,
            'department_name' => $data['department']['department_name'],
            'term_semester' => $data['term']['term_semester'],
            'term_year' => $data['term']['term_year'],
            'Student_Level' => get_student_level_from_entry_year($student_info['Entry_Years']),
            'Student_Credit' => $data['sum_credit'],
            'date' => thaiDate(date('Y-m-d H:i:s'), true, false),
        ];

        $data_array = array_merge($data_array, $student_info);
        // var_dump($data_array);

        $result = $this->service_docx->print_data($data_array, $template_file, $save_filename);

        // insert to db
        $coop_document_id = $this->Form->get_form_by_name('IN-S001', $this->Login_session->check_login()->term_id)[0]['document_id'];
        $word_file = '/uploads/'.basename($save_filename);
        $this->Form->submit_document($student_id, $coop_document_id, NULL, $word_file);

        $this->session->set_flashdata('status', '<div class="alert alert-success">สมัครเข้าร่วมเป็นนิสิตสหกิจเรียบร้อยค่ะ</div>', 300);
        
        // redirect(base_url($result['full_url']), 'refresh');
        echo "
            <img src='".base_url('assets/img/loading.gif')."' />
            <script>
                window.location = '".base_url($result['full_url'])."';
                setTimeout(function(){
                    window.location = '".site_url('Student/Main')."';
                }, 1500);
            </script>
        ";
    }
}  
  
