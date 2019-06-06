<?php
class Coop_Submitted_Form_Search_model extends CI_model {
    public function search_form_by_student($student_id)
    {
        $this->db->where('student_id',$student_id);
        $this->db->from('tb_coop_student_has_coop_document');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function search_form_by_code($form_code)
    {
        $this->db->where('coop_document_id',$form_code);
        $this->db->from('tb_coop_student_has_coop_document');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function search_form_by_student_and_code($student_id, $form_code)
    {
        $this->db->where('student_id',$student_id);
        $this->db->where('coop_document_id',$form_code);
        $this->db->from('tb_coop_student_has_coop_document');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_form_by_student_and_code($student_id, $form_code, $document_subject = NULL)
    {
        if($document_subject) {
            $this->db->where('document_subject',$document_subject);
        }
        $this->db->where('student_id',$student_id);
        $this->db->where('coop_document_id',$form_code);
        return $this->db->delete('tb_coop_student_has_coop_document');
    }

    public function insert_form_by_student_and_code($array) 
    {
        return $this->db->insert('tb_coop_student_has_coop_document', $array);
    }

    public function search_form_by_student_and_codes($student_id, $document_id_arr)
    {
        // foreach($document_id_arr as $doc_id) {
        //     $this->db->or_where('coop_document_id', $doc_id);
        // }

        // $this->db->where('student_id',$student_id);        
        // $this->db->from('tb_coop_student_has_coop_document');
        // $query = $this->db->get();

        $sql = "select * 
                from tb_coop_student_has_coop_document
                where ( `coop_document_id` in ('".implode("','", $document_id_arr)."') )
                    and `student_id` = '".$student_id."'
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function search_uploaded_form_by_student_and_codes($student_id, $document_id_arr)
    {
        // foreach($document_id_arr as $doc_id) {
        //     $this->db->or_where('coop_document_id', $doc_id);
        // }

        // $this->db->where('student_id',$student_id);        
        // $this->db->from('tb_coop_student_has_coop_document');
        // $query = $this->db->get();

        $sql = "select * 
                from tb_coop_student_has_coop_document
                where ( `coop_document_id` in ('".implode("','", $document_id_arr)."') )
                    and `document_pdf_file` != ''
                    and `student_id` = '".$student_id."'
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }    

    public function gets_student_has_document()
    {
        $sql = "SELECT distinct(student_id) FROM `tb_coop_student_has_coop_document`";

        $query = $this->db->query($sql);
        return $query->result_array();
    }


}