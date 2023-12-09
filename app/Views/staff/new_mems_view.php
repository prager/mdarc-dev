<section id="learn" class="p-5">
<div class="container">
    <div class="row">&nbsp;</div>
    <div class="row">
      <div class="col-lg-12">
      <h4>Search Result</h4>
      <p><?php echo $msg; ?></p>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Cur Yr</th>
            <th>Mem Type</th>
            <th>Callsign</th>
            <th>Lic</th>
            <th>Pay Dt</th>
            <th>Mem Since</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mems as $key => $mem) {?>
          <tr>
            <td><?php echo $mem['lname'] . ', ' . $mem['fname']; ?></td>
            <td><?php echo $mem['cur_year']; ?></td>
             <td><?php echo $mem['mem_type'];?></td>
             <td><?php echo $mem['callsign']; ?></td>
             <td><?php echo $mem['license']; ?></td>
             <td><?php echo $mem['pay_date']; ?></td>
             <td><?php echo $mem['mem_since']; ?></td>
             <td><?php
             if(strlen($mem['email']) > 30) {
               echo substr($mem['email'], 0, 30) . '...';
             }
             else {
               echo $mem['email'];
             }?>
           </td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      </div>
    </div>
</section>
