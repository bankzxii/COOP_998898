<?php
class Job_model extends CI_model {
    public function insert_job($array)
    {
        return $this->db->insert('tb_company_job_position',$array);

    }

    public function update_job($job_id, $array)
    {
        $this->db->where('job_id', $job_id);
        return $this->db->update('tb_company_job_position',$array);

    }

    public function delete_job($job_id) 
    {
        $this->db->where('job_id', $job_id);
        return $this->db->update('tb_company_job_position', array( 'job_active' => 0 ));
    }

    public function get_job($job_id)
    {
        $this->db->where('job_id', $job_id);
        $this->db->from('tb_company_job_position');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function gets_job()
    {
        $this->db->where('job_active', 1);  
        $this->db->from('tb_company_job_position');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function search_job_by_company_and_position($company_id, $job_title)
    {
        $this->db->where('job_active', 1);
        if($company_id > 0) {
            $this->db->where('company_id', $company_id);
        }
        if(is_numeric($job_title) && $job_title > 0) {
            $this->db->where('job_title_id', $job_title);
        } else {
            if($job_title != 0) {
                $this->db->where('job_title', $job_title);
            }
        }
        $this->db->from('tb_company_job_position');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function gets_job_by_company($company_id)
    {
        $this->db->where('job_active', 1);
        $this->db->where('company_id', $company_id);
        $this->db->from('tb_company_job_position');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function student_register_job($student_id, $job_id)
    {
        // $db_debug = $this->db->db_debug; //save setting
        // $this->db->db_debug = FALSE; //disable debugging for queries
        $term = $this->Term->get_current_term();
        $array['term_id'] = $term[0]['term_id'];
        $job = $this->get_job($job_id);
        $array['job_id'] = $job_id;
        $array['company_id'] = $job[0]['company_id'];
        $array['student_id'] = $student_id;
        $array['job_register_datetime'] = date('Y-m_d H:i:s');
        $array['company_status_id'] = 1;
        
        $return = $this->db->replace('tb_student_register_company_job_position',$array);

        // $this->db->db_debug = $db_debug;
        

        return $return;
    }

    public function gets_company_job_title()
    {
        $this->db->from('tb_company_job_title');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_job_title($job_title_id)
    {
        $this->db->where('job_title_id', $job_title_id);        
        $this->db->from('tb_company_job_title');
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function get_company_job_title_by_job_title_id($job_title_id)
    {
        $this->db->where('job_title_id', $job_title_id);
        $this->db->from('tb_company_job_title');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_job_title($array)
    {
        return $this->db->insert('tb_company_job_title', $array);
    }

    public function update_job_title($job_title_id,$array)
    {
        $this->db->where('job_title_id', $job_title_id);
        return $this->db->update('tb_company_job_title',$array);
    }

    public function delete_job_title($job_title_id) 
    {
        $this->db->where('job_title_id', $job_title_id);
        return $this->db->delete('tb_company_job_title');

    }
    public function check_dup_job_title($job_title)
    {
        $this->db->like('job_title',$job_title);
        $this->db->from('tb_company_job_title');
        return $this->db->count_all_results();
    }
    public function gets_job_title()
    {
        $this->db->from('tb_company_job_title');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_student_by_company_id($company_id)
    {
        $term_id = $this->Term->get_current_term()[0]['term_id'];

        // $this->db->where('term_id', $term);
        // $this->db->where('company_status_id !=', 5);
        // $this->db->where('company_id',$company_id);
        // $this->db->from('tb_student_register_company_job_position');
        // $qurey = $this->db->get();
        $sql = "SELECT `tb_student_register_company_job_position`.`student_id`, `tb_student_register_company_job_position`.`company_status_id`, `tb_student`.`student_id`, `tb_student`.`student_fullname`, `tb_student`.`student_gpax`, `tb_department`.`department_name`, `tb_company_job_position`.`job_title`, `tb_company_status`.`company_status_name`
        FROM `tb_student_register_company_job_position`
        INNER JOIN `tb_student` ON `tb_student`.`student_id` = `tb_student_register_company_job_position`.`student_id`
        INNER JOIN `tb_company_job_position` ON `tb_company_job_position`.`job_id` = `tb_student_register_company_job_position`.`job_id`
        INNER JOIN `tb_department` ON `tb_department`.`department_id` = `tb_student`.`department_id`
        INNER JOIN `tb_company` ON `tb_company`.`company_id` = `tb_student_register_company_job_position`.`company_id`
        INNER JOIN `tb_company_status` ON `tb_company_status`.`company_status_id` = `tb_student_register_company_job_position`.`company_status_id`
        WHERE `tb_student_register_company_job_position`.`term_id` = '".$term_id."'
        AND `tb_student_register_company_job_position`.`company_status_id` != 5
        AND `tb_student_register_company_job_position`.`company_id` = '".$company_id."'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_student($student_id, $array)
    {
        $this->db->where('student_id', $student_id);
        return $this->db->update('tb_student_register_company_job_position', $array);
    }
    public function gets_job_register_by_student($student)
    {
        $this->db->select('tb_company_status.*, tb_student_register_company_job_position.*, tb_company_job_position.*, tb_company.*, tb_coop_status.*');
        $this->db->where('tb_student_register_company_job_position.student_id',$student);
        $this->db->from('tb_student_register_company_job_position');
        $this->db->join('tb_company_job_position', 'tb_student_register_company_job_position.job_id = tb_company_job_position.job_id');
        $this->db->join('tb_company', 'tb_student_register_company_job_position.company_id = tb_company.company_id');
        $this->db->join('tb_student', 'tb_student_register_company_job_position.student_id = tb_student.student_id');
        $this->db->join('tb_coop_status', 'tb_student.coop_status_id = tb_coop_status.coop_status_id');
        $this->db->join('tb_company_status', 'tb_student_register_company_job_position.company_status_id = tb_company_status.company_status_id');
        $query = $this->db->get();
        return $query->result_array();

    }

}