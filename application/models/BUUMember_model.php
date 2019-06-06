<?php
class BUUMember_model extends CI_Model 
{
    public function xlogin($username, $password)
    {
        // return false;

        $data = array();
        $hash_password = '$2y$10$d270bHk09dUJe4W4LeAgLe4YJmG0tCQi8sEffsu5hn61GTLcLk5yG';
        
        
        if($username == 'nutthanon998898' && password_verify($password, $hash_password)) {
            $data['user_fullname'] = 'Nutthanon';
            $data['login_type'] = 'adviser';
            $data['login_value'] = 'nutthanon';
        } else if($username == 'kamonwans998898' && password_verify($password, $hash_password)) {
            $data['fullname'] = 'Kamonwan';
            $data['login_type'] = 'officer';
            $data['login_value'] = 'kamonwans';
            $data['user_fullname'] = 'Kamonwan Sangrawee';
        } 
        // else if(strpos($username, "est")) {
        //     $username = str_replace("test", "", $username);
        //     $data['fullname'] = $username;
        //     $data['login_value'] = $username;
        //     if($this->Coop_Student->get_coop_student($username)) {
        //         $data['login_type'] = 'coop_student';
        //     } else {
        //         $data['login_type'] = 'student';
        //         $this->insert_new_student($data['login_value']);
        //     }
        // }  
        return $data;

        // return false;
    }

    public function login($username, $password)
    {
        // return $this->xlogin($username, $password);

        $this->ldap->connect();
        // print_r($this->ldap->authenticate('' , $username, $password));
        if($this->ldap->authenticate('' , $username, $password)) {
            $userdata = $this->ldap->get_data($username,$password);
            if($userdata['ou'] == 'students') {
                //coop student and student
                $data['fullname'] = $userdata['fname'].' '.$userdata['lname'];                
                if($this->Coop_Student->get_coop_student($userdata['code'])) {
                    //coop student
                    $data['login_type'] = 'coop_student';
                } else {
                    //student
                    $this->insert_new_student($userdata['code']);
                    $data['login_type'] = 'student';                    
                }
                $data['login_value'] = $userdata['code'];

                // get thai name
                $student = $this->Student->get_student($userdata['code']);
                // print_r($student);
                $data['user_fullname'] = $student['student_prefix'].$student['student_fullname'];
                
            } else if($userdata['ou'] == 'staff') {
                //teacher and officer
                //check in teacher
                $adviser = $this->Adviser->get_adviser($userdata['code']);                
                if($adviser) {
                    $data['login_type'] = 'adviser';
                    $data['login_value'] = $userdata['code'];       
                    $data['user_fullname'] = $adviser['adviser_fullname'];
                } else {
                    $officer = $this->Officer->get_officer($userdata['code']);
                    if($officer) {
                        $data['login_type'] = 'officer';
                        $data['login_value'] = $userdata['code'];     
                        $data['user_fullname'] = $officer['officer_fullname'];                   
                    }
                }
            } else {
                //test login, mockup function
                return $this->xlogin($username, $password);
                return false;
            }
        } else {
            return $this->xlogin($username, $password);
            return false;
        }
        return $data;
    }

    public function get($login_type, $login_value)
    {
        if($login_type == 'student') {
            $this->db->where('student_id', $login_value);
            $this->db->from('tb_student');
            $query = $this->db->get();
            return $query->result_array();
        } else if($login_type == 'coop_student') {
            $this->db->join('tb_coop_student', 'tb_coop_student.student_id = tb_student.student_id');
            $this->db->where('tb_student.student_id', $login_value);
            $this->db->from('tb_student');
            $query = $this->db->get();
            return $query->result_array();
        } else if($login_type == 'adviser') {
            $this->db->where('adviser_id', $login_value);
            $this->db->from('tb_adviser');
            $query = $this->db->get();
            return $query->result_array();
        } else if($login_type == 'officer') {
            //check teacher first
            $this->db->where('adviser_id', $login_value);
            $this->db->from('tb_adviser');
            $query = $this->db->get();
            if($query->result_array()) {
                $arr = [];
                foreach($query->result_array() as $row) {
                    $row['is_adviser'] = 1;
                    $arr[] = $row;
                }
                return $arr;
            }
            //after, check officer lists

            $this->db->where('officer_id', $login_value);
            $this->db->from('tb_officer');
            $query = $this->db->get();
            return $query->result_array();
        } else if($login_type == 'company') {
            // $this->db->join('company_person', 'company_person.id = company_person_id');            
            $this->db->where('person_username', $login_value);
            $this->db->from('tb_company_person');
            $query = $this->db->get();
            // echo $this->db->last_query();
            return $query->result_array();
        }
    }

    public function insert_new_student($student_code)
    {
        if(!$this->Student->get_student($student_code)) {
            // get current term
            $this->db->query("SET @USERNAME = 'LDAP Login'");
            $term_id = $this->Term->get_current_term()[0]['term_id'];                        

            // get data from api
            $api_profile = $this->Student->get_student_data_from_profile($student_code);

            // insert a new student
            $department_id = $this->Student->search_department_by_course($api_profile['Course']);

            $insert_student = [
                'student_id' => $student_code,
                'student_prefix' => $api_profile['Student_Prefix'],
                'student_fullname' => $api_profile['Student_Name_Th'].' '.$api_profile['Student_Lname_Th'],
                'term_id' => $term_id,
                'department_id' => $department_id,
                'student_gpax' => $api_profile['GPAX'],
                'coop_status_id' => 1,
                'company_status_id' => 1,
                'student_course' => $api_profile['Course'],
                'student_core_subject_status' => 0,
                'student_created' => date('Y-m-d H:i:s'),
                'student_core_subject_status' => 'system'
            ];
            $this->Student->insert_student($insert_student);
        }
    }

}