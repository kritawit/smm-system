<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<ol class="breadcrumb">
    <li>
        <a href="<?php echo base_url(); ?>student">ย้อนกลับ</a>
    </li>
    <li class="active">เพิ่มข้อมูลนักเรียน</li>
</ol>
<div class="content-student">
<legend>เพิ่มข้อมูลนักเรียน</legend>
<div class="alert alert-success" id="alert_success" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>เพิ่มข้อมูลนักเรียน</strong> สำเร็จ
</div>
<div class="alert alert-danger" id="alert_danger" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>เกิดข้อผิดพลาด !</strong> ในการเพิ่มข้อมูล
</div>
<form id="frmStudent" class="form-horizontal" role="form" enctype="multipart/form-data">
	<fieldset>
    <!-- <div class="form-group">
      <label for="pic_profile" class="col-lg-2 control-label"><b>Picture Profile : </b></label>
      <div class="col-lg-10">
	<input type="file" style="display: none;" id="pic_profile" name="pic_profile" onchange="$('#blah')[0].src = window.URL.createObjectURL(this.files[0])" class="form-control"/>
	<a href="#" id="file_pic"><img id="blah" class="img-circle" src="" alt="Profile Picture" width="130" height="130" /></a>
      </div>
    </div> -->
    <div class="form-group" id="input-stucode">
	<label for="stuidx"  class="col-lg-2 control-label"><b>รหัสนักเรียน : </b></label>
		<div class="col-lg-10" style="width:170px;">
			<input type="hidden" name="stuidx" id="stuidx" value="" />
			<input type="number" class="form-control danger" name="stu_code" required="required" id="stu_code" value=""  placeholder="รหัสนักเรียน"/>
		</div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>คำนำหน้าชื่อ : </b></label>
    	<div class="col-lg-10" style="width:220px;">
    		<select name="stu_title" id="stu_title" class="form-control" required="required">
    			<option value="">เลือก คำนำหน้าชื่อ</option>
    			<option value="นาย">นาย</option>
    			<option value="นางสาว">นางสาว</option>
    			<option value="เด็กชาย">เด็กชาย</option>
    			<option value="เด็กหญิง">เด็กหญิง</option>
    		</select>
    	</div>
    </div>
    <div class="form-group inline">
    	<label for="stu_fname"  class="col-lg-2 control-label"><b>ชื่อ - นามสกุล : </b></label>
	<div class="col-md-4">
		<input type="text" name="stu_fname" value="" required="required" id="stu_fname" class="form-control" placeholder="ชื่อ"/>
	</div>
	<div class="col-md-4">
		<input type="text" name="stu_lname" value="" required="required" id="stu_lname" class="form-control" placeholder="นามสกุล"/>
	</div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>หมายเลขบัตรประชาชน : </b></label>
      <div class="col-lg-3">
            <input type="text" name="id_card" maxlength="13" onkeypress='return isNumberKey(event)' id="id_card" class="form-control"  title="">
     </div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>ปรีการศึกษา : </b></label>
    	<div class="col-lg-10" id="grade01" style="width:300px;">

    	</div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>ห้องเรียน : </b></label>
    	<div class="col-lg-10" id="classrm01" style="width:200px;">
    		
    	</div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>เพศ : </b></label>
      <div class="col-lg-10">
	<div class="radio">
		<label>
			<input type="radio" name="stu_gender" id="stu_gender" value="หญิง" checked="checked">
			หญิง
		</label>
		<label>
			<input type="radio" name="stu_gender" id="stu_gender" value="ชาย" >
			ชาย
		</label>
	</div>
     </div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>วันเกิด : </b></label>
      <div class="col-lg-3">
            <input type="date" name="birth_date" id="birth_date" class="form-control"  title="">
     </div>
    </div>
    <div class="form-group">
	<label for="stu_add" class="col-lg-2 control-label"><b>ที่อยู่ : </b></label>
	<div class="col-lg-10">
		<textarea name="stu_add" id="stu_add" class="form-control" rows="3" cols="30" required="required"></textarea>
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_tel" class="col-lg-2 control-label"><b>เบอร์โทร นักเรียน</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="number" name="stu_tel" id="stu_tel"  maxlength="10" size="10" class="form-control" placeholder="เบอร์โทร นักเรียน">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_ptel" class="col-lg-2 control-label"><b>เบอร์โทร ผู้ปกครอง</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="number" name="stu_ptel" id="stu_ptel" maxlength="10" size="10" required="required" class="form-control" placeholder="เบอร์โทร ผู้ปกครอง">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_email" class="col-lg-2 control-label"><b>Email นักเรียน</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="email" name="stu_email" id="stu_email"  class="form-control" placeholder="Email นักเรียน">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_pemail" class="col-lg-2 control-label"><b>Email ผู้ปกครอง</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="email" name="stu_pemail" id="stu_pemail"  class="form-control" placeholder="Email ผู้ปกครอง">
	</div>
    </div>
    <div class="form-group">
	<label for="stu_indate" class="col-lg-2 control-label"><b>เข้าเรียนวันที่ : </b></label>
	<div class="col-lg-3" >
		<input type="date" name="stu_indate" id="stu_indate" class="form-control" value="" required="required" title="">
	</div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
      	<button type="submit" onclick="save();" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        <a href="<?php echo base_url(); ?>student"  class="btn btn-danger">Cancel</a>
        <div id="loading1"></div>
      </div>
    </div>
  </fieldset>
</form>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
    $(function() {
        getgrade();
        getclass();

        $('#stu_code').keyup(function() {
            $.ajax({
                url : '<?php echo base_url() ?>student/validcode',
                type: 'POST',
                data: {
                    code: $(this).val()
                },
                success:function(data){
                    if (data=='fail') {
                        $("#input-stucode").addClass('form-group has-error');
                        $('#stu_code').val('');
                        $('#stu_code').after('<p id="error" class="text-danger">รหัสนักเรียน ซ้ำ</p>');
                    }else if(data=='success'){
                        $("#input-stucode").removeClass('form-group has-error');
                        $("#error").hide();
                        $("#input-stucode").addClass('form-group');
                    }
                }
            });
        });
    });
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
    }
    function save(){
      $("#frmStudent").ajaxForm({
         url: '<?php echo base_url() ?>student/save',
         type: 'POST',
         success: function(data) {
             if (data = 'success') {
                $("#alert_success").show();
                $("#alert_danger").hide();
             }else if (data = 'fail'){
                $("#alert_danger").show();
                $("#alert_success").hide();
             }
         }
     });
    }
	function getgrade(){
		$.ajax({
			url: '<?php echo base_url() ?>student/grade',
			type: 'GET',
			success:function(data){
				$("#grade01").html(data);
			}
		});
	}
	function getclass(){
		$.ajax({
			url:'<?php echo base_url() ?>student/classroom',
			type: 'GET',
			success:function(data){
				$("#classrm01").html(data);
			}
		});
	}
</script>