<?php
class Company_map extends CI_controller
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
        if($user->login_type != 'company') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
        //add breadcrumbs
        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.$user->login_type); //actor
    }

    public function index()
    {
        $status = $this->input->get('status');
        if( $status == 'success'){
            $data['status']['color'] = 'success';            
            $data['status']['text'] = 'UPDATE สถานที่สำเร็จ';
        }else {
            $data['status'] = '';
        }

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];

        $company_id = $tmp['company_id'];

        $data['map'] = @$this->Address->get_address_by_company($company_id)[0];
        $this->breadcrumbs->push('ปักหมุดแผนที่สถานประกอบการ', '/Company/company_map');
        $this->template->view('company/map_view', $data);
    }

    public function ajax_post()
    {
        $insert['company_address_latitude'] = $this->input->post('company_address_latitude');
        $insert['company_address_longitude'] = $this->input->post('company_address_longitude');

        $tmp = $this->Trainer->get_trainer($this->Login_session->check_login()->login_value)[0];
        $company_id = $tmp['company_id'];

        $arr = array(
            'status' => false,
            'txt' => 'err',            
        );

        if($this->Address->update_address($company_id, $insert)) {
            // echo $this->db->last_query();
            $arr['status'] = true;
            $arr['txt'] = 'ok';            
        }
        
        echo json_encode($arr);
    }


}