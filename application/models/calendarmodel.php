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
		// if ($this->session->userdata('LEVELIDX')!=1) {
		// 	$where .= 'AND LOCAIDX = '.$this->session->userdata('LOCAIDX');
		// }
		// $sql = "SELECT * FROM tbl_calendar WHERE CAL_ACTIVE = 1 $where 
		// ORDER BY CAL_DATE DESC";
		$sql = "select CALIDX,CAL_DATE,c.CAL_COLOUR,c.CALTIDX,IFNULL(c.CAL_NAME,t.CALT_NAME)AS CAL_NAME from tbl_calendar c\n".
"LEFT JOIN tbl_calendar_type t\n".
"ON c.CALTIDX = t.CALTIDX\n".
"WHERE c.CAL_ACTIVE = 1\n".
"AND t.CALT_ACTIVE = 1";

		$q = $this->db->query($sql);
		$out = array();
		foreach($q->result() as $row) {
    	$out[] = array(
        	'id' => $row->CALIDX,
        	'title' => $row->CAL_NAME,
        	'class'=>$row->CAL_COLOUR,
        	'url' => '',
        	'start' => strtotime($row->CAL_DATE) . '000',
        	'end' => strtotime($row->CAL_DATE) .'000'
    	);
		}
		echo json_encode(array('success' => 1, 'result' => $out));
	}

	function delCalendar($id=null){

		$sql = "DELETE FROM tbl_calendar
		WHERE CALIDX IN(".$id.") ";
		// $sql .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');


		if($this->db->query($sql)){
			return true;
		}else{
			return false;
		}
	}
	function geteditcalendar($data=null){

		$where = '';
		if ($data != null) {
			// $locaidx = $this->session->userdata('LOCAIDX');
			// $where .= ' AND CALIDX IN ('.$data.') AND LOCAIDX = '.$locaidx;
			$where .= ' WHERE c.CALIDX IN ('.$data.') ';
		}

		// $sql = "SELECT * FROM tbl_calendar WHERE CAL_ACTIVE = 1 $where ORDER BY CAL_DATE DESC";


		$sql ="select * \n".
"from tbl_calendar c \n".
"LEFT JOIN tbl_calendar_type ct\n".
"ON c.CALTIDX = ct.CALTIDX $where ORDER BY c.CAL_DATE DESC";


		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}else{
			return false;
		}
	}
	function getallcalendar($data=null){

		$where = '';
		if ($data != null) {
			// $locaidx = $this->session->userdata('LOCAIDX');
			// $where .= ' AND CALIDX IN ('.$data.') AND LOCAIDX = '.$locaidx;
			$where .= ' AND c.CALIDX IN ('.$data.') ';
		}

		// $sql = "SELECT * FROM tbl_calendar WHERE CAL_ACTIVE = 1 $where ORDER BY CAL_DATE DESC";


		$sql ="select c.CALIDX, \n".
"IFNULL(c.CAL_NAME,ct.CALT_NAME)AS TYPE,c.CAL_DATE\n".
"from tbl_calendar c \n".
"LEFT JOIN tbl_calendar_type ct\n".
"ON c.CALTIDX = ct.CALTIDX $where ORDER BY c.CAL_DATE DESC";



		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		}else{
			return false;
		}
	}

	function saveCalendar($data = array()){

		$memidx =$this->session->userdata('MEMIDX');
		// $locaidx = $this->session->userdata('LOCAIDX');

		if (!empty($data['calidx'])) {

			if (!empty($data['caltidx'])) {
				$value = array(
               		'MEMIDX' => $memidx,
					'CALTIDX' => $data['caltidx'],
					'CAL_DATE' => $data['cal_date'],
					'CAL_COLOUR' => $data['cal_colour'],
					'CAL_NAME' => NULL,
            	);
			}else{
				$value = array(
               		'MEMIDX' => $memidx,
					'CAL_NAME' => $data['cal_name'],
					'CAL_DATE' => $data['cal_date'],
					'CAL_COLOUR' => $data['cal_colour'],
            	);
			}

			$this->db->where('CALIDX', $data['calidx']);
			if($this->db->update('tbl_calendar', $value)){
				return 'true';
			}else{
				return "Save data error!";
			}
		}else{
			if (!empty($data['caltidx'])) {
				$value = array(
               		'MEMIDX' => $memidx,
					'CALTIDX' => $data['caltidx'],
					'CAL_DATE' => $data['cal_date'],
					'CAL_COLOUR' => $data['cal_colour'],
            	);
			}else{
				$value = array(
               		'MEMIDX' => $memidx,
					'CAL_NAME' => $data['cal_name'],
					'CAL_DATE' => $data['cal_date'],
					'CAL_COLOUR' => $data['cal_colour'],
            	);
			}

			$where ="WHERE CAL_DATE = '".$data['cal_date']."'";
			// $where .= " AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

			$sql = "SELECT * FROM tbl_calendar $where";

			$q = $this->db->query($sql);

			if ($q->num_rows() == 0) {
				if($this->db->insert('tbl_calendar', $value)){
					return 'true';
				}else{
					return "save data error!";
				}
			}else{
				return $data['cal_date'].' วันหยุดซ้ำ!';
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