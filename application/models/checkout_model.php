<?php
class Checkout_model extends CI_Model{
	protected $table_name;
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'auto_ads';
	}
	
	
	
	function save(&$data, $id=false)
	{
		

			if ($this->db->insert($this->table_name,$data)) {
			 $data['id'] = $this->db->insert_id(); 
				return $data['id'];
			}else return false;
		
	}
	
	function update($id){
			$this->db->where('ids',$id);
			return $this->db->update($this->table_name,array( 'status'=>'1'));
	}
	
	
	function get_info($id)
	{
		$query = $this->db->get_where($this->table_name,array('ids'=>$id,'status'=>'1'));
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else {
			return false;
		}
	}
}
?>

