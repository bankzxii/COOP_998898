<?php
// fix ldap
class Change_pwd_model extends CI_Model 
{
    public function Change_pwd()
    {
            $password_gen = $_POST['New_pwd'];
            $password_gen_db = password_hash($password_gen, PASSWORD_DEFAULT);
            $this->db->where('person_username',$_POST['email']);
            return $this->db->update('tb_company_person', [
                'person_password' => $password_gen_db
            ]);
    }

    public function get_company_person($username)
    {
        $this->db->where('person_username',$username);
        $this->db->from('tb_company_person');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Change_pwd_company_person($username)
    {   
        $password_gen = $_POST['new_pass'];
        $password_gen_db = password_hash($password_gen, PASSWORD_DEFAULT);
        $this->db->where('person_username' ,$username);
        return $this->db->update('tb_company_person', [
            'person_password' => $password_gen_db
        ]);
    }

}
