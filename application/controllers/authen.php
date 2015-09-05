<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authen extends CI_Controller {

	public function index()
	{
		
		$this->load->view('main/login');
	}
	public function login(){
		if ($this->input->post('bt')!=null) {
			// print_r($this->input->post());
			$this->session->set_userdata(array('login_id' => '01'));
			redirect('','refresh');
		}else{
			$this->load->view('login');
		}
	}

	public function logout(){
		// print_r('Hello');
		$this->session->sess_destroy();
		// print_r($this->session->userdata('login_id'));
		redirect('','refresh');
		exit();
	}
}

/* End of file authen.php */
/* Location: ./application/controllers/authen.php */