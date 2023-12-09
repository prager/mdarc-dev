<div class="modal fade" id="addFaq" tabindex="-1" aria-labelledby="addFaqLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFaqLabel">Add a FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo base_url() . '/index.php/master-edit-faq'; ?>" method="post">
      <div class="modal-body">
      <section class="px-2">
        <div class="row pt-2">
          <div class="col-lg-6">
            <label for="theQ" class="form-label">The Question</label>
            <input type="text" class="form-control" aria-describedby="theQHelp" name="theQ" placeholder="The Question" required>
          </div>
          <div class="col-lg-6">
            <label for="mem_types">User Type</label>
            <select class="form-select" name="mem_types">
            <?php foreach ($mem_types as $key => $type) {
            if($key == 1) {?>
                <option value="<?php echo $key; ?>" selected><?php echo $type; ?></option>
            <?php }
            else { ?>
                <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
            <?php }
              }?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg py-2">
            <label class="form-label" for="theA">The Answer</label>
            <textarea class="form-control" name="theA" type="text" style="height: 10rem;" required></textarea>
          </div>
        </div>
      </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
