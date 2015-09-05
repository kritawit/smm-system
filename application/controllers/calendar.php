<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('calendarmodel');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = array();
		$data['data'] = $this->calendarmodel->getallcalendar();
		$this->load->view('calendar/index',$data);
	}

	public function calendar_type(){
		$data = array();
		$data['data'] = $this->calendarmodel->getCalendarType();
		$this->load->view('calendar/calendar_type', $data);
	}

	public function viewcalendar(){
		$this->load->view('calendar/calendar');
	}

	public function eventcalendar(){
		$this->calendarmodel->geteventcalendar();
	}

	public function calendarform(){
		$rs = array();
		if (!empty($this->input->get())) {
			$calidx = $this->input->get('calidx');
			$rs['data'] = $this->calendarmodel->getallcalendar($calidx);
			// print_r($rs);
		}
		$rs['type'] = $this->calendarmodel->getCalendarType();
		$this->load->view('calendar/add',$rs);
	}
	public function calendareditform(){
		$rs = array();
		if (!empty($this->input->get())) {
			$calidx = $this->input->get('calidx');
			$rs['data'] = $this->calendarmodel->geteditcalendar($calidx);
		}
		$rs['type'] = $this->calendarmodel->getCalendarType();
		$this->load->view('calendar/edit',$rs);
	}
	public function add(){
		$val = array();
		$val = $this->input->post();

		// print_r($val);
		$rs = $this->calendarmodel->saveCalendar($val);

		if ($rs == 'true') {
			$this->session->set_flashdata('message_success', 'Add calendar success.');
			redirect('calendar/calendarform','refresh');
		}else{
			$this->session->set_flashdata('message', $rs);
			redirect('calendar/calendarform','refresh');
		}
	}
	public function delete(){
		$value = $this->input->get('calidx');
		// print_r($value);
		$rs = $this->calendarmodel->delCalendar($value);
		if ($rs) {
			redirect('calendar','refresh');
		}
	}
}

/* End of file calendar.php */
/* Location: ./application/controllers/calendar.php */