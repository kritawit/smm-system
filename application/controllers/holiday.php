<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('holidaymodel');
	}
	public function index()
	{
		$data = array();
		$data['data'] = $this->holidaymodel->getallcalendar();
		$this->load->view('holiday/index',$data);
	}

	public function calendar(){
		$this->load->view('holiday/calendar');
	}

	public function eventcalendar(){
		$this->holidaymodel->geteventcalendar();
	}

	public function holidayform(){
		$rs = array();
		if (!empty($this->input->get())) {
			$holidx = $this->input->get('holidx');
			$rs['data'] = $this->holidaymodel->getallholiday($holidx);
			print_r($rs);
		}
		$this->load->view('holiday/add',$rs);
	}
	public function add(){
		$val = array();
		$val = $this->input->post();
		$rs = $this->holidaymodel->saveHoliday($val);
		if ($rs == 'true') {
			$this->session->set_flashdata('alert', '');
			redirect('holiday','refresh');
		}else{
			$this->session->set_flashdata('alert', $rs);
			redirect('holiday/holidayform','refresh');
		}
	}

	public function delete(){
		$value = $this->input->get('holidx');
		// print_r($value);
		$rs = $this->holidaymodel->delHoliday($value);
		if ($rs) {
			redirect('holiday','refresh');
		}
	}
}

/* End of file holiday.php */
/* Location: ./application/controllers/holiday.php */