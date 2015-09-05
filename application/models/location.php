<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
		// $this->load->database();
	}

	public function get_location(){

		$sql = "SELECT * FROM tbl_location where loca_active = 1";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}

/* End of file location.php */
/* Location: ./application/models/location.php */