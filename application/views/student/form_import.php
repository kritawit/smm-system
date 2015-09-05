<form id="frmImport" class="form-inline" role="form" enctype="multipart/form-data">
	<div class="form-group">
		<div id="load_progress"></div>
	</div>
	<div class="form-group">
		<input type="file" name="file_excel" id="file_excel" class="form-control"accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
	</div>
	<button type="submit" class="btn btn-primary" onclick="save_import();"><span class="glyphicon glyphicon-import"></span> Start Import</button>
	<div id="succ">
		<div class="alert alert-dismissible alert-success">
  		<button type="button" class="close" data-dismiss="alert">×</button>
  		<strong>Import ข้อมุลสำเร็จ </strong>
		</div>
	</div>
	<div id="warning">
		<div class="alert alert-dismissible alert-danger">
  		<button type="button" class="close" data-dismiss="alert">×</button>
  		<strong>เกิดข้อผิดพลาดการ Import ข้อมูลในขณะนี้ ! </strong> <p id="title"></p>
		</div>
	</div>
</form>