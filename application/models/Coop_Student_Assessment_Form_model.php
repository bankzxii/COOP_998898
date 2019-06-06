<?php
class Coop_Student_Assessment_Form_model extends CI_model {
    public function gets_form_for_coop_student()
    {
        $this->db->where('term_id', $this->Term->get_current_term()[0]['term_id']);                
        $this->db->order_by('coop_student_questionnaire_subject_type', 'asc');
        $this->db->from('tb_coop_student_questionnaire_subject');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function save_coop_student_form_subject($array)
    {
        return $this->db->insert('tb_coop_student_questionnaire_subject',$array);
    }

    public function save_coop_student_comment_result($array)
    {
        return $this->db->replace('tb_coop_student_has_coop_student_questionnaire_comment',$array);
    }

    public function save_coop_student_form_result($array)
    {
        return $this->db->replace('tb_coop_student_has_coop_student_questionnaire_item',$array);
    }

    public function get_coop_student_comment_result($student_id)
    {
        $this->db->where('student_id', $student_id);
        $this->db->from('tb_coop_student_has_coop_student_questionnaire_comment');
        $query = $this->db->get();
        return $query->result_array();
    }    

    public function get_coop_student_form_result($student_id)
    {
        $this->db->where('student_id', $student_id);
        $this->db->from('tb_coop_student_has_coop_student_questionnaire_item');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_coop_student_questionnaire_item_by_subject($id)
    {
        $this->db->where('term_id', $this->Term->get_current_term()[0]['term_id']);        
        $this->db->order_by('coop_student_questionnaire_item_number', 'asc');
        $this->db->where('subject_id',$id);
        $this->db->from('tb_coop_student_questionnaire_item');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_coop_student_questionnaire_item($id)
    {
        $this->db->where('term_id', $this->Term->get_current_term()[0]['term_id']);        
        $this->db->where('coop_student_questionnaire_item_id',$id);
        $this->db->from('tb_coop_student_questionnaire_item');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_coop_student_questionnaire_item($array)
    {
        return $this->db->insert('tb_coop_student_questionnaire_item',$array);
    } 

    public function get_coop_student_questionnaire_subject($id)
    {        
        $this->db->where('coop_student_questionnaire_subject_id',$id);
        $this->db->from('tb_coop_student_questionnaire_subject');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_subject_dup($number) 
    {
        $this->db->where('term_id', $this->Term->get_current_term()[0]['term_id']);                
        $this->db->where('coop_student_questionnaire_subject_number',$number);
        $this->db->from('tb_coop_student_questionnaire_subject');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function check_item_dup($number, $subject_id)
    {
        $this->db->where('term_id', $this->Term->get_current_term()[0]['term_id']);                
        $this->db->where('coop_student_questionnaire_item_number',$number);
        $this->db->where('subject_id',$subject_id);
        
        
        $this->db->from('tb_coop_student_questionnaire_item');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_item($id)
    {
        $this->db->where('coop_student_questionnaire_item_id', $id);
        return $this->db->delete('tb_coop_student_questionnaire_item');
    }

    public function update_item($id, $array)
    {
        $this->db->where('coop_student_questionnaire_item_id', $id);
        return $this->db->update('tb_coop_student_questionnaire_item', $array);
    }

    public function sort_item($subject_id)
    {
        //get subject number
        $main_number = $this->get_coop_student_questionnaire_subject($subject_id)[0]['coop_student_questionnaire_subject_number'];
        //get items
        $i = 1;
        $rows = $this->get_coop_student_questionnaire_item_by_subject($subject_id);
        foreach($rows as $row) {
            $run_number = $main_number.".".$i;
            
            //update
            // $this->update_item($row['id'], array(
            //     'coop_student_questionnaire_item_number' => $run_number
            // ));

            $i++;
        }
    }
}