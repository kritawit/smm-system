<div class="table-responsive">
<table class="table table-striped table-hover" bgcolor="#FFFFFF" style="width: 100%;">
      <thead>
        <tr style="background-color: #303030;font-size: 30px;color:#FFFFFF;border-radius:3px;">
          <th >ระดับ</th>
          <th>ทั้งหมด</th>
          <!-- <th>ลา</th> -->
          <th>สาย</th>
          <th>ขาด</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($data) :?>
      <?php for ($i = 0; $i < count($data); $i++) :?>
      <tr style="background-color: #303030;font-size: 26px;color:#13B804;">
          <td><?php echo $data[$i]['SHORT_NAME']; ?></td>
          <td><?php echo $data[$i]['COUNT_STU']; ?></td>
          <!-- <td><?php echo $data[$i]['COUNTL']; ?></td> -->
          <td><?php echo $data[$i]['COUNTLATE']; ?></td>
          <td><?php echo $data[$i]['COUNTAB']; ?></td>
      </tr>
    <?php endfor;?>
    <?php endif; ?>
  </tbody>
</table>
</div>