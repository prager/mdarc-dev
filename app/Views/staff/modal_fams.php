<div class="modal fade" id="fMems<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="addFamMemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFamMemLabel">Family Members of <?php echo $mem['fname'] . ' ' . $mem['lname'] . ' ' . $mem['callsign']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </form>
      <div class="modal-body">
      <section class="px-2">
        <div class="row pt-2">
          <div class="col p-3">
          <?php  if(count($mem['fam_mems']) != 0) {
              foreach($mem['fam_mems'] as $fam_mem) { ?>
                <a href="<?php echo base_url() . '/index.php/show-mem/' . $fam_mem['id_members'];?>" class="text-decoration-none"><?php echo $fam_mem['fname'] . ' ' . $fam_mem['lname']; ?></a> / Id: <?php echo $fam_mem['id_members']; ?><br>
            <?php  }?>
            <?php }?>
          </div>
        </div>
      </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>
