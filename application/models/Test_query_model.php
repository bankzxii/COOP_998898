
<?php
class Test_query_model extends CI_Model {
 
 public function getdata(){

 	$where = 'tb_company_address.company_address_longitude IS NOT NULL';
 	$this->db->select('tb_company_address.company_id, tb_company.company_name_th, tb_company_address.company_address_latitude, tb_company_address.company_address_longitude');
 	$this->db->from('tb_company_address');
 	$this->db->join('tb_company', 'tb_company_address.company_id = tb_company.company_id');
 	$this->db->where($where);
	$query = $this->db->get();
    return $query->result_array();
 }

 // public function getLocation($company_id)
 // {
 // 	$this->db->select('company_id,company_address_longitude,company_address_latitude');
 // 	$this->db->from('tb_company_address');
 // 	$this->db->where('company_id', $company_id);
 // 	$query = $this->db->get();
 // 	return $query->result_array();	
 // }
 
}
?>