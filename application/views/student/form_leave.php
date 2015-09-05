<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">เพิ่มข้อมูลนักเรียน แจ้งขอลาหยุด หรือขออนุญาตออกนอกสถานที่</h3>
    </div>
  <div class="panel-body">
      <form id="frmLeave" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="stuidx"  class="col-lg-2 control-label"><b>รหัสนักเรียน : </b></label>
      <div class="col-lg-10" style="width:170px;">
        <input type="text" class="form-control danger" name="stu_code" required="required" id="stu_code" value=""  placeholder="รหัสนักเรียน"/>
      </div>
    </div>
    <div class="form-group inline">
      <label for="stu_fname"  class="col-lg-2 control-label"><b>ชื่อ - นามสกุล : </b></label>
  <div class="col-md-4">
    <input type="text" name="stu_fname" value="" readonly required="required" id="stu_fname" class="form-control" placeholder="ชื่อ"/>
  </div>
  <div class="col-md-4">
    <input type="text" name="stu_lname" value="" readonly required="required" id="stu_lname" class="form-control" placeholder="นามสกุล"/>
  </div>
    </div>
    <div class="form-group">
        <label for="gradeidx"  class="col-lg-2 control-label"><b>ปีการศึกษา : </b></label>
        <div class="col-lg-10" id="grade" style="width:270px;">
        </div>
    </div>
    <div class="form-group">
      <label for="classidx"  class="col-lg-2 control-label"><b>ห้องเรียน : </b></label>
      <div class="col-lg-10" id="classrm" style="width:200px;">
      </div>
    </div>
    <div class="form-group">
      <label for="classidx"  class="col-lg-2 control-label"><b>ประเภทการลา : </b></label>
      <div class="col-lg-10" id="leavetype" style="width:270px;">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-4">
        <button type="submit"  class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> ยืนยันการลา</button>
        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <div id="loading1"></div>
      </div>
    </div>
  </fieldset>
</form>
    </div>
</div>

<script type="text/javascript">

    $(function() {
        getgrade();
        getclass();
    });

  function getgrade(){
    $.ajax({
      url: '<?php
echo base_url() ?>student/grade',
      type: 'GET',
      success:function(data){
        $("#grade").html(data);
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
    
  }
</script>