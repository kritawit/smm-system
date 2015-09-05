<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('Datatables');
        $this->load->library('table');
    }
 
    function index()
    {
            
    }
 
    //function to handle callbacks
    function datatable()
    {
        $this->datatables->select('stu_id,stu_name,stu_last')
            ->unset_column('stu_id')
            ->add_column('Actions', get_buttons('$1'), 'stu_id')
            ->from('student');
 
        echo $this->datatables->generate();
    }
}