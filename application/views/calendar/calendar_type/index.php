<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>">Home</a>
    </li>
    <li>
      <a href="<?php echo base_url() ?>calendar">ปฏิทิน โรงเรียน (School Calendar)</a>
    </li>
    <li class="active">เพิ่ม ประเภท(Calendar Type)</li>
  </ol>
<legend>เพิ่ม ปฏิทิน(Calendar)</legend>
        <?php if(!empty($this->session->flashdata('message_error'))): ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><?php echo $this->session->flashdata('message_error'); ?></strong>
			</div>
        <?php elseif(!empty($this->session->flashdata('message_success'))): ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <strong><?php echo $this->session->flashdata('message_success'); ?></strong>
        </div>
		<?php endif; ?>
		<fieldset>
	<form id="frmCalType" method="POST" action="<?php echo base_url() ?>calendar/saveType" class="form-horizontal" role="form" enctype="multipart/form-data">
  			<input type="hidden" name="caltidx" value="<?php if(!empty($type)){ echo $type[0]['CALTIDX']; } ?>">
    		<div class="form-group inline">
    			<label for="calt_name"  class="col-lg-3 control-label"><b>ชื่อ ประเภท : </b></label>
  				<div class="col-md-4">
    			<input type="text"  name="calt_name"  id="cal_date" value="<?php if(!empty($type)){echo $type[0]['CALT_NAME'];} ?>" class="form-control" placeholder="ชื่อ ประเภท" required="required">
  				</div>
    		</div>
          <div class="form-group inline">
            <label for="cal_name"  class="col-lg-3 control-label"><b>ประเภท  : </b></label>
           	<div class="col-md-4">
           		<div class="radio">
           			<label>
           				<input type="radio" name="calt_type" value="1" <?php if(!empty($type)){if($type[0]['CALT_TYPE']==1){echo "checked";}} ?>>
           				วันธรรมดา
           			</label>
           			<label>
           				<input type="radio" name="calt_type"  value="2" <?php if(!empty($type)){if($type[0]['CALT_TYPE']==2){echo "checked";}} ?>>
           				วันหยุด
           			</label>
           		</div>
           	</div>
          </div>
    			<div class=" form-group">
            <label class="col-lg-3"></label>
      			<div class="col-md-6">
        			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> บันทึก</button>
        			<a type="reset" href="<?php echo base_url() ?>calendar" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
      			</div>
    			</div>
    	</form>
    	</fieldset>
    	<hr>
    	<div class="table-responsive">
    		<table id="table_type" class="table table-hover">
    			<thead>
    				<tr>
    					<th>รหัส</th>
    					<th>ชื่อ ประเภท</th>
    					<th>ประเเภท ของวัน</th>
    					<th>Action</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php if (!empty($data)) :?>
  		<?php for ($i = 0; $i < count($data); $i++) :?>
    	<tr>
        	<td><?php echo $data[$i]["CALTIDX"]?></td>
        	<td><?php echo $data[$i]["CALT_NAME"]?></td>
        	<td>
  				<?php if($data[$i]['CALT_TYPE']==1): ?>
        			<span class="label label-success"><?php echo $data[$i]["TYPE"]?></span>
				<?php elseif ($data[$i]['CALT_TYPE']==2):?>
					<span class="label label-warning"><?php echo $data[$i]["TYPE"]?></span>
				<?php endif; ?>
        	</td>
        	<td>
        		<a class="btn btn-info" href="javascript:edittype(<?php echo $data[$i]['CALTIDX']; ?>);" role="button"><span class="fa fa-edit"></span></a>
				<a class="btn btn-danger" href="javascript:deletetype(<?php echo $data[$i]['CALTIDX']; ?>);" role="button"><span class="fa fa-trash-o"></span></a>
        	</td>
    	</tr>
		<?php endfor;?>
		<?php endif; ?>
    			</tbody>
    		</table>
    	</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="<?php echo LB ?>datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo LB?>bootstrap/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#table_type").dataTable({
            "pagingType": "full_numbers",
    	});
	});
	function edittype(id){
		 window.location.href = "<?php echo base_url() ?>calendar/edit_type?caltidx="+id;
	}

  function deletetype(id){
    if (confirm('Confirm delete calendar type?')) {
      window.location.href = "<?php echo base_url() ?>calendar/delete_type?caltidx="+id;
    }
  }
</script>