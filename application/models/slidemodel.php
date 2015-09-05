<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slidemodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	function getallslide(){

		$where = '';
		// $locaidx = $this->session->userdata('LOCAIDX');
		// $where .= ' WHERE LOCAIDX = '.$locaidx;
		$sql = "SELECT SLIDE_ACTIVE,SLIDEIDX,SLIDE,CREATE_DATE,SLIDE_TYPE,
		CASE WHEN SLIDE_ACTIVE = 1 THEN 'Active'
            WHEN SLIDE_ACTIVE = 0 THEN 'None-Active'
        END AS STATUS
         FROM tbl_slide $where ORDER BY SLIDE_TYPE";

		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		} else {
			return false;
		}
	}
	function getslideshow(){
		$where = '';
		// $locaidx = $this->session->userdata('LOCAIDX');
		// $where .= ' WHERE LOCAIDX = '.$locaidx;
		$sql = "SELECT SLIDE_ACTIVE,SLIDEIDX,SLIDE,CREATE_DATE,SLIDE_TYPE,
		CASE WHEN SLIDE_ACTIVE = 1 THEN 'Active'
            WHEN SLIDE_ACTIVE = 0 THEN 'None-Active'
        END AS STATUS
         FROM tbl_slide $where AND SLIDE_ACTIVE = 1 ORDER BY SLIDE_TYPE DESC";
		if ($q = $this->db->query($sql)) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	function getbyidx($data=null){
		$this->db->select('SLIDE,SLIDE_TYPE');
		$this->db->where('SLIDEIDX', $data);
		// $this->db->where('LOCAIDX', $this->session->userdata('LOCAIDX'));
		$qs = $this->db->get('tbl_slide');
		return $qs->result_array();
	}

	function delslide($data=null){
		$this->db->select('SLIDE,SLIDE_TYPE');
		$this->db->where('SLIDEIDX', $data);
		// $this->db->where('LOCAIDX', $this->session->userdata('LOCAIDX'));
		$qs = $this->db->get('tbl_slide');
		$arr = $qs->result_array();
		if($arr[0]['SLIDE_TYPE']==1){
			@unlink("assets/images/slide/".$arr[0]['SLIDE']);
		}

		$sql = "DELETE FROM tbl_slide
		WHERE SLIDEIDX IN(".$data.") AND LOCAIDX = ".$this->session->userdata('LOCAIDX');

		if($this->db->query($sql)){
			return true;
		}else{
			return false;
		}
	}

	function addslide($data = array()){
		if (empty($data['video_link'])) {
			$v = array(
				'SLIDE_TYPE' => 1,
				'SLIDE'=>$data['SLIDE'],
				'MEMIDX'=>$this->session->userdata('MEMIDX'),
				// 'LOCAIDX'=> $this->session->userdata('LOCAIDX'),
			);
		} else {
			$v = array(
				'SLIDE_TYPE' => 2,
				'SLIDE'=> $data['video_link'],
				'MEMIDX'=>$this->session->userdata('MEMIDX'),
				// 'LOCAIDX'=> $this->session->userdata('LOCAIDX'),
			);
		}

		if($this->db->insert('tbl_slide', $v)){
			return 'true';
		}else{
			return 'false';
		}
	}

	function getdataslide(){
		// $locaidx = '';
		// $locaidx .= $this->session->userdata('LOCAIDX');
		$sql = "select g.GRADEIDX,\n".
"(\n".
"	SELECT COUNT(sg.STUIDX) FROM tbl_student sg \n".
"	WHERE sg.GRADEIDX = g.GRADEIDX \n".
"	AND sg.STU_ACTIVE = 1\n".
")AS COUNT_STU,\n".
"(\n".
"SELECT COUNT(*) FROM tbl_timeacc ac \n".
"LEFT JOIN tbl_student sd\n".
"ON ac.STU_CODE = sd.STU_CODE\n".
"WHERE ac.DATETIME_TYPE IN (2,3) AND sd.GRADEIDX = g.GRADEIDX\n".
"AND ac.DATETIME_DATE = CURDATE()\n".
")AS COUNTLATE,\n".
"(\n".
"select count(*) from tbl_student h,tbl_leave l \n".
"WHERE h.STU_CODE = l.STU_CODE and h.GRADEIDX = g.GRADEIDX AND (CURDATE() BETWEEN l.FDATE AND l.TDATE)\n".
")as COUNTL,\n".
"(\n".
"SELECT COUNT(*) FROM (SELECT f.STUIDX,f.STU_TITLE,g.GRADEIDX,g.SHORT_NAME,g.GRADE_NAME,\n".
"C.CLASS_NUM,f.STU_CODE,f.STU_FNAME,f.STU_LNAME \n".
"FROM tbl_student F LEFT JOIN tbl_grade G ON f.GRADEIDX = G.GRADEIDX \n".
"LEFT JOIN tbl_class C ON f.CLASSIDX = C.CLASSIDX \n".
"WHERE ( f.STU_CODE NOT IN ( SELECT STU_CODE FROM tbl_timeacc WHERE DATETIME_DATE BETWEEN CURDATE() AND CURDATE()))) T1 \n".
"WHERE T1.GRADEIDX = g.GRADEIDX \n".
"AND T1.STU_CODE NOT IN ( SELECT STU_CODE FROM tbl_leave \n".
"WHERE LEAVE_ACTIVE = 1 AND CURDATE() BETWEEN FDATE AND TDATE)\n".
")AS COUNTAB\n".
", g.SHORT_NAME,g.GRADE_NAME\n".
"from tbl_grade g,tbl_student s,tbl_leave l where \n".
"g.GRADEIDX = s.GRADEIDX \n".
// "and s.LOCAIDX = $locaidx \n".
"and GRADE_ACTIVE = 1\n".
"GROUP BY g.GRADEIDX,g.SHORT_NAME,g.GRADE_NAME";
	// print_r($sql);
		if($q = $this->db->query($sql)){
			return $q->result_array();
		}else{
			return false;
		}
	}
}

/* End of file slidemodel.php */
/* Location: ./application/models/slidemodel.php */