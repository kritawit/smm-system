<!-- <a href="#" class="btn btn-success" id="export-leave"><span class="glyphicon glyphicon-export"></span> Export ข้อมูลการลา</a> -->
<a href="#" class="btn btn-danger" id="cancel-select"><span class="glyphicon glyphicon-remove-circle"></span> ยกเลิกการลาที่เลือก</a>
<hr>
<table id="result_search" class="table table-striped table-hover ">
		<thead>
			<tr>
				<th align="center"><input type="checkbox" name="select[]" onclick="CheckAll(this)" name="select_all" ></th>
				<th>รหัส</th>
				<th>ชื่อ</th>
				<th>นามสกุล</th>
				<th>ประเภทการลา</th>
				<th>จากวันที่</th>
				<th>ถึงวันที่</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
<?php if ($data) {
	for ($i = 0; $i < count($data); $i++) {
		?>
    <tr>
        <td><input type="checkbox" name="select[]" class="chk" value="<?php echo $data[$i]["LEAVEIDX"]?>"></td>
        <td><?php echo $data[$i]["STU_CODE"]?></td>
        <td><?php echo $data[$i]["STU_FNAME"]?></td>
        <td><?php echo $data[$i]["STU_LNAME"]?></td>
        <td><span class="label label-info"><?php echo $data[$i]["LEAVE_NAME"]?></span></td>
        <td><?php echo $data[$i]["FDATE"]?></td>
        <td><?php echo $data[$i]["TDATE"]?></td>
        <td>
            <a href="#" class="btn btn-danger btn-circle" onClick="cancel_leave(<?php echo $data[$i]["LEAVEIDX"]?>);return false;"><span class="glyphicon glyphicon-remove-circle"></span></a>
        </td>
    </tr>
<?php }
}
?>
</tbody>
</table>

<script type="text/javascript" src="<?php echo LB ?>datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo LB?>bootstrap/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    var check_value = null;
	$(function() {
		$("#result_search").dataTable({
			"pagingType": "full_numbers"
		});

        $("#cancel-select").click(function(event) {
            getValueUsingClass();
        });
	});
function getValueUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];
    
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".chk:checked").each(function() {
        chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    // selected = chkArray.join(',') + ",";
    selected = chkArray.join(',');
    
    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if(selected.length > 1){
        // alert("You have selected " + selected); 
        $.ajax({
            url: '<?php echo base_url() ?>leave/cancel_select',
            type: 'POST',
            data:{
                selected,
            },
            success:function(data){
                if (data = 'success') {
                    alert('ทำการยกเลิกสำเร็จ');
                    refre_search();
                }else if(data = 'fail'){
                    alert('เกิดข้อมผิดพลาดในการยกเลิก');
                }
            }
        });
    }else{
        alert("Please at least one of the checkbox");   
    }
}

function getValueUsingParentTag(){
    var chkArray = [];
    
    /* look for all checkboes that have a parent id called 'checkboxlist' attached to it and check if it was checked */
    $("#result_search input:checked").each(function() {
        chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(',') + ",";
    
    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if(selected.length > 1){
        alert("You have selected " + selected); 
    }else{
        alert("Please at least one of the checkbox");   
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
function refre_search(){
    $.ajax({
        url: '<?php echo base_url() ?>leave/search_old',
        type: 'GET',
        success:function(data){
            if(data == 'no-data'){
                $("#result").html('<div class="alert alert-danger"><strong>Data </strong> Is Emptry!</div>');
            }else{
                $("#result").html(data);
            }
        }
    });
    return false;
}

    function cancel_leave(id){
        var leaveidx = id;
        $.ajax({
            url: "<?php echo base_url() ?>leave/cancelLeave",
            type: "POST",
            data:{leaveidx},
            success:function(data){
                if (data == 'success') {
                    alert('ทำการยกเลิกสำเร็จ');
                    refre_search();
                }else if(data == 'fail'){
                    alert('เกิดข้อมผิดพลาดในการยกเลิก');
                }
            }
        });
    }
</script>