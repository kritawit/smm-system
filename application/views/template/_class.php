<select name="classidx" id="classidx" class="form-control" placeholder="ห้องเรียน" required="required">
<option value="">เลือก ห้องเรียน</option>
  <?php if (!empty($rs)): ?>
    			<?php foreach ($rs as $c): ?>
  <?php echo "<option value='" . $c['CLASSIDX'] . "'>" . $c['CLASS_NUM'] . "</option>"; ?>
    			<?php endforeach; ?>
<?php endif; ?>
</select>