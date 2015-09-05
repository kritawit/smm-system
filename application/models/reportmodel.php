<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getByDayAbsent($data = array()){

		$stucode = '';
		$to_date = '';
		$grade = '';
		$class = '';
		$stuname = '';

		if ($data['stu_code']!=null) {
			$stucode .= ' AND S.STU_CODE = '.$data['stu_code'];
		}

		if ($data['to_date']!=null) {
			$to_date = $data['to_date'];
		}

		if ($data['stu_name']!=null) {
			$stu_name = array();
			$stu_name = explode(" ",$data['stu_name']);
			$stuname = " AND ( S.STU_FNAME LIKE '%".$stu_name[0]."%'
				OR S.STU_LNAME LIKE '%".$stu_name[1]."%' ) " ;
		}

		if ($data['gradeidx']!=null) {
			$grade = ' AND S.GRADEIDX = '.$data['gradeidx'];
		}

		if ($data['classidx']!=null) {
			$class = ' AND S.CLASSIDX = '.$data['classidx'];
		}

		$this->db->where('CAL_DATE',$to_date);
		// $this->db->where('LOCAIDX',$this->session->userdata('LOCAIDX'));
		$rq = $this->db->get('tbl_calendar');

		if ($rq->num_rows()==0) {
			$sql = "SELECT T1.* FROM\n".
		"(SELECT S.STUIDX,S.STU_TITLE,'ขาดเรียน' AS STATUS,'$to_date' AS AB_DATE,G.GRADE_NAME,C.CLASS_NUM,s.STU_CODE,s.STU_FNAME,s.STU_LNAME FROM tbl_student s\n".
		"LEFT JOIN tbl_grade G\n".
		"ON S.GRADEIDX = G.GRADEIDX\n".
		"LEFT JOIN tbl_class C\n".
		"ON S.CLASSIDX = C.CLASSIDX\n".
		"WHERE ( \n".
		"S.STU_CODE NOT IN (\n".
		"		SELECT STU_CODE FROM tbl_timeacc WHERE DATETIME_DATE = '$to_date'\n".
		") $stucode ) $stuname \n".
		"$grade $class \n".
		") T1\n".
		"WHERE T1.STU_CODE NOT IN (\n".
		"		SELECT STU_CODE FROM tbl_leave WHERE LEAVE_ACTIVE = 1 \n".
		"		AND '$to_date' BETWEEN FDATE AND TDATE \n".
		")AND weekday(T1.AB_DATE) NOT IN (6, 5)";
		// print_r($sql);
			$q = $this->db->query($sql);
    		if ($q->num_rows()>0) {
        		return $q->result_array();
    		} else {
        		return 'false';
    		}
		}else{
			return "holiday";
		}
	}

	public function getAllProfileSMS($stuidx = null,$timeidx = null){

	$where = '';
	if (!empty($stuidx)) {
		$where .= " AND S.STUIDX in (".$stuidx.")";
	}
	if (!empty($timeidx)) {
		$where .= " AND T.TIME_ACCIDX in (".$timeidx.")";
	}

	$sql = "SELECT T.TIME_ACCIDX,S.STU_PTEL,S.STUIDX,t.STU_CODE,S.STU_TITLE,S.STU_FNAME,
	S.STU_LNAME,G.GRADE_NAME,C.CLASS_NUM,
	CASE
        WHEN T.DATETIME_TYPE = 1 THEN 'ลงเวลาปกติ'
        WHEN T.DATETIME_TYPE = 2 THEN 'ลงเวลาสาย'
        WHEN T.DATETIME_TYPE = 3 THEN 'ลงเวลาขาดเรียน'
        WHEN T.DATETIME_TYPE = 4 THEN 'ลงเวลาเลิกเรียน'
        ELSE 'ไม่สามารถระบุได้'
	END AS TIME_TYPE,
	T.DATETIME_ACC
	FROM tbl_timeacc T
	LEFT JOIN tbl_student S
	ON T.STU_CODE = S.STU_CODE
	LEFT JOIN tbl_grade G
	ON S.GRADEIDX = G.GRADEIDX
	LEFT JOIN tbl_class C
	ON S.CLASSIDX = C.CLASSIDX
	WHERE
	T.TIME_ACC_ACTIVE =1
	AND S.STU_ACTIVE = 1
	AND T.DATETIME_TYPE IN (2,3) $where";
		$q = $this->db->query($sql);
		$result = array();
    	if ($q->num_rows()>0) {
        	return $q->result_array();
    	} else {
        	return false;
    	}
	}

	public function infoRate($idx = null){
		$where = '';
		if (!empty($idx)){
			$where .= " AND TIME_ACCIDX = $idx ";
		}
		$sql = "SELECT * FROM TBL_TIMEACC WHERE TIME_ACC_ACTIVE = 1 $where";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0) {
			foreach ($query->result() as $row)
			{
    			return $row->DATETIME_ACC;
			}
		}
	}

	public function getProfile($id=null){
		$where = "";

		if (!empty($id)) {
			$where .= " AND STUIDX IN ($id) ";
		}
		$sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  
		INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1 $where";
		// print_r($sql);
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_by_day($data = array()){
	$where = '';
	if (!empty($data)) {
		$where .= " AND T.DATETIME_DATE = '".$data['to_date']."'";

		$where .= " AND S.GRADEIDX = ".$data['gradeidx'];

		if ($data['classidx'] != null) {
			$where .= " AND S.CLASSIDX = ".$data['classidx'];
		}

		if($data['stu_code'] != null){
			$where .= " AND T.STU_CODE = ".$data['stu_code'];
		}

		if ($data['stu_name'] != null) {
			$stu_name = array();
			$stu_name = explode(" ",$data['stu_name']);
			$where .= " AND (S.STU_FNAME like '%".$stu_name[0]."%' OR S.STU_LNAME like '%".$stu_name[1]."%' )";
		}
	}

	$this->db->where('CAL_DATE',$data['to_date']);
	// $this->db->where('LOCAIDX',$this->session->userdata('LOCAIDX'));
	$rq = $this->db->get('tbl_calendar');

	if ($rq->num_rows() == 0) {
			$sql = "SELECT T.TIME_ACCIDX,S.STUIDX,t.STU_CODE,S.STU_TITLE,S.STU_FNAME,
			S.STU_LNAME,G.GRADE_NAME,C.CLASS_NUM,
			CASE
        WHEN T.DATETIME_TYPE = 1 THEN 'ลงเวลาปกติ'
        WHEN T.DATETIME_TYPE = 2 THEN 'ลงเวลาสาย'
        WHEN T.DATETIME_TYPE = 3 THEN 'ลงเวลาขาดเรียน'
        WHEN T.DATETIME_TYPE = 4 THEN 'ลงเวลาเลิกเรียน'
        ELSE 'ไม่สามารถระบุได้'
			END AS TIME_TYPE,
			T.DATETIME_ACC
			FROM tbl_timeacc T
			LEFT JOIN tbl_student S
			ON T.STU_CODE = S.STU_CODE
			LEFT JOIN tbl_grade G
			ON S.GRADEIDX = G.GRADEIDX
			LEFT JOIN tbl_class C
			ON S.CLASSIDX = C.CLASSIDX
			WHERE
			T.TIME_ACC_ACTIVE =1
			AND S.STU_ACTIVE = 1
			AND T.DATETIME_TYPE IN (2,3) $where";
			// print_r($sql);
			$q = $this->db->query($sql);
			$result = array();
    		if ($q->num_rows()>0) {
        		return $q->result_array();
    		} else {
        		return "false";
    		}
		}else{
			return "holiday";
		}
	}
	public function get_by_peple($data = array()){
		// print_r($data);
	}

}

/* End of file reportmodel.php */
/* Location: ./application/models/reportmodel.php */