<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coop_Submitted_Form_Search extends CI_Controller {
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

        public function by_student()
        {
            $term_id =  $this->Login_session->check_login()->term_id;

            $data['data'] = array();
            $cache = array();
            foreach($this->Student->gets_department() as $tmp) {
                $cache['department'][$tmp['department_id']] = $tmp;
            }
            
            $document_active_arr = [];
            foreach($this->Form->gets_form($term_id) as $doc) {
                if($doc['document_active'] == 1) {
                    $document_active_arr[] = $doc['document_id'];
                }
            }
            // $document_active = implode(",", $document_active_arr);

            foreach($this->Coop_Submitted_Form_Search->gets_student_has_document() as $r) {
                $row = array();
                //check document in document active
                $row['complete_form'] = false;
                
                $doc_count = $this->Coop_Submitted_Form_Search->search_uploaded_form_by_student_and_codes($r['student_id'], $document_active_arr); //รอการเช็คสถานะ

                if(count($doc_count) >= count($document_active_arr)) {
                    $row['complete_form'] = true;
                }



                $row['student'] = $this->Student->get_student($r['student_id'])[0];
                $row['student']['id_link'] = '<a href="'.site_url('Officer/Students/student_detail/'.$row['student']['student_id']).'">'.$row['student']['student_id'].'</a>';
                $row['department'] = $cache['department'][$row['student']['department_id']];

                array_push($data['data'], $row);
            }
            
            // add breadcrumbs
            $this->breadcrumbs->push('ตรวจสอบเอกสารรายบุคคล', '/Officer/Coop_Submitted_Form_Search/by_student');

            $this->template->view('Officer/Document_student_check_view',$data);
        }

        public function get_by_student($student_id)
        {
            $array = array();
            $array['data'] = array();
            $rowsDocument = $this->Form->gets_form();
            foreach($rowsDocument as $doc) {
                $tmp['document_code'] = $doc['document_code'].' - '.$doc['document_name'];
                $tmp['file'] = '';
                $files = $this->Coop_Submitted_Form_Search->search_form_by_student_and_code($student_id, $doc['document_id']);
                foreach($files as $file) {
                    if($file['document_pdf_file'] != '') {
                        $tmp['file'] .= '[<a href="'.base_url($file['document_pdf_file']).'">ดาวน์โหลด</a>] ';
                    }
                }

                array_push($array['data'], $tmp);
            }

            echo json_encode($array);
        }

        // public function get_by_form_code($form_code)
        // {
        //     $array = array();
        //     $document = $this->Form->get_form($form_code)[0];
        //     if($document) {
        //         foreach($this->Coop_Submitted_Form_Search->gets_student_has_document($form_code) as $r) {
        //             $student = $this->Student->get_student($r['student_id']);
        //             if(count($student) != 1) {
        //                 continue;
        //             }
        //             $row = array();
        //             $row['student'] = @$student[0];
        //             $row['student']['id_link'] = '<a href="'.site_url('Officer/Students/student_detail/'.$row['student']['student_id']).'">'.$row['student']['student_id'].'</a>';                
        //             $row['form'] = @$this->Coop_Submitted_Form_Search->search_form_by_student_and_code($r['student_id'], $form_code)[0];

        //             $row['form']['status'] = '<span style="color: red;">ยังไม่ส่ง</span>';
        //             if(@$row['form']['document_pdf_file']) {
        //                 $late_status = '';
        //                 if($row['form']['document_sent_date'] >= $document['document_deadline']) {
        //                     $late_status = ' (<span style="color: red;">ส่งช้า</span>)';
        //                 }
        //                 $row['form']['status'] = '<span style="color: green;">ส่งแล้ว</span>'.$late_status;
        //                 $row['form']['document_pdf_file'] = '<a href="'.base_url($row['form']['document_pdf_file']).'" target="_blank">ดาวน์โหลด</a>';
        //             } else {
        //                 $row['form']['document_pdf_file'] = '-';
        //             }

        //             if(
        //                 $row['student'] &&
        //                 $row['form']
        //             ) {
        //                 array_push($array, $row);                        
        //             }
        //         }
        //     }
            
        //     echo json_encode($array);
        // }


        public function get_by_form_code($form_code)
        {
            $array = array();
            $document = $this->Form->get_form($form_code)[0];
            if($document) {
                // cache
                $cache = [];
                foreach($this->Coop_Submitted_Form_Search->search_form_by_code($form_code) as $doc) {
                    $cache[$doc['student_id']] = $doc;
                }

                // foreach($this->Coop_Submitted_Form_Search->gets_student_has_document() as $r) {
                if(
                    $document['document_code'] == 'IN-S001' || 
                    $document['document_code'] == 'IN-S002'
                    ) 
                {
                    $gets_student = $this->Student->gets_student();
                } else {
                    $gets_student = $this->Coop_Student->gets_coop_student();
                }

                foreach($gets_student as $r) {
                
                    // $student = $this->Student->get_student($r['student_id']);
                    
                    $row = array();
                    $row['student'] = @$r;
                    $row['student']['id_link'] = '<a href="'.site_url('Officer/Students/student_detail/'.$row['student']['student_id']).'">'.$row['student']['student_id'].'</a>';                
                    // $row['form'] = @$this->Coop_Submitted_Form_Search->search_form_by_student_and_code($r['student_id'], $form_code)[0];
                    $row['form'] = @$cache[$row['student']['student_id']];
                    // $row['student']['coop_status_name'] = $r['coop_status_name'];
                    // print_r($row['student']);
                    

                    $row['form']['status'] = '<span style="color: red;">ยังไม่ส่ง</span>';
                    if(@$row['form']['document_pdf_file']) {
                        $late_status = '';
                        if($row['form']['document_sent_date'] >= $document['document_deadline']) {
                            $late_status = ' (<span style="color: red;">ส่งช้า</span>)';
                        }
                        $row['form']['status'] = '<span style="color: green;">ส่งแล้ว</span>'.$late_status;
                        $row['form']['document_pdf_file'] = '<a href="'.base_url($row['form']['document_pdf_file']).'" target="_blank">ดาวน์โหลด</a>';
                    } else {
                        $row['form']['document_pdf_file'] = '-';
                    }

                    if(
                        $row['student'] &&
                        $row['form']
                    ) {
                        array_push($array, $row);                        
                    }
                }
            }
            
            echo json_encode($array);
        }


        public function by_form()
        {
            // get form code
            $data['forms'] = $this->Form->gets_form();
            // add breadcrumbs
            $this->breadcrumbs->push('ตรวจสอบเอกสารเเยกประเภท', '/Officer/Coop_Submitted_Form_Search/by_form');

            $this->template->view('Officer/Document_code_check_view', $data);
        }
        
 

}