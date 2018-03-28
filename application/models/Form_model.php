<?php
class Form_model extends CI_model {
    public function gets_form()
    {
        $this->db->from('coop_document');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_form_by_code($form_code, $term_id = 0)
    {
        $this->db->where('id', $form_code);
        if($term_id != 0) {
            $this->db->where('term_id', $term_id);
        } 
        
        $this->db->from('coop_document');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_form_by_name($form_name, $term_id = 0)
    {
        $this->db->where('name', $form_name);
        if($term_id != 0) {
            $this->db->where('term_id', $term_id);
        } 
        
        $this->db->from('coop_document');
        $query = $this->db->get();
        return $query->result_array();
    }    

    public function submit_document($student_id, $form_code, $pdf_file, $word_file)
    {
        $array['student_id'] = $student_id;
        $array['coop_document_id'] = $form_code;
        $array['pdf_file'] = $pdf_file;
        $array['word_file'] = $word_file;

        //check if exist
        $this->db->where('student_id', $student_id);
        $this->db->where('coop_document_id', $form_code);
        $this->db->from('coop_student_has_coop_document');
        $this->db->get();
        if($this->db->count_all_results()) {
            //update
            $this->db->where('student_id', $student_id);
            $this->db->where('coop_document_id', $form_code);
            unset($array['student_id']);
            unset($array['coop_document_id']);
            if($array['pdf_file'] == '') {
                unset($array['pdf_file']);                
            }
            if($array['word_file'] == '') {
                unset($array['word_file']);                
            }
            return $this->db->update('coop_student_has_coop_document', $array);
        } else {
            //insert
            return $this->db->insert('coop_student_has_coop_document', $array);
        }
    }
}