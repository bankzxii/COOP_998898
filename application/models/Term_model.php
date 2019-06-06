<?php
class Term_model extends CI_model 
{
    public function add_term($insert)
    {
        return $this->db->insert('tb_term', $insert);
    }

    public function gets_term()
    {
        $this->db->order_by('term_id', 'desc');
        $this->db->from('tb_term');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_term($term_id = 1)
    {
        $this->db->where('term_id', $term_id);
        $this->db->from('tb_term');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function search_term($term_semester, $term_year)
    {
        $this->db->where('term_semester', $term_semester);
        $this->db->where('term_year', $term_year);
        
        $this->db->from('tb_term');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_current_term($term_id)
    {
        $this->db->update('tb_term', array(
            'term_is_current' => 0
        ));

        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_term', array(
            'term_is_current' => 1
        ));
    }

    public function get_current_term()
    {
        $userdata = $this->Login_session->check_login();
        if(@$userdata->login_type == 'officer') {
            //for officer
            $this->db->where('term_id', $userdata->term_id);
            $this->db->from('tb_term');
            $query = $this->db->get();
        } else {
            //for other actor
            $this->db->where('term_is_current', 1);
            $this->db->from('tb_term');
            $this->db->select('term_id, term_name');
            $query = $this->db->get();
        }

        return $query->result_array();
    }
  
    public function update_tb_company_has_coop_company_questionnaire_item($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_company_has_coop_company_questionnaire_item', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_company_has_department($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_company_has_department', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_company_job_position($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_company_job_position', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_coop_company_questionnaire_item($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_coop_company_questionnaire_item', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_coop_company_questionnaire_subject($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_coop_company_questionnaire_subject', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_coop_document($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_coop_document', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_coop_student_questionnaire_item($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_coop_student_questionnaire_item', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_coop_student_questionnaire_subject($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_coop_student_questionnaire_subject', array(
            'term_id' => $term_id
        ));
    }

    public function update_tb_student_core_subject($term_id)
    {
        $this->db->where('term_id', $term_id);
        return $this->db->update('tb_student_core_subject', array(
            'term_id' => $term_id
        ));
    }

}