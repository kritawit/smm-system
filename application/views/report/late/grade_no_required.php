<select name="gradeidx" id="gradeidx" class="form-control" placeholder="ปีการศึกษา">
<option value="">เลือก ปีการศึกษา</option>
  <?php if (!empty($rs)): ?>
    <?php foreach ($rs as $g): ?>
    <?php echo "<option value='" . $g['GRADEIDX'] . "'>" . $g['GRADE_NAME'] . "</option>"; ?>
    <?php endforeach; ?>
<?php endif; ?>
</select>