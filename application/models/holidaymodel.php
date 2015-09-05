<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holidaymodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	function geteventcalendar(){
		$where = '';
		$where .= 'AND LOCAIDX = '.$this->session->userdata('LOCAIDX');
		$sql = "SELECT * FROM tbl_holiday WHERE HOLI_ACTIVE = 1 $where ORDER BY HOLI_DATE DESC";
		$q = $this->db->query($sql);
		$out = array();
		foreach($q->result() as $row) {
    	$out[] = array(
        	'id' => $row->HOLIDX,
        	'title' => $row->HOLI_NAME,
        	'class'=>'event-success',
        	'url' => '',
        	'start' => strtotime($row->HOLI_DATE) . '000',
        	'end' => strtotime($row->HOLI_DATE) .'000'
    	);
		}
		echo json_encode(array('success' => 1, 'result' => $out));
	}

	function delHoliday($id=null){

		$sql = "DELETE FROM tbl_holiday 
		WHERE HOLIDX IN(".$id.") AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

		if($this->db->query($sql)){
			return true;
		}else{
			return false;
		}
	}
	function getallholiday($data=null){

		$where = '';
		if ($data != null) {
			$locaidx = $this->session->userdata('LOCAIDX');
			$where .= ' AND HOLIDX IN ('.$data.') AND LOCAIDX = '.$locaidx;
		}

		$sql = "SELECT * FROM tbl_holiday WHERE HOLI_ACTIVE = 1 $where ORDER BY HOLI_DATE DESC";
		// print_r($sql);
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}else{
			return false;
		}
	}

	function saveHoliday($data = array()){

		$memidx =$this->session->userdata('MEMIDX');
		$locaidx = $this->session->userdata('LOCAIDX');

		if ($data['holidx']!=null) {
			$value = array(
               	'MEMIDX' => $memidx,
				'HOLI_NAME' => $data['holi_name'],
				'LOCAIDX' => $locaidx,
            );
			$this->db->where('HOLIDX', $data['holidx']);
			if($this->db->update('tbl_holiday', $value)){
				return 'true';
			}else{
				return "save data error!";
			}
		}else{
			$value = array(
				'MEMIDX' => $memidx,
				'HOLI_NAME' => $data['holi_name'],
				'HOLI_DATE' => $data['holi_date'],
				'LOCAIDX' => $locaidx,
		 	);


			$where ="WHERE HOLI_DATE = '".$data['holi_date']."'";
			$where .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

			$sql = "SELECT * FROM tbl_holiday $where";

			$q = $this->db->query($sql);

			if ($q->num_rows() == 0) {
				if($this->db->insert('tbl_holiday', $value)){
					return 'true';
				}else{
					return "save data error!";
				}
			}else{
				return $data['holi_date'].' วันหยุดซ้ำ!';
			}
		}
	}

}

/* End of file holidaymodel.php */
/* Location: ./application/models/holidaymodel.php */