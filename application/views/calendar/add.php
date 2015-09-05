<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>">Home</a>
    </li>
    <li>
      <a href="<?php echo base_url() ?>calendar">ปฏิทิน โรงเรียน (School Calendar)</a>
    </li>
    <li class="active">เพิ่ม ปฏิทิน(Calendar)</li>
  </ol>
  <legend>เพิ่ม ปฏิทิน(Calendar)</legend>
        <?php if(!empty($this->session->flashdata('message_error'))): ?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong><?php echo $this->session->flashdata('message_error'); ?></strong>
				</div>
        <?php elseif(!empty($this->session->flashdata('message_success'))): ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong><?php echo $this->session->flashdata('message_success'); ?></strong>
        </div>
				<?php endif; ?>
				<form id="frmCalendar" method="POST" action="<?php echo base_url() ?>calendar/add" class="form-horizontal" role="form" enctype="multipart/form-data">
  				<fieldset>
    			<div class="form-group inline">
    			<label for="cal_date"  class="col-lg-3 control-label"><b>วันที่ : </b></label>
  				<div class="col-md-4" style="width:200px;">
    			<input type="text"  name="cal_date" value="<?php if(!empty($data[0]['CAL_DATE'])){ ?><?php echo $data[0]['CAL_DATE']; ?><?php } ?>" id="cal_date" class="form-control" <?php if(!empty($data[0]['CAL_DATE'])){ echo 'disabled'; }?> placeholder="วันที่" required="required">
<!--   				<input type="hidden" name="calidx" value="<?php if(!empty($data[0]['CALIDX'])): ?><?php echo $data[0]['CALIDX']; ?><?php endif; ?>">
 -->  				</div>
    			</div>
          <div class="form-group inline">
            <label for="cal_name"  class="col-lg-3 control-label"><b>Remark color  : </b></label>
            <div class="col-md-3" >
          <select name="cal_colour" id="cal_colour" class="form-control" >
          <option value="" selected>Please select</option>
              <option value="event-inverse">inverse</option>
              <option value="event-info">info</option>
              <option value="event-success">success</option>
              <option value="event-warning">warning</option>
              <option value="event-important">important</option>
              <option value="event-special">special</option>
          </select>
          </div>
          </div>
          <div class="form-group inline">
            <label for="cal_name"  class="col-lg-3 control-label"><b>ประเภท  : </b></label>
            <div class="col-md-3" >
          <select name="caltidx" id="caltidx" class="form-control" >
          <option value="" selected>Please select</option>
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
          <div class="form-group inline" id="panel-other" style="display: none;">
          <label for="cal_name"  class="col-lg-3 control-label"><b>ประเภท อื่นๆ : </b></label>
          <div class="col-md-6" >
             <input type="text" name="cal_name" value="<?php if(!empty($data[0]['CAL_NAME'])): ?><?php echo $data[0]['CAL_NAME']; ?><?php endif; ?>"  id="cal_name" class="form-control" placeholder="ประเภท อื่นๆ"/>
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
    // $("#panel-other").hide();
    $("#cal_name").attr('disabled','disabled');
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
        $("#cal_name").removeAttr('disabled');
    } else {
        $("#caltidx").removeAttr('disabled');
        $("#cal_name").attr('required','required');
        $("#panel-other").hide();
    }
});
</script>