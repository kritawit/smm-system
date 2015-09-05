<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	function getallnews(){
		$sql = "SELECT * FROM tbl_new WHERE LOCAIDX = ".$this->session->userdata('LOCAIDX');
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}
	}

	function getusesnews(){
		$sql = "SELECT * FROM tbl_new WHERE NEW_ACTIVE = 1 AND LOCAIDX = ".$this->session->userdata('LOCAIDX');
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	function saveas($data = array()){
			$v = array(
   				'NEW' => $data['new'],
   				'LOCAIDX' => $this->session->userdata('LOCAIDX'),
			);
			if($this->db->insert('tbl_new', $v)){
				return 'true';
			}else{
				return 'Save denied!';
			}
	}

	function saveEdit($data=array()){
			$v = array(
   				'NEW' => $data['new'],
			);
			$this->db->where('NEWIDX',$data['newidx']);
			$this->db->where('LOCAIDX',$this->session->userdata('LOCAIDX'));
			if($this->db->update('tbl_new', $v)){
				return "true";
			}else{
				return "Update denied!";
			}
	}
	function getbyidx($data = null){
		$sql = "SELECT * FROM tbl_new WHERE NEWIDX = ".$data;
		$sql .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

		if ($q=$this->db->query($sql)) {
			return $q->result_array();
		} else {
			return false;
		}
	}
	function delete($data=null){
		$sql = "DELETE FROM tbl_new WHERE NEWIDX = ".$data;
		$sql .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');
		if ($this->db->query($sql)) {
			return 'true';
		}else{
			return 'false';
		}
	}
}

/* End of file newsmodel.php */
/* Location: ./application/models/newsmodel.php */