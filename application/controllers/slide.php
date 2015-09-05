<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slide extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('slidemodel');
		$this->load->model('newsmodel');
		$this->load->library('upload');
	}

	public function index()
	{
		$rs['data'] = $this->slidemodel->getslideshow();
		$this->load->view('slide/index',$rs);
	}

	public function delete(){
		$idx = $this->input->get('slideidx');
		$rs = $this->slidemodel->delslide($idx);
		if ($rs) {
			redirect('slide','refresh');
			exit();
		}
	}

	public function editform(){
		$idx = $this->input->get('slideidx');
		$rs['data'] = $this->slidemodel->getbyidx($idx);
		$this->load->view('slide/editform',$rs);
	}
	public function showslide(){
		$this->load->view('slide/show');
	}

	public function slidedata(){
		$data['data'] = $this->slidemodel->getdataslide();
		$this->load->view('slide/contentslide', $data);
	}

	public function slideimg(){
		$rs['data'] = $this->slidemodel->getallslide();
		$this->load->view('slide/slide_img', $rs);
	}

	public function slidenews(){
		$rs['news'] = $this->newsmodel->getusesnews();
		$this->load->view('slide/slide_news',$rs);
	}

	public function slideform(){
		$this->load->view('slide/slideform');
	}

	public function add(){
		$value = array();
		$value = $this->input->post();
		$rs = $this->slidemodel->addslide($value);
		if ($rs == 'true') {
			echo 'success';
		} else if($rs == 'false') {
			$this->session->flashdata('error','save slide denied!');
			redirect('slide/slideform','refresh');
		}
	}

	public function do_upload(){
			$config = array();
			$config['upload_path'] = "assets/images/slide";
			$config['allowed_types'] = "*";
			$config['max_size'] = 50000;
			$config['max_height'] = 2000;
			$config['max_width'] = 2000;

			$this->upload->initialize($config);

			if ($this->upload->do_upload("Filedata")) {
				$data = $this->upload->data();
				$newName =  date("YmdHis").rand(0000001,999999). $data['file_ext'];
				rename($data['full_path'], $data['file_path'].$newName);

                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->upload->upload_path.$newName;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 650;
                $config['height'] = 490;
                $this->load->library('image_lib',$config);
                if (!$this->image_lib->resize()){
                	$this->session->set_flashdata('errors', $this->image_lib->display_errors('', ''));
            	}else{
            		$val = array('SLIDE' => $newName);
            		$rs = $this->slidemodel->addslide($val);
            	}
			} else {
				$this->session->set_flashdata('errors', $this->upload->display_errors());
				redirect('','refresh');
			}
	}

}

/* End of file slide.php */
/* Location: ./application/controllers/slide.php */