<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set('Asia/Bangkok');
	}

	public function authentication($data = array()){

		if (!empty($data)){
			$username = $this->security->xss_clean($data['username']);
			$password = $this->security->xss_clean($data['password']);
			$location = $this->security->xss_clean($data['location']);
		}

		$this->db->select('*');
        $this->db->from('tbl_member m');
		$this->db->join('tbl_location l', 'm.LOCAIDX = l.LOCAIDX', 'left');
        $this->db->join('tbl_level v', 'm.LEVELIDX = v.LEVELIDX', 'left');
		$this->db->where('m.MEM_USER', $username);
		$this->db->where('m.MEM_PASS', $password);
		$this->db->where('m.LOCAIDX',$location);


		$query = $this->db->get();
		if ($query->num_rows() > 0) {

			$row = $query->row();

			$data = array(
				'MEMIDX' => $row->MEMIDX,
				'LOCAIDX' => $row->LOCAIDX,
				'LOCA_NAME' => $row->LOCA_NAME,
				'MEM_FNAME' => $row->MEM_FNAME,
				'MEM_LNAME' => $row->MEM_LNAME,
				'MEM_PIC' => $row->MEM_PIC,
				'LEVEL_TYPE' => $row->LEVEL_TYPE,
				'validated' => true
			);

			$this->session->set_userdata($data);
			$now = date('Y-m-d H:i:s');
			$value = array(
				'MEM_LAST_LOGIN' => $now,
			);

			$this->db->where('MEMIDX', $row->MEMIDX);
			$this->db->update('tbl_member', $value);

			return true;
		}
		return false;
	}

}

/* End of file member.php */
/* Location: ./application/models/member.php */