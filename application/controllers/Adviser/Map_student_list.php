<?php
class Map_student_list extends CI_controller
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
            redirect($this->Login_session->check_login()->login_type);
            die();
        }

        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.$user->login_type); //actor
    }

    public function index()
    {
        $adviser_id = $this->Login_session->check_login()->login_value;
        $data['data'] = array();
        foreach ($this->Coop_Student->gets_coop_student_by_adviser($adviser_id) as $row){
            $tmp_array = array();
            $tmp_array['student'] = $this->Student->get_student($row['student_id'])[0];
            $tmp_array['department'] = $this->Student->get_department($tmp_array['student']['department_id'])[0];
            $tmp_array['company'] = @$this->Company->get_company($row['company_id'])[0];
            $tmp_array['company_address'] = $this->Address->get_address_by_company($row['company_id'])[0];
            array_push($data['data'], $tmp_array);
        }


        // add breadcrumbs
        $this->breadcrumbs->push('รายการสถานที่ฝึกงาน', '/Adviser/Map_student_list/index');


        $this->template->view('Adviser/Map_list_view',$data);
    }

    public function map($student_id)
    {
        // print_r($student_id);
        $data['map'] = $this->Coop_Student->get_coop_student($student_id)[0];
        $data['student'] = $this->Student->get_student($student_id)[0];
        $data['company'] = $this->Company->get_company($data['map']['company_id'])[0];
        $data['department'] = $this->Student->get_department($data['student']['department_id'])[0];
        // print_r($data);
        // add breadcrumbs
        $this->breadcrumbs->push('รายการสถานที่ฝึกงาน', '/Adviser/Map_student_list/index');
        $this->breadcrumbs->push('แสดงพิกัดงาน', '/');

        $this->template->view('Adviser/Map_student_view',$data);

    }

}