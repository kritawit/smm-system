<form id="frmLeave" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="stuidx"  class="col-lg-2 control-label"><b>รหัสนักเรียน : </b></label>
      <div class="col-lg-10" style="width:170px;">
        <input type="text" class="form-control danger" name="stu_code" required="required" id="stu_code" value=""  placeholder="รหัสนักเรียน"/>
      </div>
    </div>
    <div class="form-group inline">
      <label for="stu_name"  class="col-lg-2 control-label"><b>ชื่อ - นามสกุล : </b></label>
      <div class="col-md-4">
        <input type="text" name="stu_name" value=""  required="required" id="stu_name" class="form-control" placeholder="ชื่อ - นามสกุล"/>
      </div>
    </div>
    <div class="form-group">
        <label for="gradeidx"  class="col-lg-2 control-label"><b>ปีการศึกษา : </b></label>
        <div class="col-lg-10"  style="width:270px;">
            <input type="text" name="grade" id="grade" readonly class="form-control" placeholder="ปีการศึกษา" required>
        </div>
    </div>
    <div class="form-group">
      <label for="classidx"  class="col-lg-2 control-label"><b>ห้องเรียน : </b></label>
      <div class="col-lg-10" style="width:200px;">
        <input type="text" name="class" id="class" class="form-control" readonly placeholder="ห้องเรียน" required>
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
      $("input[name=stu_code]").autocomplete({
        source: '<?php echo base_url() ?>leave/getprofile_byid',
        select: function(evt, data){
          $('input[name=stu_code]').val(data.item.stu_code);
          $('input[name=stu_name]').val(data.item.name);
          $('input[name=grade]').val(data.item.grade_name);
          $('input[name=class]').val(data.item.class_num);
        }
      });

      $("input[name=stu_name]").autocomplete({
        source: '<?php echo base_url() ?>leave/getprofile_byname',
        select: function(evt, data){
          $('input[name=stu_code]').val(data.item.stu_code);
          $('input[name=grade]').val(data.item.grade_name);
          $('input[name=class]').val(data.item.class_num);
        }
      });


    var options = {
        // target:        '#',   // target element(s) to be updated with server response 
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
        type: 'POST',        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true, // clear all form fields after successful submit
        resetForm: true, // reset the form after successful submit
    };

    $('#frmLeave').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
  });

  </script>