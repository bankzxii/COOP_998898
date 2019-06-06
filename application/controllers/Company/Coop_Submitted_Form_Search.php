<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coop_Submitted_Form_Search extends CI_Controller {
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
                redirect(ucfirst($this->Login_session->check_login()->login_type).'/main/');
                die();
            }
            //add breadcrumbs
            $this->breadcrumbs->push(strToLevel($user->login_type), '/'.ucfirst($user->login_type)); //actor
        }

        public function get_by_student($student_id)
        {
            $array = array();
            $array['data'] = array();
            $rowsDocument = $this->Form->gets_form_for_company();
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

   
 

}