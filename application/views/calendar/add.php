<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <legend>Add Calendar</legend>
        <?php if(!empty($this->session->flashdata('alert'))): ?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong><?php echo $this->session->flashdata('alert'); ?></strong>
				</div>
				<?php endif; ?>
				<form id="frmHoliday" method="POST" action="<?php echo base_url() ?>calendar/add" class="form-horizontal" role="form" enctype="multipart/form-data">
  				<fieldset>
    			<div class="form-group inline">
    			<label for="cal_date"  class="col-lg-3 control-label"><b>วันที่ : </b></label>
  				<div class="col-md-4" style="width:200px;">
    			<input type="text" required="required" name="cal_date" value="<?php if(!empty($data[0]['CAL_DATE'])){ ?><?php echo $data[0]['CAL_DATE']; ?><?php } ?>"  readonly id="cal_date" class="form-control" <?php if(!empty($data[0]['CAL_DATE'])){ echo 'disabled'; }?> placeholder="วันที่"/>
  				<input type="hidden" name="calidx" value="<?php if(!empty($data[0]['CALIDX'])): ?><?php echo $data[0]['CALIDX']; ?><?php endif; ?>">
  				</div>
    			</div>
          <div class="form-group inline">
            <label for="cal_name"  class="col-lg-3 control-label"><b>ประเภท  : </b></label>
            <div class="col-md-3" >
          <select name="caltidx" id="caltidx" class="form-control" required="required">
          <option value="" selected>Please select</option>}
          option
          <?php for ($i = 0; $i < count($type); $i++) :?>
              <option value="<?php echo $type[$i]['CALTIDX']; ?>"><?php echo $type[$i]['CALT_NAME']; ?></option>
            <?php endfor; ?>
          </select>
          <div class="checkbox" >
          <label>
          <input type="checkbox" name="other" id="other" value="0">
              อื่นๆ
          </label>
          </div>
          </div>
          </div>
          <div class="form-group inline" id="panel-other">
          <label for="cal_name"  class="col-lg-3 control-label"><b>ประเภท อื่นๆ : </b></label>
          <div class="col-md-6" >
             <input type="text" name="cal_name" value="<?php if(!empty($data[0]['CAL_NAME'])): ?><?php echo $data[0]['CAL_NAME']; ?><?php endif; ?>"  required="required" id="cal_name" class="form-control" placeholder="ประเภท อื่นๆ"/>
          </div>
          </div>
    			<hr>
    			<div class=" form-group">
            <label class="col-lg-3"></label>
      			<div class="col-md-6">
        			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> บันทึก</button>
        			<a type="reset" href="<?php echo base_url() ?>calendar" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
      			</div>
    			</div>
    			</fieldset>
    			</form>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
  $(function() {
    datePick();
    $("#panel-other").hide();
  });

  function datePick(){
    $('#cal_date').datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: 'today',
        });
  }

  $('#other').change(function () {
    if ($(this).is(':checked')) {
        $("#caltidx").attr('disabled','disabled');
        $("#panel-other").show();
    } else {
        $("#caltidx").removeAttr('disabled');
        $("#panel-other").hide();
    }
});
</script>