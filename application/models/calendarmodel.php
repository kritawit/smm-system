<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendarmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	function geteventcalendar(){
		$where = '';
		if ($this->session->userdata('LEVELIDX')!=1) {
			$where .= 'AND LOCAIDX = '.$this->session->userdata('LOCAIDX');
		}
		$sql = "SELECT * FROM tbl_calendar WHERE CAL_ACTIVE = 1 $where ORDER BY CAL_DATE DESC";
		$q = $this->db->query($sql);
		$out = array();
		foreach($q->result() as $row) {
    	$out[] = array(
        	'id' => $row->CALIDX,
        	'title' => $row->CAL_NAME,
        	'class'=>'event-success',
        	'url' => '',
        	'start' => strtotime($row->CAL_DATE) . '000',
        	'end' => strtotime($row->CAL_DATE) .'000'
    	);
		}
		echo json_encode(array('success' => 1, 'result' => $out));
	}

	function delCalendar($id=null){

		$sql = "DELETE FROM tbl_calendar
		WHERE HOLIDX IN(".$id.") ";
		$sql .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');


		if($this->db->query($sql)){
			return true;
		}else{
			return false;
		}
	}
	function getallcalendar($data=null){

		$where = '';
		if ($data != null) {
			$locaidx = $this->session->userdata('LOCAIDX');
			$where .= ' AND CALIDX IN ('.$data.') AND LOCAIDX = '.$locaidx;
		}

		$sql = "SELECT * FROM tbl_calendar WHERE CAL_ACTIVE = 1 $where ORDER BY CAL_DATE DESC";
		// print_r($sql);
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}else{
			return false;
		}
	}

	function saveCalendar($data = array()){

		$memidx =$this->session->userdata('MEMIDX');
		$locaidx = $this->session->userdata('LOCAIDX');

		if ($data['calidx']!=null) {
			$value = array(
               	'MEMIDX' => $memidx,
				'CAL_NAME' => $data['cal_name'],
				'LOCAIDX' => $locaidx,
            );
			$this->db->where('CALIDX', $data['calidx']);
			if($this->db->update('tbl_calendar', $value)){
				return 'true';
			}else{
				return "save data error!";
			}
		}else{
			$value = array(
				'MEMIDX' => $memidx,
				'CAL_NAME' => $data['cal_name'],
				'CAL_DATE' => $data['cal_date'],
				'LOCAIDX' => $locaidx,
		 	);


			$where ="WHERE CAL_DATE = '".$data['cal_date']."'";
			$where .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

			$sql = "SELECT * FROM tbl_calendar $where";

			$q = $this->db->query($sql);

			if ($q->num_rows() == 0) {
				if($this->db->insert('tbl_calendar', $value)){
					return 'true';
				}else{
					return "save data error!";
				}
			}else{
				return $data['cali_date'].' วันหยุดซ้ำ!';
			}
		}
	}

	function getCalendarType(){
		$sql = "SELECT * FROM tbl_calendar_type WHERE CALT_ACTIVE = 1";
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}else{
			return "data is empty!";
		}
	}
}

/* End of file calendarmodel.php */
/* Location: ./application/models/calendarmodel.php */