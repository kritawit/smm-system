<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<div class="content-slide">
	<legend>ตั้งค่า ข่างสาร(News)</legend>
	<?php if(!empty($this->session->flashdata('error'))): ?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong><?php $this->session->flashdata('error'); ?></strong>
	</div>
	<?php endif; ?>
	<a href="<?php echo base_url(); ?>news/newsform" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> เพิ่ม</a>
	<hr>
	<table id="slide" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>ข้อความข่าว (News Content)</th>
				<th>Status</th>
				<th>Create Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($data) :?>
  		<?php for ($i = 0; $i < count($data); $i++) :?>
    	<tr>
        	<td><?php echo $data[$i]["NEWIDX"]?></td>
        	<td width="600"><?php echo $data[$i]["NEW"]?></td>
        	<td>
        	<?php if($data[$i]['NEW_ACTIVE']==1): ?>
        	<span class="label label-success">Active</span>
        	<?php elseif($data[$i]['SLIDE_ACTIVE']==0): ?>
			<span class="label label-danger">None-Active</span>
        	<?php endif; ?>
        	</td>
        	<td><?php echo $data[$i]["CREATE_DATE"]?></td>
        	<td>
        		<a href="#" class="btn btn-warning" onclick="edit(<?php echo $data[$i]["NEWIDX"]?>);return false;"><span class="glyphicon glyphicon-pencil"></span></a>
        		<a href="#" class="btn btn-danger" onclick="del(<?php echo $data[$i]["NEWIDX"]?>);return false;"><span class="glyphicon glyphicon-trash"></span>
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
		$("#slide").dataTable({
            "pagingType": "full_numbers",
    	});
	});
	function edit(id){
		window.location.href = "<?php echo base_url() ?>news/newsform?newidx="+id;
	}

	function del(id){
		if (confirm('comfirm delete slide.')) {
			window.location.href = "<?php echo base_url() ?>news/deleteNew?newidx="+id;
		}
	}
</script>