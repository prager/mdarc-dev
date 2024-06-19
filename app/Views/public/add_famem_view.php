<section id="learn" class="p-5">
  <div class="container">
    <!-- updated post -->
    
    <div class="row mt-3">
        <div class="col-lg-8 mt-3 offset-lg-1">
            <h5>Join MDARC (Mount Diablo Amateur Radio Club) - public</h5>
        </div>
    </div>

    <div class="row">
      <div class="col-lg-6 offset-lg-1 py-2" style="background-color: lightgrey;">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item col-lg-12">
              <h2 class="accordion-header" id="flush-headingOne">
                  <a href="#" class="accordion-button collapsed text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                      Membership Costs - For Details Click to Expand</a>
              </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"  data-bs-parent="#accordionFlushExample">
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
      <div class="col-lg-10 offset-lg-1">
        <small>Entries marked with <span style="color: red;">*</span> are required</small>
      </div>
    </div>
    <form class="needs-validation" action="<?php echo base_url() . '/index.php/process-pub-mem'; ?>" method="post">
    <div class="row mt-3">
      <div class="col-lg-3 offset-lg-1">
          <label for="fname">First Name <span style="color: red;">*</span></label>
          <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
          <div class="invalid-feedback">
            Please, enter First Name
          </div>
      </div>
      <div class="col-lg-3">
          <label for="lname">Last Name <span style="color: red;">*</span></label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required>
      </div>
      <div class="col-lg-3">
          <label for="callsign">Callsign (Enter SWL if no Callsign) <span style="color: red;">*</span></label>
          <input type="text" class="form-control" id="callsign" name="callsign" placeholder="Callsign" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-4 offset-lg-1">
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
      <div class="col-lg-4">
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
      <div class="col-lg-3 offset-lg-1">
        <label for="w_phone">Cell Phone</label>
        <input type="text" class="form-control" id="w_phone" name="w_phone" placeholder="Cell Phone">
      </div>
      <div class="col-lg-3">
        <label for="h_phone">Home Phone</label>
        <input type="text" class="form-control" id="h_phone" name="h_phone" placeholder="Home Phone">
      </div>
      <div class="col-lg-3">
        <label for="email">Email <span style="color: red;">*</span></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-3 offset-lg-1">
        <div class="form-check">
          <label class="form-check-label" for="arrl"> ARRL Member </label>
          <input class="form-check-input" type="checkbox" name="arrl" />
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-check">
          <label class="form-check-label" for="mem_card" data-bs-toggle="tooltip" title="Send SASE to: Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523"> Issue Member Card </label>
          <input class="form-check-input" type="checkbox" name="mem_card" data-bs-toggle="tooltip" title="Send SASE to: Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523" /><br />
          <small><em data-bs-toggle="tooltip" title="Membership Chair P.O. Box 23222 Pleasant Hill, CA 94523">Send SASE to: (hover mouse)</em></small>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-6 offset-lg-1">
        <label for="address">Street Address <span style="color: red;">*</span></label>
        <input type="text" class="form-control" name="address" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-3 offset-lg-1">
        <label for="city">City <span style="color: red;">*</span></label>
        <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
      </div>
      <div class="col-lg-3">
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
      <div class="col-lg-3">
        <label for="zip">Zip</label>
        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-3 offset-lg-1">
        <div class="form-check">
          <label class="form-check-label" for="carrier"> Carrier Copy ($18.00) </label>
          <input class="form-check-input" type="checkbox" id="carrier" name="carrier" value="add_carrier" />
          <input type="hidden" name="mdarc-mem" value="new_mem">
        </div>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-lg-8 offset-lg-1">
          <hr>
          <h5>How did you hear about MDARC?</h5>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="howHeard" id="arrlWeb" value="arrlWeb">
            <label class="form-check-label" for="arrlWeb">On ARRL website</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="howHeard" id="mdarcTest" value="mdarcTest">
            <label class="form-check-label" for="mdarcTest">During MDARC's license testing</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="howHeard" id="otherTest" value="otherTest" value="otherTest">
            <label class="form-check-label" for="otherTest">During other club's license testing</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="howHeard" id="otherReasons" value="otherReason" checked>
            <label class="form-check-label" for="otherReasons">If not above, then how did you lear about MDARC? Please, describe below:</label>
          </div>
      </div>      
    </div>
    <div class="row mb-3">
      <div class="col-lg-8 offset-lg-1">
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">How did you hear about MDARC other than above?</label>
          <textarea class="form-control" name="txtOtherReason" id="txtOtherReason" rows="7"></textarea>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-lg-10 offset-lg-1">
          <hr>
        <h5>Donations</h5>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-lg-4 offset-lg-1">
        <label for="repeater">Repeater</label>
        <input type="text" class="form-control" name="repeater" value="$0.00">
      </div>
      <div class="col-lg-4">
        <label for="mdarc_donation">MDARC</label>
        <input type="text" class="form-control" name="mdarc_donation" value="$0.00">
      </div>
    </div>
    <div class="row mt-5">
      <div class="col offset-lg-1">
        <p class="text-muted">Check "Add Family Member" if you want to add a family member living at the same address</p>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-lg-3 offset-lg-1">
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Process Application</button>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="add_fam" id="add_fam">
          <label class="form-check-label" for="add_fam"> Add Family Member </label>
        </div>
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
