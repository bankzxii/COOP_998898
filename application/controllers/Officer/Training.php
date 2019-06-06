<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Training extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if(!$this->Login_session->check_login()) {
            $this->session->sess_destroy();
            redirect('member/login');
		}
		
		$user = $this->Login_session->check_login();
        if($user->login_type != 'officer') {
            redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
            die();
        }

        $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor           
    }

    public function index($status = '')
    {
        if($status == 'success_delete' ){
            $data['status']['color'] = 'success';
            $data['status']['text'] = 'ทำการลบสำเร็จ';
        } else if($status == 'error_delete' ){
            $data['status']['color'] = 'danger';
            $data['status']['text'] = 'ผิดพลาด โปรดตรวจสอบ';
        } else if($status == 'success_insert' ){
            $data['status']['color'] = 'success';
            $data['status']['text'] = 'เพิ่มข้อมูลโครงการการอบรมสำเร็จ';
        } else if($status == 'success_update' ){
            $data['status']['color'] = 'success';
            $data['status']['text'] = 'แก้ไขข้อมูลการอบรมสำเร็จ';
        }  
        else {
            $data['status'] = '';
        }

        $data['data'] = array();
        //get student has test
        foreach($this->Training->gets_training() as $row) {
            //get train_type_id
            $tmp_array = array();
            $tmp_array['train'] = $row;
            $tmp_array['train_type'] = $this->Training->get_type($row['train_type_id'])[0];
            $tmp_array['train_location'] = $this->Training->get_location($row['train_location_id'])[0];
            
            array_push($data['data'], $tmp_array);
        }
        // print_r($data);
        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลการอบรม', '/');

        $this->template->view('Officer/Train_list_view',$data);
    }
   
    public function delete()
    {
        //check if exist
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('train_id', 'id', 'trim|required|numeric');
        
        if ($this->form_validation->run() != FALSE) {
            $id = $this->input->post('train_id');            

            if(@$this->Training->get_training($id)) {
                //delete
                $this->Training->delete_training($id);
                return $this->index('success_delete');
                die();
            } else {
                return $this->index();
                die();
            }
        } else {
            return $this->index('error_delete');
            die();
        }
        
    }

    public function edit($id, $status = '')
    {
        if($status == 'error_location') {
            $data['status']['color'] = 'warning';
            $data['status']['text'] = 'ไม่เจอสถานที่อบรม';
        } else if($status == 'error_type') {
            $data['status']['color'] = 'warning';
            $data['status']['text'] = 'ไม่เจอประเภทการอบรม';
        } else if($status != '' && !is_numeric($status)) {
            $data['status']['color'] = 'danger';
            $data['status']['text'] = $status;
        } else {
            $data['status'] = '';
        }

        //get id

        $data['data'] = $this->Training->get_training($id)[0];
        $data['train_type'] = $this->Training->gets_type();
        $data['train_location'] = $this->Training->gets_location();

        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลการอบรม', '/Officer/Training/index');
        $this->breadcrumbs->push('เเก้ไขข้อมูลโครงการอบรม', '/Officer/Training/edit'.$id);

        $this->template->view('Officer/Edit_Train_list_view', $data);
    }

    public function add($status = '')
    {
        if($status == 'error_location') {
            $data['status']['color'] = 'warning';
            $data['status']['text'] = 'ไม่เจอสถานที่อบรม';
        } else if($status == 'error_type') {
            $data['status']['color'] = 'warning';
            $data['status']['text'] = 'ไม่เจอประเภทการอบรม';
        } else if($status != '' ) {
            $data['status']['color'] = 'danger';
            $data['status']['text'] = $status;
        } else {
            $data['status'] = '';
        }

        $data['train_type'] = $this->Training->gets_type();
        $data['train_location'] = $this->Training->gets_location();

        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลการอบรม', '/Officer/Training/index');
        $this->breadcrumbs->push('เพิ่มข้อมูลโครงการอบรม', '/');

        $this->template->view('Officer/Add_Train_list_view', $data);
    }

    public function post_add()
    {
        //insert
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('train_type', 'ประเภทการอบรม', 'trim|required|numeric');
        $this->form_validation->set_rules('train_title', 'ชื่อโครงการอบรม', 'trim|required');
        $this->form_validation->set_rules('train_lecturer', 'วิทยากร', 'trim|required|thai_en_character');
        $this->form_validation->set_rules('train_seat', 'จำนวนที่นั่งเปิดรับ', 'trim|required|numeric|is_natural_no_zero');
        $this->form_validation->set_rules('train_start_date', 'วันที่เริ่มการอบรม', 'trim|required');
        $this->form_validation->set_rules('train_end_date', 'วันสิ้นสุดการอบรม', 'trim|required');   
        $this->form_validation->set_rules('train_location_id', 'ห้องอบรม', 'trim|required|numeric');
        $this->form_validation->set_rules('train_hour', 'จำนวนชั่วโมงที่ได้รับ', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run() != FALSE) {
            //check train_location
            if(!$this->Training->get_location($this->input->post('train_location_id'))) {
                return $this->add('error_location');
                die();
            }
            //check train_type
            if(!$this->Training->get_type($this->input->post('train_type'))) {
                return $this->add('error_type');
                die();
            }

            //add
            $insert['train_type_id'] = $this->input->post('train_type');
            $insert['train_title'] = $this->input->post('train_title');
            $insert['train_lecturer'] = $this->input->post('train_lecturer');
            $insert['train_seat'] = $this->input->post('train_seat');
            $insert['train_start_date'] = $this->input->post('train_start_date');            
            $insert['train_end_date'] = $this->input->post('train_end_date');
            $insert['train_location_id'] = $this->input->post('train_location_id');
            $insert['train_hour'] = $this->input->post('train_hour');
            
 
            if($this->Training->insert_training($insert)) {
                return $this->index('success_insert');
                die();
            } else {
                return $this->add('error_add');
                die();
            }
        } else {
            return $this->add(validation_errors());
            die();
        }
    }

    public function post_edit()
    {
        //insert
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('train_id', 'primary_id', 'trim|required|numeric');
        $this->form_validation->set_rules('train_type', 'ประเภทการอบรม', 'trim|required|numeric');
        $this->form_validation->set_rules('train_title', 'ชื่อโครงการอบรม', 'trim|required');
        $this->form_validation->set_rules('train_lecturer', 'วิทยากร', 'trim|required|thai_en_character');
        $this->form_validation->set_rules('train_seat', 'จำนวนที่นั่งเปิดรับ', 'trim|required|numeric|is_natural_no_zero');
        $this->form_validation->set_rules('train_start_date', 'วันที่เริ่มการอบรม', 'trim|required');
        $this->form_validation->set_rules('train_end_date', 'วันสิ้นสุดการอบรม', 'trim|required');        
        $this->form_validation->set_rules('train_location_id', 'ห้องอบรม', 'trim|required|numeric');
        $this->form_validation->set_rules('train_hour', 'จำนวนชั่วโมงที่ได้รับ', 'trim|required|is_natural_no_zero');
        $id = $this->input->post('train_id');

        if ($this->form_validation->run() != FALSE) {
            //check primary key
            if(!$this->Training->get_training($id)) {
                return $this->edit($id, 'error_location');
                die();
            }
            //check train_location
            if(!$this->Training->get_location($this->input->post('train_location_id'))) {
                return $this->edit($id, 'error_location');
                die();
            }
            //check train_type
            if(!$this->Training->get_type($this->input->post('train_type'))) {
                return $this->edit($id, 'error_type');
                die();
            }

            //add
            $insert['train_type_id'] = $this->input->post('train_type');
            $insert['train_title'] = $this->input->post('train_title');
            $insert['train_lecturer'] = $this->input->post('train_lecturer');
            $insert['train_seat'] = $this->input->post('train_seat');
            $insert['train_location_id'] = $this->input->post('train_location_id');
            $insert['train_start_date'] = $this->input->post('train_start_date');            
            $insert['train_end_date'] = $this->input->post('train_end_date');
            $insert['train_hour'] = $this->input->post('train_hour');
            
 
            if($this->Training->update_training($id, $insert)) {
                return $this->index('success_update');
                die();
            } else {
                return $this->edit($id, 'error_edit');
                die();
            }
        } else {
            return $this->edit($id, validation_errors());
            die();
        }
    }

    public function Students($training_id)
    {
        $data['status'] = [];
        $status = $this->session->flashdata('status');
        if($status == 'success_upload') {
            $data['status'] = [
                'text' => 'สำเร็จ',
                'color' => 'success'
            ];
        } else if($status == 'error_upload') {
            $data['status'] = [
                'text' => 'ผิดพลาด นามสกุลไฟล์ไม่ถูกต้อง',
                'color' => 'warning'
            ];
        } else if($status == 'error_training_id') {
            $data['status'] = [
                'text' => 'ไม่พบรายการการอบรม',
                'color' => 'danger'
            ];
        }

        if($this->session->flashdata('form-alert')) {
            $data['status'] = [
                'text' => $this->session->flashdata('form-alert'),
                'color' => 'success'
            ];
        }

        //to pdf
        $data['students'] = [];
        foreach($this->Training->gets_student_register_train($training_id) as $key => $student) {
            $student_info = @$this->Student->get_student($student['student_id'])[0];
            $data['students'][] = array(
                'student_id' => $student['student_id'],
                'student_fullname' => $student_info['student_fullname'],
                // 'student_barcode' => 'http://project.devss.pw/barcode.php?student_id='.$student['student_id'].'',
                'student_barcode' => 'https://barcode.tec-it.com/barcode.ashx?data='.$student['student_id'].'&code=Code128&dpi=96&dataseparator=',
                // 'student_barcode' => 'https://www.barcodesinc.com/generator/image.php?code='.$student['student_id'].'&style=196&type=C128B&width=158&height=100&xres=1&font=3',
            );
        }

        //training info
        $data['training'] = $this->Training->get_training($training_id)[0];
        $data['training']['train_type'] = $this->Training->get_type($data['training']['train_type_id'])[0];
        $data['training']['train_location'] = $this->Training->get_location($data['training']['train_location_id'])[0];
        $data['training']['note'] = thaiDate($data['training']['train_start_date'], true);
        
        // add breadcrumbs
        $this->breadcrumbs->push('จัดการข้อมูลการอบรม', '/Officer/Training/index');
        $this->breadcrumbs->push('รายชื่อนิสิตเข้าร่วมอบรม', '/Officer/training/Students/'.$training_id);

        $data['is_uploadform'] = true;

        $this->template->view('Officer/Student_list_report', $data);

    }

    public function upload_student_list()
    {
        // $this->load->library('form_validation');
        // $this->form_validation->set_rules('training_id','IDการอบรม','required|numeric');
        // if($this->form_validation->run() != false){
        //     //check coop test id
        //     $training_id = $this->input->post('training_id');            
        //     $training_data = $this->Training->get_training($training_id)[0];
        //     if(!$training_data) {
        //         rediretct('/Officer', 'refresh');
        //         die();
        //     }
        //     $train_type_id = $training_data['train_type_id'];
        //     $training_data['train_seat'] = (int) $training_data['train_seat'];
        	$training_id = $this->input->post('training_id');
        	$training_data = $this->Training->get_training($training_id)[0];
        	$train_type = $training_data['train_type_id'];
            $student_id = nl2br($this->input->post('student_id_post'));
            $ids = explode(PHP_EOL, $student_id);
            $error = 0; 
            $count = 0;
            $error_arr = array();
            $error_arr2 = "";

            foreach ($ids as $row) {
            	$data = $this->Training->check_student_in_training($training_id, $row);
            	$check_login_data = $this->Training->check_student_login($row);
            	if(!$check_login_data) {
            		$error++;
            		array_push($error_arr, $row);
            	} else if($data) {
            		$error++;
            		array_push($error_arr, $row);
            	} else {
            		$this->Training->add_student_to_training($training_id, $row, $train_type);
            		$count++;
            	}
            }

            foreach ($error_arr as $row) {
            	$error_arr2 = $error_arr2." ".$row;
            }
            $this->session->set_flashdata('form-alert', 'เพิ่มนิสิตได้ทั้งหมด '.$count.' คน, เพิ่มไม่สำเร็จ '.$error.' คน<br>
            	รหัสนิสิตต่อไปนี้ไม่สามารถเพิ่มได้เนื่องจากยังไม่ได้ Log-in เข้าสูระบบ หรือ มีรายชื่อนิสิตนี้อยู่แล้ว<br>
            	'.$error_arr2);
            redirect('Officer/Training/Students/'.$training_id, 'refresh');
            die();

            // print_r($ids);
            // echo $count."Error:".$error;
            
            // if(is_numeric($student_id)) {
            //                 if($this->Training->add_student_to_training($training_id, $student_id)) {
            //                     echo "Test successfully";
            //                 } else {
            //                     echo "Fail";
            //                 }
            //             }

            // $config['upload_path']          = './uploads/';
            // $config['allowed_types']        = 'xlsx';
            // $config['max_size']             = 1500;
            // $config['encrypt_name'] = true;
            // $this->load->library('upload', $config);

            // if ( ! $this->upload->do_upload('userfile')) {
            //     $data['status'] = $this->upload->display_errors();
            //     $this->session->set_flashdata('status', 'error_upload');
            //     redirect('Officer/Training/Students/'.$training_id, 'refresh');
            //     die();
            // } else {
                
            //     $file = $this->upload->data();            


            //     //แปลง Excel
            //     require(FCPATH.'/application/libraries/XLSXReader.php');
            //     $xlsx = new XLSXReader($file['full_path']);
            //     $sheet = $xlsx->getSheetNames()[1];
            //     $count = [
            //         'success' => 0,
            //         'error' => 0,
            //     ];
            //     foreach($xlsx->getSheetData($sheet) as $key => $row) {
            //         if($key == 0) {
            //             continue;
            //         }
            //         echo '.';

            //         if($key > $training_data['train_seat']) {
            //             $count['error']++;
            //             continue;
            //         } else {
            //             // $student_id = trim($row[0]);
            //             $student_id = trim($row[1]);
            //             if(is_numeric($student_id)) {
            //                 if($this->Training->add_student_to_training($training_id, $student_id)) {
            //                     $count['success']++;
            //                 } else {
            //                     $count['error']++;
            //                 }
            //             }
            //         }
            //     }

            //     unlink($file['full_path']);
            //     $this->session->set_flashdata('form-alert', 'เพิ่มนิสิตได้ทั้งหมด '.$count['success'].' คน, เพิ่มไม่สำเร็จ '.$count['error'].' คน');
                // redirect('Officer/Training/Students/'.$training_id, 'refresh');
                // die();
        //     }
        // } else {
        //     $this->session->set_flashdata('status', 'error_training_id');
        //     redirect('Officer/Training/Students/'.$training_id, 'refresh');
        //     die();  
        // }
    }

}