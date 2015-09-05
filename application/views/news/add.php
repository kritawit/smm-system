<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <legend>เพิ่ม News</legend>
        <?php if(!empty($this->session->flashdata('error'))): ?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong><?php echo $this->session->flashdata('error'); ?></strong>
				</div>
        <?php endif; ?>
				<form id="frmNews" method="POST" action="<?php echo base_url(); ?>news/save" class="form-horizontal" role="form" enctype="multipart/form-data">
  				<fieldset>
    			<div class="form-group inline">
    			<label for="holi_date"  class="col-lg-3 control-label"><b>ข้อความข่าว (255 ตัวอักษร) : </b></label>
  				<div class="col-md-6">
    			<textarea name="new" required maxlength="249" cols="60" rows="10" class="form-control"></textarea>
  				<input type="hidden" name="holidx" value="">
  				</div>
    			</div>
    			<hr>
    			<div class=" form-group">
            <label class="col-lg-3"></label>
      			<div class="col-md-6">
        			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> บันทึก</button>
        			<a type="reset" href="<?php echo base_url(); ?>news" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
      			</div>
    			</div>
    			</fieldset>
    		</form>
</div>
<?php $this->load->view('template/footer'); ?>