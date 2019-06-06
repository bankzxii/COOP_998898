<?php
class Skilled_Job_Search_model extends CI_model {
    public function search_skill_by_job($job_id) 
    {
        $this->db->where('job_id',$job_id);
        $this->db->from('tb_company_job_position');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function search_skill_category_by_job($job_id) 
    {
        $this->db->where('job_id',$job_id);
        $this->db->from('tb_company_job_has_skill');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function search_job_by_skill($skill_id)
    {
        $this->db->where('skill_id',$skill_id);
        $this->db->from('tb_company_job_position_has_skill');
        $query = $this->db->get();
        return $query->result_array();

    }

    
}