<?php
class Test_query extends CI_Controller {
 
 	public function index() {
	   	$this->load->model('Test_query_model');
	 	$data['posts'] = $this->Test_query_model->getData();
	 	$this->load->view('Officer/Test_query_view', $data);
	 	// print_r($data['posts']);	
	}
 

  	public function Checked()
 	{
   		$company_id = $this->input->post('company_id');
   		return $company_id;
   		//now use the $id variable for the desired purpose.
 	}
 // public function update_data()
 // {

 // 	$checked = $this->input->post('checked');
 // 	$this->load->model('Test_query_model');
 // 	$data['location'] = $this->Test_query_model->getLocation($checked);
 // 	$this->load->view('Officer/Test_query_view', $data);
 // }
 // public function getdata()
 // {
 // 	$this->load->model('Test_query_model');
 // 	$this->data['posts'] = $this->Test_query_model->getdata();
 // 	$this->load->view('Officer/Test_query_view', $this->data['posts']);
 // }
 
}
?>