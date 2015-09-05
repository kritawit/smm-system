<form id="frmFindPeple" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
	<div class="form-group">
      <label for="stuidx"  class="col-lg-2 control-label"><b>รหัสนักเรียน : </b></label>
      <div class="col-lg-10" style="width:170px;">
        <input type="text" class="form-control danger" name="stu_code" id="stu_code" value=""  placeholder="รหัสนักเรียน"/>
      </div>
    </div>
    <div class="form-group inline">
      <label for="stu_name"  class="col-lg-2 control-label"><b>ชื่อ - นามสกุล : </b></label>
      <div class="col-md-4">
        <input type="text" name="stu_name" value=""  id="stu_name" class="form-control" placeholder="ชื่อ - นามสกุล"/>
      </div>
    </div>
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
    <div class="form-group inline">
    <label for="stu_fname"  class="col-lg-2 control-label"><b>ช่วงวันที่ : </b></label>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="fdate" value=""  required="required" id="fdate" class="form-control" placeholder="จาก วันที่"/>
  </div>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="tdate" value=""  required="required" id="tdate" class="form-control" placeholder="ถึง วันที่"/>
  </div>
    </div>
   <div class="form-group">
   <label class="col-lg-2"></label>
   	<div class="col-md-6">
		  <button type="submit" class="btn btn-primary" onclick="submit_peple();"><span class="glyphicon glyphicon-ok"></span> ค้นหาข้อมูล</button>
      <button type="reset" class="btn btn-danger" ><span class="glyphicon glyphicon-refresh"></span> Reset</button>
	    <button  role="button" data-toggle="collapse" href="#panel-search" aria-expanded="false" class="btn btn-warning"><span class="glyphicon glyphicon-menu-up"></span> Hide</button>
  </div>
	</div>

    </fieldset>
    </form>
    <script type="text/javascript">
    $(function() {
    	 getgrade();
    	 getclass();
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
    	   $('#to_date').datepicker({
          dateFormat: "yy-mm-dd",
          maxDate: '0',
        });


        $("input[name=stu_code]").autocomplete({
        source: '<?php echo base_url() ?>leave/getprofile_byid',
        select: function(evt, data){
          $('input[name=stu_code]').val(data.item.stu_code);
          $('input[name=stu_name]').val(data.item.name);
        }
      });

      $("input[name=stu_name]").autocomplete({
        source: '<?php echo base_url() ?>leave/getprofile_byname',
        select: function(evt, data){
          $('input[name=stu_code]').val(data.item.stu_code);
        }
      });

    });

   function getgrade(){
    $.ajax({
      url: '<?php
echo base_url() ?>student/grade',
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
</script>