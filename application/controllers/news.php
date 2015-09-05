<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('newsmodel');
	}
	public function index()
	{
		$rs['data'] = $this->newsmodel->getallnews();
		$this->load->view('news/index',$rs);
	}
	public function newsform(){
		if (!empty($this->input->get())) {
			$val = $this->input->get('newidx');
			$rs['data'] = $this->newsmodel->getbyidx($val);
			$this->load->view('news/edit',$rs);
		} else {
			$this->load->view('news/add');
		}
	}

	public function save(){
		$arr = $this->input->post();
		$rs = $this->newsmodel->saveas($arr);
		if ($rs == 'true') {
			redirect('news','refresh');
		} else {
			$this->session->set_flashdata('error',$rs);
			redirect('news/newsform','refresh');
			exit();
		}
	}

	public function editsave(){
		$arr = $this->input->post();
		$rs = $this->newsmodel->saveEdit($arr);
		if ($rs == 'true') {
			redirect('news','refresh');
		} else {
			$this->session->set_flashdata('error',$rs);
			redirect('news/newsform','refresh');
			exit();
		}
	}

	public function deleteNew(){
		$idx = $this->input->get('newidx');
		$rs = $this->newsmodel->delete($idx);
		if ($rs=='true') {
			redirect('news','refresh');
		} else {
			$this->session->set_flashdata('error',$rs);
			redirect('news','refresh');
			exit();
		}
	}
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */