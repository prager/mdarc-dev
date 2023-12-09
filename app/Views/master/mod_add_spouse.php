<div class="modal fade" id="addSpouse<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="addSpouseLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php echo base_url() . '/index.php/add-spouse/'. $mem['id']; ?>" method="post">
      <div class="modal-header">
        <h5 id="addSpouse<?php echo $mem['id']; ?>Label" class="modal-title">Add Spouse</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="parent" class="pb-2">Add a Spouse to <strong><?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?>?</strong></label>
        <input type="text" class="form-control" id="parent" name="parent" placeholder="Enter Parent ID">
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
