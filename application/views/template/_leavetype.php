<select name="leave_typeidx" id="leave_typeidx" class="form-control" placeholder="ประเภทการลา" required="required">
<option value="">เลือก ประเภทการลา</option>
  <?php if (!empty($rs)): ?>
    <?php foreach ($rs as $g): ?>
    <?php echo "<option value='" . $g['LEAVE_TYPEIDX'] . "'>" . $g['LEAVE_NAME'] . "</option>"; ?>
    <?php endforeach; ?>
<?php endif; ?>
</select>