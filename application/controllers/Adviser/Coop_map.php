<?php
class Coop_map extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        //check session
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
        }

        //check priv
        $user = $this->Login_session->check_login();
        if($user->login_type != 'adviser') {
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
            die();
        }

        
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
    }

    
    public function map_view()
    {
        $this->breadcrumbs->push('แผนที่', '/Adviser/Coop_map/map_view');
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
        

        $this->template->view('Adviser/Coop_student_map_view',$data);
    }


}