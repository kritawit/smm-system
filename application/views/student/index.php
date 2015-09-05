<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<div class="content-student">
    <div class="btn-group">
        <a  href="#" class="btn btn-info" id="btnAdd"><span class="fa fa-plus-square"></span> เพิ่มข้อมูล</a>
    </div>
    <div class="btn-group">
      <a data-toggle="modal" href="#student-modal" class="btn btn-success" id="ImportStu"><span class="glyphicon glyphicon-cloud-upload"></span> Import</a>
    </div>
    <div class="btn-group">
      <a data-toggle="modal" href="#student-modal" class="btn btn-primary" id="ExportStu"><span class="glyphicon glyphicon-cloud-download"></span> Export</a>
    </div>
    <div class="btn-group">
      <a data-toggle="modal" href="#" class="btn btn-warning" id="SendAllSMS"><span class="glyphicon glyphicon-phone"></span> Send SMS All</a>
    </div>
    <hr>
    <div class="row">
      <table id="student_list" class="table table-striped table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>
          <input type="checkbox" name="select[]"  onclick="CheckAll(this)" name="select_all">
          </th>
          <th>รหัส</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>ปีการศึกษา</th>
          <th>ห้องเรียน</th>
          <th>เบอร์โทรผู้ปกครอง</th>
          <th>เมนู</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th><input type="checkbox" name="select[]" onclick="CheckAll(this)" name="select_all"></th>
          <th>รหัส</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>ปีการศึกษา</th>
          <th>ห้องเรียน</th>
          <th>เบอร์โทรผู้ปกครอง</th>
          <th>เมนู</th>
        </tr>
      </tfoot>
  </table>
  </div>
</div>
<div class="modal fade" id="sms-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="body-sms">
      <form id="frmSendSMS" onsubmit="send();return false;" class="form-horizontal" role="form" enctype="multipart/form-data">
  <fieldset>
  <input type="hidden" name="stuidx" id="stuidx" class="form-control" value="">
  <div class="form-group">
  <label for="stu_add" class="col-lg-2 control-label"><b>ข้อความ : </b></label>
    <div class="col-lg-10">
      <textarea name="word" id="word" class="form-control" rows="5" cols="30" required="required"></textarea>
    </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit"  onclick="" class="btn btn-primary" ><span class="glyphicon glyphicon-phone"></span>  ส่งข้อความ</button>
        <button type="button" id="btncancel" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span>  ยกเลิก</button>
        <div id="loading1"></div>
      </div>
    </div>
  </fieldset>
</form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="student-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" id="body-stu">
          
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="<?php echo LB ?>datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo LB?>bootstrap/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
 $(function() {

    getData();

 });
 $("#btncancel").click(function(event) {
    $("#sms-modal").modal('hide');
    $("#frmSendSMS")[0].reset();
 });
function send(){
    if (confirm('ยืนยันการส่ง SMS!')) {
          $('.modal-title').html('<img id="loader-img" alt="" src="<?php echo IMG; ?>loader/loading.GIF" width="40" height="40" align="center" />');
        $.ajax({
          url: '<?php echo base_url() ?>student/sendSMS',
          type: 'POST',
          data: $("#frmSendSMS").serialize(),
          success:function(data){
            if (data=='success') {
              $(".modal-title").html('<p class="text text-success"><span class="glyphicon glyphicon-pencil"></span>  ส่งข้อความ สำเร็จ</p>');
              $("#sms-modal").modal('hide');
            }else if(data=='fail'){
              $(".modal-title").html('<p class="text text-danger">เกิดข้อผิดพลาด</p>');
            }else if(data=='credit-out'){
              $(".modal-title").html('<p class="text text-danger">เครดิตในการส่งข้อความหมด</p>');
            }
          }
        });
      return false;
    // var options = {
    //     success: function(data){
    //         if (data=='success') {
    //           $(".modal-title").html('<p class="text text-success"><span class="glyphicon glyphicon-pencil"></span>  ส่งข้อความ สำเร็จ</p>');
    //           $("#sms-modal").modal('hide');
    //         }else if(data=='fail'){
    //           $(".modal-title").html('<p class="text text-danger">เกิดข้อผิดพลาด</p>');
    //         }else if(data=='credit-out'){
    //           $(".modal-title").html('<p class="text text-danger">เครดิตในการส่งข้อความหมด</p>');
    //         }
    //     },
    //     // other available options:
    //     url:   '<?php echo base_url() ?>student/sendSMS',        // override for form's 'action' attribute 
    //     type: 'POST',        // 'get' or 'post', override for form's 'method' attribute 
    //     //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
    //     clearForm: true,        // clear all form fields after successful submit 
    // };
    // $('#frmSendSMS').submit(function() {
    //     $('.modal-title').html('<img id="loader-img" alt="" src="<?php echo IMG; ?>loader/loading.GIF" width="40" height="40" align="center" />');
    //     $(this).ajaxSubmit(options);
    //     return false;
    // });
  }
}

  $("#SendAllSMS").click(function(event) {
     getValueUsingClass();
  });

  function sendSMS(id){
    if (id != null) {
      $(".modal-title").html('<p><span class="glyphicon glyphicon-pencil"></span>  ส่งข้อความ แบบรายบุคคล</p>');
      $("#sms-modal").modal('show');
      $("#stuidx").val('');
      $("#stuidx").val(id);
    }
  }

  function CheckAll(x){
    // alert('Hello');
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

  function getValueUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".chk:checked").each(function() {
        chkArray.push($(this).val());
    });

    var chkArr;
    chkArr = chkArray.join(',');
    $("#stuidx").val('');
    $("#stuidx").val(chkArr);
    if(chkArr.length > 1){
      $(".modal-title").html('<p><span class="glyphicon glyphicon-pencil"></span>  ส่งข้อความ แบบกลุ่ม</p>')
      $("#sms-modal").modal('show');
    }else{
      alert("Please at least one of the checkbox");   
    }
}

  function getData(){
    $('#student_list').dataTable( {
        "ajax": "<?php echo base_url() ?>student/ajax_request",
        "columns": [
            {
            "mData": null,
            "bSortable": false,
            "mRender": function (o) { return "<input type='checkbox' class='chk' name='select[]' value='"+o.STUIDX+"'>"; }
            },
            { "data": "STU_CODE" },
            { "data": "STU_FNAME" },
            { "data": "STU_LNAME" },
            { "data": "GRADE_NAME" },
            { "data": "CLASS_NUM" },
            { "data": "STU_PTEL" },
            {
            "mData": null,
            "bSortable": false,
            "mRender": function (o) { return "<a href='#' onclick='sendSMS("+ o.STUIDX +");return false;' class='btn btn-warning btn-sm' data-toggle='modal' '>" + "<span class='glyphicon glyphicon-phone'></span>" + "</a>"+
            "<a href='#' onclick='editStu("+ o.STUIDX +");' class='btn btn-primary btn-sm' >" + "<span class='glyphicon glyphicon-pencil'></span>" + "</a>"
            +"<a href='#' class='btn btn-danger btn-sm' onclick='delStu("+ o.STUIDX +");return false;' '>" + "<span class='glyphicon glyphicon-trash'></span>" + "</a>"; }
            }
        ],
        "dom": 'Tlfrtip',
            "aaSorting": [],
            "iDisplayLength": 10,
            "bStateSave": false,

            // table tools
            "tableTools": {
                sSwfPath: "<?php echo LB ?>datatables/TableTools/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                { sExtends :'pdf',
                  oSelectorOpts: { filter: 'applied', 
                                   order: 'current', 
                                 },
                  sPdfOrientation: "landscape",
                  sPdfMessage: "Export Aplicatie",
                  bFooter: false,
                },

                { sExtends :'xls',
                  oSelectorOpts: { filter: 'applied', 
                                   order: 'current',
                                 },
                  bFooter: false,
                },

                { sExtends :'print',
                  oSelectorOpts: { filter: 'applied', 
                                   order: 'current',
                                 },
                  bFooter: false,
                },
                ],
            }
      });
  }
    $("#btnAdd").click(function(event) {
         addStu();
    });

    $("#ImportStu").click(function(event) {
      import_form();
    });

    $("#ExportStu").click(function(event){
      export_form();
    });

    function export_form(){
      $.ajax({
        url: '<?php echo base_url() ?>student/export_form',
        type: 'GET',
        success:function(data){
          $(".modal-title").html('Export ข้อมุลนักเรียน');
          $("#body-stu").html(data);
        }
      });
    }

    function import_form(){
      $.ajax({
        url: '<?php echo base_url() ?>student/import_form',
        type: 'GET',
        success:function(data){
            $(".modal-title").html('Import ข้อมุลนักเรียน');
            $("#body-stu").html(data);
        }
      });
      return false;
    }

    function save_import(){
      var file = $("#file_excel").val();
      if (file != '') {
          $('#load_progress').html('<img id="loader-img" alt="" src="assets/images/loader/uploading.GIF" width="40" height="40" align="center" />');
          $("#frmImport").ajaxForm({
              url: '<?php echo base_url() ?>student/import_excel',
              type: 'POST',
              success: function(data) {
              setTimeout(function () {
                  if(data == 'success'){
                    $('#load_progress').html('');
                    $("#succ").hide();
                    $("#succ").show();
                    $("#warning").hide();
                    // $("#student-modal").modal('hide');
                    $('#student_list').DataTable().ajax.reload(null, false);
                  }else if (data == 'fail_upload') {
                    $("#warning").show();
                    $("#title").html(' พบปัญหาในการ Upload');
                    $('#load_progress').html('');
                  }else if (data == 'fail'){
                    $("#warning").show();
                    $("#title").html(' พบปัญหาในการเพิ่มข้อมูล');
                    // alert('เกิดข้อผิดพลาดกับ Import ข้อมูลได้ในขณะนี้');
                    $('#load_progress').html('');
                  }else if(data == 'duplicate'){
                    $("#warning").show();
                    $("#title").html(' พบปัญหาข้อมูลซ้ำ');
                    $('#load_progress').html('');
                  }
              }, 800);
         }
        });
      }
       return false;
    }

    function export_data(){
      $("#frmExport").ajaxForm({
         url: '<?php echo base_url() ?>student/export_excel',
         type: 'POST',
         success: function(data) {
             if (data = 'success') {
                $("#student-modal").modal('hide');
             }else if (data = 'fail'){
                alert('เกิดข้อผิดพลาดกับ บันทึกข้อมูลในขณะนี้');
             }
         }
     });
      return false;
    }

    // function save(){
    //   $("#frmStudent").ajaxForm({
    //      url: '<?php echo base_url() ?>student/save',
    //      type: 'POST',
    //      success: function(data) {
    //          if (data = 'success') {
    //             $("#student-modal").modal('hide');
    //             $('#student_list').DataTable().ajax.reload(null, false);
    //          }else if (data = 'fail'){
    //             alert('เกิดข้อผิดพลาดกับ บันทึกข้อมูลได้ในขณะนี้');
    //          }
    //      }
    //  });
    // }

    function delStu(id){
      var idx = id;
      var r = confirm("ยืนยันการ ลบ ข้อมูล !");
      if (r=true) {
         $.ajax({
          url: '<?php echo base_url() ?>student/delete',
          type: 'POST',
          data:{stuidx: idx},
          success:function(data){
            if (data='success') {
              alert('ลบข้อมูลสำเร็จ');
              $('#student_list').DataTable().ajax.reload(null,false);
              // refr();
            }else if(data = 'fail'){
              alert('เกิดข้อผิดพลาดกับ ลบข้อมูลได้ในขณะนี้');
            }
          }
      });
      }
    }

    function refr(){
      $.ajax({
        url: '<?php echo base_url() ?>student/index',
        type: 'GET',
        success:function(data){
          $("#page-wrapper").html(data);
        }
      });
      return false;
    }

    function editStu(id){
        var idx = id;
        $('#content_loader').show();
        setTimeout(function () {
            window.location.href = '<?php echo base_url() ?>student/edit?stuidx='+idx;
            $('#content_loader').hide();
        }, 800);
        return false;
      // $.ajax({
      //   url: '<?php echo base_url() ?>student/edit',
      //   type: 'POST',
      //   data: {stuidx: idx},
      //   success:function(data){
      //       $(".modal-title").html('แก้ไขข้อมูลนักเรียน');
      //       $("#body-stu").html(data);
      //   }
      // });
      // return false;
    }

    function addStu(){
        $('#content_loader').show();
          setTimeout(function () {
          window.location.href = '<?php echo base_url() ?>student/add';
          $('#content_loader').hide();
        }, 800);
        return false;

      // $.ajax({
      //   url: '<?php echo base_url() ?>student/add',
      //   type: 'GET',
      //   success:function(data){
      //       $(".modal-title").html('เพิ่มข้อมูลนักเรียน');
      //       $("#body-stu").html(data);
      //    }
      //   });
      // return false;
    }
</script>
