<?php if ($data) :?>
    <?php for ($i = 0; $i < count($data); $i++) :?>
    <div>
        <?php if($data[$i]['SLIDE_TYPE']==1): ?>
        <img class="img-sl" src="<?php echo IMG; ?>slide/<?php echo $data[$i]['SLIDE']; ?>" alt="">
        <?php endif; ?>
    </div>
	<?php endfor; ?>
<?php endif; ?>
<script type="text/javascript">
	$(function() {
		slidemain();
	});
	function slidemain(){
    $("#slidemain > div:gt(0)").hide();
    setInterval(function() {
    $('#slidemain > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#slidemain');
    },  8000);
  }
</script>