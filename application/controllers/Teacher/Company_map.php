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
        if($this->Login_session->check_login()->login_type != 'teacher') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
    }

    public function index()
    {
        $data['company'] = $this->DB_company->gets();
        $this->template->view('teacher/map_list_view', $data);
    }

    public function ajax_post()
    {
        $data = array();
        $data['data'] = array();
        foreach($this->input->post('company_id') as $company_id) {
            //get map
            $tmp_array['company'] = $this->DB_company->get($company_id);            
            $tmp_array['company_address'] = $this->DB_company_address->get($company_id);

            

            array_push($data['data'], $tmp_array);
        }

        echo json_encode($data);
    }


}