<?php
// fix ldap
class Forgot_pwd_model extends CI_Model 
{

    public function get_company_person($username)
    {
        $this->db->where('person_username',$username);
        $this->db->from('tb_company_person');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_password($username, $password_gen_db)
    {   
        $this->db->where('person_username' ,$username);
        return $this->db->update('tb_company_person', [
            'person_password' => $password_gen_db
        ]);
    }

}
