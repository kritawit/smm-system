<div id="leave-content">
<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">เพิ่มข้อมูลนักเรียน แจ้งขอลาหยุด หรือขออนุญาตออกนอกสถานที่</h3>
    </div>
  <div class="panel-body">
  <div class="form-group">
      <label for="stuidx"  class="col-lg-2 control-label"><b>รูปแบบการลา : </b></label>
      <div class="radio" class="col-lg-10">
        <label>
          <input type="radio" name="type" id="type1" value="1" />
          รายบุคคล
        </label>
        <label>
          <input type="radio" name="type" id="type2" value="2" />
          กลุ่ม
        </label>
      </div>
    </div>
    <hr>
    <div id="form-load">

    </div>
  </div>
</div>
</div>
<div class="modal fade" id="report-condition">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">กำหนดเงื่อนไขการค้นหา การออกรายงาน</h4>
      </div>
      <div class="modal-body">
        <form id="frmLeave" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="stu_title" class="col-lg-2 control-label"><b>ปรีการศึกษา : </b></label>
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
    <label for="stu_fname"  class="col-lg-2 control-label"><b>ช่วงวันที่ : </b></label>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="fdate" value=""  required="required" id="fdate" class="form-control" placeholder="จาก วันที่"/>
  </div>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="tdate" value=""  required="required" id="tdate" class="form-control" placeholder="ถึง วันที่"/>
  </div>
    </div>
    <hr>
    <div class="form-group">
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> ค้นหาข้อมูล</button>
        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    </fieldset>
    </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function() {
      // $("#report").click(function(event) {
      //   $.ajax({
      //     url:'<?php echo base_url() ?>leave/report',
      //     type: 'GET',
      //     success:function(data){
      //       $("#leave-content").html(data);
      //     }
      //   });
      //   return false;
      // });
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
      getgrade();
      getclass();
      getLeavType();

      $("#type1").focus(function(event) {
        $.ajax({
            url:'<?php echo base_url() ?>leave/form_onlyone',
            type: 'GET',
            success:function(data){
              $("#form-load").html(data);
              getLeavType();
            }
        });
      });
      $("#type2").focus(function(event) {
        $.ajax({
            url:'<?php echo base_url() ?>leave/form_everyone',
            type: 'GET',
            success:function(data){
              $("#form-load").html(data);
              getgrade();
              getclass();
              getLeavType();
            }
        });
      });
    });
  function back(){
    $('#content_loader').html('<img id="loader-img" alt="" src="assets/images/loader/loading.gif" width="40" height="40" align="center" />');
      $.ajax({
        url: '<?php echo base_url() ?>leave/index',
        type: 'GET',
        success:function(data){
          setTimeout(function () {
              $("#page-wrapper").html(data);
              $('#content_loader').html('');
              }, 500);
      }
    });
    return false;
  }
  function getgrade(){
    $.ajax({
      url: '<?php echo base_url() ?>student/grade',
      type: 'GET',
      success:function(data){
        $("#gradename").html(data);
      }
    });
  }
  function getclass(){
    $.ajax({
      url:'<?php
echo base_url() ?>student/classex',
      type: 'GET',
      success:function(data){
        $("#classrm").html(data);
      }
    });
  }

  function getLeavType(){
    $.ajax({
      url: '<?php
echo base_url() ?>leave/leavetype',
      type: 'GET',
      success:function(data){
        $("#leavetype").html(data);
      }
    });
  }
</script>