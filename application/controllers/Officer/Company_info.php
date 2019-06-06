<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company_info extends CI_controller
{
       public function __construct()
        {
            parent::__construct();
            //check session
            if(!$this->Login_session->check_login()) {
                $this->session->sess_destroy();
                redirect('member/login');
            }

            $user = $this->Login_session->check_login();
            if($user->login_type != 'officer') {
                redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
                die();
            }
            // $this->breadcrumbs->unshift('ระบบสหกิจ', '/'); //home
            $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
            $this->breadcrumbs->push('จัดการข้อมูลสถานประกอบการ', '/Officer/Company/index');            
        }

        public function step1($company_id) 
        {
            $data['company'] = $this->Company->get_company($company_id)[0];
            $data['company_address'] = @$this->Address->get_address_by_company($data['company']['company_id'])[0];
            $data['form_url'] = site_url('Officer/Company_info/post_step1');

            // add breadcrumbs
            $this->breadcrumbs->push('รายละเอียดเกี่ยวกับสถานประกอบการ/หน่วยงาน', '/Officer/company_info/step1/'.$company_id);
            
            $arr_css = [
                base_url('assets/css/company_info_step.css')
            ];
            $this->template->view('Officer/info/step1_view', $data, [], $arr_css);
        }

        public function post_step1()
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('company_id','Company ID','trim');
            $this->form_validation->set_rules('company_name_th','(ภาษาไทย)','trim|thai_character');//required ต้องการไทย
            $this->form_validation->set_rules('company_name_en','(ภาษาอังกฤษ)','trim|alpha_numeric_spaces');
            $this->form_validation->set_rules('company_address_number','ที่อยู่เลขที่','trim');//required ต้องการตัวเลขและเคนื่องหมาย'/'
            $this->form_validation->set_rules('company_address_building','อาคาร','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_road','ถนน','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_alley','ซอย','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_district','แขวง','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_area','เขต/อำเภอ','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_province','จังหวัด','trim');//required ต้องการไทย
            $this->form_validation->set_rules('company_address_postal_code','รหัสไปรษณีย์','trim|min_length[5]|max_length[5]');
            $this->form_validation->set_rules('company_type','ประเภทกิจการ/ธุรกิจ/ผลิตภัณฑ์/ลักษณะการดำเนินงาน');
            $this->form_validation->set_rules('company_total_employee','จำนวนพนักงาน','is_natural_no_zero');
            if($this->form_validation->run() == false)
            {
                
                $this->step1($this->input->post('company_id'));
                
            }
            else
            {
                // update company
                $tmp['company_id'] = $this->input->post('company_id');
                $data['company'] = $this->Company->get_company($tmp['company_id'])[0];

                $company_id = $data['company']['company_id'];
                $array_company['company_name_th'] = $this->input->post('company_name_th');
                $array_company['company_name_en'] = $this->input->post('company_name_en');
                $array_company['company_type'] = $this->input->post('company_type');
                $array_company['company_total_employee'] = $this->input->post('company_total_employee');
                $array_company['company_status'] = 'deactive';
                // update company address
                $array_company_address['company_address_number'] = $this->input->post('company_address_number');
                $array_company_address['company_address_building'] = $this->input->post('company_address_building');
                $array_company_address['company_address_road'] = $this->input->post('company_address_road');
                $array_company_address['company_address_alley'] = $this->input->post('company_address_alley');
                $array_company_address['company_address_district'] = $this->input->post('company_address_district');
                $array_company_address['company_address_area'] = $this->input->post('company_address_area');
                $array_company_address['company_address_province'] = $this->input->post('company_address_province');
                $array_company_address['company_address_postal_code'] = $this->input->post('company_address_postal_code');
                // update on table
                $this->Company->update_company($company_id , $array_company);
                $this->Address->update_address($company_id , $array_company_address);
                
                redirect('Officer/Company_info/step2/'.$company_id, 'refresh');
            }
        }

        //==================================================================//

        public function step2($company_id) 
        {
            $data['company'] = $this->Company->get_company($company_id)[0];

            $data['company_person'] = @$this->Trainer->get_trainer($data['company']['headoffice_person_id'])[0];
            $data['company_employee'] = @$this->Trainer->gets_trainer_by_company($data['company']['company_id']);

            $data['form_url'] = site_url('Officer/Company_info/post_step2');
            $data['back_url'] = site_url('Officer/Company_info/step1/'.$company_id);
            $data['save_trainer_url'] = site_url('Officer/Trainer/ajax_save_trainer');

            $data['contact_select_box'] = 0;
            if($data['company']['headoffice_person_id'] != $data['company']['contact_person_id']) {
                $data['contact_select_box'] = 1;
            }
            
            // add breadcrumbs
            $this->breadcrumbs->push('ชื่อผู้จัดการสถานประกอบการ/หัวหน้าหน่วยงาน', '/Officer/company_info/step2/'.$company_id);

            $arr_css = [
                base_url('assets/css/company_info_step.css')
            ];
            $this->template->view('Officer/info/step2_view', $data, [], $arr_css);
        }

        public function post_step2()
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('radios','radios','trim|numeric');
            $this->form_validation->set_rules('company_id','Company ID','trim|required');
            $this->form_validation->set_rules('contact_person_id','พนักงาน','trim|numeric');
            $this->form_validation->set_rules('headoffice_person_id','ผู้จัดการ','trim|numeric');
            
            if($this->form_validation->run() == false) 
            {
                $this->step2($this->input->post('company_id'));
            }
            else
            {
                if($this->input->post('radios') == "0") {
                    // headoffice == contact
                    $array_company['contact_person_id'] = $this->input->post('headoffice_person_id');
                    $array_company['headoffice_person_id'] = $this->input->post('headoffice_person_id');
                } else {
                    // headoffice != contact
                    $array_company['contact_person_id'] = $this->input->post('contact_person_id');
                    $array_company['headoffice_person_id'] = $this->input->post('headoffice_person_id');

                }
                $tmp['company_id'] = $this->input->post('company_id');
                $data['company'] = $this->Company->get_company($tmp['company_id'])[0];
                // update company_contact_person_id 
                $company_id = $data['company']['company_id'];
                
                
                // update on table
                $this->Company->update_company($company_id, $array_company);

                redirect('Officer/Company_info/step3/'.$company_id, 'refresh');
            }
        }

        //==================================================================//

        public function step3($company_id)
        {
            
            
            $tmp['company_id'] = $company_id;
            $data['company'] = $this->Company->get_company($company_id)[0];

            $data['form_url'] = site_url('Officer/Company_info/post_step3');
            $data['back_url'] = site_url('Officer/Company_info/step2/'.$company_id);

            $data['work_form_url'] = site_url('Officer/Company_info/');
            $data['company_has_department'] = [];
            foreach($this->Company->get_company_has_department($company_id) as $department) {
                $data['company_has_department'][] = $department['department_id'];
            }
            $data['company']['company_start_month_work'] = explode(",", $data['company']['company_start_month_work']);
            $data['company']['company_end_month_work'] = explode(",", $data['company']['company_end_month_work']);
            
            $data['company_work_month'] = [];
            foreach($data['company']['company_start_month_work'] as $i => $start_month_work) {
                $data['company_work_month'][] = $start_month_work."|".$data['company']['company_end_month_work'][$i];
            }

            $data['company_benefit'] = @$this->Company->get_benefit($company_id)[0];

            $data['departments'] = $this->Student->gets_department();

            $this->breadcrumbs->push('ข้อตกลง, สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน', '/Officer/company_info/step2/'.$company_id);
            
            $arr_css = [
                base_url('assets/css/company_info_step.css')
            ];

            $this->template->view('Officer/info/step3_view', $data, [], $arr_css);
        }

        public function post_step3()
        {
            $this->form_validation->set_rules('company_has_department[]', 'สาขาวิชา', 'trim|numeric');
            $this->form_validation->set_rules('company_work_month[]', 'ระยะเวลา', 'trim');

            
            $this->form_validation->set_rules('company_id', 'IDสถานประกอบการ', 'trim|numeric');
            $this->form_validation->set_rules('company_start_time', 'เวลาเริ่มงาน', 'trim');
            $this->form_validation->set_rules('company_end_time', 'เวลาเลิกงาน', 'trim');
            $this->form_validation->set_rules('company_work_day', 'จำนวนวันทำงาน', 'trim|numeric');
            $this->form_validation->set_rules('company_agreement', 'ข้อกำหนดอื่น ๆ', 'trim');

            $this->form_validation->set_rules('benefit_wage', 'ค่าตอบแทน', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('benefit_dorm', 'ที่พัก', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('benefit_shuttlebus', 'รถรับส่ง', 'trim|in_list[0,1]');
            $this->form_validation->set_rules('benefit_wage_period', 'จำนวนค่าตอบแทน', 'trim');
            $this->form_validation->set_rules('benefit_dorm_period', 'ค่าใช้จ่ายที่พัก', 'trim');
            $this->form_validation->set_rules('benefit_shuttlebus_period', 'ค่าใช้จ่ายรถรับส่ง', 'trim');
            $this->form_validation->set_rules('benefit_other', 'สวัสดิการอื่น ๆ ', 'trim');
            $benefit_wage_value = $this->input->post('benefit_wage');
            $benefit_dorm_value = $this->input->post('benefit_dorm');
            $benefit_shuttlebus_value = $this->input->post('benefit_shuttlebus');
            if($benefit_wage_value == 1) {
                $this->form_validation->set_rules('benefit_wage_period', 'จำนวนค่าตอบแทน', 'trim');
            }

            if($benefit_dorm_value == 1) {
                $this->form_validation->set_rules('benefit_dorm_period', 'ค่าใช้จ่ายที่พัก', 'trim');
            }

            if($benefit_shuttlebus_value == 1) {
                $this->form_validation->set_rules('benefit_shuttlebus_period', 'ค่าใช้จ่ายรถรับส่ง', 'trim');
            }
            $company_id = $this->input->post('company_id');
            if ($this->form_validation->run() == FALSE){
                $this->step3($company_id);
                echo "<script>alert('กรุณากรอกช้อมูลให้ครบถ้วนในส่วน สวัสดิการที่เสนอให้นิสิตในระหว่างปฏิบัติงาน')</script>";

            } else {
                // foreach($this->input->post('company_has_department[]') as $department) {
                //     $this->Company->update_company_has_department($company_id, $department);
                // }
                
                $company_start_month_work = [];
                $company_end_month_work = [];
                
                // foreach($this->input->post('company_work_month[]') as $work_month) {
                //     $work_month = explode("|", $work_month);
                //     $company_start_month_work[] = $work_month[0];
                //     $company_end_month_work[] = $work_month[1];
                    
                // }


                $update_company = [
                    'company_start_time' => $this->input->post('company_start_time'),
                    'company_end_time' => $this->input->post('company_end_time'),
                    'company_work_day' => $this->input->post('company_work_day'),
                    'company_agreement' => $this->input->post('company_agreement'),
                    'company_start_month_work' => implode(",", $company_start_month_work),
                    'company_end_month_work' => implode(",", $company_end_month_work),
                ];
                $this->Company->update_company($company_id, $update_company);


                $update_benefit = [
                    'benefit_wage' => $this->input->post('benefit_wage'),
                    'benefit_dorm' => $this->input->post('benefit_dorm'),
                    'benefit_shuttlebus' => $this->input->post('benefit_shuttlebus'),
                    'benefit_wage_period' => $this->input->post('benefit_wage_period'),
                    'benefit_dorm_period' => $this->input->post('benefit_dorm_period'),
                    'benefit_shuttlebus_period' => $this->input->post('benefit_shuttlebus_period'),
                    'benefit_other' => $this->input->post('benefit_other'),
                ];
                $this->Company->update_benefit($company_id, $update_benefit);

                redirect('Officer/Company_info/step4/'.$company_id, 'refresh');                
                
            }
            // echo "<script>alert('ok')</script>";
            // redirect('officer/company/', 'refresh');
            
        }

        //==================================================================//

        public function step4($company_id)
        {
            
            
            $tmp['company_id'] = $company_id;
            $data['company'] = $this->Company->get_company($tmp['company_id'])[0];

            $data['company_job'] = $this->Job->gets_job_by_company($tmp['company_id']);
            $data['job_title'] = $this->Job->gets_job_title();
            $data['form_url'] = site_url('Officer/Company_info/post_step4');
            $data['back_url'] = site_url('Officer/Company_info/step3/'.$company_id);

            $data['skills'] = array();
            foreach ($this->Skill->gets_skill_category() as $row) {
                $tmp_array = array();
                $tmp_array = $row;
                $tmp_array['skills'] = $this->Skill->gets_skill_by_category_id($row['skill_category_id']);
                array_push($data['skills'], $tmp_array);
            }
            $data['company_job_has_skill'] = [];
            foreach($this->Company->get_company_has_department($company_id) as $department) {
                $data['company_job_has_skill'][] = $department['department_id'];
            }
            $data['departments'] = $this->Student->gets_skill_category();
            $data['work_form_url'] = site_url('Officer/Company_info/');

            $this->breadcrumbs->push('ตำแหน่งงาน', '/Officer/company_info/step2/'.$company_id);
            
            $arr_css = [
                base_url('assets/css/company_info_step.css')
            ];
            $this->template->view('Officer/info/step4_view', $data, [], $arr_css);
        }

        public function post_step4()
        {
            echo "<script>alert('ระบบได้ทำการบันทึกข้อมูลบริษัทแล้วค่ะ')</script>";
            redirect('Officer/Company/', 'refresh');
        }
        
        //job section
        public function job_add()
        {
            $this->form_validation->set_rules('job_title_id', 'ตำแหน่ง', 'trim|required|numeric');
            $this->form_validation->set_rules('number_of_employee', 'จำนวน', 'trim|required|numeric');
            $this->form_validation->set_rules('job_description', 'ลักษณะงานที่นิสิตต้องปฏิบัติงาน', 'trim|required');
            $this->form_validation->set_rules('job_skill', 'ทักษะพิเศษ', 'trim|required');

            if ($this->form_validation->run() == FALSE){

                $company = $this->input->post('company_id');
                $this->session->set_flashdata('form-alert', '<div class="alert alert-danger"> เพิ่มไม่สำเร็จกรุณากรอกข้อมูลให้ครบทุกช่อง </div>');
                redirect('/Officer/Company_info/step4/'.$company, 'refresh');

            }
            else{

                $data['company_id'] = $this->input->post('company_id');
                $data['job_title_id'] = $this->input->post('job_title_id');
                $data['job_title'] = $this->Job->get_company_job_title_by_job_title_id($this->input->post('job_title_id'))[0]['job_title'];
                $data['job_number_employee'] = $this->input->post('number_of_employee');
                $data['job_description'] = $this->input->post('job_description');
                $data['job_skill'] = $this->input->post('job_skill');
                $data['term_id'] = $this->Term->get_current_term()[0]['term_id'];
                $data['job_active'] = 1;

                $this->Job->insert_job($data);
                $this->session->set_flashdata('form-alert', '<div class="alert alert-success">เพิ่มงานสำเร็จ</div>');
                redirect('/Officer/Company_info/step4/'.$data['company_id'], 'refresh');
            }
            // return $this->step3($data['company_id']);
        }

        public function job_hide($job_id)
        {
            $job = $this->Job->get_job($job_id);
            if($job) {
                // hide job
                $this->Job->delete_job($job_id);
                $this->session->set_flashdata('form-alert', '<div class="alert alert-primary">ลบงานสำเร็จ</div>');
                redirect('/Officer/Company_info/step4/'.$job[0]['company_id'], 'refresh');                
            } else {
                $this->session->set_flashdata('form-alert', '<div class="alert alert-warning">ผิดพลาด</div>');
                redirect('/Officer/', 'refresh');                
            }
        }
        public function job_form_edit($job_id)
        {
            
            $data['company_job_title'] = $this->Job->gets_company_job_title();
            $data['company_job_position_by_id'] = $this->Job->get_job($job_id)[0];
            $data['skills'] = array();
            foreach ($this->Skill->gets_skill_category() as $row) {
                $tmp_array = array();
                $tmp_array = $row;
                $tmp_array['skills'] = $this->Skill->gets_skill_by_category_id($row['skill_category_id']);
                array_push($data['skills'], $tmp_array);
            }
            
            $data['work_form_url'] = site_url('Officer/Company_info/job_update/'.$data['company_job_position_by_id']['job_id']);
            //print_r($data);
            $this->template->view('Officer/info/job_form_view', $data);
        }

        public function job_update()
        {
            // print_r($array);
            $this->form_validation->set_rules('job_id', 'Job ID', 'required');
            $this->form_validation->set_rules('job_title_id', 'ตำแหน่ง', 'required');
            $this->form_validation->set_rules('job_number_employee', 'จำนวน', 'required');
            $this->form_validation->set_rules('job_description', 'ลักษณะงานที่นิสิตต้องปฏิบัติงาน', 'required');
            $this->form_validation->set_rules('job_skill', 'ทักษะพิเศษ', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                $job_id = $this->input->post('job_id');
                 $this->session->set_flashdata('form-alert', '<div class="alert alert-warning">แก้ไขงานไม่สำเร็จ กรุณาตรวจทานข้อมูลทุกช่อง และ checkbox ทักษะพิเศษด้วยค่ะ</div>');
                // redirect('Officer/Company_info/job_form_edit/'.$job_id, 'refresh');
                $this->job_form_edit($job_id);
            }
            else
            {
                $company_id = $this->input->post('company_id');
                $job_id = $this->input->post('job_id');
                $job = $this->Job->get_job($job_id);

                if($job) {
                    $array['job_title_id'] = $this->input->post('job_title_id');
                    $array['job_title'] = $this->Job->get_company_job_title_by_job_title_id($this->input->post('job_title_id'))[0]['job_title'];
                    $array['job_number_employee'] = $this->input->post('job_number_employee');
                    $array['job_description'] = $this->input->post('job_description');
                    $array['job_skill'] = $this->input->post('job_skill');
                
                    $this->Job->update_job($job_id, $array);
                    $this->session->set_flashdata('form-alert', '<div class="alert alert-success">แก้ไขงานสำเร็จ</div>');
                    redirect('Officer/Company_info/step4/'.$company_id, 'refresh');
                } else {
                    $job_id = $this->input->post('job_id');
                    $this->session->set_flashdata('form-alert', '<div class="alert alert-warning">แก้ไขงานไม่สำเร็จ</div>');
                    redirect('Officer/Company_info/step4/'.$company_id, 'refresh');
                }
            }

        }


}