<?php $this->load->view('template/header'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo LB; ?>uploadify/uploadify.css">
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo base_url(); ?>slide">ย้อนกลับ</a>
    </li>
    <li class="active">slide form</li>
  </ol>
  <legend>Form เพิ่ม Slide</legend>
       <?php if(!empty($this->session->flashdata('error'))): ?>
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong><?php echo $this->session->flashdata('error'); ?></strong>
				</div>
				<?php endif; ?>
				<form id="frmSlide" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
  				<fieldset>
    			<div class="form-group inline">
    			<label for="holi_name"  class="col-lg-3 control-label"><b>ประเภท : </b></label>
  				<input type="hidden" name="slideidx" value="<?php if(!empty($data[0]['SLIDEIDX'])): ?><?php echo $data[0]['SLIDEIDX']; ?><?php endif; ?>">
          <div class="col-md-6" >
    			   	<label class="radio-inline">
  						<input type="radio" required="required" name="slide_type" onchange="selecttype(1);"  value="1" > Image
					</label>
					<!-- <label class="radio-inline">
  						<input type="radio" required="required" name="slide_type" onchange="selecttype(2);" value="2"> Video
					</label> -->
  				</div>
    			</div>
    			<div class="form-group inline">
    			<label for="holi_date"  class="col-lg-3 control-label" id="title"></label>
  				<div class="col-md-6" id="type_input">

  				</div>
    			</div>
    			<div class=" form-group" id="vedio_submit" style="display: none;">
            <label class="col-lg-3"></label>
      			<div class="col-md-6">
        			<button type="submit"  class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> บันทึก</button>
        			<a  href="<?php echo base_url() ?>slide" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>
      			</div>
    			</div>
          <hr>
    			</fieldset>
          </form>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="<?php echo LB; ?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
    $(function() {
      var options = {
        // beforeSubmit:  upload,  // pre-submit callback
        success:function(data){
          if (data=='success') {
              $("input[name=video_link]").val('');
              alert('save slide success.');
          }
        },
        // other available options:
        url: '<?php echo base_url() ?>slide/add',
        type: 'POST',
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        // clearForm: true,        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
      };

      $('#frmSlide').ajaxForm(options);

    });
  	function selecttype(id){
  		var label = '';
  		var input = '';
  		if (id == 1) {
        $("#vedio_submit").hide();
  			label = '<b></b>';
  			input = '<div id="upload"></div><a href="#" class="btn btn-success" onclick="onupload();return false;" id="onupload"><span class="glyphicon glyphicon-upload"></span> Upload</a> <a  href="<?php echo base_url() ?>slide" class="btn btn-danger" data-dismiss="modal">ยกเลิก</a>';
  		}else if(id == 2){
        $("#vedio_submit").show();
  			label = '<b>Video</b>';
  			input = '<input type="url" class="form-control" name="video_link" required="required"  placeholder="Link Video">';
  		}
  		$("#title").html(label);
  		$("#type_input").html(input);
      $("#upload").uploadify({
          auto:false,
          'fileTypeDesc' : 'Image Files',
          'fileTypeExts' : ' *.jpg; *.jpeg',
          // 'fileSizeLimit' : '400KB',
          uploader:"<?php echo base_url(); ?>slide/do_upload",
          swf:"<?php echo LB; ?>uploadify/uploadify.swf"
      });
  	}

    function onupload(){
      $('#upload').uploadify('upload','*');
    }
</script>