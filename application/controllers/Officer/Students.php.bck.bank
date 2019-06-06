<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
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

        // $this->breadcrumbs->unshift('ระบบสหกิจ', '/'); //home
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }

    public function index(){

        $data['data'] = array();
        
        $data['coop_status_type'] = $this->Student->gets_coop_status_type();
        $data['company_status_type'] = $this->Company->gets_company_status_type();

        // add breadcrumbs
        $this->breadcrumbs->push('รายชื่อนิสิต', '/Officer/Students/index');

        $this->template->view('Officer/Students_view',$data);
    }

    public function ajax_list()
    {
        $return['data'] = array();

        //cache here
        foreach($this->Student->gets_coop_status_type() as $rrr) {
            $cache['coop_student_type'][$rrr['coop_status_id']] = $rrr;
        }
        // foreach($this->Student->gets_department() as $rrr) {
        //     $cache['department'][$rrr['department_id']] = $rrr;
        // }
        // foreach($this->Company->gets_company_status_type() as $rrr) {
        //     $cache['company_status_type'][$rrr['company_status_id']] = $rrr;
        // }

        foreach($this->Student->gets_student() as $row)
        {
            $tmp_array = array();
            // $tmp_array['action_box'] = '<a href="'.site_url('Officer/Students/student_detail/'.$row['student_id']).'" class="btn btn-info"><i class="fa fa-list-alt"></i></a>';
            $tmp_array['action_box'] = '<a href="'.site_url('Officer/Students/student_detail/'.$row['student_id']).'">'.$row['student_id'].'</a>';
            
            $tmp_array['checkbox'] = '';
            
            $tmp_array['student'] = $row;
            // $tmp_array['student']['company_status'] = @$cache['company_status_type'][$row['company_status_id']]['company_status_name'];
            $tmp_array['student']['company_status'] = '<p class="text-right"><a title="'.$row['company_status_name'].'">'.$row['company_status_id'].' **</a></p>';
            $tmp_array['student']['student_gpax'] = '<p class="text-right">'.$tmp_array['student']['student_gpax'].'</p>';
            
            
            if(!$row['coop_status_id']) {
                $row['coop_status_id'] = 1;
            }
            $tmp_array['coop_student_type']['coop_status_name'] = $row['coop_status_name'];
            $coop_type_Render = '<select name="change_coop_type" onchange="change_coop_type('.$row['student_id'].', this.value)">';
            foreach($cache['coop_student_type'] as $key => $coop_type) {
                if($key == $row['coop_status_id']) {
                    $coop_type_Render .= '<option value="'.$key.'" selected>'.$coop_type['coop_status_name'].'</option>';
                } else {
                    $coop_type_Render .= '<option value="'.$key.'">'.$coop_type['coop_status_name'].'</option>';
                }
            }
            $coop_type_Render .= '</select>';
            $tmp_array['coop_student_type']['status_name'] = str_replace(" ", "", $tmp_array['coop_student_type']['coop_status_name']);
            $tmp_array['coop_student_type']['select_box'] = $coop_type_Render;
            
            $tmp_array['department']['department_name'] = $row['department_name'];

            
            $tmp_array['training_hour'] = array();
            $train_type = $this->Training->get_student_stat_of_training($row['student_id']);
            $training_status = false;
    
            foreach($train_type['train_type'] as $type) {
                $tmp['name'] = $type['train_type_name'];
                $tmp['total_hour'] = $type['train_type_total_hour'];
                $tmp['check_hour'] = 0;
                //calc total hour
                foreach($type['history'] as $history) {
                    $tmp['check_hour'] += $history['check_hour'];
                }


                if($tmp['check_hour'] >= $tmp['total_hour']) {
                    $training_status = true;
                }

                $tmp['check_hour'] = '<p class="text-right">'.$tmp['check_hour'].'</p>';
                
    
                array_push($tmp_array['training_hour'], $tmp);
            }
            
            $tmp_array['student']['student_training_hour'] = '<span style="color: red">ไม่ผ่าน</span>';
            if($training_status) {
                $tmp_array['student']['student_training_hour'] = '<span style="color: green">ผ่าน</span>';                
            }
            // $tmp_array['coop_student_type'] = $this->Student->get_by_coop_status_type($row['coop_status'])[0];
            // $tmp_array['department'] = $this->Student->get_department($row['department_id'])[0];
            array_push($return['data'], $tmp_array);
        }

        echo json_encode($return['data']);        
    }

    public function ajax_change_status()
    {
        $data = array();
        $data['status'] = false;
        $data['msg'] = 'ผิดพลาด';
        $data['msg_icon'] = 'warning';
        $status_true = false;
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status','status','required|numeric');
        if($this->form_validation->run() != false){

            $term_id = $this->Term->get_current_term()[0]['term_id'];

            $status_type = (int) $this->input->post('status');
            $coop_status_type = $this->Student->get_by_coop_status_type($status_type)[0];

            foreach($this->input->post('students') as $student_id) {
                if($this->Student->get_student($student_id)) {
                    //update status
                    //check has coop student
                    $coop_student = $this->Coop_Student->get_coop_student($student_id);
                    if(count($coop_student) > 0) {
                        $this->Coop_Student->delete_coop_student($student_id);
                    }

                    if($coop_status_type['coop_status_change_coop_student'] == "1") {
                        //get company job position tbl
                        $job = $this->Student->get_latest_register_job($student_id);
                        // print_r($job);
                        if(count($job) < 1) {
                            continue;
                        }


                        //update job register
                        $this->Job->update_student($student_id, array( 'company_status_id' => 5 ));
                        $this->Student->update_student($student_id, array( 'company_status_id' => 5 ));
                        
                        
                        $job = $job[0];
                        $student = $this->Student->get_student($student_id)[0];
                        
                        $array = [
                            'student_id' => $student_id,
                            'department_id' => $student['department_id'],
                            'term_id' => $term_id,

                            'company_id' => $job['company_id'],
                            'job_id' => $job['job_id'],
                            'coop_student_active' => 1,

                            'trainer_id' => 0,
                            'adviser_id' => '',
                        ];
                        $status_true = $this->Coop_Student->insert_coop_student($array);
                        $status_true = $this->Student->update_student($student_id, array( 'coop_status_id' => $status_type ));                        

                    } else {
                        $status_true = $this->Student->update_student($student_id, array( 'coop_status_id' => $status_type ));                        
                    }
                }
            }
            
            if($status_true) {
                $data['status'] = true;
                $data['msg'] = 'เปลี่ยนสถานะสำเร็จ';
                $data['msg_icon'] = 'success';
            }
            
            
        }

        echo json_encode($data);
    }



    public function student_detail($student_id)
    {
        $data['student'] = @$this->Student->get_student($student_id)[0];
        // $data['department'] = @$this->Student->get_department($data['student']['department_id'])[0];
        // $data['coop_status_type'] = @$this->Student->get_by_coop_status_type($data['student']['coop_status_id'])[0];
        $data['coop_status_type']['coop_status_name'] = $data['student']['coop_status_name'];
        $data['department']['department_name'] = $data['student']['department_name'];
        // $data['coop_test_status'] = @$this->Test->get_test_result_by_student($data['student']['student_id'])[0];
        if($data['student']['company_status_id'] == 5)
        {
            $data['coop_student'] = @$this->Coop_Student->get_coop_student($student_id)[0];
            
            $data['company'] = @$this->Company->get_company($data['coop_student']['company_id'])[0];
            $data['trainer'] = @$this->Trainer->get_trainer($data['coop_student']['trainer_id'])[0];
            $data['adviser'] = @$this->Adviser->get_adviser($data['coop_student']['adviser_id'])[0];
            $data['job'] = $this->Job->get_job($data['coop_student']['job_id'])[0];
        }
        $data['train_type'] = array();
        $train_type = $this->Training->get_student_stat_of_training($student_id);

        foreach($train_type['train_type'] as $type) {
            $tmp['name'] = $type['train_type_name'];
            $tmp['total_hour'] = $type['train_type_total_hour'];
            $tmp['check_hour'] = 0;
            //calc total hour
            foreach($type['history'] as $history) {
                $tmp['check_hour'] += $history['check_hour'];
            }

            array_push($data['train_type'], $tmp);
        }

        $data['student_profile'] = $this->Student->get_student_data_from_profile($student_id);
        // print_r($data);
        // die();

        // add breadcrumbs
        $this->breadcrumbs->push('รายละเอียดนิสิต', '/Officer/Students/student_detail');

        $this->template->view('Officer/Student_detail_view', $data);
       
    }

    public function training_history_student($student_id)
    {

        $data['train_type'] = array();
        $train_type = $this->Training->get_student_stat_of_training($student_id);
        foreach($train_type['train_type'] as $type) {
            $tmp['name'] = $type['train_type_name'];
            $tmp['total_hour'] = $type['train_type_total_hour'];
            $tmp['check_hour'] = 0;
            //calc total hour
            foreach($type['history'] as $history) {
                $tmp['check_hour'] += $history['check_hour'];
            }
            $tmp['history'] = $type['history'];

            array_push($data['train_type'], $tmp);
        }
        $this->template->view('Officer/Training_history_student_view', $data);
    }

    public function update_pass_core_subject()
    {
        $return['status'] = false;
        $student_id = $this->input->post('student_id');
        $student_core_subject_status = $this->input->post('student_core_subject_status');
        
        if( $this->update_student_core_subject($student_id, $student_core_subject_status) ) {
            $return['status'] = true;
        }
        echo json_encode($return);
    }

    public function check_core_subject_condition()
    {
        $return['status'] = false;
        $student_id = $this->input->post('student_id');
        
        // get core subject
        // $core_subject = ['999041'];
        $core_subject = [];
        foreach($this->Student->gets_student_core_subject() as $core_subj) {
            $core_subject[] = $core_subj['subject_id'];
        }

        // get data from api
        $data = $this->Student->get_student_register_subject_from_profile($student_id, $core_subject);
        // check condition
        if( count($data['result']) == count($core_subject) ) {
            if( $this->update_student_core_subject($student_id, 1) ) {
                $return['status'] = true;
            }
        } else {
            if( $this->update_student_core_subject($student_id, 0) ) {
                $return['status'] = false;
            }
        }

        echo json_encode($return);            

    }

    private function update_student_core_subject($student_id, $student_core_subject_status) 
    {
        return $this->Student->update_student($student_id, [ 'student_core_subject_status' => $student_core_subject_status ]);
    }

  }
