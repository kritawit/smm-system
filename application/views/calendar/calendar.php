<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav'); ?>
<div id="page-wrapper">
	<div class="content-holiday">
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url(); ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>calendar">ปฏิทิน โรงเรียน (School Calendar)</a>
			</li>
			<li class="active">ปฏิทิน</li>
		</ol>
			<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
			</div>
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
		<hr>
		<div class="row calendar">
		<div class="span9">
		<div id="calendar"></div>
		</div>
		</div>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="<?php echo LB; ?>calendar/components/underscore/underscore-min.js"></script>
<script type="text/javascript" src="<?php echo LB; ?>calendar/js/calendar.js"></script>
<script type="text/javascript">
	$(function() {
		var options = {
		events_source: '<?php echo base_url(); ?>calendar/eventcalendar',
		view: 'month',
		tmpl_path: '<?php echo LB; ?>calendar/tmpls/',
		tmpl_cache: false,
		onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

		var calendar = $('#calendar').calendar(options);
		$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
			$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
			});
		});
		$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});
	});
</script>