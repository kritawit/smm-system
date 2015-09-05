</div>
<script type="text/javascript" src="<?php echo JS?>jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS?>jquery.form.js"></script>
<script type="text/javascript" src="<?php echo LB?>jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo LB?>bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo LB?>bootstrap/dist/js/sb-admin-2.js"></script>

<script src="<?php echo LB?>bootstrap/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo JS;?>smm-system.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#student").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      		window.location.href = '<?php echo base_url() ?>student';
        	$('#content_loader').hide();
        }, 800);
		return false;
		// $('#content_loader').show();
		// 	$.ajax({
		// 		url: '<?php echo base_url() ?>student/index',
		// 		type: 'GET',
		// 		success:function(data){
		// 			setTimeout(function () {
  //     				$("#page-wrapper").html(data);
  //       			$('#content_loader').hide();
  //           	}, 800);
		// 	}
		// });
		// return false;
	});
	$("#leave").click(function(event) {
		$('#content_loader').show();
			$.ajax({
				url: '<?php echo base_url() ?>leave/index',
				type: 'GET',
				success:function(data){
					setTimeout(function () {
      				$("#page-wrapper").html(data);
        			$('#content_loader').hide();
            	}, 800);
			}
		});
		return false;
	});
	$("#ab_person").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      				window.location.href = '<?php echo base_url() ?>report/absent_person';
        			$('#content_loader').hide();
        }, 800);
		return false;
	});

	$("#search-leave").click(function(event) {
		$('#content_loader').show();
			$.ajax({
				url: '<?php echo base_url() ?>leave/search_form',
				type: 'GET',
				success:function(data){
					setTimeout(function () {
      				$("#page-wrapper").html(data);
        			$('#content_loader').hide();
            	}, 800);
			}
		});
		return false;
	});

	$("#main-late").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      				window.location.href = '<?php echo base_url() ?>report/main_late';
        			$('#content_loader').hide();
        }, 800);
		return false;
	});

	$("#main-absent").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      				window.location.href = '<?php echo base_url() ?>report/main_absent';
        			$('#content_loader').hide();
        }, 800);
		return false;
	});
	$("#ncalendar").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      		window.location.href = '<?php echo base_url() ?>calendar';
        	$('#content_loader').hide();
        }, 800);
		return false;
	});
	$("#main-slide01").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      		window.location.href = '<?php echo base_url() ?>slide';
        	$('#content_loader').hide();
        }, 800);
		return false;
	});
	$("#main-slide02").click(function(event) {
		$('#content_loader').show();
		setTimeout(function () {
      		window.location.href = '<?php echo base_url() ?>news';
        	$('#content_loader').hide();
        }, 800);
		return false;
	});
});
</script>
</body>
</html>