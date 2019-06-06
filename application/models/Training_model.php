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
        $this->db->from('tb_train');
        $this->db->order_by("train_id", "desc");
        $query = $this->db->get();
        return $query->result_array();
       
    }

    public function get_training_by_student_id($training_id,$student_id)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('train_id', $training_id);
        $this->db->from('tb_student_train_register');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_training($training_id)
    {
        $this->db->where('train_id', $training_id);
        $this->db->from('tb_train');
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function insert_training($array)
    {
        return $this->db->insert('tb_train',$array);

    }

    public function update_training($training_id,$array)
    {
        $this->db->where('train_id', $training_id);
        return $this->db->update('tb_train',$array);

    }

    public function delete_training($training_id)
    {
        $this->db->where('train_id', $training_id);
	return $this->db->delete('tb_train');

    }

    public function add_student_to_training($training_id, $student_id, $train_type_id) 
    {
        $array['student_id'] = $student_id;
        $array['register_date'] = date('Y-m-d H:i:s'); 
        $array['train_id'] = $training_id;
        $array['train_type_id'] = $train_type_id;
        $status = $this->db->insert('tb_student_train_register',$array); 
        
        return $status;
    }

    public function get_training_by_student_and_type($student_id, $training_type)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('train_type_id', $training_type);
        
        $this->db->from('tb_student_train_register');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_student_login($student_id)
    {
        $this->db->where('student_id' ,$student_id);
        $this->db->from('tb_student');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_student_in_training($training_id, $student_id) 
    {
        $this->db->where('train_id', $training_id);
        $this->db->where('student_id', $student_id);
        $this->db->from('tb_student_train_register');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result_array();
    }
  

    public function insert_location($array)
    {
        return $this->db->insert('tb_train_location', $array);
    }

    public function gets_location()
    {
        $this->db->from('tb_train_location');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_location($location_id)
    {
        $this->db->where('location_id', $location_id);
        $this->db->from('tb_train_location');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_location($location_id, $array)
    {
        $this->db->where('location_id', $location_id);
        return $this->db->update('tb_train_location', $array);
    }

    public function delete_location($location_id)
    {
        $this->db->where('location_id', $location_id);
        return $this->db->delete('tb_train_location');
    }

    public function gets_type()
    {
        $this->db->from('tb_train_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_type($type_id)
    {
        $this->db->where('train_type_id', $type_id);
        $this->db->from('tb_train_type');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_current_register_period()
    {
        return false;
        //cancel

        $this->db->order_by('register_period', 'asc');
        // $this->db->limit(1);
        $this->db->where('register_period <=', date('Y-m-d H:i:s'));
        $this->db->where('register_period >', date('Y-m-d H:i:s', time()-(86400*2)));
        $this->db->from('tb_train');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function gets_student_register_train($training_id)
    {
        $this->db->where('train_id', $training_id);
        $this->db->from('tb_student_train_register');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_student_stat_of_training($student_id)
    {
        $data['train_type'] = array();
        foreach($this->gets_type() as $type) {
            $type['history'] = array();
            
            foreach($this->get_training_by_student_and_type($student_id, $type['train_type_id']) as $row) {
                $train_info = @$this->get_training($row['train_id'])[0];
                $row['tb_train'] = $train_info;

                
                $row['is_complete_train'] = false;
                //count all checking in train id
                $check_count = count($this->Training_Check_Student->count_total_check_by_train($row['train_id']));
                //count student checking in train
                $student_count = count($this->Training_Check_Student->get_student_by_train($student_id, $row['train_id']));

                $row['total_hour'] = $train_info['train_hour'];

                $per_hour = 0;

                if($check_count > 0)
                    $per_hour = $train_info['train_hour']/$check_count;
                else
                    $check_count = 0;
                
                $row['check_hour'] = 0;
                if( ($student_count == $check_count) && ($check_count > 0) ) {
                    $row['is_complete_train'] = true;
                    $row['check_hour'] = $row['total_hour'];
                } else {
                    $row['check_hour'] = $per_hour*$student_count;
                    $row['is_complete_train'] = false;
                }

                array_push($type['history'], $row);
                
            }

            array_push($data['train_type'], $type);
        }

        return $data;
    }
}
