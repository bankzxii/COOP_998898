<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends CI_Controller {

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
            redirect(ucfirst($user->login_type).'/main/');
            die();
        }
          //add ->breadcrumbs
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor

    }


    public function lists()
    {
        $data = [];
        
        
        $student_id = $this->Login_session->check_login()->login_value;


        
        if(!$this->Skill_Search->search_skill_by_student($student_id)){
            $this->session->set_flashdata('status', 'select_before');
            redirect('Student/Skill/index?', 'refresh');
        }

        

        $this->load->library('form_validation');

        $this->form_validation->set_rules('company_id', 'บริษัท', 'required|numeric');
        $this->form_validation->set_rules('job_title_id', 'ตำแหน่งงาน', 'required|numeric');
        
        $data['student'] = $this->Student->get_student($student_id)[0];
        $data['session_alert'] = '';
        $data['pass_training'] = false;
        $train_type = $this->Training->get_student_stat_of_training($student_id)['train_type'];
        $data['train_type'] = array();
        foreach($train_type as $type) {
            $tmp['name'] = $type['train_type_name'];
            $tmp['total_hour'] = $type['train_type_total_hour'];
            $tmp['check_hour'] = 0;
            //calc total hour
            foreach($type['history'] as $history) {
                $tmp['check_hour'] += $history['check_hour'];
            }

            if($tmp['check_hour'] >= $tmp['total_hour']) {
                $data['pass_training'] = true;
            } else {
                $data['pass_training'] = false;
            }
        }
        if($data['student']['coop_status_id'] > 1) {
            $data['session_alert'] = '<div class="alert alert-warning">คุณทำการสมัครงานสหกิจแล้ว โปรดรอการตอบกลับขั้นตอนต่อไปค่ะ</div>';
        } else {
            $data['company'] = $this->Company->gets_company_active();
            $data['job'] = $this->Job->gets_job_title();
        
            $data['data'] = array();
            $jobs = [];
            if($this->form_validation->run() == FALSE) {
                $jobs = $this->Job->gets_job();
            } else {
                // if($this->input->post('job_title_id') > 0) {
                    // $job_title = @$this->Job->get_company_job_title_by_job_title_id($this->input->post('job_title_id'))[0]['job_title'];
                // } else {
                    // $job_title = null;
                // }
                // $job_title = null;
                // $job_title = $this->input->post('job_title');

                $jobs = $this->Job->search_job_by_company_and_position($this->input->post('company_id'), $this->input->post('job_title_id'));
                // if($this->input->post('job_title_id') > 0) {
                //     $jobs = $this->Job->search_job_by_company_and_position($this->input->post('company_id'), $this->input->post('job_title_id'));
                // } else {
                //     $jobs = $this->Job->gets_job_by_company($this->input->post('company_id'));  
                // }
            }

    
            foreach($jobs as $row) {
                $temp = array();
                $temp['company_job_position'] = $row;
                
                $temp['company'] = @$this->Company->get_companys($row['company_id'])[0];
                $temp['address_company'] = @$this->Address->get_address_by_company($row['company_id'])[0];

                if(
                    $temp['address_company'] &&
                    $temp['company']
                ) {
                    array_push($data['data'], $temp);
                }
    
            }
            
        }

        


        
        $this->breadcrumbs->push('รายการสมัคร ตำแหน่งงาน และสถานประกอบการ', '/Student/Job/lists');
        $this->template->view('Student/Job_lists_view',$data);
    }

    public function register_form_company($company_id, $company_job_position_id)
    {
        $student_id = $this->Login_session->check_login()->login_value;
        $data['student'] = $this->Student->get_student($student_id)[0];
        $data['department'] = $this->Student->get_department($data['student']['department_id'])[0];
        $data['company'] = @$this->Company->get_company($company_id)[0];
        $data['company_job_position'] = @$this->Skilled_Job_Search->search_skill_by_job($company_job_position_id)[0];
        $data['student_profile'] = $this->Student->get_student_data_from_profile($student_id);

        $data['has_profile'] = $this->Student->has_student_data_from_profile($student_id);
        // print_r($data);
        

        //add ->breadcrumbs
        $this->breadcrumbs->push('รายการสมัคร ตำแหน่งงาน และสถานประกอบการ', '/Student/Job/lists');
        $this->breadcrumbs->push('แบบฟอร์มยื่นสมัครกับบริษัท', '/Student/Job/register_form_company');
        $this->template->view('Student/Register_form_company_view',$data);
    }

    public function register_status()
    {
        $student_id = $this->Login_session->check_login()->login_value;

        $data['company_job_position_has_student'] = $this->Job->gets_job_register_by_student($student_id);
        $this->breadcrumbs->push('ประกาศผลการสมัครงาน', '/Student/Job/register_status');
        $this->template->view('Student/Register_result_view', $data);
    }

    public function print_data()
    { //in-s002
        
        $student_id = $this->Login_session->check_login()->login_value;
        
        // print_r($_POST);
        // die();
        $this->form_validation->set_rules('job_student', 'ระบุสายงานและลักษณะงานอาชีพที่นิสิตสนใจ', 'trim|required');
        $this->form_validation->set_rules('telephone', 'โทร', 'trim|required');
        $this->form_validation->set_rules('height', 'ส่วนสูง cm', 'trim|required');
        $this->form_validation->set_rules('weight', 'น้ำหนัก kg', 'trim|required');
        $this->form_validation->set_rules('GPA', 'GPA', 'trim|required');

        $this->form_validation->set_rules('language_lang[]', 'ภาษา', 'trim|required');
        
        // input form view
        if ($this->form_validation->run() == FALSE)
        {
            $company_id = $this->input->post('company_id');
            $company_job_position_id = $this->input->post('company_job_position_id');
            $this->register_form_company($company_id, $company_job_position_id);
        }else{

            $telephone = $this->input->post('telephone');
        
            // input ข้อมูลส่วนตัวนิสิต
            $height = $this->input->post('height');
            $weight = $this->input->post('weight');
            $gpa = $this->input->post('GPA');

            // get form model

            $company_id = $this->input->post('company_id');
            $company_job_position_id = $this->input->post('company_job_position_id');
        

            $data['student_profile'] = @$this->Student->get_student_data_from_profile($student_id);
            $data['student'] = @$this->Student->get_student($student_id)[0];
            $data['department'] = @$this->Student->get_department($data['student']['department_id'])[0];
            $data['company'] = @$this->Company->get_company($company_id)[0];
            $data['job_position_name'] = @$this->Job->get_job($company_job_position_id)[0]['job_title'];
            // print_r($student_id);

            // $data['student_profile'] = array_walk($data['student_profile'], 'replace_null_val');
            // $data['student_profile'] = array_walk($data['student_profile'], 'replace_null_val');
            $data['student_profile'] = array_map('replace_null_val', $data['student_profile']);

        
            $template_file = "template/IN-S002.docx";        
        
            $save_filename = "download/".$student_id."-IN-S002-".time().".docx";
            $data_array = [

            // ข้อมูลนิสิต
                "Student_Prefix_Th" => $data['student_profile']['Student_Prefix'], //คำนำหน้า
                "Student_Name_Th" => $data['student_profile']['Student_Name_Th'], //ชื่อ(name)
                "Student_Lname_Th" => $data['student_profile']['Student_Lname_Th'], //นามสกุล(Surname)         
                "Student_ID" => $data['student_profile']['Student_ID'], //รหัสนิสิต

            // input form
                "Student_telephone" => $telephone, //โทร
                "Student_Phone" =>  $data['student_profile']['Student_Phone'], //มือถือ
                "Student_Email" => $data['student_profile']['Student_Email'], //อีเมล์

               
            // ชื่อสถานประกอบการที่ต้องการสมัคร
                "round" => "1", //รอบ
                "company_name_th" => $data['company']['company_name_th'], //ชื่อสถานประกอบการ
                "company_job_position" => $data['job_position_name'], //สมัครตำแหน่งงาน

            //ข้อมูลส่วนตัวนิสิต 
                "Student_Prefix_Th" => $data['student_profile']['Student_Prefix'], //คำนำหน้า 
                "Student_Name_Th" => $data['student_profile']['Student_Name_Th'], //ชื่อ
                "Student_Lname_Th" => $data['student_profile']['Student_Lname_Th'], //นามสกุล
                "Student_Nickname" => $data['student_profile']['Student_Nickname'], //ชื่อเล่น

                "Student_Prefix_Eng" => $data['student_profile']['Student_Prefix'], //คำนำหน้าอังกฤษ
                "Student_Name_Eng" => $data['student_profile']['Student_Name_Eng'], //ชื่ออังกฤษ
                "Student_Lname_Eng" => $data['student_profile']['Student_Lname_Eng'], //นามสกุลอังกฤษ
                "Student_IdNum" => $data['student_profile']['Student_IdNum'], //รหัสบัตรประชาชน
                "Nationnality" => $data['student_profile']['Nationality'],  //สัญชาติ
                "Religion" => $data['student_profile']['Relidion'], //ศาสนา
                "Province_Birth" => $data['student_profile']['Province_Birth'], //สถานที่เกิด
                "Birthday" => thaiDate($data['student_profile']['Birthday'], false, false), //วัน เดือน ปี เกิด
                
                // input form
                "Age" => get_age_from_birthday($data['student_profile']['Birthday']), //อายุ
                "Sex" => detect_gender_th($data['student_profile']['Student_Prefix']), //เพศ
                "height" => $height,  //ส่วนสูง
                "weight" => $weight, //น้ำหนัก

                "Course" => $data['department']['department_name'], //สาขา 
                "Student_ID" => $data['student_profile']['Student_ID'], //รหัสนิสิต

                // input form
                "Level" => get_student_level_from_entry_year($data['student_profile']['Entry_Years']), //ชั้นปี
                
                "GPA" => $gpa, //เกรดเฉลี่ยภาคที่ผ่านมา
                "GPAX" => $data['student_profile']['GPAX'], //เกรดเฉลี่ยรวม
                "Address_Number" => $data['student_profile']['Address_Number'], //ที่อยู่ที่ติดต่อได้ เลขที่
                "Address_Moo" => $data['student_profile']['Address_Moo'], //ที่อยู่ที่ติดต่อได้ หมู่
                "Address_Soi" => $data['student_profile']['Address_Soi'], //ที่อยู่ที่ติดต่อได้ ซอย
                "Address_Tumbon" => $data['student_profile']['Address_Tumbon'], //ที่อยู่ที่ติดต่อได้ ตำบล
                "Address_Aumper" => $data['student_profile']['Address_Aumper'], //ที่อยู่ที่ติดต่อได้ อำเภอ
                "Address_Province" => $data['student_profile']['Address_Province'], //ที่อยู่ที่ติดต่อได้ จังหวัด
                "Address_Postcode" => $data['student_profile']['Address_Postcode'], //ที่อยู่ที่ติดต่อได้ รหัสไปรษณีย์
                "Address_Phone" => $data['student_profile']['Address_Phone'], //ที่อยู่ที่ติดต่อได้ มือถือ
                "Address_Email" => $data['student_profile']['Address_Email'], //ที่อยู่ที่ติดต่อได้ อีเมล์
                "Home_Address_Number" => $data['student_profile']['Home_Address_Number'], //ที่ตามทะเบียนบ้าน เลขที่
                "Home_Address_Moo" => $data['student_profile']['Home_Address_Moo'], //ที่ตามทะเบียนบ้าน หมู่
                "Home_Address_Soi" => $data['student_profile']['Home_Address_Soi'], //ที่ตามทะเบียนบ้าน ซอย
                "Home_Address_Tumbon" => $data['student_profile']['Home_Address_Tumbon'], //ที่ตามทะเบียนบ้าน ตำบล
                "Home_Address_Aumper" => $data['student_profile']['Home_Address_Aumper'], //ที่ตามทะเบียนบ้าน อำเภอ
                "Home_Address_Province" => $data['student_profile']['Home_Address_Province'], //ที่ตามทะเบียนบ้าน จังหวัด
                "Home_Address_Postcode" => $data['student_profile']['Home_Address_Postcode'], //ที่ตามทะเบียนบ้าน รหัสไปรษณีย์
                
    
                "Address_Phone" => $data['student_profile']['Address_Phone'], //โทร
                "Student_Phone" => $data['student_profile']['Student_Phone'], //มือถือ
                "Student_Email" => $data['student_profile']['Student_Email'], //E-mail Address
                
                "Contact_Name" => $data['student_profile']['Contact_Name'], //บุคคลที่ติดต่อฉุกเฉิน
                "Contact_Phone" => $data['student_profile']['Contact_Phone'], //โทรศัพท์
                "Contact_Status" => $data['student_profile']['Contact_Status'], //ความสัมพันธ์
                "Contact_Address_Number" => $data['student_profile']['Contact_Address_Number'], //ที่อยู่กรณีติดต่อฉุกเฉิน เลขที่
                "Contact_Address_Tumbon" => $data['student_profile']['Contact_Address_Tumbon'], //ที่อยู่กรณีติดต่อฉุกเฉิน ตำบล
                "Contact_Address_Aumper" => $data['student_profile']['Contact_Address_Aumper'], //ที่อยู่กรณีติดต่อฉุกเฉิน อำเภอ
                "Contact_Address_Province" => $data['student_profile']['Contact_Address_Province'], //ที่อยู่กรณีติดต่อฉุกเฉิน จังหวัด
                "Contact_Address_Postcode" => $data['student_profile']['Contact_Address_Postcode'], //ที่อยู่กรณีติดต่อฉุกเฉิน รหัสไปรษณีย์
                
                "Father_Name" => $data['student_profile']['Father_Name'], //บิดา
                "Father_Career" => $data['student_profile']['Father_Career'], //อาชีพ
                "Father_Phone" => $data['student_profile']['Father_Phone'], //มือถือ
                
                "Father_Status_l" => "\u{2610}\u{0020}",// สถานะบิดา มีชีวิต
                "Father_Status_d" => "\u{2610}\u{0020}", // สถานะบิดา ถึงแก่กรรม

                "Father_Age" => "      ",

                "Father_Address_Number" => $data['student_profile']['Father_Address_Number'], //ที่อยู่บิดา เลขที่
                "Father_Address_Moo" => $data['student_profile']['Father_Address_Moo'], //ที่อยู่บิดา หมู่
                "Father_Address_Soi" => $data['student_profile']['Father_Address_Soi'], //ที่อยู่บิดา ซอย
                "Father_Address_Tumbon" => $data['student_profile']['Father_Address_Tumbon'], //ที่อยู่บิดา ตำบล
                "Father_Address_Aumper" => $data['student_profile']['Father_Address_Aumper'], //ที่อยู่บิดา อำเภอ
                "Father_Address_Province" => $data['student_profile']['Father_Address_Province'], //ที่อยู่บิดา จังหวัด
                "Father_Address_Postcode" => $data['student_profile']['Father_Address_Postcode'], //ที่อยู่บิดา รหัสไปรษณีย์



                "Mother_Name" => $data['student_profile']['Mother_Name'], //มารดา
                "Mother_Career" => $data['student_profile']['Mother_Career'], //อาชีพ
                "Mother_Phone" => $data['student_profile']['Mother_Phone'], //มือถือ


                "Mother_Status_l" => "\u{2610}\u{0020}",// สถานะบิดา มีชีวิต
                "Mother_Status_d" => "\u{2610}\u{0020}", // สถานะบิดา ถึงแก่กรรม

                "Mother_Age" => "      ",


                "Mother_Address_Number" => $data['student_profile']['Father_Address_Number'],
                "Mother_Address_Moo" => $data['student_profile']['Father_Address_Moo'],
                "Mother_Address_Soi" => $data['student_profile']['Father_Address_Soi'],
                "Mother_Address_Tumbon" => $data['student_profile']['Father_Address_Tumbon'],
                "Mother_Address_Aumper" => $data['student_profile']['Father_Address_Aumper'],
                "Mother_Address_Province" => $data['student_profile']['Father_Address_Province'],
                "Mother_Address_Postcode" => $data['student_profile']['Father_Address_Postcode'],

                // "Brethren" => "น้อง 1 คน", กรอกเอง


                "S_IT" => "\u{2610}\u{0020} ",
                "S_CS" => "\u{2610}\u{0020} ",
                "S_SE" => "\u{2610}\u{0020} ",

        ];


        // EDUCATIONAL HISTORY
        $education_history = [];
        $education_place = $this->input->post('education_place');
        $education_start_year = $this->input->post('education_start_year');
        $education_end_year = $this->input->post('education_end_year');
        $education_result = $this->input->post('education_result');
        foreach($this->input->post('education_level') as $key => $education_level) {
          $education_history[] = [

                'level' => $education_level,
                'place' => $education_place[$key],
                'startY' => $education_start_year[$key],
                'endY' => $education_end_year[$key],
                'result' => $education_result[$key]
            ];
        }
        $data_array['edu_history'] = $education_history;

        // TRAINING HISTORY
        $training_history = [];
        $training_place = $this->input->post('training_place');
        $training_start_period = $this->input->post('training_start_period');
        $training_end_period = $this->input->post('training_end_period');
        foreach(@$this->input->post('training_subject') as $key => $training_subject) {
            $training_history[] = [
                'subject' => $training_subject,
                'place' => $training_place[$key],
                'start' => $training_start_period[$key],
                'end' => $training_end_period[$key]
            ];
        }

        $data_array['training'] = $training_history;

        // CAREER VISION
        $data_array['job_student'] = $this->input->post('job_student');

        // LANGUAGE PROFICIENCY
        $lang_pro = [];
        $language_listen = $this->input->post('language_listen');
        $language_speak = $this->input->post('language_speak');
        $language_read = $this->input->post('language_read');
        $language_write = $this->input->post('language_write');
        foreach(@$this->input->post('language_lang') as $key => $language_lang) {
            $tmp_array = [
                'lang' => $language_lang,
                'l3' => "",
                'l2' => "",
                'l1' => "",
                's3' => "",
                's2' => "",
                's1' => "",
                'r3' => "",
                'r2' => "",
                'r1' => "",
                'w3' => "",
                'w2' => "",
                'w1' => ""                
            ];
            $tmp_array['l'.$language_listen[$key]] = "\u{2714}";
            $tmp_array['s'.$language_speak[$key]] = "\u{2714}";
            $tmp_array['r'.$language_read[$key]] = "\u{2714}";
            $tmp_array['w'.$language_write[$key]] = "\u{2714}";

            

                $lang_pro[] = $tmp_array;
            }
            $data_array['lang_pro'] = $lang_pro;



        // ความสามารถพิเศษทางคอมพิวเตอร์, ทักษะ
        // get head table
        $tmp_array_item = [];

        //get student selected skill
        $student_has_skill = array();
        foreach($this->Skill_Search->search_skill_by_student($student_id) as $has_skill) {
            $student_has_skill[] = $has_skill['skill_id'];
        }

        
        foreach($this->Skill->gets_skill_category() as $i => $skill_category) {
            $data_array['HS_'.++$i] = $skill_category['skill_category_name'];

            foreach($this->Skill->gets_skill_by_category_id($skill_category['skill_category_id']) as $key => $skill) { 
                $tmp_array_item[$key]['i_'.$i] = '';
                if(in_array($skill['skill_id'], @$student_has_skill)) {
                    $tmp_array_item[$key]['i_'.$i] .= "\u{2611}\u{0020} ";
                } else {
                    $tmp_array_item[$key]['i_'.$i] .= "\u{2610}\u{0020} ";
                }
                $tmp_array_item[$key]['i_'.$i] .= trim($skill['skill_name']);

                //delete undefined
                for($x=1;$x<=count($this->Skill->gets_skill_category());$x++) {
                    if(!@$tmp_array_item[$key]['i_'.$x]) {
                        $tmp_array_item[$key]['i_'.$x] = ' ';
                    }
                }
            }
        }
        

        $data_array['skill_item'] = $tmp_array_item;




      

        if($data['department']['department_id'] == 1) {
            $data_array['S_IT'] = "\u{2611}\u{0020} ";

        }else if($data['department']['department_id'] == 2){
            $data_array['S_CS'] = "\u{2611}\u{0020} ";
        }else if($data['department']['department_id'] == 3) {
            $data_array['S_SE'] = "\u{2611}\u{0020} ";
        }

        // print_r($data_array);


        if($data['student_profile']['Father_Status'] == "มีชีวิต" ){
            $data_array ['Father_Status_l'] = "\u{2611}\u{0020} ";
        } else if ($data['student_profile']['Father_Status'] == "ถึงแก่กรรม" ) {

        }


        if($data['student_profile']['Mother_Status'] == "มีชีวิต" ){
            $data_array ['Mother_Status_l'] = "\u{2611}\u{0020} ";
        } else if ($data['student_profile']['Mother_Status'] == "ถึงแก่กรรม" ) {

        }




            // $data_array['image'] = 'http://reg.buu.ac.th/registrar/getstudentimage.asp?id='.$student_id;
            $data_array['image'] = 'http://10.5.1.174/registrar/getstudentimage.asp?id='.$student_id; // .174 == reg.buu
            // print_r($data_array);
            // die();

            $result = $this->service_docx->print_data($data_array, $template_file, $save_filename);
            // print_r($result);
            //redirect(base_url($result['full_url']), 'refresh');
            
            //insert to form word
            $term_id = $this->Login_session->check_login()->term_id;
            $coop_document_id = $this->Form->get_form_by_name('IN-S002', $term_id)[0]['document_id'];
            $word_file = '/uploads/'.basename($save_filename);
            $this->Form->submit_document($student_id, $coop_document_id, NULL, $word_file);

            //insert to db
            if($this->Job->student_register_job($student_id, $company_job_position_id)) {
                $this->Student->update_student($student_id, array(
                    'coop_status_id' => 2
                ));
                $this->session->set_flashdata('session_alert', '<div class="alert alert-success">ทำการสมัครงานสหกิจเรียบร้อย โปรดรอขั้นตอนต่อไป</div>');
            } else {
                $this->session->set_flashdata('session_alert', '<div class="alert alert-warning">มีปัญหาระหว่างทาง โปรดตรวจสอบกับเจ้าหน้าที่</div>');
            }



            // print_r($result);
            // redirect(base_url($result['full_url']), 'refresh');
            echo "
                <img src='".base_url('assets/img/loading.gif')."' />
                <script>
                    window.location = '".base_url($result['full_url'])."';
                    setTimeout(function(){
                        window.location = '".site_url()."';
                    }, 3000);
                </script>
            ";


        }
    }    
   


}
