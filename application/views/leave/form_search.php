<div id="content-search">
	<a class="btn btn-primary" data-toggle="modal" href='#condition'><span class="glyphicon glyphicon-search"></span>  ค้นหาข้อมูลการลา</a>
</div>
<hr>
<div id="result">
	<div class="alert alert-warning">
      <strong>Data </strong> invalid...
  </div>
</div>
<div class="modal fade" id="condition">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">ค้นหาข้อมูลการลา</h4>
				<div id="loading"></div>
			</div>
			<div class="modal-body">
<form id="frmSearchLeave" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="stu_title" class="col-lg-3 control-label"><b>ปีการศึกษา : </b></label>
      <div class="col-lg-10" id="gradename" style="width:300px;">

      </div>
    </div>
    <div class="form-group">
      <label for="stu_title" class="col-lg-3 control-label"><b>ห้องเรียน : </b></label>
      <div class="col-lg-10" id="classrm" style="width:200px;">

      </div>
    </div>
    <div class="form-group">
      <label for="classidx"  class="col-lg-3 control-label"><b>ประเภทการลา : </b></label>
      <div class="col-lg-10" id="leavetype" style="width:270px;">

      </div>
    </div>
    <div class="form-group inline">
    <label for="stu_fname"  class="col-lg-3 control-label"><b>ช่วงวันที่ : </b></label>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="fdate" value=""  required="required" id="fdate" class="form-control" placeholder="จาก วันที่"/>
  </div>
  <div class="col-md-4" style="width:200px;">
    <input type="text" name="tdate" value=""  required="required" id="tdate" class="form-control" placeholder="ถึง วันที่"/>
  </div>
    </div>
      <div class="modal-footer">
		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> ค้นหาข้อมูล</button>
        <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	</div>

    </fieldset>
    </form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		getgrade();
      	getclass();
      	getLeavType();

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
        // beforeSubmit: , // pre-submit callback 
    	success: function(data) {
            if(data == 'no-data'){
              	setTimeout(function () {
              		$('#loading').html('');
                  $("#condition").modal('hide');
              		$("#result").html('<div class="alert alert-danger"><strong>Data </strong> Not Found!</div>');
            	}, 500);
            }else{
            	setTimeout(function () {
            		$('#loading').html('');
            		$("#condition").modal('hide');
      				$("#result").html(data);
            	}, 500);
            }
        },
        url: '<?php echo base_url() ?>leave/search_leave', // override for form's 'action' attribute 
        type: 'POST',
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true, // clear all form fields after successful submit
        resetForm: true
    	};

    	$('#frmSearchLeave').submit(function() {
    		$('#loading').html('<img id="loader-img" alt="" src="assets/images/loader/loading.gif" width="40" height="40" align="center" />');
        	$(this).ajaxSubmit(options);
        	return false;
    	});
	});
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
echo base_url() ?>leave/search_leavetype',
      type: 'GET',
      success:function(data){
        $("#leavetype").html(data);
      }
    });
  }
</script>