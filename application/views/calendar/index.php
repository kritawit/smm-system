<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<div class="content-holiday">
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>">Home</a>
            </li>
            <li class="active">ปฏิทิน โรงเรียน (School Calendar)</li>
        </ol>
        <legend>ปฏิทิน โรงเรียน (School Calendar)</legend>
    <a type="button" class="btn btn-info"  href='<?php echo base_url() ?>calendar/viewcalendar'><span class="glyphicon glyphicon-calendar"></span> ปฏิทิน</a>
	<a type="button" class="btn btn-success"  href='<?php echo base_url() ?>calendar/calendarform'><span class="glyphicon glyphicon-plus"></span> เพิ่ม</a>
	<a href="javascript:editcalendar();" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> แก้ไข</a>
	<a href="javascript:deletecalenday();" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ลบ</a>
	<hr>
		<table id="holiday" class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>
          			<input type="checkbox" name="select[]"  onclick="CheckAll(this)" name="select_all">
         			</th>
          			<th>วันที่</th>
          			<th>ประเภท</th>
				</tr>
			</thead>
		<tbody>
	<?php if ($data) :?>
  	<?php for ($i = 0; $i < count($data); $i++) :?>
    <tr>
        <td>
        <input type="checkbox" name="select[]" class="chk" value="<?php echo $data[$i]["CALIDX"]?>"></td>
        <td><?php echo $data[$i]["CAL_DATE"]?></td>
        <td><?php echo $data[$i]["TYPE"]?></td>
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
		datePick();
		$("#holiday").dataTable({
            "pagingType": "full_numbers",
        });
	});
	function editcalendar() {
		getOneCheck();
	}

    function deletecalenday(){
        getValueDelete();
    }

    function getOneCheck(){
        
        var chkArray = [];

        chkArray.push($('.chk:checked').val());

        var selected;

        selected = chkArray.join(',');
        if(selected.length >= 1){
            window.location.href = "<?php echo base_url() ?>calendar/calendareditform?calidx="+selected;
        }else{
            alert("Please at least one of the checkbox");
        }
    }

	function getValueUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];

    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    	$(".chk:checked").each(function() {
        	chkArray.push($(this).val());
    	});

    	var selected;

    	selected = chkArray.join(',');
    	if(selected.length >= 1){
        	window.location.href = "<?php echo base_url() ?>calendar/calendar/form?calidx="+selected;
    	}else{
        	alert("Please at least one of the calendar.");
    	}
	}
    function getValueDelete(){
    /* declare an checkbox array */
    var chkArray = [];

    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
        $(".chk:checked").each(function() {
            chkArray.push($(this).val());
        });

        var selected;

        selected = chkArray.join(',');
        if(selected.length >= 1){
            if (confirm('Confirm delete calendar ?')) {
                 window.location.href = "<?php echo base_url() ?>calendar/delete?calidx="+selected;
            }
        }else{
            alert("Please at least one of the calendar.");
        }
    }

	function CheckAll(x){
    var allInputs = document.getElementsByName(x.name);
        for (var i = 0, max = allInputs.length; i < max; i++) 
    {
            if (allInputs[i].type == 'checkbox')
            if (x.checked == true)
                allInputs[i].checked = true;
            else
                allInputs[i].checked = false;
    }
}
	function datePick(){
		$('#cal_date').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 'today',
        });
	}
</script>