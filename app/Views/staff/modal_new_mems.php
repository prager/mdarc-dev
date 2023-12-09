<div class="modal fade" id="newMems" tabindex="-1" aria-labelledby="showMemLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="showMemLabel">New Members</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
        if($new_mems != NULL) {
        foreach ($new_mems as $key => $mem) {?>
          <div class="row">
            <div class="col">
              <?php echo $mem['fname']; ?>
            </div>
            <div class="col">
              <?php echo $mem['lname']; ?>
            </div>
          </div>
        <?php }
        }
        else {?>
          <div class="row">
            <div class="col">
              <h4>No new members for the period <?php echo $date_start . ' to ' . $date_stop; ?></h4>
            </div>
          </div>
      <?php }?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
