<section id="learn" class="p-5">
  <div class="container">
    <!-- updated post -->
    <form action="<?php echo base_url() . '/index.php/process-pub-mem'; ?>" method="post">
    <div class="row mt-3">
        <div class="col-md-8 mt-3 offset-md-1">
            <h5>Join MDARC (Mount Diablo Amateur Radio Club) - public</h5>
        </div>
    </div>

    <div class="row">
    <div class="col-md offset-md-1">
    
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item col-md-8">
            <h2 class="accordion-header" id="flush-headingOne">
                <a href="#" class="accordion-button collapsed text-decoration-none text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Membership Costs - For Details Click to Expand</a></h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col">
                            First time members joining Jan 1 thru Sep 30 (Valid for all of the current year): <strong>$30.00</strong>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            First time members only joining Oct 1 thru Dec 31 (Dues will cover the balance of current year and all of the next year): <strong>$45.00</strong>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            Individual or Family membership renewals (All living at the same address): <strong>$45.00</strong><br />
                            <small><em>Valid for all of the current year. Family members are full members, but a family receives only one copy of the newsletter.</em></small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            Student membership (must provide copy of student ID to Membership Chair): <strong>$15.00</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
      </div>
      <div class="col-md-3">
          <label for="lname">Last Name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
      </div>
      <div class="col-md-3">
          <label for="callsign">Callsign (Enter SWL if no Callsign)</label>
          <input type="text" class="form-control" id="callsign" name="callsign" placeholder="Callsign">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-4 offset-md-1">
        <label for="sel_lic">License Type</label>
        <select class="form-select" name="sel_lic">
          <?php
            foreach($lic as $license) {
              if($license == 'Technician') { ?>
                <option value="<?php echo $license; ?>" selected><?php echo $license; ?></option>
          <?php    }
              else { ?>
                <option value="<?php echo $license; ?>"><?php echo $license; ?></option>
          <?php }
            }
          ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="sel_lic">Member Type</label>
        <select class="form-select" name="mem_types">
          <?php
            foreach($mem_types as $type) {
              if($type['id'] == 1) {?>
                <option value="<?php echo $type['id']; ?>" selected><?php echo $type['description']; ?></option>
              <?php }
              elseif($type['id'] == 5) { ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['description']; ?></option>
          <?php  }
            }
          ?>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <label for="w_phone">Cell Phone</label>
        <input type="text" class="form-control" id="w_phone" name="w_phone" placeholder="Cell Phone">
      </div>
      <div class="col-md-3">
        <label for="h_phone">Home Phone</label>
        <input type="text" class="form-control" id="h_phone" name="h_phone" placeholder="Home Phone">
      </div>
      <div class="col-md-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <div class="form-check">
          <label class="form-check-label" for="arrl"> ARRL Member </label>
          <input class="form-check-input" type="checkbox" name="arrl" />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-check">
          <label class="form-check-label" for="mem_card" data-bs-toggle="tooltip" title="Send SASE to: Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523"> Issue Member Card </label>
          <input class="form-check-input" type="checkbox" name="mem_card" data-bs-toggle="tooltip" title="Send SASE to: Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523" /><br />
          <small><em data-bs-toggle="tooltip" title="Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523">Send SASE to: (hover mouse)</em></small>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 offset-md-1">
        <label for="address">Street Address</label>
        <input type="text" class="form-control" name="address">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="City">
      </div>
      <div class="col-md-3">
        <label for="callsign">State</label>
        <select class="form-select" name="state" aria-label="Default select example">
          <?php
            foreach($states as $state) {
              if($state == 'California') {?>
              <option selected value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php }
              else { ?>
              <option value="<?php echo key($states); ?>"><?php echo $state; ?></option>
            <?php
                }
            next($states);
              }?>
        </select>
      </div>
      <div class="col-md-3">
        <label for="zip">Zip</label>
        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-3 offset-md-1">
        <div class="form-check">
          <label class="form-check-label" for="carrier"> Carrier Copy ($18.00) </label>
          <input class="form-check-input" type="checkbox" id="carrier" name="carrier" value="add_carrier" />
          <input type="hidden" name="mdarc-mem" value="new_mem">
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-8 offset-md-1">
          <hr>
          <h5>Donations</h5>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-lg-4 offset-md-1">
        <label for="repeater">Repeater</label>
        <input type="text" class="form-control" name="repeater" value="$0.00">
      </div>
      <div class="col-lg-4">
        <label for="mdarc_donation">MDARC</label>
        <input type="text" class="form-control" name="mdarc_donation" value="$0.00">
      </div>
    </div>
    <div class="row mt-5">
      <div class="col offset-md-1">
          <button type="submit" class="btn btn-primary">Process Application</button>
      </div>
      <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        </script>
    </div>
  </form>
  </div>
</section>
