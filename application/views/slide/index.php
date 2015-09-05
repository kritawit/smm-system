<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<div class="content-slide">
	<legend>ตั้งค่า Slide Show</legend>
	<a href="<?php echo base_url(); ?>slide/slideform" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> เพิ่ม</a>
	<hr>
	<table id="slide" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Image / Video</th>
				<th>Status</th>
				<th>Create Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($data) :?>
  		<?php for ($i = 0; $i < count($data); $i++) :?>
    	<tr>
        	<td><?php echo $data[$i]["SLIDEIDX"]?></td>
        	<?php if($data[$i]['SLIDE_TYPE']==1): ?>
        		<td><img width="125" height="110" src="<?php echo IMG ?>slide/<?php echo $data[$i]["SLIDE"]?>" alt=""></td>
        	<?php elseif($data[$i]['SLIDE_TYPE']==2): ?>
        		<td>
					<a href="<?php echo $data[$i]["SLIDE"];?>" class="btn btn-info" target="_blank"><span class="glyphicon glyphicon-facetime-video"></span> Video</a>
				</td>
        	<?php endif; ?>
        	<td>
        	<?php if($data[$i]['SLIDE_ACTIVE']==1): ?>
        	<span class="label label-success"><?php echo $data[$i]["STATUS"];?></span>
        	<?php elseif($data[$i]['SLIDE_ACTIVE']==0): ?>
			<span class="label label-danger"><?php echo $data[$i]["STATUS"];?></span>
        	<?php endif; ?>
        	</td>
        	<td><?php echo $data[$i]["CREATE_DATE"]?></td>
        	<td>
        		<a href="#" class="btn btn-warning" onclick="edit(<?php echo $data[$i]["SLIDEIDX"]?>);return false;"><span class="glyphicon glyphicon-picture"></span></a>
        		<a href="#" class="btn btn-danger" onclick="del(<?php echo $data[$i]["SLIDEIDX"]?>);return false;"><span class="glyphicon glyphicon-trash"></span>
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
		window.location.href = "<?php echo base_url() ?>slide/editform?slideidx="+id;
	}

	function del(id){
		if (confirm('comfirm delete slide.')) {
			window.location.href = "<?php echo base_url() ?>slide/delete?slideidx="+id;
		}
	}
</script>