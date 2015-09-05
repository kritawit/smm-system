<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>slide">ย้อนกลับ</a>
    </li>
    <li class="active">slide form</li>
  </ol>
  <legend>Form แก้ไข Slide</legend>
  <?php for ($i = 0; $i < count($data); $i++) :?>
  	<img width="650" height="650" src="<?php echo IMG ?>slide/<?php echo $data[$i]["SLIDE"]?>" alt="">
  <?php endfor; ?>
 </div>
<?php $this->load->view('template/footer'); ?>