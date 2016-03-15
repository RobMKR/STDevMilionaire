<?php $k = 1 ?>
<div class="row">
  <div class="col-lg-3"></div>
  <div class="col-lg-6">
    <h1 align='center'>High Scores</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Place </th>
          <th>User</th>
          <th>Points</th>
          <th>Date and Time</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($model as $record): ?>
          <tr>
            <td><?=$k?></td>
            <td><?=$record['username']?></td>
            <td><?=$record['points']?></td>
            <td><?=date('d-m-Y H:i:s', $record['timestamp'])?></td>
          </tr>
          <?php $k++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="col-lg-3"></div>
</div>
