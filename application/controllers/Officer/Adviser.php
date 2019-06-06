<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adviser extends CI_controller{
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
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/'  );
            die();
        }

        // $this->breadcrumbs->unshift('ระบบสหกิจ', '/'); //home
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }
    public function index()
    {
        $data = array();
        $data['adviser'] = @$this->Adviser->gets_adviser();

        // addBreadcrumb
        $this->breadcrumbs->push('จัดอาจารย์ที่ปรึกษากับนิสิต', '/Officer/Adviser/index');
        $this->template->view('Officer/Adviser_view',$data);
    }
    
    public function ajax_list()
    {
        $return = array();
        //cache
        foreach(@$this->Adviser->gets_adviser() as $adviser) {
            $cache['adviser'][$adviser['adviser_id']] = $adviser;
        }
        // foreach(@$this->Address->gets_address() as $address) {
        //     $cache['address'][$address['company_id']] = $address;
        // }
        // foreach(@$this->Student->gets_student() as $student) {
        //     $cache['student'][$student['student_id']] = $student;
        // }

        $company_id = $this->input->get('company_id');
        if($company_id) {
            $rows = $this->Coop_Student->gets_coop_student_by_company($company_id);
            // $company = $this->Company->get_company($company_id)[0];
            // $cache['company'][$company['company_id']] = $company;
        } else {
            $rows = $this->Coop_Student->gets_coop_student();
            // foreach(@$this->Company->gets_company() as $company) {
            //     $cache['company'][$company['company_id']] = $company;
            // }
        }
        foreach($rows as $row)
        {
            $tmp_array = array();
            $tmp_array['student']['student_id'] = $row['student_id'];
            $tmp_array['student']['student_fullname'] = $row['student_fullname'];
            
            
            // $tmp_array['student'] = $cache['student'][$row['student_id']];
            $tmp_array['student']['id_link'] = '<a href="'.site_url('Officer/Students/student_detail/'.$tmp_array['student']['student_id']).'">'.$tmp_array['student']['student_id'].'</a>';            
            
            $tmp_array['adviser']['adviser_fullname'] = '-';
            if(@$cache['adviser'][$row['adviser_id']]) {
                $tmp_array['adviser'] = @$cache['adviser'][$row['adviser_id']];                
            }

            $adviser_Render = '<select name="update_student_into_adviser" onchange="update_student_into_adviser('.$row['student_id'].', this.value)">';
            $adviser_Render .= '<option> ---- </option>';
            
            foreach($cache['adviser'] as $key => $adviser) {
                if($key == $row['adviser_id']) {
                    $adviser_Render .= '<option value="'.$key.'" selected>'.$adviser['adviser_fullname'].'</option>';
                } else {
                    $adviser_Render .= '<option value="'.$key.'">'.$adviser['adviser_fullname'].'</option>';
                }
            }
            $adviser_Render .= '</select>';
            $tmp_array['adviser']['select_box'] = $adviser_Render;
            
            
            if(!$row['company_id']) {
                $tmp_array['company']['company_name_th'] = '-';
                $tmp_array['company_address']['company_address_area'] = '-';
                $tmp_array['company_address']['company_address_province'] = '-';
            } else {
                $tmp_array['company']['company_name_th'] = $row['company_name_th'];
                $tmp_array['company_address']['company_address_area'] = $row['company_address_area'];
                $tmp_array['company_address']['company_address_province'] = $row['company_address_province'];
            }

            array_push($return, $tmp_array);
        }
        echo json_encode($return);        
    }



    public function ajax_change_status()
    {
        $data = array();
        $data['status'] = false;
        $data['msg'] = 'ผิดพลาด';
        $data['msg_icon'] = 'warning';
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('adviser','adviser','required');
        if($this->form_validation->run() != false){


            $adviser = $this->input->post('adviser');
            foreach($this->input->post('students') as $student_id) {
                if($this->Coop_Student->get_coop_student($student_id)) {
                    //update status
                    $this->Coop_Student->update_coop_student($student_id, array( 'adviser_id' => $adviser ));
                }
            }
            $data['status'] = true;
            $data['msg'] = 'เปลี่ยนสถานะสำเร็จ';
            $data['msg_icon'] = 'success';
            
            
        } else {
            $data['msg'] = validation_errors();            
        }

        echo json_encode($data);
    }


    public function map_view()
    {
        $this->breadcrumbs->push('แผนที่', '/Officer/Adviser/map_view');
        $data = [];
        $data['company'] = [];

      	$data['getData'] = $this->Company->gets_company_has_coop_student();
        $data['hasLocation'] = $this->Company->get_company_has_address();
        $data['nullLocation'] = $this->Company->get_company_is_null();

        

      	$data['company_checked_id'] = [];
        $checked_1 = $this->input->post('chkbox');
        if($this->input->post('chkbox') != NULL){
            $data['company_checked_id'] = $checked_1;
        }
        $data['company_checked_id2'] = $this->input->post('chkbox1');



        if ($data['company_checked_id2'] == "") {
            $data['company_checked_id2'] = [];
        }
        
        
        if($data['company_checked_id'] != ""){
        	foreach ($data['company_checked_id'] as $company_id) {
	            foreach($this->Company->gets_company_has_coop_student2($company_id) as $company) {
	                $tmp['company_name_th'] = $company['company_name_th'];
	                $tmp['map'] = @$this->Address->get_address_by_company($company['company_id'])[0];
                    $latitude = (String)$tmp['map']['company_address_latitude'];
                    $longitude = (String)$tmp['map']['company_address_longitude'];

	                //check adviser in student
	                $tmp['pin_color'] = 'FE7569';   
	                $check_student = $this->Coop_Student->gets_coop_student_no_adviser_by_company($company['company_id']);
	                if(count($check_student) < 1) {
	                    // get count all student
	                    $count = count($this->Coop_Student->gets_coop_student_by_company($company['company_id']));

	                    $tmp['pin_color'] = 'FB89D1';   
	                    // $tmp['message'] = 'นิสิตสหกิจมีอาจารย์ที่ปรึกษาครบทุกคน';
	                    $tmp['message'] = 'นิสิตสหกิจจำนวน '.$count.' คน มีอาจารย์ที่ปรึกษาครบทุกคน<br><a href=http://maps.google.com/?q='.$latitude.','.$longitude.'>Google Map</a>';

	                } else {
	                    $tmp['message'] = 'มีนิสิตจำนวน '.count($check_student).' คน ไม่มีอาจารย์ที่ปรึกษา<br><br><a href=\''.site_url('Officer/Adviser/?company_id='.$company['company_id']).'\' target=\'_blank\'>จัดอาจารย์ที่ปรึกษาให้นิสิต</a>';
	                }
	                
	                if(@$tmp['map']) {
	                    $data['company'][] = $tmp;
	                }
	            }
	        }
        }

        if($data['company_checked_id2'] != ""){
            foreach ($data['company_checked_id2'] as $company_id) {
                foreach($this->Company->gets_company_has_coop_student2($company_id) as $company) {
                    $tmp['company_name_th'] = $company['company_name_th'];
                    $tmp['map'] = @$this->Address->get_address_by_company($company['company_id'])[0];
                    $latitude = (String)$tmp['map']['company_address_latitude'];
                    $longitude = (String)$tmp['map']['company_address_longitude'];
                     //check adviser in student
                    $tmp['pin_color'] = 'FE7569';   
                    $check_student = $this->Coop_Student->gets_coop_student_no_adviser_by_company($company['company_id']);
                    if(count($check_student) < 1) {
                        // get count all student
                        $count = count($this->Coop_Student->gets_coop_student_by_company($company['company_id']));

                        $tmp['pin_color'] = '1aff1a';   
                        // $tmp['message'] = 'นิสิตสหกิจมีอาจารย์ที่ปรึกษาครบทุกคน';

                        $tmp['message'] = 'นิสิตสหกิจจำนวน '.$count.' คน มีอาจารย์ที่ปรึกษาครบทุกคน<br><a href=http://maps.google.com/?q='.$latitude.','.$longitude.'>Google Map</a>';

                    } else {
                        $tmp['message'] = 'มีนิสิตจำนวน '.count($check_student).' คน ไม่มีอาจารย์ที่ปรึกษา<br><br><a href=\''.site_url('Officer/Adviser/?company_id='.$company['company_id']).'\' target=\'_blank\'>จัดอาจารย์ที่ปรึกษาให้นิสิต</a>';
                    }
                    
                    if(@$tmp['map']) {
                        $data['company'][] = $tmp;
                    }
                }
            }
        }
        

        $this->template->view('Officer/Coop_student_map_view',$data);
    }

}



