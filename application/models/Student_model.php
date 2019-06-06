<?php 

class Student_model extends CI_model {

    var $student_id;

    var $first_name;

    var $last_name;

    var $profile_picture;

    var $coop_test_status;

    var $coop_status_id;
    
    public function get_test($student_id){
                $sql = "SELECT tbc.student_id,document_pdf_file,tb_document.document_deadline from tb_coop_student_has_coop_document as tbc 

        INNER JOIN tb_coop_document as tb_document ON tbc.coop_document_id = tb_document.document_id

        where tbc.student_id = $student_id";
    }
    

    public function get_student($student_id)

    {

        $term_id = $this->Term->get_current_term()[0]['term_id'];



        // $this->db->where('term_id', $term_id);

        // $this->db->where('student_id',$student_id);

        // $this->db->from('tb_student');

        // $query = $this->db->get();

        // return $query->result_array();



        $sql = "SELECT * FROM `tb_student` 

        INNER JOIN `tb_department` ON `tb_department`.`department_id` = `tb_student`.`department_id`

        INNER JOIN `tb_company_status` ON `tb_company_status`.`company_status_id` = `tb_student`.`company_status_id`

        INNER JOIN `tb_coop_status` ON `tb_coop_status`.`coop_status_id` = `tb_student`.`coop_status_id`

        WHERE `student_id` = '".$student_id."' AND `term_id` = '".$term_id."'";

        $query = $this->db->query($sql);

        return $query->result_array();

    }



    public function search_department_by_course($course)

    {

        $this->db->from('tb_department');

        $query = $this->db->get();

        foreach($query->result_array() as $department) {

            if(strpos($course, $department['department_name'])) {

                return $department['department_id'];

            }

        }



        return 1;

    }    



    public function gets_student()

    {

        $term_id = $this->Term->get_current_term()[0]['term_id'];



        // $this->db->where('term_id', $term_id);

        // $this->db->from('tb_student');

        // $query = $this->db->get();
        // $this->db->select('tb_student.company_status_id, tb_student.student_gpax, tb_student.student_fullname, tb_student.student_id, tb_department.department_name, tb_company_status.company_status_name, tb_coop_status.coop_status_id, tb_coop_status.coop_status_name');
        // $this->db->form('tb_student');
        // $this->db->join('tb_company_status', 'tb_department.department_id = tb_student.department_id', 'INNER');
        // $this->db->join('tb_department', 'tb_company_status.company_status_id = tb_student.company_status_id', 'INNER');
        // $this->db->join('tb_coop_status', 'tb_coop_status.coop_status_id = tb_student.coop_status_id', 'INNER');
        // $this->db->where('tb_student.term_id', $term_id);
        // if($this->coop_status_id && is_numeric($this->coop_status_id)) {
        //     $this->db->where('tb_student.coop_status_id', $this->coop_status_id);
        // }
        //  $query = $this->db->get();
         $sql = "SELECT `tb_student`.`company_status_id`, `tb_student`.`student_gpax`, `tb_student`.`student_fullname`, `tb_student`.`student_id`, `tb_department`.`department_name`, `tb_company_status`.`company_status_name`, `tb_coop_status`.`coop_status_id`, `tb_coop_status`.`coop_status_name`
        FROM `tb_student` 
        INNER JOIN `tb_department` ON `tb_department`.`department_id` = `tb_student`.`department_id`
        INNER JOIN `tb_company_status` ON `tb_company_status`.`company_status_id` = `tb_student`.`company_status_id`
        INNER JOIN `tb_coop_status` ON `tb_coop_status`.`coop_status_id` = `tb_student`.`coop_status_id`
        WHERE `tb_student`.`term_id` = ".$term_id;
        if($this->coop_status_id && is_numeric($this->coop_status_id)) {
            $sql .= " AND `tb_student`.`coop_status_id` = ".$this->coop_status_id;
        }
        
        $query = $this->db->query($sql);
         return $query->result_array();
       

        

    }

    public function gets_student_for_codecheck()

    {

        $term_id = $this->Term->get_current_term()[0]['term_id'];
        

         $sql = "SELECT `tb_student`.`company_status_id`, `tb_student`.`student_gpax`, `tb_student`.`student_fullname`, `tb_student`.`student_id`, `tb_department`.`department_name`, `tb_company_status`.`company_status_name`, `tb_coop_status`.`coop_status_id`, `tb_coop_status`.`coop_status_name`

        FROM `tb_student` 

        INNER JOIN `tb_department` ON `tb_department`.`department_id` = `tb_student`.`department_id`

        INNER JOIN `tb_company_status` ON `tb_company_status`.`company_status_id` = `tb_student`.`company_status_id`

        INNER JOIN `tb_coop_status` ON `tb_coop_status`.`coop_status_id` = `tb_student`.`coop_status_id`

        WHERE `tb_student`.`term_id` = ".$term_id;

        $query = $this->db->query($sql);
        return $query->result_array();

    }

    public function gets_student_by_department($department_id)

    {

        $term_id = $this->Term->get_current_term()[0]['term_id'];



        $this->db->where('term_id', $term_id);

        $this->db->where('department_id', $deparment_id);

        $this->db->from('tb_student');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function insert_student($array) 

    {

        return $this->db->insert('tb_student',$array);

    }



    public function update_student($student_id, $array)

    {

        $term_id = $this->Term->get_current_term()[0]['term_id'];

        $this->db->where('term_id', $term_id);

        $this->db->where('student_id', $student_id);

        return $this->db->update('tb_student',$array);



    }

    

    public function gets_department()

    {

        $this->db->from('tb_department');

        $query = $this->db->get();

        return $query->result_array();



    }
    public function gets_skill_category()

    {

        $this->db->from('tb_skill_category');

        $query = $this->db->get();

        return $query->result_array();



    }



    public function get_department($department_id)

    {

        $this->db->select('department_name, department_id');

        $this->db->where('department_id', $department_id);        

        $this->db->from('tb_department');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function gets_coop_status_type()

    {

        $this->db->from('tb_coop_status');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function get_by_coop_status_type($status_type_id)

    {

        $this->db->where('coop_status_id', $status_type_id);

        $this->db->from('tb_coop_status');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function get_student_data_from_profile($student_id)

    {

        $ch = curl_init();

        $timeout = 20;

        $token = $this->get_profile_api_token();

        $authorization = "Authorization: Bearer $token";

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/v1/student/'.$student_id.'/about');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $result = curl_exec($ch);

        curl_close($ch);



        $api = json_decode($result, true);



        if(@$api['status'] == "true") {

            return $api['result'];

        } 

        

        return false;

    }



    public function has_student_data_from_profile($student_id) 

    {

        $ch = curl_init();

        $timeout = 5;

        $token = $this->get_profile_api_token();

        $authorization = "Authorization: Bearer $token";

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/v1/student/'.$student_id.'/about');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $result = curl_exec($ch);

        curl_close($ch);



        if( count( explode("null", $result) ) > 20 ) {

            return false;

        } 

        

        return true;

    }



    public function get_student_register_subject_from_profile($student_id, $subject_arr) 

    {

        $ch = curl_init();

        $timeout = 5;

        $subject_codes = implode(",", $subject_arr);



        $token = $this->get_profile_api_token();

        $authorization = "Authorization: Bearer $token";

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/v1/student/'.$student_id.'/subjects?Subject_Code='.$subject_codes);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $result = curl_exec($ch);

        curl_close($ch);

        $api = json_decode($result, true);





        if(@$api['status'] == "true") {

            return $api;

        } 

        

        return false;

    }    



    public function get_latest_register_job($student_id)

    {

        $this->db->where('student_id', $student_id);

        $this->db->order_by('job_register_created', 'DESC');

        $this->db->from('tb_student_register_company_job_position');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_student_core_subject($subject_id)

    {

        $this->db->where('subject_id', $subject_id);

        $this->db->from('tb_student_core_subject');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function gets_student_core_subject()

    {

        $this->db->from('tb_student_core_subject');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function insert_student_core_subject($array)

    {

        $db_debug = $this->db->db_debug; //save setting

        $this->db->db_debug = FALSE; //disable debugging for queries



        $return = $this->db->insert('tb_student_core_subject', $array);

        $this->db->db_debug = $db_debug;

        return $return;        

    }

    public function delete_student_core_subject($subject_id)

    {

        $this->db->where('subject_id', $subject_id);

        return $this->db->delete('tb_student_core_subject');

    }



    public function get_company_status_type($company_status_id)

    {

        $this->db->where('company_status_id', $company_status_id);

        $this->db->from('tb_company_status');

        $query = $this->db->get();

        return $query->result_array();

    }



    private function get_profile_api_token()

    {

        $token = '';

        if(! $token = $this->cache->file->get('profile_api_token')) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_USERPWD, "buu_profile:profile_999");

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/token');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            $result = curl_exec($ch);

            curl_close($ch);

            $api = json_decode($result, true);

            $token = $api['result']['token'];

            $this->cache->file->save('profile_api_token', $token, 7100);

        }



        return $token;

    }





    public function get_student_sum_credit($student_id) 

    {

        $ch = curl_init();

        $timeout = 5;



        $token = $this->get_profile_api_token();

        $authorization = "Authorization: Bearer $token";

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/v1/student/'.$student_id.'/credit');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $result = curl_exec($ch);

        curl_close($ch);

        $api = json_decode($result, true);





        if(@$api['status'] == "true") {

            return $api['result'][0]['sum_credit'];

        } 

        

        return false;

    }    



    public function get_adviser_name_from_student($student_id) 

    {

        $ch = curl_init();

        $timeout = 5;



        $token = $this->get_profile_api_token();

        $authorization = "Authorization: Bearer $token";

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($ch, CURLOPT_URL, getenv('API_URL').'api/v1/adviser/'.$student_id.'/adviser');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $result = curl_exec($ch);

        curl_close($ch);

        $api = json_decode($result, true);





        if(@$api['status'] == "true") {

            return $api['result'][0]['Full_Name_Teacher'];

        } 

        

        return false;

    }    

}
