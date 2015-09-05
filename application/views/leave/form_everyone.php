<form id="frmLeave" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="stu_title" class="col-lg-2 control-label"><b>ปีการศึกษา : </b></label>
      <div class="col-lg-10" id="gradename" style="width:300px;">

      </div>
    </div>
    <div class="form-group">
      <label for="stu_title" class="col-lg-2 control-label"><b>ห้องเรียน : </b></label>
      <div class="col-lg-10" id="classrm" style="width:200px;">

      </div>
    </div>
    <div class="form-group">
      <label for="classidx"  class="col-lg-2 control-label"><b>ประเภทการลา : </b></label>
      <div class="col-lg-10" id="leavetype" style="width:270px;">

      </div>
    </div>
    <div class="form-group inline">
    <label for="stu_fname"  class="col-lg-2 control-label"><b>วันที่หยุด : </b></label>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="fdate" value=""  required="required" id="fdate" class="form-control" placeholder="จาก วันที่"/>
  </div>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="tdate" value=""  required="required" id="tdate" class="form-control" placeholder="ถึง วันที่"/>
  </div>
    </div>
    <div class="form-group">
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> ยืนยันการลา</button>
        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <div id="loading1"></div>
      </div>
    </div>
</fieldset>
</form>
<div id="alert">
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>รหัส นักเรียน</strong><p id="desc"></p>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $("#alert").hide();
    var dateToday = new Date();
      $('#fdate').datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date){
            var selectedDate = new Date(date);
            var msecsInADay = 86400000;
            var endDate = new Date(selectedDate.getTime() + msecsInADay);
            $("#tdate").datepicker( "option", "minDate", endDate );
        }
    });
    $('#tdate').datepicker({
          dateFormat: "yy-mm-dd",
    });

    var options = {
        // target:        '#',
        // beforeSubmit: '', // pre-submit callback 
        success: function(data) {
            if (data == 'success') {
              alert('success');
              $("#alert").hide();
            }else if(data == 'fail'){
              alert('fail');
            }else {
              $("#alert").show();
              $("#desc").html(data+" ได้ทำการลาซ้ำ");
            }
        },
        url: '<?php echo base_url() ?>leave/add_leave', // override for form's 'action' attribute 
        type: 'POST',
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true, // clear all form fields after successful submit
        resetForm: true
    };

    $('#frmLeave').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
  });
</script>