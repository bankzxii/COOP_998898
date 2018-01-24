<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Train_location extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		//check priv
        if($this->Login_session->check_login()->login_type != 'officer') {
            redirect($this->Login_session->check_login()->login_type);
            die();
        }
    }

    public function index($status = '')
    {
        if($status == 'success_delete' ){
            $data['status']['color'] = 'success';
            $data['status']['text'] = 'ทำการลบเรียบร้อย';
        } else if($status == 'error_delete' ){
            $data['status']['color'] = 'danger';
            $data['status']['text'] = 'ผิดพลาด โปรดตรวจสอบ';
        } 
        else {
            $data['status'] = '';
        }

        $data['train_locations'] = $this->DB_train_location->gets();
        $this->template->view('Officer/Train_location_view',$data);
    }

    public function add($status = '')
    {
        $this->template->view('Officer/Train_location_form_view');
    }

    public function edit($room_id)
    {
        $data['row'] = $this->DB_train_location->get($room_id);
        $this->template->view('Officer/Train_location_form_view',$data);
    }    

    public function ajax_post()
    {
        $return['status'] = false;
        $return['print'] = false;
                
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('building', 'ตึก', 'trim|required');
        $this->form_validation->set_rules('room', 'ห้อง', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim|numeric');
        
        if ($this->form_validation->run() != FALSE) {
            $data['building'] =  $this->input->post('building');
            $data['room'] = $this->input->post('room');
            $room_id = $this->input->post('id');
            
            //save
            if(@$this->DB_train_location->get($room_id)) {
                //update                
                $this->DB_train_location->update($room_id, $data);
            } else {
                //insert
                $this->DB_train_location->add($data);                
            }

            $return['status'] = true;
        } else {
           $return['status'] = false;
           $return['message'] = strip_tags(validation_errors());
        }

        echo json_encode($return);

    }

    public function delete()
    {
        //check if exist
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        if ($this->form_validation->run() != FALSE) {
            $room_id = $this->input->post('id');            
            if($this->DB_train_location->get($room_id)) {
                //delete
                $this->DB_train_location->delete($room_id);
                return $this->index('success_delete');
                die();
            } else {
                return $this->index('error_delete');
                die();
            }
        } else {
            return $this->index('error_delete');
            die();
        }
        
    }

}