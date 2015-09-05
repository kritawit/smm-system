<div id="cover-table-student">
    <div class="btn-group">
        <a data-toggle="modal" href="#student-modal" class="btn btn-info" id="btnAdd"><span class="fa fa-plus-square"></span> เพิ่มข้อมูล</a>
    </div>
    <div class="btn-group">
      <a data-toggle="modal" href="#student-modal" class="btn btn-success" id="ImportStu"><span class="glyphicon glyphicon-cloud-upload"></span> Import</a>
    </div>
    <div class="btn-group">
      <a data-toggle="modal" href="#student-modal" class="btn btn-primary" id="ExportStu"><span class="glyphicon glyphicon-cloud-download"></span> Export</a>
    </div>
    <hr>
    <div class="row">
      <table id="student_list" class="table table-striped table-hover" cellspacing="0" width="100%">
      <thead>
        <tr>
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
<div class="modal fade" id="student-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          
        </div>
<!--         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>
<script type="text/javascript" src="<?php echo LB ?>datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo LB?>bootstrap/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
      getData();
  });

  function getData(){
    $('#student_list').dataTable( {
        "ajax": "<?php echo base_url() ?>student/ajax_request",
        "columns": [
            { "data": "STU_CODE" },
            { "data": "STU_FNAME" },
            { "data": "STU_LNAME" },
            { "data": "GRADE_NAME" },
            { "data": "CLASS_NUM" },
            { "data": "STU_PTEL" },
            {
            "mData": null,
            "bSortable": false,
            "mRender": function (o) { return "<a href='#student-modal' onclick='editStu("+ o.STUIDX +");' class='btn btn-warning btn-sm' data-toggle='modal' href='#modal-student' '>" + "<span class='glyphicon glyphicon-pencil'></span>" + "</a>"
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
          $(".modal-body").html(data);
        }
      });
    }

    function import_form(){
      $.ajax({
        url: '<?php echo base_url() ?>student/import_form',
        type: 'GET',
        success:function(data){
            $(".modal-title").html('Import ข้อมุลนักเรียน');
            $(".modal-body").html(data);
        }
      });
      return false;
    }

    function save_import(){
      var file = $("#file_excel").val();
      if (file != '') {
          $('#load_progress').html('<img id="loader-img" alt="" src="assets/images/loader/uploading.gif" width="40" height="40" align="center" />');
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


    function save(){
      $("#frmStudent").ajaxForm({
         url: '<?php echo base_url() ?>student/save',
         type: 'POST',
         success: function(data) {
             if (data = 'success') {
                $("#student-modal").modal('hide');
                $('#student_list').DataTable().ajax.reload(null, false);
             }else if (data = 'fail'){
                alert('เกิดข้อผิดพลาดกับ บันทึกข้อมูลได้ในขณะนี้');
             }
         }
     });
    }

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
              refr();
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
      $.ajax({
        url: '<?php echo base_url() ?>student/edit',
        type: 'POST',
        data: {stuidx: idx},
        success:function(data){
            $(".modal-title").html('แก้ไขข้อมูลนักเรียน');
            $(".modal-body").html(data);
        }
      });
      return false;
    }

    function addStu(){
      $.ajax({
        url: '<?php echo base_url() ?>student/add',
        type: 'GET',
        success:function(data){
            $(".modal-title").html('เพิ่มข้อมูลนักเรียน');
            $(".modal-body").html(data);
         }
        });
      return false;
    }
</script>
