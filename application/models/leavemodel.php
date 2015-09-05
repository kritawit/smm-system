<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leavemodel extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
    public function add_leave($data = array()){
    	if (!empty($data)) {
    		$ins = array();

			$ins['STU_CODE'] = $data['stu_code'];
			$ins['LEAVE_TYPEIDX'] = $data['leave_typeidx'];
			$ins['FDATE'] = $data['fdate'];
			$ins['TDATE'] = $data['tdate'];
			$ins['CREATE_BY'] = 1;
			$ins['LOCAIDX'] = 1;

			$rs = $this->db->insert("TBL_LEAVE", $ins);
			if ($rs) {
				return true;
			}else{
				return false;
			}
    	}
    }

    public function setcancel($data   = array()){

        $where = '';
        $val = '';
        if (!empty($data)) {
            $val = $data['selected'];
            $where .= " AND LEAVEIDX IN ($val)";
        }

        $this->db->trans_start();
        $sql = "UPDATE TBL_LEAVE SET LEAVE_ACTIVE = 0 WHERE 1=1  $where";
        $this->db->query($sql);
        $this->db->trans_complete();

        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            return true;
        }
    }

    public function search($data = array()){
        $where = '';
        $fdate = '';
        $tdate = '';
        $leave_type = '';
        $stu_code = array();
        if (!empty($data)) {
            $fdate = $data['fdate'];
            $tdate = $data['tdate'];
            $where .= ' AND GRADEIDX = '.$data['gradeidx'];
            if (!empty($data['classidx'])) {
                $where .= ' AND CLASSIDX = '.$data['classidx'];
            }
            if (!empty($data['leave_typeidx'])) {
                $leave_type = $data['leave_typeidx'];
            }
        }
        $sql_stu = "SELECT * FROM TBL_STUDENT WHERE 1=1 $where ";
        $q_stu = $this->db->query($sql_stu);
        if ($q_stu->num_rows() > 0) {
            $i=0;
            foreach ($q_stu->result_array() as $row){
                $stu_code[$i] = $row['STU_CODE'];
                $i++;
            }
            $stu_in = '';
            if ($i > 1) {
                $stu_in = implode(',',$stu_code);
            } else {
                $stu_in = $stu_code[0];
            }
            $sql_leave = "SELECT  l.LEAVEIDX,l.STU_CODE,s.STU_LNAME,s.STU_FNAME,t.LEAVE_NAME,l.FDATE,l.TDATE  FROM tbl_leave l
            INNER JOIN tbl_student s ON l.STU_CODE = s.STU_CODE
            INNER JOIN tbl_leavetype t ON l.LEAVE_TYPEIDX = t.LEAVE_TYPEIDX
            WHERE l.LEAVE_ACTIVE = 1 AND l.STU_CODE IN ($stu_in)
            AND (FDATE BETWEEN '$fdate' AND '$tdate'
                AND TDATE BETWEEN '$fdate' AND '$tdate')";
            if (!empty($data['leave_typeidx'])) {
                $sql_leave .= " AND l.LEAVE_TYPEIDX = ".$leave_type ;
            }
            // print_r($sql_leave);

            $q_leave = $this->db->query($sql_leave);
            if ($q_leave->num_rows()>0) {
                return $q_leave->result_array();
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function check_duplicate($data = array()){
            $where = '';
            if (!empty($data)) {
                $stu_code = $data['stu_code'];
                $fdate = $data['fdate'];
                $tdate = $data['tdate'];
            }
            $sql = "SELECT * FROM TBL_LEAVE WHERE STU_CODE = '$stu_code' 
            AND (FDATE BETWEEN '$fdate' AND '$tdate')
            OR (TDATE BETWEEN '$fdate' AND '$fdate')";

            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                return true;
            }else{
                return false;
            }
    }

    public function get_leavetype() {
        $sql = "SELECT * FROM TBL_LEAVETYPE WHERE LEAVE_TYPE_ACTIVE = 1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else {
            return false;
        }
    }

    public function get_id_student($q) {

    	$where = $q;

        $sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1 AND S.STU_CODE LIKE '$where%'";
        $q = $this->db->query($sql);
        $row_set = array();
        $new_row = array();
        if ($q->num_rows > 0) {
        	 foreach ($q->result_array() as $row){
                preg_replace('/\s+/', '', $row['STU_FNAME']);
        		$new_row['label']=htmlentities(stripslashes($row['STU_CODE']));
        		$new_row['name']=htmlentities(stripslashes(preg_replace('/\s+/', '', $row['STU_FNAME']).' '.preg_replace('/\s+/', '', $row['STU_LNAME'])));
        		$new_row['grade_name']=htmlentities(stripslashes($row['GRADE_NAME']));
        		$new_row['class_num']=htmlentities(stripslashes($row['CLASS_NUM']));
        		$row_set[] = $new_row; //build an array
      		}
      		echo json_encode($row_set);
        }
        else {
            return false;
        }
    }
    public function get_name_student($q) {

    	$where = $q;

        $sql = "SELECT * FROM TBL_STUDENT S INNER JOIN TBL_GRADE G  ON S.GRADEIDX = G.GRADEIDX  INNER JOIN TBL_CLASS C  ON S.CLASSIDX = C.CLASSIDX  WHERE S.STU_ACTIVE = 1 AND S.STU_FNAME like '%$where%' OR S.STU_LNAME like '%$where%'";
        $q = $this->db->query($sql);
        $row_set = array();
        $new_row = array();
        if ($q->num_rows > 0) {
        	 foreach ($q->result_array() as $row){
        	 	$new_row['stu_code']=htmlentities(stripslashes($row['STU_CODE']));
        		$new_row['label']=htmlentities(stripslashes($row['STU_FNAME'].' '.$row['STU_LNAME']));
        		$new_row['name']=htmlentities(stripslashes($row['STU_FNAME'].' '.$row['STU_LNAME']));
        		$new_row['grade_name']=htmlentities(stripslashes($row['GRADE_NAME']));
        		$new_row['class_num']=htmlentities(stripslashes($row['CLASS_NUM']));
        		$row_set[] = $new_row;
      		}
      		echo json_encode($row_set);
        }
        else {
            return false;
        }
    }
}

/* End of file leavemodel.php */

/* Location: ./application/models/leavemodel.php */
