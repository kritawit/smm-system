<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('reportmodel');
        $this->load->model('studentmodel');
        $this->load->library('sendsms');
        $this->load->library('thaiformat');
        $this->load->library('excel');
    }
    public function absent_person(){
        $this->load->view('report/absent_person/index');
    }
    public function main_absent(){
        $this->load->view('report/absent/main_absent');
    }
    public function main_late(){
        $this->load->view('report/late/main_late');
    }
    public function form_absent_day() {
        $this->load->view('report/late/form_find_day');
    }
    public function form_absent_peple() {
        $this->load->view('report/late/form_find_peple');
    }
    public function form_day() {
        $this->load->view('report/late/form_find_day');
    }
    public function form_peple() {
        $this->load->view('report/late/form_find_peple');
    }

    public function search_absent_day(){

        $condition =  array();
        $data = array();
        $condition = $this->input->post();
        $rs = $this->reportmodel->getByDayAbsent($condition);
        if ($rs == "false") {
            echo "no-data";
        }else if ($rs == "holiday") {
            echo "holiday";
        }else{
            $data['data'] = $rs;
            $this->load->view('report/absent/result_by_day', $data);
        }
    }

    public function search_by_day() {
        $data = array();
        $val = array();
        $val = $this->input->post();
        $rs = $this->reportmodel->get_by_day($val);

        if ($rs == "false") {
            echo "no-data";
        }else if ($rs == "holiday") {
            echo "holiday";
        } else {
            $data["data"] = $rs;
            // print_r($data);
            $this->load->view('report/late/result_by_day', $data);
        }
    }
    public function search_by_peple() {
        $val = array();
        $val = $this->input->post();
        $rs = $this->reportmodel->get_by_peple($val);

    }

    public function sendAllSMSAbsent(){
        $rsprofile = array();
        $rs_send = array();
        $stuidx = $this->input->post('stuidx');
        $abdate = $this->input->post('abdate');
        $rsprofile = $this->reportmodel->getProfile($stuidx);
        $i=0;
        foreach ($rsprofile as $data) {
            $dateab = $this->thaiformat->DateThai($abdate);
            $message = $data['STU_TITLE'].$data['STU_FNAME'].' '.$data['STU_LNAME'].' ไม่มาแสกนลายนิ้วมือ '.trim($dateab,', 00:00');
            $numphone = $data['STU_PTEL'];
            // print_r($message);
            if(!empty($numphone)){
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

    public function sendSMSAbsent(){
        $rs = array();
        $stuidx = $this->input->post('id');
        $abdate = $this->input->post('abdate');
        // print_r($abdate);
        $a = array();
        $b = array();
        $rs = $this->reportmodel->getProfile($stuidx);
        $dateabsent = $this->thaiformat->DateThai($abdate);

        $message = $rs[0]['STU_TITLE'].$rs[0]['STU_FNAME'].' '.$rs[0]['STU_LNAME'].' ไม่มาแสกนลายนิ้วมือ '.trim($dateabsent,', 00:00');
        $numphone = $rs[0]['STU_PTEL'];

        $this->sendsms->username = 'c00875';
        $this->sendsms->password = 'ce8609';
        $a = $this->sendsms->getCredit();
        if ($a[1]=='success') {
            $b = $this->sendsms->send('0000',$numphone, $message);
            if ($b[1]=='success') {
                    echo "success";
            }elseif ($b[1]=='fail') {
                    echo "fail";
            }
        }elseif ($a[1]=='credit-out') {
                echo "credit-out";
        }
    }

    public function sendSMS(){

    	$rs = array();
    	$numphone = null;
    	$a = array();
    	$b = array();
    	$stuidx = $this->input->post('id');
    	$timeaccidx = $this->input->post('idtime');
    	$ratedatetime = $this->reportmodel->infoRate($timeaccidx);
    	if (!empty($ratedatetime)) {
    		$rs = $this->reportmodel->getProfile($stuidx);
    		$datetimeacc = $this->thaiformat->DateThai($ratedatetime);
    		$message = $rs[0]['STU_TITLE'].$rs[0]['STU_FNAME'].' '.$rs[0]['STU_LNAME'].' ลงเวลาการมาเรียนสาย '.$datetimeacc;
    		$numphone = $rs[0]['STU_PTEL'];

    		$this->sendsms->username = 'c00875';
    		$this->sendsms->password = 'ce8609';

    		$a = $this->sendsms->getCredit();

			if ($a[1]=='success') {
				$b = $this->sendsms->send('0000',$numphone, $message);
				if ($b[1]=='success') {
					echo "success";
				}elseif ($b[1]=='fail') {
					echo "fail";
				}
			}elseif ($a[1]=='credit-out') {
				echo "credit-out";
			}
    	}
    }
    public function exportLate(){
    	$rs = array();
    	$stuidx = $this->input->post('stuidx');
    	$rs = $this->reportmodel->getAllProfileSMS($stuidx,null);
    	if ($rs) {
    		$this->export_late($rs);
    	}
    }
     public function export_late($data = array()) {
        if (!empty($data)) {

            $phpExcel = new excel();
            $prestasi = $phpExcel->setActiveSheetIndex(0);

            //merger
            $phpExcel->getActiveSheet()->mergeCells('A1:I1');

            //manage row hight
            $phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);

            //style alignment
            $styleArray = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),);
            $phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $phpExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);

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
            $prestasi->setCellValue('A1', 'รายงาน การลงเวลามาเรียน');
            $phpExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray);
            $phpExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray1);
            $phpExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray12);
            $prestasi->setCellValue('A2', 'No');
            $prestasi->setCellValue('B2', 'รหัส');
            $prestasi->setCellValue('C2', 'คํานําหน้าชื่อ');
            $prestasi->setCellValue('D2', 'ชื่อ-นามสกุล');
            $prestasi->setCellValue('E2', 'ปีการศึกษา');
            $prestasi->setCellValue('F2', 'ห้องเรียน');
            $prestasi->setCellValue('G2', 'วันที่ เวลา');
            $prestasi->setCellValue('H2', 'สถานะ');
            $prestasi->setCellValue('I2', 'เบอร์โทรผู้ปกครอง');
            $no = 0;
            $rowexcel = 2;
            foreach ($data as $row) {
                $no++;
                $rowexcel++;
                $phpExcel->getActiveSheet()->getStyle('A' . $rowexcel.':J' . $rowexcel)->applyFromArray($styleArray);
                $phpExcel->getActiveSheet()->getStyle('A' . $rowexcel.':J' . $rowexcel)->applyFromArray($styleArray1);
                $prestasi->setCellValue('A' . $rowexcel, $no);
                $prestasi->setCellValue('B' . $rowexcel, $row['STU_CODE']);
                $prestasi->setCellValue('C' . $rowexcel, $row['STU_TITLE']);
                $prestasi->setCellValue('D' . $rowexcel, $row['STU_FNAME'].' '.$row['STU_LNAME']);
                $prestasi->setCellValue('E' . $rowexcel, $row['GRADE_NAME']);
                $prestasi->setCellValue('F' . $rowexcel, $row['CLASS_NUM']);
                $prestasi->setCellValue('G' . $rowexcel, $row['DATETIME_ACC']);
                $prestasi->setCellValue('H' . $rowexcel, $row['TIME_TYPE']);
                $prestasi->setCellValue('I' . $rowexcel, $row['STU_PTEL']);
            }
            $prestasi->setTitle('รายงาน รายชื่อนักเรียน');
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"report_student_late.xls\"");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
			$path = '../report_student_late.xls';
            $objWriter->save($path);

            $response = array(
     			'success' => true,
     			'url' => $path
 			);
 			echo json_encode($response);
 			exit();
            // $objWriter->save("php://output");
        }
    }

    public function sendAllSMS(){
    	$rs = array();
    	$rs_send = array();
    	$a = array();
    	$b = array();
    	$stuidx = $this->input->post('stuidx');
    	$timeidx = $this->input->post('timeidx');
    	$rs = $this->reportmodel->getAllProfileSMS($stuidx,$timeidx);
    	$i=0;
    	foreach ($rs as $data) {
    		$datetimeacc = $this->thaiformat->DateThai($data['DATETIME_ACC']);
    		$message = $data['STU_TITLE'].$data['STU_FNAME'].' '.$data['STU_LNAME'].' ลงเวลาการมาเรียนสาย '.$datetimeacc;
    		$numphone = $data['STU_PTEL'];
    		if(!empty($numphone)){
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
}

/* End of file report.php */

/* Location: ./application/controllers/report.php */
