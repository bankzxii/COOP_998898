<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_pwd extends CI_Controller { 

	public function index(){
        $this->load->view('Officer/Change_pwd_view');
    }
}  

