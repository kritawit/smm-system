<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper" >
<div class="content-report">
	<a role="button" data-toggle="collapse" href="#panel-search" aria-expanded="false" onclick="search_day();"  class="btn btn-success"><span class="glyphicon glyphicon-search"></span> ค้นหาข้อมูลขาดเรียน แบบรายวัน</a>
	<!-- <a  role="button" data-toggle="collapse" href="#panel-search" aria-expanded="false" onclick="search_peple();" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> ค้นหาข้อมูล แบบรายบุคคล</a> -->
	<div class="collapse" id="panel-search">
  		<div class="well">
   		 
  		</div>
	</div>
	<hr>
	<div id="result-search">
		<div class="alert alert-warning">
      		<strong>Data </strong> invalid...
  		</div>
	</div>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
	function submit_day(){
		var options = {
        success: function(data) {
            if (data == 'no-data') {
              var alert = '<div class="alert alert-danger"><strong>Data </strong> Not Found!</div>';
            	$("#result-search").html(alert);
            }else if(data == 'holiday'){
              var alert = '<div class="alert alert-warning"><strong>ตรงกับวันหยุด </strong> !</div>';
              $("#result-search").html(alert);
            }else{
              $("#result-search").html(data);
            }
        },
        url: '<?php echo base_url() ?>report/search_absent_day', // override for form's 'action' attribute 
        type: 'POST',        // 'get' or 'post', override for form's 'method' attribute
        resetForm: true, // reset the form after successful submit
    };

    $('#frmFindDay').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
	}

	function submit_peple(){
		var options = {
        // target:        '#',   // target element(s) to be updated with server response 
        // beforeSubmit: '', // pre-submit callback 
        success: function(data) {
            if (data == 'no-data') {
              var alert = '<div class="alert alert-danger"><strong>Data </strong> Not Found!</div>';
              $("#result-search").html(alert);
            }else{
              $("#result-search").html(data);
            }
        },
        url: '<?php echo base_url() ?>report/search_by_peple', // override for form's 'action' attribute 
        type: 'POST',        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true, // clear all form fields after successful submit
        resetForm: true, // reset the form after successful submit
    };

    $('#frmFindPeple').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
	}
	function search_day(){
		$.ajax({
			url: '<?php echo base_url() ?>report/form_absent_day',
			type: 'GET',
			success:function(data){
    			$("#panel-search").on('show.bs.collapse');
				$(".well").html(data);
			}
		});
		return false;
	}
	function search_peple(){
		$.ajax({
			url: '<?php echo base_url() ?>report/form_absent_peple',
			type: 'GET',
			success:function(data){
    			$("#panel-search").on('show.bs.collapse');
				$(".well").html(data);
			}
		});
		return  false;
	}
</script>