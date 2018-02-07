<?php
class Training_model extends CI_model 
{
    var $training_id;
    var $training_name;
    var $training_type;
    var $training_hour;
    var $training_lecturer;
    var $training_description;
    var $officer_id;

    public function gets_training()
    {
        $this->db->from('train');
        $query = $this->db->get();
        return $query->result_array();
       
    }

    public function get_training($training_id)
    {
        $this->db->where('id',$training_id);
        $this->db->from('train');
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function insert_training($array)
    {
        return $this->db->insert('train',$array);

    }

    public function update_training($training_id,$array)
    {
        $this->db->where('id',$training_id);
        return $this->db->update('train',$array);

    }

    public function delete_training($training_id)
    {
        $this->db->where('id',$training_id);
        return $this->db->delete('train');

    }

    public function add_student($training_id, $student_id) 
    {
        $array['student_id'] = $student_id;
        $term = $this->Term->get_current_term();
        $array['student_term_id'] = $term[0]['id'];
        $array['register_date'] = date('Y-m-y H:i:s'); 
        $array['train_id'] = $training_id;
        $train = $this->get_training($training_id);
        $array['train_train_type_id'] = $train;
        return $this->db->insert('student_train_register',$array); 

    }
  
}