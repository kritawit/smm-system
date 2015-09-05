<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<ol class="breadcrumb">
    <li>
        <a href="<?php echo base_url(); ?>student">ย้อนกลับ</a>
    </li>
    <li class="active">แก้ไขข้อมูลนักเรียน</li>
</ol>
<div class="content-student">
<legend>แก้ไขข้อมูลนักเรียน</legend>
<div class="alert alert-success" id="alert_success" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>เพิ่มข้อมูลนักเรียน</strong> สำเร็จ
</div>
<div class="alert alert-danger" id="alert_danger" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>เกิดข้อผิดพลาด !</strong> ในการเพิ่มข้อมูล
</div>
<?php if (!empty($rs)):  ?>
<?php foreach ($rs as $data): ?>
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
			<input type="hidden" name="stuidx" id="stuidx" value="<?php echo $data['STUIDX'];?>" />
			<input type="number" class="form-control" name="stu_code" id="stu_code" value="<?php echo $data['STU_CODE'];?>"  placeholder="รหัสนักเรียน" disabled/>
		</div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>คำนำหน้าชื่อ : </b></label>
    	<div class="col-lg-10" style="width:220px;">
    		<select name="stu_title" id="stu_title" class="form-control" required="required">
    			<option value="">เลือก คำนำหน้าชื่อ</option>
    			<option value="นาย" <?php if($data['STU_TITLE']=='นาย') { echo'selected'; } ?>>นาย</option>
    			<option value="นางสาว" <?php if($data['STU_TITLE']=='นางสาว') { echo'selected'; } ?>>นางสาว</option>
    			<option value="เด็กชาย" <?php if($data['STU_TITLE']=='เด็กชาย') { echo'selected'; } ?>>เด็กชาย</option>
    			<option value="เด็กหญิง" <?php if($data['STU_TITLE']=='เด็กหญิง') { echo'selected'; } ?>>เด็กหญิง</option>
    		</select>
    	</div>
    </div>
    <div class="form-group inline">
    	<label for="stu_fname"  class="col-lg-2 control-label"><b>ชื่อ - นามสกุล : </b></label>
	<div class="col-md-4">
		<input type="text" name="stu_fname" value="<?php echo $data['STU_FNAME']; ?>" required="required" id="stu_fname" class="form-control" placeholder="ชื่อ"/>
	</div>
	<div class="col-md-4">
		<input type="text" name="stu_lname" value="<?php echo $data['STU_LNAME']; ?>" required="required" id="stu_lname" class="form-control" placeholder="นามสกุล"/>
	</div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>หมายเลขบัตรประชาชน : </b></label>
      <div class="col-lg-3">
        	<input type="text" name="ID_CARD" value="<?php echo $data['ID_CARD']; ?>" maxlength="13" onkeypress='return isNumberKey(event)' id="ID_CARD" class="form-control"  title="">
     </div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>ปรีการศึกษา : </b></label>
    	<div class="col-lg-10" id="grade" style="width:300px;">
			<div class="input-group">
      			<input type="text" class="form-control"  value="<?php echo $data['GRADE_NAME']; ?>" disabled>
    			<a href="#" id="changegrade" class="input-group-addon btn-info"><span class="glyphicon glyphicon-edit"></span></a>
    		</div>
    	</div>
    </div>
    <div class="form-group">
    	<label for="stu_title" class="col-lg-2 control-label"><b>ห้องเรียน : </b></label>
    	<div class="col-lg-10" id="classrm" style="width:300px;">
    		<div class="input-group">
      			<input type="text" class="form-control"  value="<?php echo $data['CLASS_NUM']; ?>" disabled>
    			<a href="#" id="changeclass" class="input-group-addon btn-info"><span class="glyphicon glyphicon-edit"></span></a>
    		</div>
    	</div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>เพศ : </b></label>
      <div class="col-lg-10">
	<div class="radio">
		<label>
			<input type="radio" name="stu_gender" id="stu_gender" value="หญิง" checked="<?php if($data['STU_GENDER']=='หญิง') { echo'checked'; } ?>">
			หญิง
		</label>
		<label>
			<input type="radio" name="stu_gender" id="stu_gender" value="ชาย" checked="<?php if($data['STU_GENDER']=='ชาย') { echo'checked'; } ?>">
			ชาย
		</label>
	</div>
     </div>
    </div>
    <div class="form-group">
      <label for="stu_gender" class="col-lg-2 control-label"><b>วันเกิด : </b></label>
      <div class="col-lg-3">
            <input type="date" name="BIRTH_DATE" value="<?php echo $data['BIRTH_DATE']; ?>" id="birth_date" class="form-control"  title="">
     </div>
    </div>
    <div class="form-group">
	<label for="stu_add" class="col-lg-2 control-label"><b>ที่อยู่ : </b></label>
	<div class="col-lg-10">
		<textarea name="stu_add" id="stu_add" class="form-control" rows="3" cols="30" required="required"><?php echo $data['STU_ADD']; ?></textarea>
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_tel" class="col-lg-2 control-label"><b>เบอร์โทร นักเรียน</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="tel" name="stu_tel" id="stu_tel" value="<?php echo $data['STU_TEL']; ?>" maxlength="10" size="10" class="form-control" placeholder="เบอร์โทร นักเรียน">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_ptel" class="col-lg-2 control-label"><b>เบอร์โทร ผู้ปกครอง</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="tel" name="stu_ptel" id="stu_ptel" value="<?php echo $data['STU_PTEL']; ?>" maxlength="10" size="10" required="required" class="form-control" placeholder="เบอร์โทร ผู้ปกครอง">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_email" class="col-lg-2 control-label"><b>Email นักเรียน</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="email" name="stu_email" id="stu_email" value="<?php echo $data['STU_EMAIL']; ?>" class="form-control" placeholder="Email นักเรียน">
	</div>
    </div>
    <div class="form-group">
    	<label for="stu_pemail" class="col-lg-2 control-label"><b>Email ผู้ปกครอง</b></label>
	<div class="col-lg-10" style="width:300px;">
		<input type="email" name="stu_pemail" id="stu_pemail" value="<?php echo $data['STU_PEMAIL']; ?>" class="form-control" placeholder="Email ผู้ปกครอง">
	</div>
    </div>
    <div class="form-group">
	<label for="stu_indate" class="col-lg-2 control-label"><b>เข้าเรียนวันที่ : </b></label>
	<div class="col-lg-10" style="width:220px;">
		<input type="date" name="stu_indate" id="stu_indate" class="form-control" value="<?php echo $data['STU_INDATE'] ?>" required="required" title="">
	</div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
      	<button type="submit" onclick="save();"  class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        <a href="<?php echo base_url(); ?>student"  class="btn btn-danger">Cancel</a>
      </div>
    </div>
  </fieldset>
  </form>

<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		// getgrade();
		// getclass();
		$("#changeclass").click(function(event) {
			getclass();
		});

		$("#changegrade").click(function(event) {
			getgrade();
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
				$("#grade").html(data);
			}
		});
	}
	function getclass(){
		$.ajax({
			url:'<?php echo base_url() ?>student/classroom',
			type: 'GET',
			success:function(data){
				$("#classrm").html(data);
			}
		});
	}
</script>