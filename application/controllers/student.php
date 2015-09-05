<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('studentmodel');
        $this->load->model('reportmodel');
        $this->load->library('sendsms');
        $this->load->library('excel');
    }
    public function index() {
        $this->load->view('student/index');
    }

    public function sendSMS(){
        $rsprofile = array();
        $rs_send = array();
        $stuidx = $this->input->post('stuidx');
        $mess = $this->input->post('word');
        $rsprofile = $this->reportmodel->getProfile($stuidx);
        $i=0;
        foreach ($rsprofile as $data) {
            $message = $mess;
            if(!empty($data['STU_PTEL'])){
                $numphone = $data['STU_PTEL'];
                $this->sendsms->username = 'c00875';
                $this->sendsms->password = 'ce8609';
                $a = $this->sendsms->getCredit();
                if ($a[1]=='success') {
                        $b = $this->sendsms->send('0000',$numphone, $message);
                        if ($b[1]=='success') {
                            $rs_send[$i] = 'success';
                        }elseif ($b[1]=='fail') {
                            $rs_send[$i] = "fail";
                        }
                }elseif ($a[1]=='credit-out') {
                        $rs_send[$i] =  "credit-out";
                }
            }
            $i++;
        }
        if (in_array('credit-out',$rs_send)) {
            echo "credit-out";
        }else{
            if (in_array('fail',$rs_send)) {
                echo "fail";
            }else{
                echo "success";
            }
        }
    }


    public function import_form() {
        $this->load->view('student/form_import');
    }

    public function export_form() {
        $this->load->view('student/form_export');
    }

    public function export_excel() {

        $data = array();
        $rs = array();
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($data['condition'] == 1) {
                $rs = $this->studentmodel->get_student($data);
                // print_r($rs);
                $this->export_data($rs);
            }
            else if ($data['condition'] == 2) {
                $data = null;
                $rs = $this->studentmodel->get_student($data);
                // print_r($rs);
                $this->export_data($rs);
            }
        }
    }

    public function export_data($data = array()) {
        if (!empty($data)) {

            $phpExcel = new excel();
            $prestasi = $phpExcel->setActiveSheetIndex(0);

            //merger
            $phpExcel->getActiveSheet()->mergeCells('A1:L1');

            //manage row hight
            $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);

            //style alignment
            $styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),);
            $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $phpExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);

            //border
            $styleArray1 = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            //background
            $styleArray12 = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'FFEC8B',),),);

            //freeepane
            $phpExcel->getActiveSheet()->freezePane('A3');

            //coloum width
            $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.1);
            $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
            $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $phpExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
            $phpExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            $prestasi->setCellValue('A1', 'รายงาน รายชื่อนักเรียน');
            $phpExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray);
            $phpExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray12);
            $prestasi->setCellValue('A2', 'No');
            $prestasi->setCellValue('B2', 'รหัส');
            $prestasi->setCellValue('C2', 'คํานําหน้าชื่อ');
            $prestasi->setCellValue('D2', 'ชื่อ-นามสกุล');
            $prestasi->setCellValue('E2', 'รหัสบัตรประชาชน');
            $prestasi->setCellValue('F2', 'วันเกิด');
            $prestasi->setCellValue('G2', 'ปีการศึกษา');
            $prestasi->setCellValue('H2', 'ห้องเรียน');
            $prestasi->setCellValue('I2', 'ที่อยู่');
            $prestasi->setCellValue('J2', 'เบอร์โทรนักเรียน');
            $prestasi->setCellValue('K2', 'เบอร์โทรผู้ปกครอง');
            $prestasi->setCellValue('L2', 'วันที่เข้าเรียน');
            $no = 0;
            $rowexcel = 2;
            foreach ($data as $row) {
                $no++;
                $rowexcel++;
                $phpExcel->getActiveSheet()->getStyle('A' . $rowexcel.':L' . $rowexcel)->applyFromArray($styleArray);
                $phpExcel->getActiveSheet()->getStyle('A' . $rowexcel.':L' . $rowexcel)->applyFromArray($styleArray1);
                $prestasi->setCellValue('A' . $rowexcel, $no);
                $prestasi->setCellValue('B' . $rowexcel, $row['STU_CODE']);
                $prestasi->setCellValue('C' . $rowexcel, $row['STU_TITLE']);
                $prestasi->setCellValue('D' . $rowexcel, $row['STU_FNAME'].' '.$row['STU_LNAME']);
                $prestasi->setCellValue('E' . $rowexcel, $row['ID_CARD']);
                $prestasi->setCellValue('F' . $rowexcel, $row['BIRTH_DATE']);
                $prestasi->setCellValue('G' . $rowexcel, $row['GRADE_NAME']);
                $prestasi->setCellValue('H' . $rowexcel, $row['CLASS_NUM']);
                $prestasi->setCellValue('I' . $rowexcel, $row['STU_ADD']);
                $prestasi->setCellValue('J' . $rowexcel, $row['STU_TEL']);
                $prestasi->setCellValue('K' . $rowexcel, $row['STU_PTEL']);
                $prestasi->setCellValue('L' . $rowexcel, $row['STU_INDATE']);
            }
            $prestasi->setTitle('รายงาน รายชื่อนักเรียน');
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"Students Report.xls\"");
            header("Cache-Control: max-age=0");
            $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
            $objWriter->save("php://output");
        }
    }
    
    public function import_excel() {
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        
        $objReader->setReadDataOnly(true);
        
        $config['upload_path'] = "assets/files/import_student";
        $config['allowed_types'] = "xls|xlsx";
        $config['max_size'] = 1024;
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload("file_excel")) {
            $data = $this->upload->data();
            $newname = $data['file_path'] . date("YmdHis") . $data['file_ext'];
            rename($data['full_path'], $newname);

            $objPHPExcel = $objReader->load($newname);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $state = true;
            for ($i = 2; $i <= 100; $i++) {
                $STU_CODE = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
                $LOCAIDX = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
                $GRADEIDX = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                $CLASSIDX = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
                $STU_TITLE = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
                $ID_CARD = $objWorksheet->getCellByColumnAndRow(5, $i)->getValue();
                $BIRTH_DATE = $objWorksheet->getCellByColumnAndRow(6, $i)->getValue();
                $STU_FNAME = $objWorksheet->getCellByColumnAndRow(7, $i)->getValue();
                $STU_LNAME = $objWorksheet->getCellByColumnAndRow(8, $i)->getValue();
                $STU_GENDER = $objWorksheet->getCellByColumnAndRow(9, $i)->getValue();
                $STU_ADD = $objWorksheet->getCellByColumnAndRow(10, $i)->getValue();
                $STU_PASS = $objWorksheet->getCellByColumnAndRow(11, $i)->getValue();
                $STU_TEL = $objWorksheet->getCellByColumnAndRow(12, $i)->getValue();
                $STU_PTEL = $objWorksheet->getCellByColumnAndRow(13, $i)->getValue();
                $STU_EMAIL = $objWorksheet->getCellByColumnAndRow(14, $i)->getValue();
                $STU_PEMAIL = $objWorksheet->getCellByColumnAndRow(15, $i)->getValue();
                $STU_INDATE = $objWorksheet->getCellByColumnAndRow(16, $i)->getFormattedValue();
                $STU_INDATE = date("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($STU_INDATE));
                $CREATE_BY = $objWorksheet->getCellByColumnAndRow(17, $i)->getValue();
                $UPDATE_BY = $objWorksheet->getCellByColumnAndRow(18, $i)->getValue();

                if (!empty($STU_CODE) && !empty($LOCAIDX) && !empty($GRADEIDX) && !empty($CLASSIDX)) {

                    $rs = $this->studentmodel->get_stucode($STU_CODE);

                    if ($rs) {
                        $data_user = array(
                            "STU_CODE" => $STU_CODE, 
                            "LOCAIDX" => $LOCAIDX, 
                            "GRADEIDX" => $GRADEIDX, 
                            "CLASSIDX" => $CLASSIDX, 
                            "STU_TITLE" => $STU_TITLE, 
                            "STU_FNAME" => $STU_FNAME, 
                            "STU_LNAME" => $STU_LNAME, "STU_GENDER" => $STU_GENDER, 
                            "STU_ADD" => $STU_ADD, "STU_PASS" => $STU_PASS, 
                            "STU_TEL" => $STU_TEL, "STU_PTEL" => $STU_PTEL, 
                            "STU_EMAIL" => $STU_EMAIL, "STU_PEMAIL" => $STU_PEMAIL, 
                            "STU_INDATE" => $STU_INDATE, "CREATE_BY" => $CREATE_BY, 
                            "UPDATE_BY" => $UPDATE_BY,
                            "ID_CARD" => $ID_CARD,
                            "BIRTH_DATE"=>$BIRTH_DATE
                        );
                        $rs = $this->studentmodel->add_student($data_user);
                        if (!$rs) {
                            $state = false;
                            exit();
                        }
                    }
                    else {
                        echo "duplicate";
                        exit();
                    }
                }
            }
        }
        else {
            echo "fail_upload";
            exit();
        }
        if ($state == true) {
            echo "success";
        }
        else {
            echo "fail";
        }
    }
    
    public function ajax_request() {
        $rs = array();
        $rs = $this->studentmodel->get_all_student();
        echo json_encode($rs);
    }
    
    public function save() {
        $val = array();
        if (!empty($this->input->post('stuidx'))) {
            
            $val = $this->input->post();
            $rs = $this->studentmodel->update_student($val);
            if ($rs) {
                echo "success";
            } 
            else {
                echo "fail";
            }
        } 
        else {
            $val = $this->input->post();
            $rs = $this->studentmodel->add_student($val);
            if ($rs) {
                echo "success";
            }
            else {
                echo "fail";
            }
        }
    }
    
    public function add() {
        $this->load->view('student/form_add');
    }
    
    public function edit() {
        $rs = array();
        
        $stuidx = $this->input->get('stuidx');

        
        $rs['rs'] = $this->studentmodel->get_edit_student($stuidx);
        
        $this->load->view('student/form_edit', $rs);
    }
    
    public function delete() {
        $stuidx = $this->input->post('stuidx');
        $rs = $this->studentmodel->del_student($stuidx);
        if ($rs) {
            echo 'success';
        }
        else {
            echo 'fail';
        }
    }
    
    public function grade() {
        
        $rs = array();
        
        $rs['rs'] = $this->studentmodel->get_grade();
        
        $this->load->view('template/_grade', $rs);
    }
    
    public function classroom() {
        
        $rs = array();
        
        $rs['rs'] = $this->studentmodel->get_class();
        
        $this->load->view('template/_class', $rs);
    }
    
    public function classex() {
        $rs = array();
        
        $rs['rs'] = $this->studentmodel->get_class();
        
        $this->load->view('student/class_ex', $rs);
    }
    
    public function validcode() {
        if ($this->input->post()) {
            
            $stucode = $this->input->post('code');
            
            // print_r($stucode);
            $rs = $this->studentmodel->get_stucode($stucode);
            
            if ($rs) {
                echo "success";
            }
            else {
                echo "fail";
            }
        }
    }

}

/* End of file student.php */

/* Location: ./application/controllers/student.php */
