<form id="frmExport" action="student/export_excel" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
	<fieldset>
    <div class="form-group inline">
        <div class="col-md-4" id="grade">
        </div>
        <div class="col-md-4" id="classrm">
        </div>
    </div>
    <div class="form-group inline">
        <div class="col-md-4">
        <label for="condition" class="control-label"><b>เงื่อนไข : </b></label>
        <div class="radio">
          <label>
            <input type="radio" name="condition" id="condition" value="1" checked="checked">
            ตามเงื่อนไข
          </label>
          <label>
            <input type="radio" name="condition" id="condition2" value="2" >
            ทั้งหมด
          </label>
           </div>
        </div>
        <div class="col-md-4">
        <label for="stu_indate" class="control-label"><b>เข้าเรียนวันที่ : </b></label>
        <input type="date" name="stu_indate" id="stu_indate" class="form-control" value=""  title="">
        </div>
    </div>
    <div class="form-group">
      <div class="col-md-4">
      	<button type="submit"  class="btn btn-primary"><span class="glyphicon glyphicon-export"></span> Export</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <div id="loading1"></div>
      </div>
    </div>
  </fieldset>
</form>

<script type="text/javascript">

    $(function() {
        getgrade();
        getclass();
    });
   $("#condition2").focus(function(event) {
        document.getElementById("gradeidx").disabled = true;
        document.getElementById("classidx").disabled = true;
        document.getElementById("stu_indate").disabled = true;
    });
    $("#condition").focus(function(event) {
        document.getElementById("gradeidx").disabled = false;
        document.getElementById("classidx").disabled = false;
        document.getElementById("stu_indate").disabled = false;
    });

	function getgrade(){
		$.ajax({
			url: '<?php echo base_url() ?>student/grade',
			type: 'GET',
			success:function(data){
				$("#grade").html(data);
			}
		});
	}
	function getclass(){
		$.ajax({
			url:'<?php echo base_url() ?>student/classex',
			type: 'GET',
			success:function(data){
				$("#classrm").html(data);
			}
		});
	}
</script>