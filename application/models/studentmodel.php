<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studentmodel extends CI_Model {

	public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}
	public function get_all_student(){
		$sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1";
		$q = $this->db->query($sql);

		// print_r($sql);

		$output = array(
			"data" => array(),
		);

		if ($q->num_rows > 0) {
			$output['data'] = $q->result();
			foreach($output['data'] as $d) {
        		$d->href = '<a href="' . site_url("student/delete" . $d->STUIDX) . '" class="editor_remove" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i></a>';
    		}
			return $output;
		}
		else {
			return false;
		}
	}

	public function add_student($data = array())
	{
		if (!empty($data)) {

			$ins = array();

			$ins = $data;
			$ins['LOCAIDX'] = 1;

			$rs = $this->db->insert("TBL_STUDENT", $ins);
			if ($rs) {
				return true;
			}else{
				return false;
			}
		}
	}

	public function update_student($data = array()){
		if (!empty($data)) {
			$ins = array();
			$ins = $data;
			// print_r($ins);
			$this->db->where("STUIDX", $ins['stuidx']);
			$rs = $this->db->update("TBL_STUDENT", $ins);
			if ($rs) {
				return true;
			}else{
				return false;
			}
		}
	}

	public function get_edit_student($id=null){
		$where = "";

		if (!empty($id)) {
			$where .= " AND STUIDX = '$id' ";
		}
		$sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  
		INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1 $where";

		// $sql = "SELECT * FROM TBL_STUDENT where 1=1 $where ";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}

	}

	public function del_student($data = null){
		if ($data != null) {
			$this->db->where("STUIDX", $data);
			$rs = $this->db->delete("TBL_STUDENT");
			if ($rs) {
				return true;
			}else{
				return false;
			}
		}
	}

	public function get_grade(){

		$sql = "SELECT * FROM TBL_GRADE WHERE GRADE_ACTIVE = 1";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function get_class(){
		$sql = "SELECT * FROM TBL_CLASS WHERE CLASS_ACTIVE = 1";
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_stucode($data =null){
		$where = '';
		if ($data != null) {
			$where .= " AND STU_CODE = '$data' ";
			$sql = "SELECT * FROM TBL_STUDENT WHERE 1=1 $where AND STU_ACTIVE = 1 ";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}

	public function get_student($data = array()){
		$where = '';
		if (!empty($data)) {
			$grade = $data['gradeidx'];
			$where .= " AND S.GRADEIDX = '$grade' ";
			if (!empty($data['classidx'])) {
				$classidx = $data['classidx'];
				$where .= " AND S.CLASSIDX = '$classidx' ";
			}
			if (!empty($data['stu_indate'])) {
				$stu_indate = $data['stu_indate'];
				$date = date_format($stu_indate,"Y/m/d");
				$where .= " AND S.STU_INDATE = '$date'";
			}
		}

		$sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1 $where";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
}