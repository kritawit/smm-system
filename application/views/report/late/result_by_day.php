<div id="cover-table-student">
    <!-- <div class="btn-group">
      <a  href="#" class="btn btn-success" id="export_by_day"><span class="glyphicon glyphicon-export"></span> Export Excel</a>
    </div> -->
    <!-- <div class="btn-group">
      <a href="#" class="btn btn-primary" id="print_by_day"><span class="glyphicon glyphicon-print"></span> Print</a>
    </div> -->
    <div class="btn-group">
      <a href="#" class="btn btn-warning" id="send_sms_all"><span class="glyphicon glyphicon-phone"></span> SMS All</a>
    </div>
    <hr>
    <div class="row">
    <table id="result_search" class="table table-striped table-hover" width="100%">
      <thead>
        <tr>
          <th align="center"><input type="checkbox" name="select[]" onclick="CheckAll(this)" name="select_all" ></th>
          <th>รหัส</th>
          <th>คำนำหน้า</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>ปีการศึกษา</th>
          <th>ห้องเรียน</th>
          <th>วันที่เวลา</th>
          <th>สถานะ</th>
          <th>เมนู</th>
        </tr>
      </thead>
  <tbody>
<?php if ($data) {
  for ($i = 0; $i < count($data); $i++) {
    ?>
    <tr>
        <td>
        <input type="hidden" name="stuidx[]" value="<?php echo $data[$i]["STUIDX"] ?>">
        <input type="hidden" name="timeidx[]" value="<?php echo $data[$i]["TIME_ACCIDX"] ?>">
        <input type="checkbox" name="select[]" class="chk" value="<?php echo $data[$i]["STUIDX"]?>"></td>
        <td><?php echo $data[$i]["STU_CODE"]?></td>
        <td><?php echo $data[$i]["STU_TITLE"]?></td>
        <td><?php echo $data[$i]["STU_FNAME"]?></td>
        <td><?php echo $data[$i]["STU_LNAME"]?></td>
        <td><?php echo $data[$i]["GRADE_NAME"]?></td>
        <td><?php echo $data[$i]["CLASS_NUM"]?></td>
        <td><?php echo $data[$i]["DATETIME_ACC"]?></td>
        <td><span class="label label-warning"><?php echo $data[$i]["TIME_TYPE"]?></span></td>
        <td>
            <a href="#" class="btn btn-danger btn-xs" onClick="sendSMS(<?php echo $data[$i]["STUIDX"].','.$data[$i]["TIME_ACCIDX"]?>);return false;"><span class="glyphicon glyphicon-phone"></span> SMS</a>
        </td>
    </tr>
<?php }
}
?>
</tbody>
</table>
  </div>
</div>
<div class="modal fade" id="modal-control">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo LB ?>datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo LB?>bootstrap/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
	$(function() {
    $("#result_search").dataTable({
      "pagingType": "full_numbers"
    });

    $("#send_sms_all").click(function(event) {
        getValueUsingClass();
        return false;
    });

    $("#export_by_day").click(function(event) {
        getValueExport();
        // alert("You");
    });

  });
function getValueExport(){
    /* declare an checkbox array */
    var stuidx = [];
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $('input[name="stuidx[]"]').each(function() {
        stuidx.push($(this).val());
    });
    /* we join the array separated by the comma */
    var ex_stuidx;
    // selected = chkArray.join(',') + ",";
    ex_stuidx = stuidx.join(',');
    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if(ex_stuidx.length > 1){

        $.ajax({
            url: '<?php echo base_url() ?>report/exportLate',
            type: 'POST',
            data:{
                stuidx:ex_stuidx,
            },
            success:function(output){
                document.location.href =(output.url);
            }
        });
    }else{
        alert("Data not found!");
    }
}
  function getValueUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];
    var valTime = [];
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".chk:checked").each(function() {
        chkArray.push($(this).val());
    });
    $('input[name="timeidx[]"]').each(function() {
        valTime.push($(this).val());
    });
    /* we join the array separated by the comma */
    var selected;
    var timeidx;
    // selected = chkArray.join(',') + ",";
    selected = chkArray.join(',');
    timeidx = valTime.join(',');
    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if(selected.length > 1){
        if (confirm("ยืนยันการส่ง SMS!") == true) {
        $.ajax({
            url: '<?php echo base_url() ?>report/sendAllSMS',
            type: 'POST',
            data:{
                stuidx:selected,
                timeidx:timeidx,
            },
            success:function(data){
                if (data = 'success') {

                }else if(data = 'fail'){
                    alert('การส่ง SMS ล้มเหลว');
                }
            }
        });
        }
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

function sendSMS(id,idtime){
    // alert(id);
    // alert(idtime);
    // $("#modal-control").modal('show');
    // $(".modal-title").html('ส่ง SMS');
    if (confirm("ยืนยันการส่ง SMS!") == true) {
        $.ajax({
            url: '<?php echo base_url() ?>report/sendSMS',
            type: 'POST',
            data:{
                id:id,
                idtime:idtime,
            },
            success:function(data){
                if (data=='success') {
                    alert('ส่ง SMS สำเร็จ');
                }else if(data=='fail'){
                    alert('การส่ง SMS ล้มเหลว');
                }else if(data=='credit-out'){
                    alert('credit sms หมด กรุณาติดต่อ ผู้ดูแลระบบ');
                }
            }
        });
        return false;
    }
}
</script>
