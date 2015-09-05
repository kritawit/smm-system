<marquee behavior="scroll" scrollamount="5" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
    <?php if(!empty($news)): ?>
      <?php for ($i = 0; $i < count($news); $i++) :?>
        <div class="slide-text"><?php echo $news[$i]['NEW'];?></div>
      <?php endfor; ?>
    <?php endif; ?>
</marquee>