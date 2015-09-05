<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller
{
    var $data_old = array();

    public function __construct() {
        parent::__construct();
        //Do your magic here
        $this->load->model('leavemodel');
        $this->load->model('studentmodel');
    }
    public function index() {
        $this->load->view('leave/form_leave');
    }
    public function search_form(){
        $this->load->view('leave/form_search');
    }
    public function cancelLeave(){
        $leaveidx = array();
        $leaveidx['selected'] = $this->input->post('leaveidx');
        $rs = $this->leavemodel->setcancel($leaveidx);
        if ($rs) {
            echo "success";
        } else {
            echo "fail";
        }
    }
    public function cancel_select(){
        // $leaveidx = '';
        $leaveidx = $this->input->post();
        // print_r($leaveidx);
        $rs = $this->leavemodel->setcancel($leaveidx);
        if ($rs) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function add_leave() {
        $val = array();
        $valall = array();
        $result = array();
        $data = array();
        $chkd = array();
        $stu_code = array();
        if ($this->input->post()) {
            $val = $this->input->post();
            if (!empty($val['gradeidx'])) {
                $valall = $this->studentmodel->get_student($val);
                if (!empty($valall)) {
                	$i = 0;
                    foreach ($valall as $row) {
                    	$chkd['stu_code'] = $row['STU_CODE'];
                    	$chkd['fdate'] = $val['fdate'];
                    	$chkd['tdate'] = $val['tdate'];
                    	$dup = $this->leavemodel->check_duplicate($chkd);
                    	if ($dup == false) {
                    		$data['stu_code'] = $row['STU_CODE'];
                        	$data['leave_typeidx'] = $val['leave_typeidx'];
                        	$data['fdate'] = $val['fdate'];
                        	$data['tdate'] = $val['tdate'];
                        	$rs = $this->leavemodel->add_leave($data);
                        	if ($rs) {
                        		$result[$i] = "success";
                        	}else{
                        		$result[$i] = "fail";
                        	}
                    	}else{
                    		$result[$i] = "duplicate";
                    		$stu_code[$i] = $row['STU_CODE'];
                    		// break;
                    	}
                        $i++;
                    }
                    if (!in_array("fail",$result,true)) {
                    	if (!in_array("duplicate", $result,true)) {
                    		echo "success";
                    	} else {
                    		$dup = implode(' , ',$stu_code);
                    		echo $dup;
                    	}
                    }else{
                    	echo "fail";
                    }
                }
            }
            else {
            	$dup = $this->leavemodel->check_duplicate($val);
            	if ($dup == false) {
            		$rs = $this->leavemodel->add_leave($val);
                	if ($rs) {
                    	echo "success";
                	}
                	else {
                    	echo "fail";
                	}
            	} else {
            		echo $val['stu_code'];
            	}
            }
        }
    }
    public function search_leave(){
        $arr = array();
        $data = array();
        $item = array();
        if ($this->input->post()) {
            $arr =$this->input->post();
            $this->session->set_userdata($arr);
            $item = $this->leavemodel->search($arr);
            if ($item == false) {
                echo "no-data";
            } else {
                $data["data"] = $item;
                $this->load->view('leave/result_search', $data);
            }
        }
    }

    public function search_old(){

        $data = array();
        $item = array();
        $arr  = array();
        $arr = $this->session->all_userdata();
        $item = $this->leavemodel->search($arr);

        if ($item == false) {
            $array_items = array(
                'gradeidx' => '',
                'classidx' => '',
                'leave_typeidx'=>'',
                'fdate'=>'',
                'tdate'=>''
            );
            $this->session->unset_userdata($array_items);
            echo "no-data";
        } else {
            $data["data"] = $item;
            $this->load->view('leave/result_search', $data);
        }
    }

    public function report(){
    	$this->load->view('leave/report');
    }

    public function form_onlyone() {
        $this->load->view('leave/form_onlyone');
    }

    public function form_everyone() {
        $this->load->view('leave/form_everyone');
    }

    public function leavetype() {
        $rs = array();
        $rs['rs'] = $this->leavemodel->get_leavetype();
        $this->load->view('template/_leavetype', $rs);
    }
    public function search_leavetype() {
        $rs = array();
        $rs['rs'] = $this->leavemodel->get_leavetype();
        $this->load->view('leave/search_leavetype', $rs);
    }
    public function getprofile_byid() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->leavemodel->get_id_student($q);
        }
    }
    public function getprofile_byname() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->leavemodel->get_name_student($q);
        }
    }
}

/* End of file leave.php */

/* Location: ./application/controllers/leave.php */
