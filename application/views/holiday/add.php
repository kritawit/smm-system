<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <legend>Add Holiday</legend>
        <?php if(!empty($this->session->flashdata('alert'))): ?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong><?php echo $this->session->flashdata('alert'); ?></strong>
				</div>
				<?php endif; ?>
				<form id="frmHoliday" method="POST" action="<?php echo base_url() ?>holiday/add" class="form-horizontal" role="form" enctype="multipart/form-data">
  				<fieldset>
    			<div class="form-group inline">
    			<label for="holi_date"  class="col-lg-3 control-label"><b>วันที่ : </b></label>
  				<div class="col-md-4" style="width:200px;">
    			<input type="text" required="required" name="holi_date" value="<?php if(!empty($data[0]['HOLI_DATE'])){ ?><?php echo $data[0]['HOLI_DATE']; ?><?php } ?>"  readonly id="holi_date" class="form-control" <?php if(!empty($data[0]['HOLI_DATE'])){ echo 'disabled'; }?> placeholder="วันที่ หยุด"/>
  				<input type="hidden" name="holidx" value="<?php if(!empty($data[0]['HOLIDX'])): ?><?php echo $data[0]['HOLIDX']; ?><?php endif; ?>">
  				</div>
    			</div>
    			<div class="form-group inline">
    			<label for="holi_name"  class="col-lg-3 control-label"><b>ชื่อ วันหยุด : </b></label>
  				<div class="col-md-6" >
    			   <input type="text" name="holi_name" value="<?php if(!empty($data[0]['HOLI_NAME'])): ?><?php echo $data[0]['HOLI_NAME']; ?><?php endif; ?>"  required="required" id="holi_name" class="form-control" placeholder="ชื่อ วันหยุด"/>
  				</div>
    			</div>
    			<hr>
    			<div class=" form-group">
            <label class="col-lg-3"></label>
      			<div class="col-md-6">
        			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> บันทึก</button>
        			<a type="reset" href="<?php echo base_url() ?>holiday" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
      			</div>
    			</div>
    			</fieldset>
    			</form>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
  $(function() {
    datePick();
  });

  function datePick(){
    $('#holi_date').datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: 'today',
        });
  }
</script>