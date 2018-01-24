<?php
class Company_person_login_model extends CI_model
{
    var $table_name;
    var $primary_key;
    

    public function __construct(){
        parent::__construct();
        $this->table_name = 'company_person_login';
        $this->primary_key = 'company_person_id';
    }

    public function get($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->from($this->table_name);
        $query = $this->db->get();
        return $query->result()[0];
    }

    public function get_by_username($username)
    {
        $this->db->where('username', $username);
        $this->db->from($this->table_name);
        $query = $this->db->get();
        return $query->result()[0];
    }    

    public function gets()
    {
        $this->db->from($this->table_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function add($array)
    {
        return $this->db->insert($this->table_name, $array);
    }

    public function update($id, $array)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table_name, $array);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);        
        return $this->db->delete($this->table_name);
    }


    public function login($username, $password) 
    {
        $this->db->select('password');
        $this->db->where('username', $username);
        $this->db->from('company_person_login');
        $query = $this->db->get();
        $row = $query->result()[0];
        if(password_verify($password, $row->password))
            return $row;

        return false;
    }
}