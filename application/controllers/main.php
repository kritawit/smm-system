<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('studentmodel');
        $this->load->model('location');
        $this->load->model('member');
    }
    public function index()
    {
        $arr = array();
        $data = $this->location->get_location();

        $arr['model'] = $data;

        $validated = $this->session->userdata('validated');
        if ($validated) {
            $this->load->view('main/index');
        }else{
            $this->load->view('main/login', $arr);
        }
    }
    public function login(){
        if ($this->input->post()!=null) {
            $arr = $this->input->post();
            $rs = $this->member->authentication($arr);
            if ($rs) {
                $this->load->view('main/index');
            } else {
                echo $result = 'fail';
            }
        }
    }

    public function logout(){
        // print_r('Hello');
        $this->session->sess_destroy();
        // print_r($this->session->userdata('login_id'));
        redirect('','refresh');
        exit();
    }

    private function check_isvalidated() {
        $validated = $this->session->userdata('validated');
        if ($validated) {
            
        }
    }

    public function ajax_request()  {
    	$rs = array();
    	$rs = $this->studentmodel->get_all_student();
    	echo json_encode($rs);
	}

    public function get_grade_norequired(){
        $rs = array();
        
        $rs['rs'] = $this->studentmodel->get_grade();
        
        $this->load->view('template/grade_no_required', $rs);
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */